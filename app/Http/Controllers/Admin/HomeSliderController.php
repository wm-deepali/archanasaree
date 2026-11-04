<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class HomeSliderController extends Controller
{
    public function index()
    {
        $sliders = HomeSlider::orderBy('sort_order')->orderBy('id')->paginate(10);

        return view('admin.home.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.home.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(true));

        $data = $this->payload($request);
        $data['image'] = $this->compressAndStore($request->file('image'), 'home-sliders');

        HomeSlider::create($data);

        return redirect()->route('admin.home.sliders.index')->with('success', 'Slider created successfully.');
    }

    public function edit($id)
    {
        $slider = HomeSlider::findOrFail($id);

        return view('admin.home.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $slider = HomeSlider::findOrFail($id);

        $request->validate($this->rules(false));

        $data = $this->payload($request);

        if ($request->hasFile('image')) {
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $this->compressAndStore($request->file('image'), 'home-sliders');
        }

        $slider->update($data);

        return redirect()->route('admin.home.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy($id)
    {
        $slider = HomeSlider::findOrFail($id);

        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return response()->json(['message' => 'Slider deleted successfully.']);
    }

    private function rules(bool $imageRequired): array
    {
        // Links may be a full URL, a site path (/products) or an anchor (#x). Blocks javascript: etc.
        $link = ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/i'];

        return [
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            'eyebrow' => 'nullable|string|max:120',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:600',

            'primary_btn_text' => 'nullable|string|max:60',
            'primary_btn_link' => $link,
            'secondary_btn_text' => 'nullable|string|max:60',
            'secondary_btn_link' => $link,

            'note' => 'nullable|string|max:160',

            'theme' => 'required|in:default,white',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
        ];
    }

    private function payload(Request $request): array
    {
        $data = $request->only([
            'eyebrow',
            'title',
            'description',
            'primary_btn_text',
            'primary_btn_link',
            'secondary_btn_text',
            'secondary_btn_link',
            'note',
            'theme',
        ]);

        $data['sort_order'] = (int) $request->input('sort_order', 0);
        $data['status'] = $request->boolean('status');

        return $data;
    }

    /** Compress and store an uploaded image as WebP (hero banners, so keep width generous). */
    private function compressAndStore(UploadedFile $file, string $folder, int $maxWidth = 1920, int $quality = 80): string
    {
        $manager = ImageManager::usingDriver(Driver::class);
        $image = $manager->decode($file);

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: $quality);

        $path = trim($folder, '/') . '/' . Str::uuid() . '.webp';
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }
}