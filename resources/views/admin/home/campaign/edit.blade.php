@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>Lehenga Campaign</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a><span>›</span>
                        Campaign
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="ok-box">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="err-box"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('admin.home.campaign.update') }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="create-layout">
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Content</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Eyebrow</label>
                                    <input type="text" name="eyebrow" class="field-input" maxlength="120"
                                        value="{{ old('eyebrow', $campaign->eyebrow) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Title <span class="req">*</span></label>
                                    <textarea name="title" class="field-textarea" maxlength="255" required>{{ old('title', $campaign->title) }}</textarea>
                                    <div class="field-hint">Press Enter to start a new line in the headline.</div>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Description</label>
                                    <textarea name="description" class="field-textarea" maxlength="600">{{ old('description', $campaign->description) }}</textarea>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Highlights</label>
                                    <textarea name="highlights" class="field-textarea" maxlength="500">{{ old('highlights', $campaign->highlights) }}</textarea>
                                    <div class="field-hint">One point per line. They show as the small list under the buttons.</div>
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Buttons</h5></div>
                            <div class="section-card-body">
                                <div class="two-col" style="margin-bottom:16px">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Primary Button Text</label>
                                        <input type="text" name="primary_btn_text" class="field-input" maxlength="60"
                                            value="{{ old('primary_btn_text', $campaign->primary_btn_text) }}">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Primary Button Link</label>
                                        <input type="text" name="primary_btn_link" class="field-input"
                                            value="{{ old('primary_btn_link', $campaign->primary_btn_link) }}" placeholder="/categories/lehenga">
                                    </div>
                                </div>
                                <div class="two-col">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Secondary Button Text</label>
                                        <input type="text" name="secondary_btn_text" class="field-input" maxlength="60"
                                            value="{{ old('secondary_btn_text', $campaign->secondary_btn_text) }}">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Secondary Button Link</label>
                                        <input type="text" name="secondary_btn_link" class="field-input"
                                            value="{{ old('secondary_btn_link', $campaign->secondary_btn_link) }}">
                                    </div>
                                </div>
                                <div class="field-hint" style="margin-top:12px">
                                    Link can be a full URL (https://...) or a site path (/products). A button shows on the site only when both its text and link are filled.
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Images</h5></div>
                            <div class="section-card-body">
                                @include('admin.home._image-field', [
                                    'name' => 'bg_image',
                                    'label' => 'Background Image',
                                    'current' => $campaign->bg_image ? $campaign->bg_image_url : null,
                                    'hint' => 'Wide banner · Recommended 1920 × 800 px · Max 5 MB',
                                ])
                                @include('admin.home._image-field', [
                                    'name' => 'image',
                                    'label' => 'Side Photo',
                                    'current' => $campaign->image ? $campaign->image_url : null,
                                    'hint' => 'Portrait photo · Recommended 800 × 1000 px · Max 5 MB',
                                ])
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body" style="padding:14px 20px">
                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Show on homepage</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ old('status', (int) $campaign->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', (int) $campaign->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="section-card">
                            <div class="section-card-body" style="font-size:12.5px;color:var(--text-secondary);line-height:1.8">
                                Images left empty keep the current or default image.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.home-page.index') }}" class="btn-secondary-dash">Back</a>
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-save"></i> Save Campaign</button>
                </div>
            </form>

        </div>
    </div>
</div>
@include('admin.footer')