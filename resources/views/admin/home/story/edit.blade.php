@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>Our Story &amp; Founder</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a><span>›</span>
                        Our Story
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="ok-box">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="err-box"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('admin.home.story.update') }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="create-layout">
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Our Story</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Eyebrow</label>
                                    <input type="text" name="eyebrow" class="field-input" maxlength="120"
                                        value="{{ old('eyebrow', $story->eyebrow) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Title <span class="req">*</span></label>
                                    <input type="text" name="title" class="field-input" maxlength="255" required
                                        value="{{ old('title', $story->title) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">First Paragraph</label>
                                    <textarea name="description" class="field-textarea" maxlength="1000">{{ old('description', $story->description) }}</textarea>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Second Paragraph</label>
                                    <textarea name="description_2" class="field-textarea" maxlength="1000">{{ old('description_2', $story->description_2) }}</textarea>
                                </div>
                                <div class="two-col" style="margin-bottom:16px">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Button Text</label>
                                        <input type="text" name="btn_text" class="field-input" maxlength="60"
                                            value="{{ old('btn_text', $story->btn_text) }}">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Button Link</label>
                                        <input type="text" name="btn_link" class="field-input"
                                            value="{{ old('btn_link', $story->btn_link) }}" placeholder="/page/about-us">
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Image Tag</label>
                                    <input type="text" name="tag" class="field-input" maxlength="80"
                                        value="{{ old('tag', $story->tag) }}" placeholder="e.g. Inspired by Delhi">
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Story Images</h5></div>
                            <div class="section-card-body">
                                @include('admin.home._image-field', [
                                    'name' => 'main_image',
                                    'label' => 'Main Image',
                                    'current' => $story->main_image ? $story->main_image_url : null,
                                ])
                                @include('admin.home._image-field', [
                                    'name' => 'small_image',
                                    'label' => 'Small Image',
                                    'current' => $story->small_image ? $story->small_image_url : null,
                                ])
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Meet the Founder</h5></div>
                            <div class="section-card-body">
                                <div class="two-col" style="margin-bottom:16px">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Name</label>
                                        <input type="text" name="founder_name" class="field-input" maxlength="120"
                                            value="{{ old('founder_name', $story->founder_name) }}">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Role</label>
                                        <input type="text" name="founder_role" class="field-input" maxlength="160"
                                            value="{{ old('founder_role', $story->founder_role) }}">
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Message</label>
                                    <textarea name="founder_message" class="field-textarea" maxlength="600">{{ old('founder_message', $story->founder_message) }}</textarea>
                                </div>
                                @include('admin.home._image-field', [
                                    'name' => 'founder_photo',
                                    'label' => 'Founder Photo',
                                    'current' => $story->founder_photo ? $story->founder_photo_url : null,
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
                                        <option value="1" {{ old('status', (int) $story->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', (int) $story->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.home-page.index') }}" class="btn-secondary-dash">Back</a>
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-save"></i> Save Story</button>
                </div>
            </form>

        </div>
    </div>
</div>
@include('admin.footer')