<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeStory;
use App\Traits\StoresHomeImages;
use Illuminate\Http\Request;

class HomeStoryController extends Controller
{
    use StoresHomeImages;

    public function edit()
    {
        $story = HomeStory::latest('id')->first() ?? new HomeStory(HomeStory::DEFAULTS);

        return view('admin.home.story.edit', compact('story'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'eyebrow' => 'nullable|string|max:120',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'description_2' => 'nullable|string|max:1000',
            'tag' => 'nullable|string|max:80',
            'btn_text' => 'nullable|string|max:60',
            'btn_link' => ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/i'],

            'founder_name' => 'nullable|string|max:120',
            'founder_role' => 'nullable|string|max:160',
            'founder_message' => 'nullable|string|max:600',

            'main_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'small_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'founder_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'required|in:0,1',
        ]);

        $story = HomeStory::latest('id')->first() ?? new HomeStory();

        $data = $request->only([
            'eyebrow', 'title', 'description', 'description_2', 'tag',
            'btn_text', 'btn_link',
            'founder_name', 'founder_role', 'founder_message',
        ]);
        $data['status'] = $request->boolean('status');

        foreach (['main_image' => 1200, 'small_image' => 800, 'founder_photo' => 600] as $field => $width) {
            if ($request->hasFile($field)) {
                $this->deleteStored($story->{$field});
                $data[$field] = $this->compressAndStore($request->file($field), 'home-story', $width);
            }
        }

        $story->fill($data)->save();

        return redirect()->route('admin.home.story.edit')->with('success', 'Story saved successfully.');
    }
}