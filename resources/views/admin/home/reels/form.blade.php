@php $isEdit = $reel->exists; @endphp
@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>{{ $isEdit ? 'Edit Reel' : 'Add Reel' }}</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a><span>›</span>
                        <a href="{{ route('admin.home.reels.index') }}">Reels</a><span>›</span>
                        {{ $isEdit ? 'Edit' : 'Add New' }}
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="err-box"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" enctype="multipart/form-data"
                action="{{ $isEdit ? route('admin.home.reels.update', $reel->id) : route('admin.home.reels.store') }}">
                @csrf
                @if ($isEdit) @method('PUT') @endif

                <div class="create-layout">
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Reel Details</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Title <span class="req">*</span></label>
                                    <input type="text" name="title" class="field-input" maxlength="120" required
                                        value="{{ old('title', $reel->title) }}" placeholder="e.g. Bridal Edit">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Subtitle</label>
                                    <input type="text" name="subtitle" class="field-input" maxlength="160"
                                        value="{{ old('subtitle', $reel->subtitle) }}" placeholder="e.g. Made for the big day.">
                                </div>

                                @include('admin.home._image-field', [
                                    'name' => 'thumbnail',
                                    'label' => 'Cover Image' . ($isEdit ? '' : ' *'),
                                    'current' => $isEdit ? $reel->thumbnail_url : null,
                                    'hint' => 'Portrait · Recommended 720 × 1280 px · Max 5 MB',
                                ])
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Video <span style="font-weight:400;color:var(--text-hint)">(optional)</span></h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Upload Video</label>
                                    <input type="file" name="video" class="field-input" style="padding-top:7px" accept="video/mp4,video/webm">
                                    <div class="field-hint">MP4 or WEBM · Max 30 MB.
                                        @if ($isEdit && $reel->video)
                                            A video is already uploaded; choosing a new file replaces it.
                                        @endif
                                    </div>
                                    @if ($isEdit && $reel->video)
                                        <label style="font-size:12.5px;margin-top:8px;display:block">
                                            <input type="checkbox" name="remove_video" value="1"> Remove the uploaded video
                                        </label>
                                    @endif
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Or Video Link</label>
                                    <input type="text" name="video_url" class="field-input"
                                        value="{{ old('video_url', $reel->video_url) }}" placeholder="https://...">
                                    <div class="field-hint">Used only when no video is uploaded. Without either, the play button is hidden.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body" style="padding:14px 20px">
                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Sort Order</div>
                                        <div class="toggle-sub">Lower = appears first</div>
                                    </div>
                                    <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $reel->sort_order ?? 0) }}"
                                        style="width:64px;height:32px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 8px;font-size:13px;font-weight:600;text-align:center;font-family:var(--font);outline:none;">
                                </div>
                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visible on homepage</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ old('status', (int) $reel->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', (int) $reel->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.home.reels.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-save"></i> Save Reel</button>
                </div>
            </form>

        </div>
    </div>
</div>
@include('admin.footer')