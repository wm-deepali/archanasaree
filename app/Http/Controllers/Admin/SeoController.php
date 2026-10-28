<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SeoPage;

class SeoController extends Controller
{
    public function index(Request $request)
    {
        $pages = SeoPage::query()
            ->when($request->filled('group'), fn ($q) => $q->where('page_group', $request->group))
            ->orderByRaw("FIELD(page_group, 'main', 'service', 'industry', 'general')")
            ->orderBy('id')
            ->get();

        $groups = SeoPage::select('page_group')->distinct()->pluck('page_group');

        return view('admin.seo.index', compact('pages', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $page = SeoPage::findOrFail($id);

        $data = $request->validate([
            'meta_title'          => ['nullable', 'string', 'max:255'],
            'meta_description'    => ['nullable', 'string', 'max:500'],
            'meta_keywords'       => ['nullable', 'string', 'max:255'],
            'canonical_url'       => ['nullable', 'url', 'max:255'],
            'robots'              => ['required', Rule::in([
                'index, follow',
                'index, nofollow',
                'noindex, follow',
                'noindex, nofollow',
            ])],

            'og_title'            => ['nullable', 'string', 'max:255'],
            'og_description'      => ['nullable', 'string', 'max:500'],
            'og_image'            => ['nullable', 'string', 'max:255'],
            'og_type'             => ['required', Rule::in(['website', 'article', 'product', 'profile'])],

            'twitter_card'        => ['required', Rule::in(['summary', 'summary_large_image'])],
            'twitter_title'       => ['nullable', 'string', 'max:255'],
            'twitter_description' => ['nullable', 'string', 'max:500'],
            'twitter_image'       => ['nullable', 'string', 'max:255'],

            'schema_markup'       => ['nullable', 'string', function ($attr, $value, $fail) {
                if ($value !== null && trim($value) !== '') {
                    json_decode($value);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $fail('Schema markup must be valid JSON-LD: ' . json_last_error_msg());
                    }
                }
            }],
            'scripts'             => ['nullable', 'string'],
            'body_scripts'        => ['nullable', 'string'],

            'sitemap_priority'    => ['required', 'numeric', 'between:0,1'],
            'sitemap_changefreq'  => ['required', Rule::in(['daily', 'weekly', 'monthly', 'yearly'])],
        ]);

        // Checkboxes (unchecked = not sent)
        $data['in_sitemap'] = $request->boolean('in_sitemap');
        $data['is_active']  = $request->boolean('is_active');

        // Slug / page_key / page_name are system-managed (tied to routes) – not editable here.
        $page->update($data);

        return back()->with('success', 'SEO updated successfully for "' . $page->page_name . '".');
    }
}