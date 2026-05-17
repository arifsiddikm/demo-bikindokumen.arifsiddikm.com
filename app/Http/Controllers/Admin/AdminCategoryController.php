<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = DocumentCategory::withCount('documents')
            ->orderBy('group')
            ->orderBy('sort_order')
            ->get();

        $groups = $categories->groupBy('group')->map->count();

        return view('admin.categories.index', compact('categories', 'groups'));
    }

    public function create()
    {
        $groups = DocumentCategory::distinct()->pluck('group')->sort()->values();
        return view('admin.categories.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'group'       => 'required|string|max:100',
            'icon'        => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'color'       => 'nullable|string|max:20',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
            'templates'   => 'nullable|string',
            'fields'      => 'nullable|string',
        ]);

        $data['slug']      = Str::slug($data['name']) . '-' . Str::random(4);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['templates'] = $request->templates ? json_decode($request->templates) : [];
        $data['fields']    = $request->fields ? json_decode($request->fields) : [];

        DocumentCategory::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(DocumentCategory $category)
    {
        $groups = DocumentCategory::distinct()->pluck('group')->sort()->values();
        return view('admin.categories.edit', compact('category', 'groups'));
    }

    public function update(Request $request, DocumentCategory $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'group'       => 'required|string|max:100',
            'icon'        => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'color'       => 'nullable|string|max:20',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
            'templates'   => 'nullable|string',
            'fields'      => 'nullable|string',
        ]);

        $data['is_active'] = $request->boolean('is_active', false);
        $data['templates'] = $request->filled('templates') ? json_decode($request->templates) : ($category->templates ?? []);
        $data['fields']    = $request->filled('fields') ? json_decode($request->fields) : ($category->fields ?? []);

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(DocumentCategory $category)
    {
        $category->delete();
        return response()->json(['success' => true]);
    }

    public function toggle(DocumentCategory $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        return response()->json(['success' => true, 'is_active' => $category->is_active]);
    }
}
