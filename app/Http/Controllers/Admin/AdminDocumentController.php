<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminDocumentController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users'      => User::count(),
            'total_documents'  => Document::count(),
            'total_downloads'  => Document::sum('download_count'),
            'total_categories' => DocumentCategory::where('is_active', true)->count(),
            'today_documents'  => Document::whereDate('created_at', today())->count(),
            'this_month'       => Document::whereMonth('created_at', now()->month)->count(),
        ];

        $recentDocuments = Document::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        $categoryStats = DocumentCategory::withCount('documents')
            ->orderByDesc('documents_count')
            ->take(8)
            ->get();

        $recentUsers = User::latest()->take(5)->get();

        // Monthly chart data (last 6 months)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartData[] = [
                'label' => $month->format('M Y'),
                'count' => Document::whereYear('created_at', $month->year)
                                   ->whereMonth('created_at', $month->month)
                                   ->count(),
            ];
        }

        return view('admin.dashboard', compact('stats', 'recentDocuments', 'categoryStats', 'recentUsers', 'chartData'));
    }

    public function index(Request $request)
    {
        $query = Document::with(['user', 'category']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $documents  = $query->latest()->paginate(20);
        $categories = DocumentCategory::orderBy('name')->get();

        return view('admin.documents.index', compact('documents', 'categories'));
    }

    public function show(Document $document)
    {
        $document->load(['user', 'category']);
        return view('admin.documents.show', compact('document'));
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return response()->json(['success' => true]);
    }

    public function users(Request $request)
    {
        $query = User::withCount('documents');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function reports(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to   = $request->to   ?? now()->toDateString();

        $documents = Document::with(['user', 'category'])
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->latest()
            ->paginate(30);

        $summary = [
            'total_documents' => Document::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->count(),
            'total_downloads' => Document::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->sum('download_count'),
            'unique_users'    => Document::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->distinct('user_id')->count(),
        ];

        return view('admin.reports.index', compact('documents', 'summary', 'from', 'to'));
    }

    /**
     * Export laporan ke PDF (pakai dompdf)
     */
    public function exportReport(Request $request)
    {
        $from   = $request->from ?? now()->startOfMonth()->toDateString();
        $to     = $request->to   ?? now()->toDateString();
        $format = $request->format ?? 'pdf'; // 'pdf' atau 'csv'

        $documents = Document::with(['user', 'category'])
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->latest()
            ->get();

        $summary = [
            'total_documents' => $documents->count(),
            'total_downloads' => $documents->sum('download_count'),
            'unique_users'    => $documents->pluck('user_id')->unique()->count(),
            'completed'       => $documents->where('status', 'completed')->count(),
            'draft'           => $documents->where('status', 'draft')->count(),
        ];

        // Export CSV
        if ($format === 'csv') {
            $csv = "No,Judul,Kategori,User,Email,Template,Status,Download,Tanggal\n";
            foreach ($documents as $i => $doc) {
                $csv .= implode(',', [
                    $i + 1,
                    '"' . str_replace('"', '""', $doc->title) . '"',
                    '"' . str_replace('"', '""', $doc->category->name ?? '-') . '"',
                    '"' . str_replace('"', '""', $doc->user->name ?? '-') . '"',
                    '"' . ($doc->user->email ?? '-') . '"',
                    '"' . ($doc->template_used ?? '-') . '"',
                    $doc->status,
                    $doc->download_count,
                    $doc->created_at->format('d/m/Y H:i'),
                ]) . "\n";
            }

            return response($csv)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="laporan-' . $from . '-sd-' . $to . '.csv"');
        }

        // Export PDF (dompdf)
        $pdf = Pdf::loadView('admin.reports.pdf', compact('documents', 'summary', 'from', 'to'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-bikindokumen-' . $from . '-sd-' . $to . '.pdf');
    }
}
