@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>Page Banners</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        Page Banners
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="ok-box">{{ session('success') }}</div>
            @endif

            <div class="section-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Page</th>
                            <th style="width:160px">Banner</th>
                            <th style="width:200px">Last Updated</th>
                            <th style="width:90px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (\App\Models\PageHero::PAGES as $key => $cfg)
                            <tr>
                                <td><strong>{{ $cfg['label'] }}</strong></td>
                                <td>
                                    <span class="pill {{ $saved->has($key) ? 'pill-on' : 'pill-off' }}">
                                        {{ $saved->has($key) ? 'Customised' : 'Default' }}
                                    </span>
                                </td>
                                <td style="color:var(--text-secondary)">
                                    {{ $saved->has($key) ? \Illuminate\Support\Carbon::parse($saved[$key])->format('d M Y, h:i A') : '—' }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.page-heroes.edit', $key) }}" class="icon-btn" title="Edit"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@include('admin.footer')