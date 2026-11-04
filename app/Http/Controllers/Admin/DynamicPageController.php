<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use Illuminate\Http\Request;

class DynamicPageController extends Controller
{
    public function index()
    {
        $pages = DynamicPage::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        DynamicPage::create($this->payload($request));

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit($id)
    {
        $page = DynamicPage::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = DynamicPage::findOrFail($id);

        $request->validate($this->rules());

        $page->update($this->payload($request, $page->id));

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        DynamicPage::findOrFail($id)->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Page deleted successfully.']);
        }

        return redirect()->back()->with('success', 'Page deleted successfully.');
    }

    private function rules(): array
    {
        return [
            'slug'              => 'nullable|string|max:150',
            'heading'           => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'content'           => 'required|string',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'status'            => 'required|in:0,1',
        ];
    }

    private function payload(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->only([
            'heading',
            'short_description',
            'content',
            'meta_title',
            'meta_description',
        ]);

        // Unique slug: typed value, or generated from heading
        $data['slug']   = DynamicPage::makeSlug($request->input('slug'), $request->input('heading'), $ignoreId);
        $data['status'] = $request->boolean('status');

        return $data;
    }
}