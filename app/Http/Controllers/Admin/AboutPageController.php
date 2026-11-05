<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutItem;
use App\Models\AboutSection;
use App\Traits\StoresHomeImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutPageController extends Controller
{
    use StoresHomeImages;

    private const IMAGE_FIELDS = ['image', 'image_2'];

    public function index()
    {
        $sections = AboutSection::withCount('items')->get()->keyBy('key');

        return view('admin.about.index', compact('sections'));
    }

    public function edit(string $key)
    {
        $cfg = $this->config($key);

        $section = AboutSection::with('items')->firstOrNew(['key' => $key]);

        return view('admin.about.edit', compact('key', 'cfg', 'section'));
    }

    public function update(Request $request, string $key)
    {
        $cfg = $this->config($key);

        $request->validate($this->rules($cfg));

        $section = AboutSection::firstOrNew(['key' => $key]);

        $data = $request->only(array_diff($cfg['fields'], self::IMAGE_FIELDS));
        $data['status'] = $request->boolean('status');

        foreach (array_intersect(self::IMAGE_FIELDS, $cfg['fields']) as $field) {
            if ($request->hasFile($field)) {
                $this->deleteStored($section->{$field});
                $data[$field] = $this->compressAndStore($request->file($field), 'about', 1400);
            }
        }

        DB::transaction(function () use ($section, $data, $cfg, $request, $key) {
            $section->fill($data)->save();

            // items: rebuild from the submitted rows (row order = display order)
            AboutItem::where('section_key', $key)->delete();

            foreach (array_keys($cfg['groups'] ?? []) as $group) {
                $order = 0;
                foreach ((array) $request->input("items.$group", []) as $row) {
                    if (blank($row['title'] ?? null)) {
                        continue;   // skip empty rows
                    }

                    AboutItem::create([
                        'section_key' => $key,
                        'group_key' => $group,
                        'title' => $row['title'],
                        'description' => $row['description'] ?? null,
                        'icon' => $row['icon'] ?? null,
                        'value' => $row['value'] ?? null,
                        'link' => $row['link'] ?? null,
                        'sort_order' => ++$order,
                        'status' => true,
                    ]);
                }
            }
        });

        return redirect()->route('admin.about.edit', $key)->with('success', $cfg['label'] . ' saved successfully.');
    }

    private function config(string $key): array
    {
        abort_unless(isset(AboutSection::SECTIONS[$key]), 404);

        return AboutSection::SECTIONS[$key];
    }

    private function rules(array $cfg): array
    {
        $link = ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/i'];

        $rules = ['status' => 'required|in:0,1'];

        foreach ($cfg['fields'] as $f) {
            $rules[$f] = match ($f) {
                'image', 'image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'btn_link' => $link,
                'title' => 'required|string|max:255',
                'description', 'description_2', 'description_3' => 'nullable|string|max:1500',
                default => 'nullable|string|max:160',
            };
        }

        foreach (($cfg['groups'] ?? []) as $g => $gc) {
            $rules["items.$g"] = 'nullable|array|max:' . ($gc['max'] ?? 12);

            foreach ($gc['fields'] as $f) {
                $rules["items.$g.*.$f"] = match ($f) {
                    'description' => 'nullable|string|max:500',
                    'link' => $link,
                    'icon' => ['nullable', 'string', 'max:60', 'regex:/^[a-z0-9\- ]+$/i'],
                    default => 'nullable|string|max:160',
                };
            }
        }

        return $rules;
    }
}