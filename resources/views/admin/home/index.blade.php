@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
        :root {
            --bg: #f1f2f4;
            --surface: #ffffff;
            --border: #e3e5e8;
            --text-primary: #202223;
            --text-secondary: #6d7175;
            --text-hint: #8c9196;
            --accent: #303d89;
            --accent-light: #f0f1fc;
            --green: #007a5e;
            --green-bg: #e3f1ec;
            --blue: #0069d9;
            --blue-bg: #e8f2ff;
            --purple: #6d28d9;
            --purple-bg: #ede9fe;
            --amber: #916a00;
            --amber-bg: #fff5cc;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .home-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .home-page * {
            box-sizing: border-box;
        }

        /* Page header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .page-header h1 {
            font-size: 20px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
        }

        .crumb {
            font-size: 12.5px;
            color: var(--text-hint);
            margin-top: 3px;
        }

        .crumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .crumb a:hover {
            text-decoration: underline;
        }

        .crumb span {
            margin: 0 5px;
        }

        /* Info banner */
        .info-banner {
            background: var(--accent-light);
            border: 1px solid #c7cdf5;
            border-radius: var(--radius-md);
            padding: 12px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--accent);
            font-weight: 500;
        }

        .info-banner i {
            font-size: 15px;
            flex-shrink: 0;
        }

        /* Widget grid */
        .widget-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        @media(max-width:960px) {
            .widget-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:580px) {
            .widget-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Widget card */
        .widget-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            transition: box-shadow .15s, transform .15s;
        }

        .widget-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, .1), 0 0 0 1px var(--border);
            transform: translateY(-2px);
        }

        /* Widget icon */
        .widget-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .wi-blue {
            background: var(--blue-bg);
            color: var(--blue);
        }

        .wi-green {
            background: var(--green-bg);
            color: var(--green);
        }

        .wi-purple {
            background: var(--purple-bg);
            color: var(--purple);
        }

        .wi-amber {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .wi-accent {
            background: var(--accent-light);
            color: var(--accent);
        }

        /* Widget header */
        .widget-head {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .widget-num {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-hint);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .widget-title {
            font-size: 13.5px;
            font-weight: 650;
            color: var(--text-primary);
            line-height: 1.3;
        }

        /* Type badge */
        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            margin-top: 4px;
        }

        .tb-multiple {
            background: var(--blue-bg);
            color: var(--blue);
        }

        .tb-fixed {
            background: var(--accent-light);
            color: var(--accent);
        }

        .tb-mixed {
            background: var(--purple-bg);
            color: var(--purple);
        }

        /* Widget actions */
        .widget-actions {
            display: flex;
            gap: 7px;
            flex-wrap: wrap;
            margin-top: auto;
        }

        .btn-manage {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--accent);
            color: #fff !important;
            border: none;
            border-radius: var(--radius-sm);
            padding: 7px 13px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
            flex: 1;
            justify-content: center;
        }

        .btn-manage:hover {
            background: #252f70;
        }

        .btn-secondary-sm {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--surface);
            color: var(--text-primary) !important;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 7px 13px;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
            flex: 1;
            justify-content: center;
        }

        .btn-secondary-sm:hover {
            background: var(--bg);
        }

        @media(max-width:768px) {
            .home-page {
                padding: 16px;
            }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="home-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Home Page Widgets</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Manage Home Page
                    </div>
                </div>
            </div>

            <!-- Info banner -->
            <div class="info-banner">
                <i class="fa fa-info-circle"></i>
                Manage all homepage sections from here — click <strong>Manage</strong> on any widget to edit its
                content.
            </div>

            <!-- Widget grid -->
            <div class="widget-grid">

                <!-- 1. Home Sliders -->
                <div class="widget-card">
                    <div class="widget-head">
                        <div class="widget-icon wi-blue"><i class="fa fa-picture-o"></i></div>
                        <div>
                            <div style="display:flex;align-items:center;gap:8px">
                                <span class="widget-num">1</span>
                                <span class="widget-title">Home Sliders</span>
                            </div>
                            <span class="type-badge tb-multiple"><i class="fa fa-th-large"></i> Multiple</span>
                        </div>
                    </div>
                    <div style="font-size:12px;color:var(--text-hint)">Main hero banner carousel shown at the top of the
                        homepage.</div>
                    <div class="widget-actions">
                        <a href="{{ route('admin.home.sliders.index') }}" class="btn-manage">
                            <i class="fa fa-pencil"></i> Manage
                        </a>
                    </div>
                </div>

                <!-- 2. Lehenga Campaign -->
                <div class="widget-card">
                    <div class="widget-head">
                        <div class="widget-icon wi-purple"><i class="fa fa-bullhorn"></i></div>
                        <div>
                            <div style="display:flex;align-items:center;gap:8px">
                                <span class="widget-num">2</span>
                                <span class="widget-title">Lehenga Campaign</span>
                            </div>
                            <span class="type-badge tb-fixed"><i class="fa fa-square-o"></i> Fixed</span>
                        </div>
                    </div>
                    <div style="font-size:12px;color:var(--text-hint)">Full-width campaign banner with headline, buttons
                        and highlights.</div>
                    <div class="widget-actions">
                        <a href="{{ route('admin.home.campaign.edit') }}" class="btn-manage"><i
                                class="fa fa-pencil"></i> Manage</a>
                    </div>
                </div>

                <!-- 3. Our Story -->
                <div class="widget-card">
                    <div class="widget-head">
                        <div class="widget-icon wi-amber"><i class="fa fa-book"></i></div>
                        <div>
                            <div style="display:flex;align-items:center;gap:8px">
                                <span class="widget-num">3</span>
                                <span class="widget-title">Our Story &amp; Founder</span>
                            </div>
                            <span class="type-badge tb-fixed"><i class="fa fa-square-o"></i> Fixed</span>
                        </div>
                    </div>
                    <div style="font-size:12px;color:var(--text-hint)">Brand story text, images and the Meet the Founder
                        block.</div>
                    <div class="widget-actions">
                        <a href="{{ route('admin.home.story.edit') }}" class="btn-manage"><i class="fa fa-pencil"></i>
                            Manage</a>
                    </div>
                </div>

                <!-- 4. Reels -->
                <div class="widget-card">
                    <div class="widget-head">
                        <div class="widget-icon wi-green"><i class="fa fa-film"></i></div>
                        <div>
                            <div style="display:flex;align-items:center;gap:8px">
                                <span class="widget-num">4</span>
                                <span class="widget-title">Style in Motion (Reels)</span>
                            </div>
                            <span class="type-badge tb-multiple"><i class="fa fa-th-large"></i> Multiple</span>
                        </div>
                    </div>
                    <div style="font-size:12px;color:var(--text-hint)">Reel cards with a cover image and a playable
                        video.</div>
                    <div class="widget-actions">
                        <a href="{{ route('admin.home.reels.index') }}" class="btn-manage"><i class="fa fa-pencil"></i>
                            Manage</a>
                    </div>
                </div>

                <!-- 5. Newsletter Subscribers -->
                <div class="widget-card">
                    <div class="widget-head">
                        <div class="widget-icon wi-accent"><i class="fa fa-envelope-o"></i></div>
                        <div>
                            <div style="display:flex;align-items:center;gap:8px">
                                <span class="widget-num">5</span>
                                <span class="widget-title">Newsletter Subscribers</span>
                            </div>
                            <span class="type-badge tb-mixed"><i class="fa fa-list"></i> List</span>
                        </div>
                    </div>
                    <div style="font-size:12px;color:var(--text-hint)">Emails collected from the homepage subscribe
                        form, with CSV export.</div>
                    <div class="widget-actions">
                        <a href="{{ route('admin.home.subscribers.index') }}" class="btn-manage"><i
                                class="fa fa-eye"></i> View</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')