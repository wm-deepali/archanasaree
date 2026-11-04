@include('admin.top-header')

<div class="main-section">

    @include('admin.header')

    <div class="app-content content container-fluid">

        <div class="content-wrapper pb-4">

            <div class="list-page">

                <!-- Page Header -->
                <div class="list-page-header mb-4">
                    <div>
                        <h1>Contact Enquiry Details</h1>

                        <div class="crumb">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            <span>›</span>
                            <a href="{{ route('admin.contact-enquiries.index') }}">Contact Enquiries</a>
                            <span>›</span>
                            View Enquiry
                        </div>
                    </div>

                    <a href="{{ route('admin.contact-enquiries.index') }}" class="btn-secondary-dash">
                        <i class="fa fa-arrow-left"></i>
                        Back
                    </a>
                </div>

                <div class="list-card">

                    <div class="p-4">

                        <div class="row mb-4">
                            <div class="col-md-3"><strong>Name</strong></div>
                            <div class="col-md-9">{{ $enquiry->name }}</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3"><strong>Email</strong></div>
                            <div class="col-md-9"><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3"><strong>Phone</strong></div>
                            <div class="col-md-9"><a
                                    href="tel:{{ preg_replace('/[^\d+]/', '', $enquiry->phone) }}">{{ $enquiry->phone }}</a>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3"><strong>Enquiry Type</strong></div>
                            <div class="col-md-9">
                                <span class="inq-tag">{{ $enquiry->type ?: 'General' }}</span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3"><strong>Submitted On</strong></div>
                            <div class="col-md-9">
                                {{ $enquiry->created_at->format('d M Y') }}
                                <div class="text-muted small">{{ $enquiry->created_at->format('h:i A') }}</div>
                            </div>
                        </div>

                        @if($enquiry->ip_address)
                            <div class="row mb-4">
                                <div class="col-md-3"><strong>IP Address</strong></div>
                                <div class="col-md-9 text-muted">{{ $enquiry->ip_address }}</div>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-3"><strong>Message</strong></div>
                            <div class="col-md-9">
                                <div class="border rounded p-3 bg-light">{!! nl2br(e($enquiry->message)) !!}</div>
                            </div>
                        </div>

                        @php
                            $wa = preg_replace('/\D/', '', $enquiry->phone);
                            if (strlen($wa) === 10) {
                                $wa = '91' . $wa;
                            }
                        @endphp
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9" style="display:flex;gap:8px;flex-wrap:wrap">
                                <a href="mailto:{{ $enquiry->email }}?subject={{ rawurlencode('Re: your enquiry') }}"
                                    class="btn-secondary-dash">
                                    <i class="fa fa-envelope"></i> Reply by Email
                                </a>
                                @if(strlen($wa) >= 10)
                                    <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener"
                                        class="btn-secondary-dash">
                                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
    .list-page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .crumb {
        font-size: 12px;
        color: #8c9196;
    }

    .crumb a {
        color: #303d89;
        text-decoration: none;
    }

    .btn-secondary-dash {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid #e3e5e8;
        padding: 8px 16px;
        border-radius: 8px;
        color: #202223 !important;
        text-decoration: none;
    }

    .list-card {
        background: #fff;
        border: 1px solid #e3e5e8;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
    }

    .inq-tag {
        display: inline-flex;
        padding: 4px 10px;
        border-radius: 6px;
        background: #fff5cc;
        color: #916a00;
        font-size: 12px;
        font-weight: 600;
    }
</style>
@include('admin.footer')