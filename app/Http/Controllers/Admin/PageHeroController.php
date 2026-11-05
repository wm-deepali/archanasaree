<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageHero;
use App\Traits\StoresHomeImages;
use Illuminate\Http\Request;

class PageHeroController extends Controller
{
    use StoresHomeImages;

    public function index()
    {
        $saved = PageHero::pluck('updated_at', 'page_key');

        return view('admin.page-heroes.index', compact('saved'));
    }

    public function edit(string $page)
    {
        $cfg = $this->config($page);
        $hero = PageHero::forPage($page);

        return view('admin.page-heroes.edit', compact('page', 'cfg', 'hero'));
    }

    public function update(Request $request, string $page)
    {
        $cfg = $this->config($page);
        $link = ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/i'];

        $rules = [
            'eyebrow' => 'nullable|string|max:120',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:600',
            'tag' => 'nullable|string|max:80',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'primary_btn_text' => 'nullable|string|max:60',
            'primary_btn_link' => $link,
            'secondary_btn_text' => 'nullable|string|max:60',
            'secondary_btn_link' => $link,
        ];

        $request->validate(array_intersect_key($rules, array_flip($cfg['fields'])));

        $hero = PageHero::where('page_key', $page)->first() ?? new PageHero(['page_key' => $page]);

        $data = $request->only(array_diff($cfg['fields'], ['image']));

        if ($request->hasFile('image')) {
            $this->deleteStored($hero->image);
            $data['image'] = $this->compressAndStore($request->file('image'), 'page-heroes', 1400);
        }

        $hero->fill($data)->save();

        return redirect()->route('admin.page-heroes.edit', $page)
            ->with('success', $cfg['label'] . ' banner saved successfully.');
    }

    private function config(string $page): array
    {
        abort_unless(isset(PageHero::PAGES[$page]), 404);

        return PageHero::PAGES[$page];
    }
}