@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>Add Slider</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span>›</span>
                        <a href="{{ route('admin.home.sliders.index') }}">Home Sliders</a>
                        <span>›</span>
                        Add New
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="err-box">
                    <ul>@foreach($errors->all() as $e)
                    <li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.home.sliders.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="create-layout">

                    <!-- LEFT -->
                    <div>

                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Slider Image</h5>
                            </div>
                            <div class="section-card-body">
                                <div class="upload-zone" id="uploadZone">
                                    <input type="file" name="image" id="imageInput" accept=".jpg,.jpeg,.png,.webp"
                                        required>
                                    <div class="uz-icon"><i class="fa fa-cloud-upload"></i></div>
                                    <div class="uz-title">Click or drag image here</div>
                                    <div class="uz-sub">JPG, PNG, WEBP &nbsp;·&nbsp; Recommended: 2048 × 730 px
                                        &nbsp;·&nbsp; Max 5 MB</div>
                                </div>
                                <div id="imgPreview">
                                    <img id="previewImg" src="" alt="Preview">
                                    <div><button type="button" onclick="clearPreview()"><i class="fa fa-times"></i>
                                            Remove</button></div>
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Slide Text <span style="font-weight:400;color:var(--text-hint)">(all
                                        optional)</span></h5>
                            </div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Eyebrow</label>
                                    <input type="text" name="eyebrow" class="field-input" maxlength="120"
                                        value="{{ old('eyebrow') }}" placeholder="Small text above the title">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Title</label>
                                    <textarea name="title" class="field-textarea" maxlength="255"
                                        placeholder="Main headline">{{ old('title') }}</textarea>
                                    <div class="field-hint">Press Enter to start a new line in the headline.</div>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Description</label>
                                    <textarea name="description" class="field-textarea" maxlength="600"
                                        placeholder="One or two lines under the title">{{ old('description') }}</textarea>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Note</label>
                                    <input type="text" name="note" class="field-input" maxlength="160"
                                        value="{{ old('note') }}" placeholder="Small line under the buttons">
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Buttons</h5>
                            </div>
                            <div class="section-card-body">
                                <div class="two-col" style="margin-bottom:16px">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Primary Button Text</label>
                                        <input type="text" name="primary_btn_text" class="field-input" maxlength="60"
                                            value="{{ old('primary_btn_text') }}" placeholder="e.g. Shop Now">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Primary Button Link</label>
                                        <input type="text" name="primary_btn_link" class="field-input"
                                            value="{{ old('primary_btn_link') }}" placeholder="/products">
                                    </div>
                                </div>
                                <div class="two-col">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Secondary Button Text</label>
                                        <input type="text" name="secondary_btn_text" class="field-input" maxlength="60"
                                            value="{{ old('secondary_btn_text') }}"
                                            placeholder="e.g. Explore Collection">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Secondary Button Link</label>
                                        <input type="text" name="secondary_btn_link" class="field-input"
                                            value="{{ old('secondary_btn_link') }}" placeholder="/categories">
                                    </div>
                                </div>
                                <div class="field-hint" style="margin-top:12px">
                                    Link can be a full URL (https://...) or a site path (/products). A button shows on
                                    the site only when both its text and link are filled.
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Settings</h5>
                            </div>
                            <div class="section-card-body" style="padding:14px 20px">

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Sort Order</div>
                                        <div class="toggle-sub">Lower = appears first</div>
                                    </div>
                                    <input type="number" name="sort_order" min="0" value="{{ old('sort_order', 0) }}"
                                        style="width:64px;height:32px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 8px;font-size:13px;font-weight:600;text-align:center;font-family:var(--font);outline:none;">
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Text Theme</div>
                                        <div class="toggle-sub">White = for light images</div>
                                    </div>
                                    <select name="theme" class="field-select-sm">
                                        <option value="default" {{ old('theme', 'default') === 'default' ? 'selected' : '' }}>Default</option>
                                        <option value="white" {{ old('theme') === 'white' ? 'selected' : '' }}>White
                                        </option>
                                    </select>
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visible on homepage</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ old('status', '1') == '0' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Image Tips</h5>
                            </div>
                            <div class="section-card-body"
                                style="padding:14px 20px;font-size:12.5px;color:var(--text-secondary);line-height:1.8">
                                <div>📐 <strong style="color:var(--text-primary)">Size:</strong> 2048 × 730 px</div>
                                <div>🖼️ <strong style="color:var(--text-primary)">Format:</strong> JPG, PNG or WEBP
                                </div>
                                <div>⚡ <strong style="color:var(--text-primary)">Max:</strong> 5 MB</div>
                                <div style="margin-top:8px;font-size:11.5px;color:var(--text-hint)">Leave the text
                                    fields empty to show the image as a plain banner.</div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.home.sliders.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-save"></i> Save Slider</button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    document.getElementById('imageInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imgPreview').style.display = 'block';
            document.getElementById('uploadZone').style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    function clearPreview() {
        document.getElementById('imageInput').value = '';
        document.getElementById('imgPreview').style.display = 'none';
        document.getElementById('uploadZone').style.display = 'block';
    }
</script>