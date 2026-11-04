<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Traits\CompressesImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use CompressesImages;

    public function index()
    {
        $blogs = Blog::orderByDesc('published_at')->orderByDesc('id')->get();

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->makeSlug($request);
        $data['published_at'] = $data['published_at'] ?? now()->toDateString();

        if ($request->hasFile('image')) {
            $data['image'] = $this->compressAndStore($request->file('image'), 'blogs', 1200, 80);
        }

        $blog = Blog::create($data);
        $this->keepSingleFeatured($blog);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog Added Successfully');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $this->validated($request);
        $data['slug'] = $this->makeSlug($request, $blog->id);
        $data['published_at'] = $data['published_at'] ?? ($blog->published_at ?? now())->toDateString();

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = $this->compressAndStore($request->file('image'), 'blogs', 1200, 80);
        }

        $blog->update($data);
        $this->keepSingleFeatured($blog);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog Updated Successfully');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();

        return response()->json(['message' => 'Blog Deleted Successfully']);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:100',
            'tags' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'short_description' => 'nullable|string',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        unset($data['slug'], $data['image']); // handled separately
        $data['show_home'] = $request->boolean('show_home');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['status'] = $request->boolean('status');

        return $data;
    }

    /** Uses the typed slug if present, otherwise the title, and makes it unique */
    private function makeSlug(Request $request, ?int $ignoreId = null): string
    {
        $base = trim($request->slug ?: $request->title);
        $slug = Str::slug($base) ?: preg_replace('/\s+/u', '-', $base);

        $original = $slug;
        $i = 2;
        while (Blog::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }

    /** Only one post can be the featured one on the listing page */
    private function keepSingleFeatured(Blog $blog): void
    {
        if ($blog->is_featured) {
            Blog::where('id', '!=', $blog->id)->update(['is_featured' => 0]);
        }
    }
}