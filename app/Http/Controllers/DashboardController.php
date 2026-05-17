<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $recentDocuments = Document::where('user_id', $user->id)
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'total_documents'    => Document::where('user_id', $user->id)->count(),
            'total_downloads'    => Document::where('user_id', $user->id)->sum('download_count'),
            'total_categories'   => Document::where('user_id', $user->id)->distinct('category_id')->count('category_id'),
            'this_month'         => Document::where('user_id', $user->id)
                                        ->whereMonth('created_at', now()->month)
                                        ->count(),
        ];

        $categories = DocumentCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('dashboard.index', compact('recentDocuments', 'stats', 'categories', 'user'));
    }

    public function history(Request $request)
    {
        $user = auth()->user();
        $query = Document::where('user_id', $user->id)->with('category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $documents  = $query->latest()->paginate(12);
        $categories = DocumentCategory::where('is_active', true)->get();

        return view('dashboard.history', compact('documents', 'categories'));
    }
}
