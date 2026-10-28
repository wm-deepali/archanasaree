@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg:            #f1f2f4;
        --surface:       #ffffff;
        --border:        #e3e5e8;
        --text-primary:  #202223;
        --text-secondary:#6d7175;
        --text-hint:     #8c9196;
        --accent:        #303d89;
        --accent-light:  #f0f1fc;
        --green:         #007a5e;
        --green-bg:      #e3f1ec;
        --red:           #b22222;
        --red-bg:        #fce8e8;
        --amber:         #8a5a00;
        --amber-bg:      #fff4dc;
        --radius-sm:     8px;
        --radius-md:     12px;
        --shadow-card:   0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:          'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .list-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .list-page * { box-sizing: border-box; }

    .list-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .list-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    .alert-banner { display: flex; align-items: flex-start; gap: 8px; padding: 11px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; margin-bottom: 16px; }
    .alert-success { background: var(--green-bg); color: var(--green); border: 1px solid rgba(0,122,94,.18); }
    .alert-danger  { background: var(--red-bg); color: var(--red); border: 1px solid rgba(178,34,34,.18); }
    .alert-danger ul { margin: 0; padding-left: 16px; }

    .list-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }
    .list-card-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
    .list-card-header h5 { font-size: 14px; font-weight: 650; color: var(--text-primary); margin: 0; }

    /* group filter pills */
    .filter-pills { display: flex; gap: 6px; flex-wrap: wrap; }
    .pill-link { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-decoration: none; color: var(--text-secondary); background: var(--bg); border: 1px solid var(--border); text-transform: capitalize; }
    .pill-link:hover { color: var(--text-primary); text-decoration: none; }
    .pill-link.active { background: var(--accent-light); color: var(--accent); border-color: rgba(48,61,137,.25); }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead tr { background: #fafafa; border-bottom: 1px solid var(--border); }
    .data-table thead th { padding: 10px 16px; font-size: 11px; font-weight: 650; text-transform: uppercase; letter-spacing: .05em; color: var(--text-secondary); white-space: nowrap; text-align: left; }
    .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table td { padding: 13px 16px; font-size: 13px; color: var(--text-primary); vertical-align: middle; }

    .id-chip { display: inline-block; background: var(--bg); border: 1px solid var(--border); border-radius: 6px; padding: 2px 8px; font-size: 11.5px; font-family: 'SF Mono','Fira Mono',monospace; color: var(--text-secondary); }
    .page-name { font-size: 13.5px; font-weight: 600; color: var(--text-primary); line-height: 1.4; display: block; }
    .page-slug { font-size: 11.5px; color: var(--text-hint); font-family: 'SF Mono','Fira Mono',monospace; }
    .meta-title-cell { font-size: 12.5px; color: var(--text-secondary); max-width: 380px; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .text-empty { color: var(--text-hint); }

    .badge-chip { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: capitalize; }
    .badge-group  { background: var(--accent-light); color: var(--accent); }
    .badge-ok     { background: var(--green-bg); color: var(--green); }
    .badge-warn   { background: var(--amber-bg); color: var(--amber); }
    .badge-off    { background: var(--red-bg); color: var(--red); }

    .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); cursor: pointer; text-decoration: none; transition: all .15s; font-size: 12px; }
    .action-btn:hover      { background: var(--bg); color: var(--text-primary); border-color: #c9cccf; }
    .action-btn.edit:hover { background: var(--accent-light); color: var(--accent); border-color: rgba(48,61,137,.25); }

    .empty-state { text-align: center; padding: 56px 24px; }
    .empty-icon-wrap { width: 56px; height: 56px; border-radius: 50%; background: var(--accent-light); margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 22px; }
    .empty-state h6 { font-size: 14px; font-weight: 650; color: var(--text-primary); margin: 0 0 6px; }
    .empty-state p  { font-size: 13px; color: var(--text-hint); margin: 0; }

    @media(max-width:768px) { .list-page { padding: 16px; } }

    /* ════════════════ MODAL ════════════════ */
    #seoModal .modal-content { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; font-family: var(--font); }
    #seoModal .modal-header { padding: 16px 20px; border-bottom: 1px solid var(--border); background: #fafafa; align-items: center; }
    #seoModal .modal-title { font-size: 14px; font-weight: 650; color: var(--text-primary); }
    #seoModal .modal-title small { font-weight: 500; color: var(--text-hint); margin-left: 8px; font-family: 'SF Mono','Fira Mono',monospace; font-size: 11.5px; }
    #seoModal .modal-header .close { font-size: 20px; color: var(--text-hint); opacity: 1; text-shadow: none; transition: color .15s; }
    #seoModal .modal-header .close:hover { color: var(--text-primary); }
    #seoModal .modal-body { padding: 0; max-height: 70vh; overflow-y: auto; }
    #seoModal .modal-footer { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: flex-end; gap: 10px; }

    /* tabs */
    #seoModal .seo-tabs { display: flex; gap: 2px; padding: 0 20px; border-bottom: 1px solid var(--border); background: #fafafa; position: sticky; top: 0; z-index: 2; }
    #seoModal .seo-tab { padding: 11px 14px; font-size: 12.5px; font-weight: 600; color: var(--text-secondary); background: none; border: none; border-bottom: 2px solid transparent; cursor: pointer; font-family: var(--font); }
    #seoModal .seo-tab:hover { color: var(--text-primary); }
    #seoModal .seo-tab.active { color: var(--accent); border-bottom-color: var(--accent); }
    #seoModal .seo-pane { display: none; padding: 20px; }
    #seoModal .seo-pane.active { display: block; }

    #seoModal .field-group { margin-bottom: 16px; }
    #seoModal .field-group:last-child { margin-bottom: 0; }
    #seoModal .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    #seoModal .field-label { display: flex; justify-content: space-between; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; margin-bottom: 6px; }
    #seoModal .counter { font-weight: 500; text-transform: none; letter-spacing: 0; color: var(--text-hint); }
    #seoModal .counter.over { color: var(--red); font-weight: 600; }
    #seoModal .field-input, #seoModal .field-textarea, #seoModal .field-select {
        width: 100%; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0 12px;
        font-size: 13.5px; color: var(--text-primary); background: var(--surface); outline: none;
        transition: border-color .15s, box-shadow .15s; font-family: var(--font);
    }
    #seoModal .field-input, #seoModal .field-select { height: 38px; }
    #seoModal .field-textarea { padding: 10px 12px; resize: vertical; }
    #seoModal .field-textarea.code { font-family: 'SF Mono','Fira Mono',monospace; font-size: 12.5px; }
    #seoModal .field-input:focus, #seoModal .field-textarea:focus, #seoModal .field-select:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }
    #seoModal .field-hint { font-size: 11.5px; color: var(--text-hint); margin-top: 4px; }
    #seoModal .check-row { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; color: var(--text-primary); margin: 0; cursor: pointer; }
    #seoModal .check-row input { width: 16px; height: 16px; accent-color: var(--accent); }

    /* Google snippet preview */
    #seoModal .serp { border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 12px 14px; background: #fff; margin-bottom: 18px; }
    #seoModal .serp-url   { font-size: 12px; color: #202124; margin-bottom: 2px; word-break: break-all; }
    #seoModal .serp-title { font-size: 18px; color: #1a0dab; line-height: 1.3; margin-bottom: 3px; font-family: Arial, sans-serif; }
    #seoModal .serp-desc  { font-size: 13px; color: #4d5156; line-height: 1.5; font-family: Arial, sans-serif; }

    #seoModal .btn-primary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--accent); color: #fff !important; border: none; border-radius: var(--radius-sm); padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: var(--font); transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25); }
    #seoModal .btn-primary-dash:hover { background: #252f70; }
    #seoModal .btn-secondary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary) !important; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 18px; font-size: 13px; font-weight: 500; font-family: var(--font); transition: background .15s; cursor: pointer; }
    #seoModal .btn-secondary-dash:hover { background: var(--bg); }

    @media(max-width:576px) { #seoModal .field-row { grid-template-columns: 1fr; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <!-- Page header -->
            <div class="list-page-header">
                <div>
                    <h1>Manage SEO</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Manage SEO
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert-banner alert-success">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-banner alert-danger">
                    <i class="fa fa-exclamation-circle" style="margin-top:3px"></i>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main card -->
            <div class="list-card">

                <div class="list-card-header">
                    <h5>SEO Pages <span class="text-empty" style="font-weight:500">({{ $pages->count() }})</span></h5>

                    <div class="filter-pills">
                        <a href="{{ route('admin.seo.index') }}" class="pill-link {{ request('group') ? '' : 'active' }}">All</a>
                        @foreach($groups as $g)
                            <a href="{{ route('admin.seo.index', ['group' => $g]) }}"
                               class="pill-link {{ request('group') === $g ? 'active' : '' }}">{{ $g }}</a>
                        @endforeach
                    </div>
                </div>

                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th>Page</th>
                                <th>Group</th>
                                <th>Meta Title</th>
                                <th>Status</th>
                                <th style="width:90px">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($pages as $page)

                                <tr>
                                    <td><span class="id-chip">{{ $page->id }}</span></td>

                                    <td>
                                        <span class="page-name">{{ $page->page_name }}</span>
                                        <span class="page-slug">{{ $page->slug }}</span>
                                    </td>

                                    <td><span class="badge-chip badge-group">{{ $page->page_group }}</span></td>

                                    <td>
                                        @if($page->meta_title)
                                            <span class="meta-title-cell" title="{{ $page->meta_title }}">{{ $page->meta_title }}</span>
                                        @else
                                            <span class="meta-title-cell text-empty">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if(!$page->is_active)
                                            <span class="badge-chip badge-off">Inactive</span>
                                        @elseif(str_contains($page->robots, 'noindex'))
                                            <span class="badge-chip badge-warn">Noindex</span>
                                        @elseif(!$page->meta_title || !$page->meta_description)
                                            <span class="badge-chip badge-warn">Incomplete</span>
                                        @else
                                            <span class="badge-chip badge-ok">Live</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button type="button" class="action-btn edit" title="Edit SEO"
                                                onclick="openSeoModal({{ $page->id }})">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon-wrap">
                                                <i class="fa fa-magnifying-glass-chart"></i>
                                            </div>
                                            <h6>No SEO Pages Found</h6>
                                            <p>Run <code>php artisan db:seed --class=SeoPageSeeder</code> to register pages.</p>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')


{{-- ================= MODAL ================= --}}
<div class="modal fade" id="seoModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="seoForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit SEO <small id="seo_slug_label"></small></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="seo-tabs">
                        <button type="button" class="seo-tab active" data-pane="pane-basic">Basic</button>
                        <button type="button" class="seo-tab" data-pane="pane-social">Social</button>
                        <button type="button" class="seo-tab" data-pane="pane-advanced">Advanced</button>
                        <button type="button" class="seo-tab" data-pane="pane-sitemap">Sitemap</button>
                    </div>

                    {{-- ══ BASIC ══ --}}
                    <div class="seo-pane active" id="pane-basic">

                        <div class="serp">
                            <div class="serp-url" id="serp_url"></div>
                            <div class="serp-title" id="serp_title"></div>
                            <div class="serp-desc" id="serp_desc"></div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Meta Title <span class="counter" id="cnt_title">0 / 60</span></label>
                            <input type="text" name="meta_title" id="seo_meta_title" class="field-input" maxlength="255">
                            <div class="field-hint">Ideal length: 50–60 characters.</div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Meta Description <span class="counter" id="cnt_desc">0 / 160</span></label>
                            <textarea name="meta_description" id="seo_meta_description" class="field-textarea" rows="3" maxlength="500"></textarea>
                            <div class="field-hint">Ideal length: 120–160 characters.</div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="seo_meta_keywords" class="field-input" maxlength="255">
                            <div class="field-hint">Comma separated. Optional – Google ignores it, some other engines don't.</div>
                        </div>

                    </div>

                    {{-- ══ SOCIAL ══ --}}
                    <div class="seo-pane" id="pane-social">

                        <div class="field-group">
                            <label class="field-label">OG Title</label>
                            <input type="text" name="og_title" id="seo_og_title" class="field-input">
                        </div>

                        <div class="field-group">
                            <label class="field-label">OG Description</label>
                            <textarea name="og_description" id="seo_og_description" class="field-textarea" rows="2"></textarea>
                        </div>

                        <div class="field-row">
                            <div class="field-group">
                                <label class="field-label">OG Image</label>
                                <input type="text" name="og_image" id="seo_og_image" class="field-input" placeholder="/images/og-default.jpg">
                                <div class="field-hint">1200 × 630 px recommended.</div>
                            </div>
                            <div class="field-group">
                                <label class="field-label">OG Type</label>
                                <select name="og_type" id="seo_og_type" class="field-select">
                                    <option value="website">website</option>
                                    <option value="article">article</option>
                                    <option value="product">product</option>
                                    <option value="profile">profile</option>
                                </select>
                            </div>
                        </div>

                        <hr style="border-color:var(--border);margin:18px 0">

                        <div class="field-group">
                            <label class="field-label">Twitter / X Card</label>
                            <select name="twitter_card" id="seo_twitter_card" class="field-select">
                                <option value="summary_large_image">summary_large_image</option>
                                <option value="summary">summary</option>
                            </select>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Twitter Title</label>
                            <input type="text" name="twitter_title" id="seo_twitter_title" class="field-input">
                        </div>

                        <div class="field-group">
                            <label class="field-label">Twitter Description</label>
                            <textarea name="twitter_description" id="seo_twitter_description" class="field-textarea" rows="2"></textarea>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Twitter Image</label>
                            <input type="text" name="twitter_image" id="seo_twitter_image" class="field-input">
                        </div>

                    </div>

                    {{-- ══ ADVANCED ══ --}}
                    <div class="seo-pane" id="pane-advanced">

                        <div class="field-row">
                            <div class="field-group">
                                <label class="field-label">Robots</label>
                                <select name="robots" id="seo_robots" class="field-select">
                                    <option value="index, follow">index, follow</option>
                                    <option value="index, nofollow">index, nofollow</option>
                                    <option value="noindex, follow">noindex, follow</option>
                                    <option value="noindex, nofollow">noindex, nofollow</option>
                                </select>
                            </div>
                            <div class="field-group">
                                <label class="field-label">Canonical URL</label>
                                <input type="text" name="canonical_url" id="seo_canonical_url" class="field-input" placeholder="Leave empty to use page URL">
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Schema Markup (JSON-LD)</label>
                            <textarea name="schema_markup" id="seo_schema_markup" class="field-textarea code" rows="6" placeholder='{"@@context":"https://schema.org","@@type":"Organization", ...}'></textarea>
                            <div class="field-hint">Paste JSON only – without &lt;script&gt; tags. It is validated on save.</div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Head Scripts</label>
                            <textarea name="scripts" id="seo_scripts" class="field-textarea code" rows="4"></textarea>
                            <div class="field-hint">Raw tags injected into the page &lt;head&gt; (analytics, verification, pixels).</div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Body Scripts</label>
                            <textarea name="body_scripts" id="seo_body_scripts" class="field-textarea code" rows="3"></textarea>
                            <div class="field-hint">Injected right after the opening &lt;body&gt; tag (e.g. GTM noscript).</div>
                        </div>

                    </div>

                    {{-- ══ SITEMAP ══ --}}
                    <div class="seo-pane" id="pane-sitemap">

                        <div class="field-group">
                            <label class="check-row">
                                <input type="checkbox" name="in_sitemap" id="seo_in_sitemap" value="1"> Include in sitemap.xml
                            </label>
                        </div>

                        <div class="field-row">
                            <div class="field-group">
                                <label class="field-label">Priority</label>
                                <input type="number" step="0.1" min="0" max="1" name="sitemap_priority" id="seo_sitemap_priority" class="field-input">
                                <div class="field-hint">0.0 – 1.0 (home = 1.0).</div>
                            </div>
                            <div class="field-group">
                                <label class="field-label">Change Frequency</label>
                                <select name="sitemap_changefreq" id="seo_sitemap_changefreq" class="field-select">
                                    <option value="daily">daily</option>
                                    <option value="weekly">weekly</option>
                                    <option value="monthly">monthly</option>
                                    <option value="yearly">yearly</option>
                                </select>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="check-row">
                                <input type="checkbox" name="is_active" id="seo_is_active" value="1"> Page SEO active
                            </label>
                            <div class="field-hint">When off, the page falls back to the layout's default meta tags.</div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-secondary-dash" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa-solid fa-save"></i> Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


{{-- ================= SCRIPT ================= --}}
<script>
    // All page data, safely JSON-encoded (no inline quoting problems)
    const SEO_PAGES = @json($pages->keyBy('id'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    const SITE_URL  = @json(url('/'));

    const TEXT_FIELDS = [
        'meta_title', 'meta_description', 'meta_keywords', 'canonical_url', 'robots',
        'og_title', 'og_description', 'og_image', 'og_type',
        'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image',
        'schema_markup', 'scripts', 'body_scripts',
        'sitemap_priority', 'sitemap_changefreq'
    ];

    function openSeoModal(id) {
        const page = SEO_PAGES[id];
        if (!page) return;

        $('#seoForm').attr('action', '/admin/seo/' + id);
        $('#seoModal .modal-title').contents().first().replaceWith('Edit SEO – ' + page.page_name + ' ');
        $('#seo_slug_label').text(page.slug || '');

        TEXT_FIELDS.forEach(function (f) {
            $('#seo_' + f).val(page[f] ?? '');
        });

        $('#seo_in_sitemap').prop('checked', !!page.in_sitemap);
        $('#seo_is_active').prop('checked', !!page.is_active);

        window._seoSlug = page.slug || '/';
        showSeoPane('pane-basic');
        updateSeoPreview();

        $('#seoModal').modal('show');
    }

    function showSeoPane(paneId) {
        $('#seoModal .seo-tab').removeClass('active').filter('[data-pane="' + paneId + '"]').addClass('active');
        $('#seoModal .seo-pane').removeClass('active');
        $('#' + paneId).addClass('active');
    }

    function updateSeoPreview() {
        const t = $('#seo_meta_title').val();
        const d = $('#seo_meta_description').val();

        $('#serp_url').text(SITE_URL.replace(/\/$/, '') + (window._seoSlug === '/' ? '' : window._seoSlug));
        $('#serp_title').text(t || 'Meta title will appear here');
        $('#serp_desc').text(d || 'Meta description will appear here.');

        $('#cnt_title').text(t.length + ' / 60').toggleClass('over', t.length > 60);
        $('#cnt_desc').text(d.length + ' / 160').toggleClass('over', d.length > 160);
    }

    $(document).on('click', '#seoModal .seo-tab', function () {
        showSeoPane($(this).data('pane'));
    });

    $(document).on('input', '#seo_meta_title, #seo_meta_description', updateSeoPreview);
</script>