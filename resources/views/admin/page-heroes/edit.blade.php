@php $has = fn($f) => in_array($f, $cfg['fields']); @endphp
@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>{{ $cfg['label'] }} Banner</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.page-heroes.index') }}">Page Banners</a><span>›</span>
                        {{ $cfg['label'] }}
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="ok-box">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="err-box"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('admin.page-heroes.update', $page) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="create-layout">
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Banner Text</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Eyebrow</label>
                                    <input type="text" name="eyebrow" class="field-input" maxlength="120"
                                        value="{{ old('eyebrow', $hero->eyebrow) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Title (H1) <span class="req">*</span></label>
                                    <textarea name="title" class="field-textarea" maxlength="255" required>{{ old('title', $hero->title) }}</textarea>
                                    <div class="field-hint">This is the page's main heading. Press Enter to start a new line.</div>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Description</label>
                                    <textarea name="description" class="field-textarea" maxlength="600">{{ old('description', $hero->description) }}</textarea>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Image Tag</label>
                                    <input type="text" name="tag" class="field-input" maxlength="80"
                                        value="{{ old('tag', $hero->tag) }}">
                                </div>
                            </div>
                        </div>

                        @if ($has('primary_btn_text'))
                            <div class="section-card">
                                <div class="section-card-header"><h5>Buttons</h5></div>
                                <div class="section-card-body">
                                    <div class="two-col" style="margin-bottom:16px">
                                        <div class="field-group" style="margin:0">
                                            <label class="field-label">Primary Button Text</label>
                                            <input type="text" name="primary_btn_text" class="field-input" maxlength="60"
                                                value="{{ old('primary_btn_text', $hero->primary_btn_text) }}">
                                        </div>
                                        <div class="field-group" style="margin:0">
                                            <label class="field-label">Primary Button Link</label>
                                            <input type="text" name="primary_btn_link" class="field-input"
                                                value="{{ old('primary_btn_link', $hero->primary_btn_link) }}">
                                        </div>
                                    </div>
                                    <div class="two-col">
                                        <div class="field-group" style="margin:0">
                                            <label class="field-label">Secondary Button Text</label>
                                            <input type="text" name="secondary_btn_text" class="field-input" maxlength="60"
                                                value="{{ old('secondary_btn_text', $hero->secondary_btn_text) }}">
                                        </div>
                                        <div class="field-group" style="margin:0">
                                            <label class="field-label">Secondary Button Link</label>
                                            <input type="text" name="secondary_btn_link" class="field-input"
                                                value="{{ old('secondary_btn_link', $hero->secondary_btn_link) }}">
                                        </div>
                                    </div>
                                    <div class="field-hint" style="margin-top:12px">
                                        Link can be a full URL, a site path (/products) or an anchor (#aboutStory). A button shows only when its text is filled.
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="section-card">
                            <div class="section-card-header"><h5>Image</h5></div>
                            <div class="section-card-body">
                                @include('admin.home._image-field', [
                                    'name' => 'image',
                                    'label' => 'Banner Image',
                                    'current' => $hero->image ? $hero->image_url : null,
                                    'hint' => 'Portrait or square · Recommended 900 × 1100 px · Max 5 MB',
                                ])
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="section-card">
                            <div class="section-card-body" style="font-size:12.5px;color:var(--text-secondary);line-height:1.8">
                                @if ($page === 'contact')
                                    The Call and WhatsApp buttons on this banner come from General Settings (phone and WhatsApp).
                                @elseif ($page === 'faqs')
                                    This banner has no buttons.
                                @elseif ($page === 'blogs')
                                    This banner has no buttons. Blog posts have their own images.
                                @else
                                    Leaving the image empty keeps the current or default image.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.page-heroes.index') }}" class="btn-secondary-dash">Back</a>
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-save"></i> Save Banner</button>
                </div>
            </form>

        </div>
    </div>
</div>
@include('admin.footer')