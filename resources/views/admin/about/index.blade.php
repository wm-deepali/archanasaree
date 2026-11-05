@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>About Page</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        About Page
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="ok-box">{{ session('success') }}</div>
            @endif

            <div class="ok-box" style="background:var(--accent-light);color:var(--accent);border-color:#c7cdf5">
                The top banner of the About page is fixed. Every section below can be edited, and a section set to Inactive is hidden on the site.
            </div>

            <div class="section-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Section</th>
                            <th>Layout</th>
                            <th style="width:90px">Items</th>
                            <th style="width:110px">Status</th>
                            <th style="width:90px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (\App\Models\AboutSection::SECTIONS as $key => $cfg)
                            @php $row = $sections->get($key); @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $cfg['label'] }}</strong></td>
                                <td style="color:var(--text-secondary)">{{ $cfg['where'] }}</td>
                                <td>{{ $row?->items_count ?? 0 }}</td>
                                <td>
                                    @if (!$row)
                                        <span class="pill pill-off">Not set</span>
                                    @else
                                        <span class="pill {{ $row->status ? 'pill-on' : 'pill-off' }}">{{ $row->status ? 'Active' : 'Inactive' }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.about.edit', $key) }}" class="icon-btn" title="Edit"><i class="fa fa-pencil"></i></a>
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