@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
        .cke_notifications_area,
        .cke_notification,
        .cke_notification_warning { display: none !important; }

        :root {
            --bg: #f1f2f4;
            --surface: #ffffff;
            --border: #e3e5e8;
            --text-primary: #202223;
            --text-secondary: #6d7175;
            --text-hint: #8c9196;
            --accent: #303d89;
            --accent-light: #f0f1fc;
            --red: #b22222;
            --red-bg: #fce8e8;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .page-edit { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
        .page-edit * { box-sizing: border-box; }

        .page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
        .page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
        .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
        .crumb a { color: var(--accent); text-decoration: none; }
        .crumb a:hover { text-decoration: underline; }
        .crumb span { margin: 0 5px; }

        .alert-error { background: var(--red-bg); color: var(--red); border: 1px solid #f5c6c6; border-radius: var(--radius-sm); padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }
        .alert-error ul { margin: 0; padding-left: 18px; }

        .page-identity { display: flex; align-items: center; gap: 10px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 10px 16px; box-shadow: var(--shadow-card); }
        .page-identity-icon { width: 36px; height: 36px; border-radius: var(--radius-sm); background: var(--accent-light); display: flex; align-items: center; justify-content: center; font-size: 15px; color: var(--accent); flex-shrink: 0; }
        .page-identity-name { font-size: 13px; font-weight: 650; color: var(--text-primary); }
        .page-identity-id { font-size: 12px; color: var(--text-hint); margin-top: 1px; font-family: 'SF Mono', 'Fira Code', monospace; }

        .edit-layout { display: grid; grid-template-columns: 1fr 280px; gap: 20px; align-items: start; }
        @media(max-width:960px) { .edit-layout { grid-template-columns: 1fr; } }

        .section-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 16px; }
        .section-card:last-child { margin-bottom: 0; }
        .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; }
        .section-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
        .section-card-body { padding: 20px; }

        .field-group { margin-bottom: 16px; }
        .field-group:last-child { margin-bottom: 0; }
        .field-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; margin-bottom: 6px; }
        .field-label .req { color: var(--red); margin-left: 2px; }
        .field-hint { font-size: 11.5px; color: var(--text-hint); margin-top: 4px; }

        .field-input, .field-select, .field-textarea {
            width: 100%; border: 1px solid var(--border); border-radius: var(--radius-sm);
            padding: 0 12px; font-size: 13.5px; color: var(--text-primary); background: var(--surface);
            outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--font);
        }
        .field-input, .field-select { height: 38px; }
        .field-textarea { padding: 10px 12px; resize: vertical; min-height: 90px; }
        .field-input:focus, .field-select:focus, .field-textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48, 61, 137, .12); }

        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        @media(max-width:600px) { .two-col { grid-template-columns: 1fr; } }

        .field-select-sm {
            height: 32px; border: 1px solid var(--border); border-radius: var(--radius-sm);
            padding: 0 28px 0 10px; font-size: 12.5px; color: var(--text-primary); background: var(--surface);
            outline: none; font-family: var(--font); min-width: 110px; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 9px center; transition: border-color .15s;
        }
        .field-select-sm:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48, 61, 137, .12); }

        .toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--bg); }
        .toggle-label { font-size: 13px; font-weight: 500; color: var(--text-primary); }
        .toggle-sub { font-size: 11.5px; color: var(--text-hint); margin-top: 1px; }

        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid var(--bg); font-size: 13px; }
        .info-row:first-child { padding-top: 0; }
        .info-row:last-child { border-bottom: none; padding-bottom: 0; }
        .info-label { color: var(--text-hint); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .03em; }
        .info-value { font-weight: 600; color: var(--text-primary); }
        .mono { font-family: 'SF Mono', 'Fira Code', monospace; font-size: 12px; color: var(--accent); }

        .ph-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid var(--bg); font-size: 12.5px; }
        .ph-row:last-child { border-bottom: none; }
        .ph-row .k { color: var(--text-hint); }
        .ph-row .v { font-family: monospace; color: var(--accent); font-size: 12px; }

        .cke { border-radius: var(--radius-sm) !important; border: 1px solid var(--border) !important; overflow: hidden; }
        .cke_top { background: #fafafa !important; border-bottom: 1px solid var(--border) !important; }

        .btn-primary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--accent); color: #fff !important; border: none; border-radius: var(--radius-sm); padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none !important; font-family: var(--font); transition: background .15s; box-shadow: 0 1px 3px rgba(48, 61, 137, .25); }
        .btn-primary-dash:hover { background: #252f70; }
        .btn-secondary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary) !important; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 18px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none !important; font-family: var(--font); transition: background .15s; }
        .btn-secondary-dash:hover { background: var(--bg); }

        .action-bar { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 20px; }

        @media(max-width:768px) { .page-edit { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="page-edit">

            <div class="page-header">
                <div>
                    <h1>Edit Dynamic Page</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.pages.index') }}">Dynamic Pages</a>
                        <span>›</span>
                        Edit Page
                    </div>
                </div>

                <div class="page-identity">
                    <div class="page-identity-icon"><i class="fa fa-file-text-o"></i></div>
                    <div>
                        <div class="page-identity-name">{{ $page->heading ?: $page->slug }}</div>
                        <div class="page-identity-id">/{{ $page->slug }} &nbsp;·&nbsp; ID #{{ $page->id }}</div>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.pages.update', $page->id) }}">
                @csrf
                @method('PUT')

                <div class="edit-layout">

                    <!-- LEFT -->
                    <div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Page Details</h5></div>
                            <div class="section-card-body">

                                <div class="two-col" style="margin-bottom:16px">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Heading <span class="req">*</span></label>
                                        <input type="text" name="heading" class="field-input"
                                            value="{{ old('heading', $page->heading) }}">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Slug</label>
                                        <input type="text" name="slug" class="field-input"
                                            value="{{ old('slug', $page->slug) }}">
                                        <div class="field-hint">Used in the URL: /page/<strong>slug</strong></div>
                                    </div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Short Description</label>
                                    <textarea name="short_description" class="field-textarea"
                                        style="min-height:70px">{{ old('short_description', $page->short_description) }}</textarea>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Page Content <span class="req">*</span></label>
                                    <textarea name="content" id="content" class="field-textarea editor"
                                        style="min-height:200px">{{ old('content', $page->content) }}</textarea>
                                </div>

                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>SEO</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="field-input"
                                        value="{{ old('meta_title', $page->meta_title) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Meta Description</label>
                                    <textarea name="meta_description"
                                        class="field-textarea">{{ old('meta_description', $page->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body" style="padding:14px 20px">
                                @php $currentStatus = (string) old('status', $page->status ? 1 : 0); @endphp
                                <div class="toggle-row" style="padding:0;border:none">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visible to visitors</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ $currentStatus === '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $currentStatus === '0' ? 'selected' : '' }}>Blocked</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Content Placeholders</h5></div>
                            <div class="section-card-body" style="padding:14px 20px">
                                <div class="field-hint" style="margin:0 0 8px">
                                    Use these in the content. They are replaced with values from Settings.
                                </div>
                                <div class="ph-row"><span class="k">Site name</span><span class="v">[[site_name]]</span></div>
                                <div class="ph-row"><span class="k">Email</span><span class="v">[[email]]</span></div>
                                <div class="ph-row"><span class="k">Phone</span><span class="v">[[phone]]</span></div>
                                <div class="ph-row"><span class="k">Address</span><span class="v">[[address]]</span></div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Record Info</h5></div>
                            <div class="section-card-body" style="padding:14px 20px">
                                <div class="info-row">
                                    <span class="info-label">Page ID</span>
                                    <span class="info-value mono">#{{ $page->id }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Slug</span>
                                    <span class="info-value mono">{{ $page->slug }}</span>
                                </div>
                                @if($page->created_at)
                                    <div class="info-row">
                                        <span class="info-label">Created</span>
                                        <span class="info-value">{{ $page->created_at->format('d M Y') }}</span>
                                    </div>
                                @endif
                                @if($page->updated_at)
                                    <div class="info-row">
                                        <span class="info-label">Updated</span>
                                        <span class="info-value">{{ $page->updated_at->format('d M Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.pages.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Update Page
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    CKEDITOR.config.versionCheck = false;
    CKEDITOR.replace('content');
</script>