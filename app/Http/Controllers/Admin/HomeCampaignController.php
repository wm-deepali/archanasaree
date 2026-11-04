<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeCampaign;
use App\Traits\StoresHomeImages;
use Illuminate\Http\Request;

class HomeCampaignController extends Controller
{
    use StoresHomeImages;

    public function edit()
    {
        $campaign = HomeCampaign::latest('id')->first() ?? new HomeCampaign(HomeCampaign::DEFAULTS);

        return view('admin.home.campaign.edit', compact('campaign'));
    }

    public function update(Request $request)
    {
        $link = ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/i'];

        $request->validate([
            'eyebrow' => 'nullable|string|max:120',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:600',
            'primary_btn_text' => 'nullable|string|max:60',
            'primary_btn_link' => $link,
            'secondary_btn_text' => 'nullable|string|max:60',
            'secondary_btn_link' => $link,
            'highlights' => 'nullable|string|max:500',
            'bg_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'required|in:0,1',
        ]);

        $campaign = HomeCampaign::latest('id')->first() ?? new HomeCampaign();

        $data = $request->only([
            'eyebrow', 'title', 'description',
            'primary_btn_text', 'primary_btn_link',
            'secondary_btn_text', 'secondary_btn_link',
            'highlights',
        ]);
        $data['status'] = $request->boolean('status');

        foreach (['bg_image' => 1920, 'image' => 1000] as $field => $width) {
            if ($request->hasFile($field)) {
                $this->deleteStored($campaign->{$field});
                $data[$field] = $this->compressAndStore($request->file($field), 'home-campaign', $width);
            }
        }

        $campaign->fill($data)->save();

        return redirect()->route('admin.home.campaign.edit')->with('success', 'Campaign saved successfully.');
    }
}