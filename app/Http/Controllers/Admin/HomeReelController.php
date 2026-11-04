<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeReel;
use App\Traits\StoresHomeImages;
use Illuminate\Http\Request;

class HomeReelController extends Controller
{
    use StoresHomeImages;

    public function index()
    {
        $reels = HomeReel::ordered()->paginate(10);

        return view('admin.home.reels.index', compact('reels'));
    }

    public function create()
    {
        $reel = new HomeReel(['status' => 1, 'sort_order' => 0]);

        return view('admin.home.reels.form', compact('reel'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(true));

        $data = $this->payload($request);
        $data['thumbnail'] = $this->compressAndStore($request->file('thumbnail'), 'home-reels', 900);

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('home-reels/videos', 'public');
        }

        HomeReel::create($data);

        return redirect()->route('admin.home.reels.index')->with('success', 'Reel created successfully.');
    }

    public function edit($id)
    {
        $reel = HomeReel::findOrFail($id);

        return view('admin.home.reels.form', compact('reel'));
    }

    public function update(Request $request, $id)
    {
        $reel = HomeReel::findOrFail($id);

        $request->validate($this->rules(false));

        $data = $this->payload($request);

        if ($request->hasFile('thumbnail')) {
            $this->deleteStored($reel->thumbnail);
            $data['thumbnail'] = $this->compressAndStore($request->file('thumbnail'), 'home-reels', 900);
        }

        if ($request->hasFile('video')) {
            $this->deleteStored($reel->video);
            $data['video'] = $request->file('video')->store('home-reels/videos', 'public');
        } elseif ($request->boolean('remove_video')) {
            $this->deleteStored($reel->video);
            $data['video'] = null;
        }

        $reel->update($data);

        return redirect()->route('admin.home.reels.index')->with('success', 'Reel updated successfully.');
    }

    public function destroy($id)
    {
        $reel = HomeReel::findOrFail($id);

        $this->deleteStored($reel->thumbnail);
        $this->deleteStored($reel->video);

        $reel->delete();

        return response()->json(['message' => 'Reel deleted successfully.']);
    }

    private function rules(bool $thumbRequired): array
    {
        return [
            'title' => 'required|string|max:120',
            'subtitle' => 'nullable|string|max:160',
            'thumbnail' => [$thumbRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video' => 'nullable|file|mimetypes:video/mp4,video/webm|max:30720',
            'video_url' => ['nullable', 'string', 'max:255', 'regex:/^https?:\/\//i'],
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
        ];
    }

    private function payload(Request $request): array
    {
        $data = $request->only(['title', 'subtitle', 'video_url']);
        $data['sort_order'] = (int) $request->input('sort_order', 0);
        $data['status'] = $request->boolean('status');

        return $data;
    }
}