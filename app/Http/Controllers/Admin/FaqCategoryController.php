<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FaqCategoryController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::withCount('faqs')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.faq-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.faq-categories.create');
    }

    public function store(Request $request)
    {
        FaqCategory::create($this->validated($request));

        return redirect()->route('admin.faq-categories.index')
            ->with('success', 'Category Added Successfully');
    }

    public function edit($id)
    {
        $category = FaqCategory::findOrFail($id);

        return view('admin.faq-categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = FaqCategory::findOrFail($id);
        $category->update($this->validated($request, $category->id));

        return redirect()->route('admin.faq-categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy($id)
    {
        // faqs.faq_category_id is nullOnDelete, so its FAQs move to "General"
        FaqCategory::findOrFail($id)->delete();

        return response()->json(['message' => 'Category Deleted Successfully']);
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:100',
                             Rule::unique('faq_categories', 'name')->ignore($ignoreId)],
            'icon'       => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['icon']       = trim($data['icon'] ?? '') ?: 'fa-solid fa-circle-question';
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['status']     = $request->boolean('status');

        return $data;
    }
}