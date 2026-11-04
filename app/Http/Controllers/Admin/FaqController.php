<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('category')->latest()->get();

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $categories = FaqCategory::orderBy('sort_order')->get();

        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Faq::create($this->validated($request));

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ Added Successfully');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $categories = FaqCategory::orderBy('sort_order')->get();

        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, $id)
    {
        Faq::findOrFail($id)->update($this->validated($request));

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ Updated Successfully');
    }

    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();

        return response()->json(['message' => 'FAQ Deleted Successfully']);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'faq_category_id' => 'nullable|exists:faq_categories,id',
            'question'        => 'required|string|max:500',
            'answer'          => 'required|string',
            'sort_order'      => 'nullable|integer|min:0',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['show_home']  = $request->boolean('show_home');
        $data['status']     = $request->boolean('status');

        return $data;
    }
}