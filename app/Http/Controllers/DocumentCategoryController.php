<?php

namespace App\Http\Controllers;

use App\Models\DocumentCategory;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentCategoryController extends Controller
{
    public function index()
    {
        $categories = DocumentCategory::where('is_active', true)
            ->orderBy('group')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $stats = [
            'total_categories' => $categories->count(),
            'total_groups'     => $categories->pluck('group')->unique()->count(),
            'total_documents'  => Document::count(),
        ];

        return view('documents.categories', compact('categories', 'stats'));
    }

    public function create(string $slug)
    {
        $category = DocumentCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // templates & fields sudah di-cast array oleh model, TIDAK perlu json_decode
        $templates = is_array($category->templates) ? $category->templates : [];
        $fields    = is_array($category->fields)    ? $category->fields    : [];

        $recentDocs = auth()->check()
            ? Document::where('user_id', auth()->id())
                ->where('category_id', $category->id)
                ->latest()->take(3)->get()
            : collect();

        return view('documents.create', compact('category', 'templates', 'fields', 'recentDocs'));
    }

    public function store(Request $request, string $slug)
    {
        $category = DocumentCategory::where('slug', $slug)->firstOrFail();

        $request->validate([
            'title'         => 'required|string|max:255',
            'template_used' => 'required|string',
            'form_data'     => 'required|array',
        ]);

        $document = Document::create([
            'user_id'       => auth()->id(),
            'category_id'   => $category->id,
            'title'         => $request->title,
            'template_used' => $request->template_used,
            'form_data'     => $request->form_data,
            'color_theme'   => $request->color_theme ?? $category->color,
            'status'        => 'draft',
        ]);

        return response()->json([
            'success'     => true,
            'document_id' => $document->id,
            'preview_url' => route('documents.preview', $document->id),
        ]);
    }

    public function preview(Document $document)
    {
        $this->authorizeDocument($document);
        $category = $document->category;
        return view('documents.preview', compact('document', 'category'));
    }

    public function download(Document $document)
    {
        $this->authorizeDocument($document);

        $document->increment('download_count');
        $document->update(['last_downloaded_at' => now()]);

        $category = $document->category;

        // Universal template — 1 template untuk semua 40+ kategori
        try {
            $html = view('documents.pdf.universal', [
                'document' => $document,
                'data'     => $document->form_data ?? [],
                'category' => $category,
            ])->render();
        } catch (\Throwable $e) {
            return response('<div style="padding:40px;font-family:sans-serif;"><h2 style="color:#DC2626;">Error rendering dokumen</h2><pre style="font-size:12px;">' . e($e->getMessage()) . '</pre></div>', 500)
                ->header('Content-Type', 'text/html; charset=UTF-8');
        }

        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('X-Document-Title', $document->title);
    }

    public function update(Request $request, Document $document)
    {
        $this->authorizeDocument($document);
        $updateData = [
            'form_data'   => $request->form_data   ?? $document->form_data,
            'color_theme' => $request->color_theme ?? $document->color_theme,
            'status'      => $request->status      ?? $document->status,
        ];
        // Support update title juga
        if ($request->filled('title')) {
            $updateData['title'] = $request->title;
        }
        $document->update($updateData);
        return response()->json(['success' => true]);
    }

    public function destroy(Document $document)
    {
        $this->authorizeDocument($document);
        $document->delete();
        return response()->json(['success' => true]);
    }

    public function livePreview(Request $request, string $slug)
    {
        $category = DocumentCategory::where('slug', $slug)->firstOrFail();

        $data     = $request->input('form_data', []);
        $template = $request->input('template', '');
        $color    = $request->input('color_theme', $category->color ?? '#DC2626');

        // Fake document untuk preview (tidak disimpan ke DB)
        $fakeDocument = new Document([
            'title'         => $data['nama_lengkap'] ?? $data['nama'] ?? $data['nama_pelamar'] ?? 'Preview',
            'template_used' => $template,
            'form_data'     => $data,
            'color_theme'   => $color,
            'status'        => 'draft',
            'download_count' => 0,
        ]);
        // Manually set timestamps as Carbon so blade ->format() works
        $fakeDocument->created_at = now();
        $fakeDocument->updated_at = now();
        $fakeDocument->setRelation('user', auth()->user());
        $fakeDocument->setRelation('category', $category);

        try {
            $html = view('documents.pdf.universal', [
                'document'      => $fakeDocument,
                'data'          => $data,
                'category'      => $category,
                'isLivePreview' => true,
            ])->render();
        } catch (\Throwable $e) {
            return response('<div style="padding:40px;font-family:sans-serif;color:#DC2626;">
                <strong>Preview Error:</strong><br>' . e($e->getMessage()) . '
            </div>', 500)->header('Content-Type', 'text/html; charset=UTF-8');
        }

        return response($html)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    private function authorizeDocument(Document $document): void
    {
        if (auth()->id() !== $document->user_id && !auth()->user()?->is_admin) {
            abort(403);
        }
    }
}
