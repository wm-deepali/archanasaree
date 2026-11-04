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
        --red: #b22222;
        --red-bg: #fce8e8;
        --radius-sm: 8px;
        --radius-md: 12px;
        --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
        --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .detail-page {
        background: var(--bg);
        padding: 24px 28px;
        min-height: 100vh;
        font-family: var(--font);
        color: var(--text-primary);
    }

    .detail-page * {
        box-sizing: border-box;
    }

    .detail-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .detail-page-header h1 {
        font-size: 20px;
        font-weight: 650;
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

    .create-layout {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 20px;
        align-items: start;
    }

    @media(max-width:900px) {
        .create-layout {
            grid-template-columns: 1fr;
        }
    }

    .section-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 16px;
    }

    .section-card:last-child {
        margin-bottom: 0;
    }

    .section-card-header {
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        background: #fafafa;
    }

    .section-card-header h5 {
        font-size: 13px;
        font-weight: 650;
        margin: 0;
    }

    .section-card-body {
        padding: 20px;
    }

    .field-group {
        margin-bottom: 16px;
    }

    .field-group:last-child {
        margin-bottom: 0;
    }

    .field-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        letter-spacing: .03em;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .field-label .req {
        color: var(--red);
        margin-left: 2px;
    }

    .field-hint {
        font-size: 11.5px;
        color: var(--text-hint);
        margin-top: 4px;
        line-height: 1.6;
    }

    .field-input,
    .field-textarea {
        width: 100%;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 0 12px;
        height: 38px;
        font-size: 13.5px;
        color: var(--text-primary);
        background: var(--surface);
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        font-family: var(--font);
    }

    .field-textarea {
        height: auto;
        padding: 10px 12px;
        resize: vertical;
        min-height: 70px;
    }

    .field-input:focus,
    .field-textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
    }

    .two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media(max-width:600px) {
        .two-col {
            grid-template-columns: 1fr;
        }
    }

    .upload-zone {
        border: 2px dashed var(--border);
        border-radius: var(--radius-md);
        padding: 28px 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s, background .15s;
        position: relative;
    }

    .upload-zone:hover {
        border-color: var(--accent);
        background: var(--accent-light);
    }

    .upload-zone input[type=file] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .upload-zone .uz-icon {
        font-size: 28px;
        color: var(--text-hint);
        margin-bottom: 8px;
    }

    .upload-zone .uz-title {
        font-size: 13px;
        font-weight: 600;
    }

    .upload-zone .uz-sub {
        font-size: 11.5px;
        color: var(--text-hint);
        margin-top: 4px;
    }

    #imgPreview {
        display: none;
        margin-top: 12px;
    }

    #imgPreview img {
        width: 100%;
        max-height: 180px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border);
    }

    #imgPreview button {
        font-size: 12px;
        color: var(--red);
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        margin-top: 6px;
    }

    .toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--bg);
    }

    .toggle-row:first-child {
        padding-top: 0;
    }

    .toggle-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .toggle-label {
        font-size: 13px;
        font-weight: 500;
    }

    .toggle-sub {
        font-size: 11.5px;
        color: var(--text-hint);
        margin-top: 1px;
    }

    .field-select-sm {
        height: 32px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 0 28px 0 10px;
        font-size: 12.5px;
        color: var(--text-primary);
        background: var(--surface);
        outline: none;
        font-family: var(--font);
        min-width: 100px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 9px center;
    }

    .field-select-sm:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
    }

    .err-box {
        background: var(--red-bg);
        color: var(--red);
        border: 1px solid #f5c6c6;
        border-radius: var(--radius-sm);
        padding: 12px 16px;
        margin-bottom: 18px;
        font-size: 13px;
    }

    .err-box ul {
        margin: 0;
        padding-left: 18px;
    }

    .btn-primary-dash {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--accent);
        color: #fff !important;
        border: none;
        border-radius: var(--radius-sm);
        padding: 8px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none !important;
        font-family: var(--font);
        transition: background .15s;
        box-shadow: 0 1px 3px rgba(48, 61, 137, .25);
    }

    .btn-primary-dash:hover {
        background: #252f70;
    }

    .btn-secondary-dash {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--surface);
        color: var(--text-primary) !important;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 8px 18px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none !important;
        font-family: var(--font);
        transition: background .15s;
    }

    .btn-secondary-dash:hover {
        background: var(--bg);
    }

    .action-bar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    @media(max-width:768px) {
        .detail-page {
            padding: 16px;
        }
    }

    .ok-box {
        background: #e3f1ec;
        color: #007a5e;
        border: 1px solid #b7dccf;
        border-radius: var(--radius-sm);
        padding: 12px 16px;
        margin-bottom: 18px;
        font-size: 13px;
    }

    .toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        text-align: left;
        font-size: 11.5px;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: .03em;
        padding: 10px 16px;
        background: #fafafa;
        border-bottom: 1px solid var(--border);
    }

    .data-table td {
        padding: 12px 16px;
        font-size: 13px;
        border-bottom: 1px solid var(--bg);
        vertical-align: middle;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .thumb {
        width: 54px;
        height: 72px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--border);
    }

    .pill {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 9px;
        border-radius: 20px;
    }

    .pill-on {
        background: #e3f1ec;
        color: #007a5e;
    }

    .pill-off {
        background: #fce8e8;
        color: #b22222;
    }

    .row-actions {
        display: flex;
        gap: 6px;
    }

    .icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text-primary) !important;
        cursor: pointer;
        text-decoration: none !important;
        font-size: 13px;
    }

    .icon-btn:hover {
        background: var(--bg);
    }

    .icon-btn.danger {
        color: var(--red) !important;
    }

    .stat-chip {
        font-size: 12.5px;
        color: var(--text-secondary);
    }

    .stat-chip b {
        color: var(--text-primary);
    }
</style>