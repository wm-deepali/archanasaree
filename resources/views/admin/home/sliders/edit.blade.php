@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>Edit Slider</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span>›</span>
                        <a href="{{ route('admin.home.sliders.index') }}">Home Sliders</a>
                        <span>›</span>
                        Edit
                    </div>
                </div>

                @if($slider->image)
                    <div class="slider-identity">
                        <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider #{{ $slider->id }}">
                        <div class="slider-identity-info">
                            <div class="name">{{ $slider->eyebrow ?: 'Slider #' . $slider->id }}</div>
                            <div class="meta">Sort: {{ $slider->sort_order }} &nbsp;·&nbsp;
                                {{ $slider->status ? 'Active' : 'Inactive' }}</div>
                        </div>
                    </div>
                @endif
            </div>

            @if ($errors->any())
                <div class="err-box">
                    <ul>@foreach($errors->all() as $e)
                    <li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.home.sliders.update', $slider->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="create-layout">

                    <!-- LEFT -->
                    <div>

                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Slider Image</h5>
                            </div>
                            <div class="section-card-body">

                                @if($slider->image)
                                    <div class="current-img-wrap" id="currentImgWrap">
                                        <img src="{{ asset('storage/' . $slider->image) }}" alt="Current slider">
                                        <div class="current-img-info">
                                            <strong>Current Image</strong>
                                            <span>Upload a new file below to replace it.</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="upload-zone" id="uploadZone">
                                    <input type="file" name="image" id="imageInput" accept=".jpg,.jpeg,.png,.webp">
                                    <div class="uz-icon"><i class="fa fa-cloud-upload"></i></div>
                                    <div class="uz-title">{{ $slider->image ? 'Replace image' : 'Upload image' }}</div>
                                    <div class="uz-sub">JPG, PNG, WEBP &nbsp;·&nbsp; 2048 × 730 px recommended
                                        &nbsp;·&nbsp; Max 5 MB</div>
                                </div>

                                <div id="newImgPreview">
                                    <img id="previewImg" src="" alt="New preview">
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
                                        value="{{ old('eyebrow', $slider->eyebrow) }}"
                                        placeholder="Small text above the title">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Title</label>
                                    <textarea name="title" class="field-textarea" maxlength="255"
                                        placeholder="Main headline">{{ old('title', $slider->title) }}</textarea>
                                    <div class="field-hint">Press Enter to start a new line in the headline.</div>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Description</label>
                                    <textarea name="description" class="field-textarea" maxlength="600"
                                        placeholder="One or two lines under the title">{{ old('description', $slider->description) }}</textarea>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Note</label>
                                    <input type="text" name="note" class="field-input" maxlength="160"
                                        value="{{ old('note', $slider->note) }}"
                                        placeholder="Small line under the buttons">
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
                                            value="{{ old('primary_btn_text', $slider->primary_btn_text) }}"
                                            placeholder="e.g. Shop Now">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Primary Button Link</label>
                                        <input type="text" name="primary_btn_link" class="field-input"
                                            value="{{ old('primary_btn_link', $slider->primary_btn_link) }}"
                                            placeholder="/products">
                                    </div>
                                </div>
                                <div class="two-col">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Secondary Button Text</label>
                                        <input type="text" name="secondary_btn_text" class="field-input" maxlength="60"
                                            value="{{ old('secondary_btn_text', $slider->secondary_btn_text) }}"
                                            placeholder="e.g. Explore Collection">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Secondary Button Link</label>
                                        <input type="text" name="secondary_btn_link" class="field-input"
                                            value="{{ old('secondary_btn_link', $slider->secondary_btn_link) }}"
                                            placeholder="/categories">
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
                                @php $currentStatus = (string) old('status', $slider->status ? 1 : 0); @endphp

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Sort Order</div>
                                        <div class="toggle-sub">Lower = appears first</div>
                                    </div>
                                    <input type="number" name="sort_order" min="0"
                                        value="{{ old('sort_order', $slider->sort_order) }}"
                                        style="width:64px;height:32px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 8px;font-size:13px;font-weight:600;text-align:center;font-family:var(--font);outline:none;">
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Text Theme</div>
                                        <div class="toggle-sub">White = for light images</div>
                                    </div>
                                    <select name="theme" class="field-select-sm">
                                        <option value="default" {{ old('theme', $slider->theme) === 'default' ? 'selected' : '' }}>Default</option>
                                        <option value="white" {{ old('theme', $slider->theme) === 'white' ? 'selected' : '' }}>White</option>
                                    </select>
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visible on homepage</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ $currentStatus === '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $currentStatus === '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Record Info</h5>
                            </div>
                            <div class="section-card-body" style="padding:14px 20px">
                                <div class="info-row">
                                    <span class="info-label">Slider ID</span>
                                    <span class="info-value"
                                        style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--accent)">#{{ $slider->id }}</span>
                                </div>
                                @if($slider->created_at)
                                    <div class="info-row">
                                        <span class="info-label">Created</span>
                                        <span class="info-value">{{ $slider->created_at->format('d M Y') }}</span>
                                    </div>
                                @endif
                                @if($slider->updated_at)
                                    <div class="info-row">
                                        <span class="info-label">Updated</span>
                                        <span class="info-value">{{ $slider->updated_at->format('d M Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.home.sliders.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-save"></i> Update Slider</button>
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
            document.getElementById('newImgPreview').style.display = 'block';
            document.getElementById('uploadZone').style.display = 'none';
            const cur = document.getElementById('currentImgWrap');
            if (cur) cur.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    function clearPreview() {
        document.getElementById('imageInput').value = '';
        document.getElementById('newImgPreview').style.display = 'none';
        document.getElementById('uploadZone').style.display = 'block';
        const cur = document.getElementById('currentImgWrap');
        if (cur) cur.style.display = 'flex';
    }
</script>