<style>
:root {
    --bg:#f1f2f4; --surface:#fff; --border:#e3e5e8;
    --text-primary:#202223; --text-secondary:#6d7175; --text-hint:#8c9196;
    --accent:#303d89; --accent-light:#f0f1fc;
    --green:#007a5e; --green-bg:#e3f1ec; --red:#b22222; --red-bg:#fce8e8;
    --radius-sm:8px; --radius-md:12px;
    --shadow-card:0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
    --font:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}
.faq-page { background:var(--bg); padding:24px 28px; min-height:100vh; font-family:var(--font); color:var(--text-primary); }
.faq-page * { box-sizing:border-box; }

.page-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }
.page-header h1 { font-size:20px; font-weight:650; margin:0; }
.crumb { font-size:12.5px; color:var(--text-hint); margin-top:3px; }
.crumb a { color:var(--accent); text-decoration:none; }
.crumb a:hover { text-decoration:underline; }
.crumb span { margin:0 5px; }

.btn-primary-dash { display:inline-flex; align-items:center; gap:6px; background:var(--accent); color:#fff !important; border:none; border-radius:var(--radius-sm); padding:8px 18px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none !important; font-family:var(--font); transition:background .15s; box-shadow:0 1px 3px rgba(48,61,137,.25); }
.btn-primary-dash:hover:not(:disabled) { background:#252f70; }
.btn-primary-dash:disabled { opacity:.65; cursor:not-allowed; }
.btn-secondary-dash { display:inline-flex; align-items:center; gap:6px; background:var(--surface); color:var(--text-primary) !important; border:1px solid var(--border); border-radius:var(--radius-sm); padding:8px 18px; font-size:13px; font-weight:500; cursor:pointer; text-decoration:none !important; font-family:var(--font); transition:background .15s; }
.btn-secondary-dash:hover { background:var(--bg); }

.faq-card, .section-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-md); box-shadow:var(--shadow-card); overflow:hidden; margin-bottom:16px; }
.section-card-header { padding:14px 20px; border-bottom:1px solid var(--border); background:#fafafa; }
.section-card-header h5 { font-size:13px; font-weight:650; margin:0; }
.section-card-body { padding:20px; }

/* Table */
.faq-table-wrap { overflow-x:auto; }
.faq-table { width:100%; border-collapse:collapse; font-size:13px; }
.faq-table thead th { font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:var(--text-hint); padding:10px 16px; border-bottom:1px solid var(--border); background:#fafafa; text-align:left; white-space:nowrap; }
.faq-table tbody tr { border-bottom:1px solid var(--border); }
.faq-table tbody tr:last-child { border-bottom:none; }
.faq-table tbody tr:hover { background:#fafbfc; }
.faq-table tbody td { padding:14px 16px; vertical-align:middle; }
.id-chip { display:inline-block; background:var(--bg); color:var(--text-secondary); font-size:11px; font-weight:700; padding:2px 7px; border-radius:6px; font-family:'SF Mono','Fira Code',monospace; }
.question-text { font-weight:600; font-size:13.5px; line-height:1.4; }
.cat-ico { width:34px; height:34px; border-radius:var(--radius-sm); background:var(--accent-light); color:var(--accent); display:inline-flex; align-items:center; justify-content:center; font-size:14px; }
.cat-chip { display:inline-block; background:var(--accent-light); color:var(--accent); font-size:11.5px; font-weight:600; padding:3px 9px; border-radius:20px; }

.pill { display:inline-flex; align-items:center; gap:4px; font-size:11.5px; font-weight:600; padding:3px 9px; border-radius:20px; }
.pill::before { content:''; width:5px; height:5px; border-radius:50%; display:inline-block; }
.pill-yes, .pill-active { background:var(--green-bg); color:var(--green); }
.pill-yes::before, .pill-active::before { background:var(--green); }
.pill-no { background:var(--bg); color:var(--text-hint); }
.pill-no::before { background:var(--text-hint); }
.pill-inactive { background:var(--red-bg); color:var(--red); }
.pill-inactive::before { background:var(--red); }

.action-btn { display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:var(--radius-sm); border:1px solid var(--border); background:var(--surface); color:var(--text-secondary); font-size:12px; cursor:pointer; transition:all .12s; text-decoration:none; }
.action-btn:hover { background:var(--bg); color:var(--text-primary); }
.action-btn-danger:hover { background:var(--red-bg); border-color:#f5c6c6; color:var(--red); }

.empty-state { text-align:center; padding:64px 20px; }
.empty-state .empty-icon { width:56px; height:56px; border-radius:50%; background:var(--bg); display:inline-flex; align-items:center; justify-content:center; font-size:22px; color:var(--text-hint); margin-bottom:14px; }
.empty-state p { font-size:14px; color:var(--text-secondary); margin:6px 0 16px; }

/* Form */
.form-layout { display:grid; grid-template-columns:1fr 280px; gap:20px; align-items:start; }
@media(max-width:860px) { .form-layout { grid-template-columns:1fr; } }
.field-group { margin-bottom:18px; }
.field-group:last-child { margin-bottom:0; }
.field-label { display:block; font-size:12px; font-weight:600; color:var(--text-secondary); letter-spacing:.03em; text-transform:uppercase; margin-bottom:6px; }
.field-label .req { color:var(--red); margin-left:2px; }
.field-input { width:100%; height:38px; border:1px solid var(--border); border-radius:var(--radius-sm); padding:0 12px; font-size:13.5px; color:var(--text-primary); background:var(--surface); outline:none; transition:border-color .15s, box-shadow .15s; font-family:var(--font); }
.field-input:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(48,61,137,.12); }
.field-input.is-invalid { border-color:var(--red); }
.field-error { color:var(--red); font-size:12px; margin-top:5px; }
.field-hint { color:var(--text-hint); font-size:11.5px; margin-top:5px; }
.icon-preview { display:flex; align-items:center; gap:10px; margin-top:10px; }

.toggle-row { display:flex; align-items:center; justify-content:space-between; padding:12px 0; }
.toggle-row:first-child { padding-top:0; }
.toggle-row:last-child { padding-bottom:0; }
.toggle-label { font-size:13px; font-weight:500; }
.toggle-sub { font-size:11.5px; color:var(--text-hint); margin-top:2px; }
.toggle-switch { position:relative; width:36px; height:20px; flex-shrink:0; }
.toggle-switch input { opacity:0; width:0; height:0; position:absolute; }
.toggle-track { position:absolute; inset:0; background:var(--border); border-radius:20px; cursor:pointer; transition:background .2s; }
.toggle-track::after { content:''; position:absolute; left:3px; top:3px; width:14px; height:14px; background:#fff; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); }
.toggle-switch input:checked + .toggle-track { background:var(--accent); }
.toggle-switch input:checked + .toggle-track::after { transform:translateX(16px); }

.action-bar { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-md); box-shadow:var(--shadow-card); padding:14px 20px; display:flex; align-items:center; justify-content:flex-end; gap:10px; margin-top:20px; }
@media(max-width:768px) { .faq-page { padding:16px; } }
</style>