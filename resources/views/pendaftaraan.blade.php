<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Murid Baru — PKBM</title>
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary: #1a56db;
            --primary-dark: #1241a8;
            --primary-light: #e8f0fe;
            --accent: #f97316;
            --success: #10b981;
            --error: #ef4444;
            --bg: #f0f4ff;
            --surface: #ffffff;
            --surface-2: #f8faff;
            --border: #dce5f5;
            --text: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --shadow-sm: 0 1px 3px rgba(26,86,219,0.08);
            --shadow-md: 0 4px 16px rgba(26,86,219,0.10);
            --shadow-lg: 0 8px 32px rgba(26,86,219,0.14);
            --radius: 12px;
            --radius-sm: 8px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            background-image:
                radial-gradient(ellipse at 0% 0%, rgba(26,86,219,0.10) 0%, transparent 60%),
                radial-gradient(ellipse at 100% 100%, rgba(249,115,22,0.08) 0%, transparent 60%);
        }

        /* ── Header ── */
        .site-header {
            background: var(--primary);
            color: #fff;
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(26,86,219,0.25);
        }
        .header-inner {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .header-logo {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.18);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
        .header-title { font-weight: 800; font-size: 1.1rem; letter-spacing: -0.01em; }
        .header-sub { font-size: 0.78rem; opacity: 0.75; margin-top: 1px; }

        /* ── Page wrapper ── */
        .page-wrap {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 24px 80px;
        }

        /* ── Hero band ── */
        .hero-band {
            background: linear-gradient(135deg, var(--primary) 0%, #2563eb 50%, #1a56db 100%);
            border-radius: 20px;
            padding: 36px 40px;
            color: #fff;
            margin-bottom: 36px;
            position: relative;
            overflow: hidden;
        }
        .hero-band::after {
            content: '';
            position: absolute;
            right: -40px;
            top: -40px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }
        .hero-band::before {
            content: '';
            position: absolute;
            right: 60px;
            bottom: -60px;
            width: 260px;
            height: 260px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 12px;
        }
        .hero-h1 { font-size: 1.9rem; font-weight: 800; line-height: 1.2; letter-spacing: -0.02em; }
        .hero-desc { font-size: 0.9rem; opacity: 0.8; margin-top: 10px; max-width: 500px; line-height: 1.6; }
        .hero-steps {
            display: flex;
            gap: 8px;
            margin-top: 24px;
            flex-wrap: wrap;
        }
        .step-pill {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 0.78rem;
            font-weight: 600;
        }
        .step-pill.active {
            background: var(--accent);
            border-color: var(--accent);
        }

        /* ── Section cards ── */
        .section-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px 36px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.2s;
        }
        .section-card:hover { box-shadow: var(--shadow-md); }

        .section-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary-light);
        }
        .section-icon {
            width: 44px;
            height: 44px;
            background: var(--primary-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .section-title { font-size: 1.05rem; font-weight: 700; color: var(--primary); }
        .section-subtitle { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }

        /* ── Grid ── */
        .form-grid { display: grid; gap: 20px; }
        .col-2 { grid-template-columns: 1fr 1fr; }
        .col-3 { grid-template-columns: 1fr 1fr 1fr; }
        .col-full { grid-column: 1 / -1; }

        @media (max-width: 640px) {
            .col-2, .col-3 { grid-template-columns: 1fr; }
            .section-card { padding: 20px 18px; }
            .hero-band { padding: 24px 22px; }
            .hero-h1 { font-size: 1.4rem; }
        }

        /* ── Field ── */
        .field { display: flex; flex-direction: column; gap: 7px; }
        .field label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .required-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--accent);
            flex-shrink: 0;
        }
        .optional-tag {
            font-size: 0.7rem;
            font-weight: 500;
            color: var(--text-light);
            background: #f1f5f9;
            border-radius: 4px;
            padding: 1px 6px;
        }

        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.88rem;
            color: var(--text);
            background: var(--surface);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26,86,219,0.12);
            background: #fff;
        }
        input::placeholder, textarea::placeholder { color: var(--text-light); }
        textarea { resize: vertical; min-height: 80px; }

        /* Error state */
        input.error, select.error, textarea.error {
            border-color: var(--error);
            background: #fef2f2;
        }
        input.error:focus, select.error:focus, textarea.error:focus {
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
        }

        .error-message {
            color: var(--error);
            font-size: 0.75rem;
            margin-top: 4px;
            display: none;
        }
        .error-message.show {
            display: block;
        }

        /* Custom select arrow */
        .select-wrap { position: relative; }
        .select-wrap::after {
            content: '▾';
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
            font-size: 0.85rem;
        }
        .select-wrap select { padding-right: 36px; }

        /* ── Radio / Checkbox group ── */
        .radio-group, .check-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .radio-pill, .check-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border: 1.5px solid var(--border);
            border-radius: 40px;
            cursor: pointer;
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--text-muted);
            transition: all 0.18s;
            user-select: none;
            background: var(--surface-2);
        }
        .radio-pill:hover, .check-pill:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }
        .radio-pill input, .check-pill input { display: none; }
        .radio-pill .dot {
            width: 14px; height: 14px;
            border: 2px solid currentColor;
            border-radius: 50%;
            flex-shrink: 0;
            position: relative;
        }
        .radio-group input[type="radio"]:checked + .radio-pill,
        .radio-pill:has(input[type="radio"]:checked) {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
        }

        /* Inline "other" input */
        .other-input-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border: 1.5px dashed var(--border);
            border-radius: 40px;
            background: var(--surface-2);
        }
        .other-input-wrap input[type="text"] {
            border: none;
            padding: 0;
            background: transparent;
            font-size: 0.84rem;
            width: 120px;
            box-shadow: none;
        }
        .other-input-wrap input[type="text"]:focus { box-shadow: none; }
        .other-label { font-size: 0.83rem; color: var(--text-muted); white-space: nowrap; font-weight: 500; }

        /* ── File upload ── */
        .file-upload-card {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            padding: 22px 18px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            background: var(--surface-2);
        }
        .file-upload-card:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }
        .file-upload-card.error {
            border-color: var(--error);
            background: #fef2f2;
        }
        .file-upload-card input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }
        .upload-icon { font-size: 28px; margin-bottom: 8px; }
        .upload-title { font-size: 0.85rem; font-weight: 700; color: var(--text); }
        .upload-hint { font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; }
        .upload-badge {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary);
            font-size: 0.72rem;
            font-weight: 700;
            border-radius: 4px;
            padding: 2px 8px;
            margin-top: 8px;
        }
        .upload-badge.optional {
            background: #f1f5f9;
            color: var(--text-muted);
        }

        .upload-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        @media (max-width: 640px) {
            .upload-grid { grid-template-columns: 1fr 1fr; }
        }

        /* ── Notice box ── */
        .notice {
            background: var(--primary-light);
            border: 1px solid rgba(26,86,219,0.2);
            border-left: 4px solid var(--primary);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            font-size: 0.83rem;
            color: var(--primary-dark);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        /* ── Phone inputs ── */
        .phone-list { display: flex; flex-direction: column; gap: 10px; }
        .phone-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .phone-item input { flex: 1; }
        .phone-num {
            width: 28px;
            height: 28px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* ── Submit ── */
        .submit-area {
            margin-top: 36px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }
        .btn-submit {
            background: linear-gradient(135deg, var(--primary) 0%, #2563eb 100%);
            color: #fff;
            border: none;
            padding: 16px 56px;
            border-radius: 50px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            cursor: pointer;
            box-shadow: 0 6px 24px rgba(26,86,219,0.35);
            transition: transform 0.18s, box-shadow 0.18s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(26,86,219,0.45);
        }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .submit-note { font-size: 0.8rem; color: var(--text-muted); text-align: center; }

        /* ── Divider ── */
        .divider {
            border: none;
            border-top: 1.5px solid var(--border);
            margin: 24px 0;
        }

        /* Animated entrance */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .section-card { animation: fadeUp 0.4s ease both; }
        .section-card:nth-child(1) { animation-delay: 0.05s; }
        .section-card:nth-child(2) { animation-delay: 0.10s; }
        .section-card:nth-child(3) { animation-delay: 0.15s; }
        .section-card:nth-child(4) { animation-delay: 0.20s; }
        .section-card:nth-child(5) { animation-delay: 0.25s; }
        .section-card:nth-child(6) { animation-delay: 0.30s; }
        .section-card:nth-child(7) { animation-delay: 0.35s; }
        .section-card:nth-child(8) { animation-delay: 0.40s; }
    </style>
</head>
<body>

<!-- ── HEADER ── -->
<header class="site-header">
    <div class="header-inner">
        <div class="header-logo">🏫</div>
        <div>
            <div class="header-title">PKBM — Pendidikan Kesetaraan</div>
            <div class="header-sub">Pusat Kegiatan Belajar Masyarakat</div>
        </div>
    </div>
</header>

<div class="page-wrap">

    <!-- ── HERO ── -->
    <div class="hero-band">
        <div class="hero-badge">✦ Formulir Online</div>
        <h1 class="hero-h1">Pendaftaran Murid Baru</h1>
        <p class="hero-desc">Isi formulir dengan lengkap dan benar. Bukti pendaftaran akan dikirim ke email yang Anda daftarkan.</p>
        <div class="hero-steps">
            <div class="step-pill active">① Data Diri</div>
            <div class="step-pill">② Data Orang Tua</div>
            <div class="step-pill">③ Kontak & Program</div>
            <div class="step-pill">④ Dokumen</div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div style="background:#d1fae5;border:1px solid #10b981;color:#065f46;padding:16px;border-radius:12px;margin-bottom:24px;font-weight:500;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:#fee2e2;border:1px solid #ef4444;color:#991b1b;padding:16px;border-radius:12px;margin-bottom:24px;">
            <strong style="font-weight:700;">⚠️ Ada kesalahan pengisian:</strong>
            <ul style="margin-top:8px;margin-left:20px;list-style:disc;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pendaftaran.store') }}" enctype="multipart/form-data" id="pendaftaranForm" novalidate>
        @csrf

        <!-- ════════════════════════════════
             SEKSI 1 — DATA PRIBADI
        ════════════════════════════════ -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">👤</div>
                <div>
                    <div class="section-title">Data Pribadi Calon Murid</div>
                    <div class="section-subtitle">Isi sesuai dengan identitas resmi / akta lahir</div>
                </div>
            </div>

            <div class="form-grid col-2">
                <!-- Nama Lengkap -->
                <div class="field col-full">
                    <label><span class="required-dot"></span> Nama Lengkap (Sesuai Identitas)</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" 
                           value="{{ old('nama_lengkap') }}" 
                           placeholder="Contoh: Ahmad Fauzi Hidayatullah" required
                           data-rule="required|min:3">
                    <span class="error-message" id="error-nama_lengkap"></span>
                </div>

                <!-- Tempat Lahir -->
                <div class="field">
                    <label><span class="required-dot"></span> Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                           value="{{ old('tempat_lahir') }}" 
                           placeholder="Contoh: Batam" required
                           data-rule="required|min:2">
                    <span class="error-message" id="error-tempat_lahir"></span>
                </div>

                <!-- Tanggal Lahir -->
                <div class="field">
                    <label><span class="required-dot"></span> Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                           value="{{ old('tanggal_lahir') }}" required
                           data-rule="required|date|before:today">
                    <span class="error-message" id="error-tanggal_lahir"></span>
                </div>

                <!-- Jenis Kelamin -->
                <div class="field">
                    <label><span class="required-dot"></span> Jenis Kelamin</label>
                    <div class="radio-group">
                        <label class="radio-pill">
                            <input type="radio" name="jenis_kelamin" value="pria" 
                                   {{ old('jenis_kelamin') == 'pria' ? 'checked' : '' }} 
                                   required data-rule="required">
                            <span class="dot"></span> Pria
                        </label>
                        <label class="radio-pill">
                            <input type="radio" name="jenis_kelamin" value="wanita"
                                   {{ old('jenis_kelamin') == 'wanita' ? 'checked' : '' }}>
                            <span class="dot"></span> Wanita
                        </label>
                    </div>
                    <span class="error-message" id="error-jenis_kelamin"></span>
                </div>

                <!-- Agama -->
                <div class="field">
                    <label><span class="required-dot"></span> Agama</label>
                    <div class="radio-group">
                        @foreach(['Islam','Katholik','Protestan','Budha','Hindu','Konghucu'] as $agama)
                        <label class="radio-pill">
                            <input type="radio" name="agama" value="{{ $agama }}" 
                                   {{ old('agama') == $agama ? 'checked' : '' }} 
                                   required data-rule="required">
                            <span class="dot"></span> {{ $agama }}
                        </label>
                        @endforeach
                        
                    </div>
                    <span class="error-message" id="error-agama"></span>
                </div>

                <!-- NISN -->
                <div class="field">
                    <label>NISN <span class="optional-tag">Opsional</span></label>
                    <input type="text" name="nisn" id="nisn"
                           value="{{ old('nisn') }}" 
                           placeholder="Nomor Induk Siswa Nasional"
                           data-rule="numeric|digits_between:10,10">
                    <span class="error-message" id="error-nisn"></span>
                </div>

                <!-- No. KK / NIK -->
                <div class="field">
                    <label><span class="required-dot"></span> No. Induk KK (NIK)</label>
                    <input type="text" name="no_kk" id="no_kk"
                           value="{{ old('no_kk') }}" 
                           placeholder="16 digit nomor KK" maxlength="16" required
                           data-rule="required|numeric|digits:16">
                    <span class="error-message" id="error-no_kk"></span>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════
             SEKSI 2 — RIWAYAT PENDIDIKAN
        ════════════════════════════════ -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">🎓</div>
                <div>
                    <div class="section-title">Riwayat Pendidikan</div>
                    <div class="section-subtitle">Asal sekolah dan program yang diminati</div>
                </div>
            </div>

            <div class="form-grid col-2">
                <!-- Alumni Sekolah -->
                <div class="field col-full">
                    <label><span class="required-dot"></span> Alumni Sekolah (Sebelumnya Bersekolah di)</label>
                    <input type="text" name="alumni_sekolah" id="alumni_sekolah"
                           value="{{ old('alumni_sekolah') }}" 
                           placeholder="Nama sekolah asal" required
                           data-rule="required|min:3">
                    <span class="error-message" id="error-alumni_sekolah"></span>
                </div>

                <!-- Tahun Tamat -->
                <div class="field">
                    <label><span class="required-dot"></span> Tahun Tamat</label>
                    <input type="number" name="tahun_tamat" id="tahun_tamat"
                           value="{{ old('tahun_tamat') }}" 
                           placeholder="Contoh: 2022"  required>
                    <span class="error-message" id="error-tahun_tamat"></span>
                </div>

                <!-- Program Paket -->
                <div class="field col-full">
                    <label><span class="required-dot"></span> Program Paket yang Dipilih</label>
                    <div class="radio-group">
                        <label class="radio-pill">
                            <input type="radio" name="program_paket" value="paket_a" 
                                   {{ old('program_paket') == 'paket_a' ? 'checked' : '' }}
                                   required data-rule="required">
                            <span class="dot"></span> Paket A — Setara SD/MI
                        </label>
                        <label class="radio-pill">
                            <input type="radio" name="program_paket" value="paket_b"
                                   {{ old('program_paket') == 'paket_b' ? 'checked' : '' }}>
                            <span class="dot"></span> Paket B — Setara SMP/MTs
                        </label>
                        <label class="radio-pill">
                            <input type="radio" name="program_paket" value="paket_c"
                                   {{ old('program_paket') == 'paket_c' ? 'checked' : '' }}>
                            <span class="dot"></span> Paket C — Setara SMA/SMK
                        </label>
                    </div>
                    <span class="error-message" id="error-program_paket"></span>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════
             SEKSI 3 — ALAMAT & TEMPAT TINGGAL
        ════════════════════════════════ -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">🏠</div>
                <div>
                    <div class="section-title">Alamat & Tempat Tinggal</div>
                    <div class="section-subtitle">Alamat domisili saat ini</div>
                </div>
            </div>

            <div class="form-grid col-2">
                <!-- Alamat -->
                <div class="field col-full">
                    <label><span class="required-dot"></span> Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" required
                              data-rule="required|min:10">{{ old('alamat') }}</textarea>
                    <span class="error-message" id="error-alamat"></span>
                </div>

                <!-- Kelurahan -->
                <div class="field">
                    <label><span class="required-dot"></span> Kelurahan</label>
                    <input type="text" name="kelurahan" id="kelurahan"
                           value="{{ old('kelurahan') }}" 
                           placeholder="Nama kelurahan" required
                           data-rule="required|min:2">
                    <span class="error-message" id="error-kelurahan"></span>
                </div>

                <!-- Kecamatan -->
                <div class="field">
                    <label><span class="required-dot"></span> Kecamatan</label>
                    <input type="text" name="kecamatan" id="kecamatan"
                           value="{{ old('kecamatan') }}" 
                           placeholder="Nama kecamatan" required
                           data-rule="required|min:2">
                    <span class="error-message" id="error-kecamatan"></span>
                </div>

                <!-- Kota -->
                <div class="field">
                    <label><span class="required-dot"></span> Kota / Kabupaten</label>
                    <input type="text" name="kota" id="kota"
                           value="{{ old('kota') }}" 
                           placeholder="Nama kota" required
                           data-rule="required|min:2">
                    <span class="error-message" id="error-kota"></span>
                </div>

                <!-- Tinggal Bersama -->
                <div class="field col-full">
                    <label><span class="required-dot"></span> Tinggal Bersama Dengan</label>
                    <div class="radio-group">
                        @foreach(['Orang Tua' => 'orang_tua','Sendiri' => 'sendiri','Kontrakan' => 'kontrakan'] as $label => $val)
                        <label class="radio-pill">
                            <input type="radio" name="tinggal_bersama" value="{{ $val }}" 
                                   {{ old('tinggal_bersama') == $val ? 'checked' : '' }}
                                   required data-rule="required">
                            <span class="dot"></span> {{ $label }}
                        </label>
                        @endforeach
                        <div class="other-input-wrap">
                            <span class="other-label">Lainnya:</span>
                            <input type="text" name="tinggal_lain" id="tinggal_lain"
                                   value="{{ old('tinggal_lain') }}" placeholder="Sebutkan...">
                        </div>
                    </div>
                    <span class="error-message" id="error-tinggal_bersama"></span>
                </div>

                <!-- Transportasi -->
                <div class="field col-full">
                    <label><span class="required-dot"></span> Alat Transportasi Sehari-Hari</label>
                    <div class="radio-group">
                        @foreach(['Sepeda Motor' => 'motor','Angkutan Umum' => 'angkot','Mobil' => 'mobil','Jalan Kaki' => 'jalan_kaki'] as $label => $val)
                        <label class="radio-pill">
                            <input type="radio" name="transportasi" value="{{ $val }}" 
                                   {{ old('transportasi') == $val ? 'checked' : '' }}
                                   required data-rule="required">
                            <span class="dot"></span> {{ $label }}
                        </label>
                        @endforeach
                    </div>
                    <span class="error-message" id="error-transportasi"></span>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════
             SEKSI 4 — DATA IBU KANDUNG
        ════════════════════════════════ -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">👩</div>
                <div>
                    <div class="section-title">Data Ibu Kandung</div>
                    <div class="section-subtitle">Informasi mengenai ibu kandung peserta didik</div>
                </div>
            </div>

            <div class="form-grid col-2">
                <div class="field">
                    <label><span class="required-dot"></span> Nama Ibu Kandung</label>
                    <input type="text" name="nama_ibu" id="nama_ibu"
                           value="{{ old('nama_ibu') }}" 
                           placeholder="Nama lengkap ibu" required
                           data-rule="required|min:3">
                    <span class="error-message" id="error-nama_ibu"></span>
                </div>
                <div class="field">
                    <label><span class="required-dot"></span> NIK Ibu Kandung</label>
                    <input type="text" name="nik_ibu" id="nik_ibu"
                           value="{{ old('nik_ibu') }}" 
                           placeholder="16 digit NIK" maxlength="16" required
                           data-rule="required|numeric|digits:16">
                    <span class="error-message" id="error-nik_ibu"></span>
                </div>
                <div class="field">
                    <label><span class="required-dot"></span> Pekerjaan Ibu Kandung</label>
                    <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu"
                           value="{{ old('pekerjaan_ibu') }}" 
                           placeholder="Contoh: Wiraswasta" required
                           data-rule="required|min:2">
                    <span class="error-message" id="error-pekerjaan_ibu"></span>
                </div>
                <div class="field">
                    <label><span class="required-dot"></span> Penghasilan Ibu Kandung</label>
                    <div class="select-wrap">
                        <select name="penghasilan_ibu" id="penghasilan_ibu" required data-rule="required">
                            <option value="" disabled selected>— Pilih rentang penghasilan —</option>
                            <option value="0-500rb" {{ old('penghasilan_ibu') == '0-500rb' ? 'selected' : '' }}>0 – 500 rb / bulan</option>
                            <option value="500rb-1jt" {{ old('penghasilan_ibu') == '500rb-1jt' ? 'selected' : '' }}>500 rb – 1 jt / bulan</option>
                            <option value="1jt-2jt" {{ old('penghasilan_ibu') == '1jt-2jt' ? 'selected' : '' }}>1 jt – 2 jt / bulan</option>
                            <option value="2jt-4jt" {{ old('penghasilan_ibu') == '2jt-4jt' ? 'selected' : '' }}>2 jt – 4 jt / bulan</option>
                            <option value=">4jt" {{ old('penghasilan_ibu') == '>4jt' ? 'selected' : '' }}>Lebih dari 4 jt / bulan</option>
                        </select>
                    </div>
                    <span class="error-message" id="error-penghasilan_ibu"></span>
                </div>
                <div class="field col-full">
                    <label><span class="required-dot"></span> Pendidikan Terakhir Ibu Kandung</label>
                    <div class="radio-group">
                        @foreach(['Tidak Sekolah','SD','SMP','SMA','D3','S1','S2','S3'] as $p)
                        <label class="radio-pill">
                            <input type="radio" name="pendidikan_ibu" value="{{ $p }}" 
                                   {{ old('pendidikan_ibu') == $p ? 'checked' : '' }}
                                   required data-rule="required">
                            <span class="dot"></span> {{ $p }}
                        </label>
                        @endforeach
                    </div>
                    <span class="error-message" id="error-pendidikan_ibu"></span>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════
             SEKSI 5 — DATA AYAH KANDUNG
        ════════════════════════════════ -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">👨</div>
                <div>
                    <div class="section-title">Data Ayah Kandung</div>
                    <div class="section-subtitle">Informasi mengenai ayah kandung peserta didik</div>
                </div>
            </div>

            <div class="form-grid col-2">
                <div class="field">
                    <label><span class="required-dot"></span> Nama Ayah Kandung</label>
                    <input type="text" name="nama_ayah" id="nama_ayah"
                           value="{{ old('nama_ayah') }}" 
                           placeholder="Nama lengkap ayah" required
                           data-rule="required|min:3">
                    <span class="error-message" id="error-nama_ayah"></span>
                </div>
                <div class="field">
                    <label><span class="required-dot"></span> NIK Ayah Kandung</label>
                    <input type="text" name="nik_ayah" id="nik_ayah"
                           value="{{ old('nik_ayah') }}" 
                           placeholder="16 digit NIK" maxlength="16" required
                           data-rule="required|numeric|digits:16">
                    <span class="error-message" id="error-nik_ayah"></span>
                </div>
                <div class="field">
                    <label><span class="required-dot"></span> Pekerjaan Ayah Kandung</label>
                    <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah"
                           value="{{ old('pekerjaan_ayah') }}" 
                           placeholder="Contoh: Buruh Pabrik" required
                           data-rule="required|min:2">
                    <span class="error-message" id="error-pekerjaan_ayah"></span>
                </div>
                <div class="field">
                    <label><span class="required-dot"></span> Penghasilan Ayah Kandung</label>
                    <div class="select-wrap">
                        <select name="penghasilan_ayah" id="penghasilan_ayah" required data-rule="required">
                            <option value="" disabled selected>— Pilih rentang penghasilan —</option>
                            <option value="0-500rb" {{ old('penghasilan_ayah') == '0-500rb' ? 'selected' : '' }}>0 – 500 rb / bulan</option>
                            <option value="500rb-1jt" {{ old('penghasilan_ayah') == '500rb-1jt' ? 'selected' : '' }}>500 rb – 1 jt / bulan</option>
                            <option value="1jt-2jt" {{ old('penghasilan_ayah') == '1jt-2jt' ? 'selected' : '' }}>1 jt – 2 jt / bulan</option>
                            <option value="2jt-4jt" {{ old('penghasilan_ayah') == '2jt-4jt' ? 'selected' : '' }}>2 jt – 4 jt / bulan</option>
                            <option value=">4jt" {{ old('penghasilan_ayah') == '>4jt' ? 'selected' : '' }}>Lebih dari 4 jt / bulan</option>
                        </select>
                    </div>
                    <span class="error-message" id="error-penghasilan_ayah"></span>
                </div>
                <div class="field col-full">
                    <label><span class="required-dot"></span> Pendidikan Terakhir Ayah Kandung</label>
                    <div class="radio-group">
                        @foreach(['Tidak Sekolah','SD','SMP','SMA','D3','S1','S2','S3'] as $p)
                        <label class="radio-pill">
                            <input type="radio" name="pendidikan_ayah" value="{{ $p }}" 
                                   {{ old('pendidikan_ayah') == $p ? 'checked' : '' }}
                                   required data-rule="required">
                            <span class="dot"></span> {{ $p }}
                        </label>
                        @endforeach
                    </div>
                    <span class="error-message" id="error-pendidikan_ayah"></span>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════
             SEKSI 6 — KONTAK & INFORMASI
        ════════════════════════════════ -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">📞</div>
                <div>
                    <div class="section-title">Kontak & Informasi Lanjutan</div>
                    <div class="section-subtitle">Nomor yang dapat dihubungi dan email aktif</div>
                </div>
            </div>

            <div class="form-grid col-2">
                <!-- Nomor HP -->
                <div class="field col-full">
                    <label><span class="required-dot"></span> No. Handphone yang Dapat Dihubungi</label>
                    <div class="notice">
                        ℹ️ Wajib mengisi <strong>minimal 2 nomor</strong>. Nomor harus aktif sebagai WhatsApp dan nomor HP biasa.
                    </div>
                    <div class="phone-list">
                        <div class="phone-item">
                        <div class="phone-num">1</div>
                        <input type="tel" name="no_hp[]" class="no_hp_input" 
                            value="{{ old('no_hp')[0] ?? '' }}" 
                            placeholder="Nomor WA / HP utama" required
                            data-rule="required|phone">
                    </div>

                    <!-- Nomor 2 - WAJIB -->
                    <div class="phone-item">
                        <div class="phone-num">2</div>
                        <input type="tel" name="no_hp[]" class="no_hp_input" 
                            value="{{ old('no_hp')[1] ?? '' }}" 
                            placeholder="Nomor WA / HP kedua" required
                            data-rule="required|phone">
                        <span class="error-message" id="error-no_hp"></span>
                    </div>

                    <!-- Nomor 3 - OPSIONAL (tanpa required) -->
                    <div class="phone-item" id="hp3" style="display:none;">
                        <div class="phone-num">3</div>
                        <input type="tel" name="no_hp[]" class="no_hp_input" 
                            value="{{ old('no_hp')[2] ?? '' }}" 
                            placeholder="Nomor tambahan"  <!-- ⚠️ TANPA required -->
                            data-rule="nullable|phone">
                    </div>
                    </div>
                    <button type="button" onclick="document.getElementById('hp3').style.display='flex'"
                        style="margin-top:8px;background:none;border:1.5px dashed var(--border);padding:7px 16px;border-radius:40px;font-size:0.82rem;font-family:inherit;color:var(--text-muted);cursor:pointer;font-weight:600;">
                        + Tambah Nomor
                    </button>
                </div>

                <!-- Email -->
                <div class="field col-full">
                    <label><span class="required-dot"></span> Email Aktif</label>
                    <div class="notice">
                        📧 Bukti pendaftaran akan dikirim ke alamat email ini. Pastikan email Anda aktif dan bisa menerima pesan.
                    </div>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}" 
                           placeholder="contoh@gmail.com" required
                           data-rule="required|email">
                    <span class="error-message" id="error-email"></span>
                </div>

                <!-- Nama Pengenal di PKBM -->
                <div class="field col-full">
                    <label><span class="required-dot"></span> Nama Orang yang Dikenal di PKBM / yang Membawa ke PKBM</label>
                    <input type="text" name="nama_pengenal" id="nama_pengenal"
                           value="{{ old('nama_pengenal') }}" 
                           placeholder="Nama wali / kenalan di PKBM" required
                           data-rule="required|min:3">
                    <span class="error-message" id="error-nama_pengenal"></span>
                </div>

                <!-- Tanggal Daftar -->
                <div class="field">
                    <label><span class="required-dot"></span> Tanggal Daftar</label>
                    <input type="date" name="tanggal_daftar" id="tanggal_daftar"
                           value="{{ old('tanggal_daftar', date('Y-m-d')) }}" required
                           data-rule="required|date">
                    <span class="error-message" id="error-tanggal_daftar"></span>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════
             SEKSI 7 — UPLOAD DOKUMEN
        ════════════════════════════════ -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">📎</div>
                <div>
                    <div class="section-title">Unggah Dokumen Pendukung</div>
                    <div class="section-subtitle">Format yang didukung: JPG, PNG, PDF • Maks. 10 MB per file</div>
                </div>
            </div>

            <div class="notice">
                🔒 Dokumen Anda akan disimpan dengan aman dan hanya digunakan untuk keperluan administrasi pendaftaran.
            </div>

            <div class="upload-grid">

                <!-- Akta Lahir - WAJIB -->
                <div>
                    <div class="field" style="margin-bottom:8px;">
                        <label><span class="required-dot"></span> Akta Kelahiran</label>
                    </div>
                    <div class="file-upload-card" id="upload-akta">
                        <input type="file" name="akta_lahir" accept=".jpg,.jpeg,.png,.pdf" required
                               data-rule="required|file|max:10240">
                        <div class="upload-icon">📄</div>
                        <div class="upload-title">Klik untuk unggah</div>
                        <div class="upload-hint">JPG, PNG, PDF</div>
                        <span class="upload-badge">Wajib</span>
                        <span class="error-message" id="error-akta_lahir" style="margin-top:8px;"></span>
                    </div>
                </div>

                <!-- KTP - Opsional -->
                <div>
                    <div class="field" style="margin-bottom:8px;">
                        <label>KTP <span class="optional-tag">Jika Ada</span></label>
                    </div>
                    <div class="file-upload-card" id="upload-ktp">
                        <input type="file" name="ktp" accept=".jpg,.jpeg,.png,.pdf"
                               data-rule="nullable|file|max:10240">
                        <div class="upload-icon">🪪</div>
                        <div class="upload-title">Klik untuk unggah</div>
                        <div class="upload-hint">JPG, PNG, PDF</div>
                        <span class="upload-badge optional">Opsional</span>
                        <span class="error-message" id="error-ktp" style="margin-top:8px;"></span>
                    </div>
                </div>

                <!-- KK - Wajib -->
                <div>
                    <div class="field" style="margin-bottom:8px;">
                        <label><span class="required-dot"></span> Kartu Keluarga (KK)</label>
                    </div>
                    <div class="file-upload-card" id="upload-kk">
                        <input type="file" name="kartu_keluarga" accept=".jpg,.jpeg,.png,.pdf" required
                               data-rule="required|file|max:10240">
                        <div class="upload-icon">🏡</div>
                        <div class="upload-title">Klik untuk unggah</div>
                        <div class="upload-hint">JPG, PNG, PDF</div>
                        <span class="upload-badge">Wajib</span>
                        <span class="error-message" id="error-kartu_keluarga" style="margin-top:8px;"></span>
                    </div>
                </div>

                <!-- Ijazah - Opsional -->
                <div>
                    <div class="field" style="margin-bottom:8px;">
                        <label>Ijazah Terakhir <span class="optional-tag">Jika Ada</span></label>
                    </div>
                    <div class="file-upload-card" id="upload-ijazah">
                        <input type="file" name="ijazah" accept=".jpg,.jpeg,.png,.pdf"
                               data-rule="nullable|file|max:10240">
                        <div class="upload-icon">🎖️</div>
                        <div class="upload-title">Klik untuk unggah</div>
                        <div class="upload-hint">JPG, PNG, PDF</div>
                        <span class="upload-badge optional">Opsional</span>
                        <span class="error-message" id="error-ijazah" style="margin-top:8px;"></span>
                    </div>
                </div>

                <!-- Raport - Opsional -->
                <div>
                    <div class="field" style="margin-bottom:8px;">
                        <label>Raport <span class="optional-tag">Jika Ada</span></label>
                    </div>
                    <div class="file-upload-card" id="upload-raport">
                        <input type="file" name="raport" accept=".jpg,.jpeg,.png,.pdf"
                               data-rule="nullable|file|max:10240">
                        <div class="upload-icon">📋</div>
                        <div class="upload-title">Klik untuk unggah</div>
                        <div class="upload-hint">JPG, PNG, PDF</div>
                        <span class="upload-badge optional">Opsional</span>
                        <span class="error-message" id="error-raport" style="margin-top:8px;"></span>
                    </div>
                </div>

                <!-- Pas Foto - Opsional -->
                <div>
                    <div class="field" style="margin-bottom:8px;">
                        <label>Pas Foto <span class="optional-tag">Jika Ada</span></label>
                    </div>
                    <div class="file-upload-card" id="upload-foto">
                        <input type="file" name="pas_foto" accept=".jpg,.jpeg,.png"
                               data-rule="nullable|image|max:10240">
                        <div class="upload-icon">📷</div>
                        <div class="upload-title">Klik untuk unggah</div>
                        <div class="upload-hint">JPG, PNG saja</div>
                        <span class="upload-badge optional">Opsional</span>
                        <span class="error-message" id="error-pas_foto" style="margin-top:8px;"></span>
                    </div>
                </div>

            </div>
        </div>

        <!-- ════════════════════════════════
             SUBMIT
        ════════════════════════════════ -->
        <div class="submit-area">
            <p class="submit-note">
                Dengan menekan tombol di bawah, Anda menyatakan bahwa semua data yang diisi adalah <strong>benar dan dapat dipertanggungjawabkan</strong>.
            </p>
            <button type="submit" class="btn-submit" id="btnSubmit">
                <span>🚀</span> Kirim Pendaftaran
            </button>
            <p class="submit-note">Konfirmasi akan dikirim ke email Anda dalam 1×24 jam</p>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pendaftaranForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const submitNote = document.querySelector('.submit-note:last-child');
    
    // ===== REAL-TIME VALIDATION (sama seperti sebelumnya) =====
    const validateField = (input, rule) => {
        const value = input.value.trim();
        const errorEl = document.getElementById('error-' + input.name) || input.closest('.field')?.querySelector('.error-message');
        let error = null;

        if (rule.includes('required') && !value) error = 'Field ini wajib diisi';
        const minMatch = rule.match(/min:(\d+)/);
        if (minMatch && value.length < parseInt(minMatch[1])) error = `Minimal ${minMatch[1]} karakter`;
        if (rule.includes('numeric') && value && !/^\d+$/.test(value)) error = 'Harus berupa angka';
        const digitsMatch = rule.match(/digits:(\d+)/);
        if (digitsMatch && value && value.length !== parseInt(digitsMatch[1])) error = `Harus ${digitsMatch[1]} digit`;
        const betweenMatch = rule.match(/digits_between:(\d+),(\d+)/);
        if (betweenMatch && value) {
            const len = value.length, min = parseInt(betweenMatch[1]), max = parseInt(betweenMatch[2]);
            if (len < min || len > max) error = `Harus ${min}-${max} digit`;
        }
        if (rule.includes('email') && value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) error = 'Format email tidak valid';
        if (rule.includes('phone') && value && !/^(\+62|62|08)[0-9]{8,}$/.test(value.replace(/[\s\-\(\)]/g, ''))) error = 'Format nomor tidak valid';
        if (rule.includes('before:today') && value) {
            const today = new Date().toISOString().split('T')[0];
            if (value >= today) error = 'Tanggal harus sebelum hari ini';
        }
        if (rule.includes('file') && input.files?.[0]) {
            const file = input.files[0];
            const maxMatch = rule.match(/max:(\d+)/);
            if (maxMatch && file.size > parseInt(maxMatch[1]) * 1024) error = `Ukuran file maksimal ${parseInt(maxMatch[1])/1024} MB`;
            if (rule.includes('image') && !['image/jpeg','image/jpg','image/png'].includes(file.type)) error = 'Format file harus JPG/PNG';
            if (rule.includes('mimes:jpg,jpeg,png,pdf') && !['image/jpeg','image/jpg','image/png','application/pdf'].includes(file.type)) error = 'Format file harus JPG/PNG/PDF';
        }

        if (error) {
            input.classList.add('error');
            if (errorEl) { errorEl.textContent = error; errorEl.classList.add('show'); }
            if (input.closest('.file-upload-card')) input.closest('.file-upload-card').classList.add('error');
            return false;
        } else {
            input.classList.remove('error');
            if (errorEl) { errorEl.textContent = ''; errorEl.classList.remove('show'); }
            if (input.closest('.file-upload-card')) input.closest('.file-upload-card').classList.remove('error');
            return true;
        }
    };

    document.querySelectorAll('[data-rule]').forEach(input => {
        const rule = input.dataset.rule;
        if (input.type === 'radio') {
            const name = input.name;
            document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
                radio.addEventListener('change', () => validateField(input, rule));
            });
        } else if (input.type === 'file') {
            input.addEventListener('change', () => {
                validateField(input, rule);
                if (input.files[0]) {
                    const card = input.closest('.file-upload-card');
                    const title = card?.querySelector('.upload-title');
                    const hint = card?.querySelector('.upload-hint');
                    if (title && hint) {
                        const name = input.files[0].name;
                        title.textContent = name.length > 22 ? name.slice(0,19)+'...' : name;
                        hint.textContent = (input.files[0].size / 1024 / 1024).toFixed(2) + ' MB';
                        card.style.borderColor = 'var(--success)';
                        card.style.background = '#f0fdf4';
                        card.querySelector('.upload-icon').textContent = '✅';
                    }
                }
            });
        } else if (input.tagName === 'SELECT') {
            input.addEventListener('change', () => validateField(input, rule));
        } else {
            input.addEventListener('blur', () => validateField(input, rule));
            input.addEventListener('input', () => { if (input.classList.contains('error')) validateField(input, rule); });
        }
    });

        const validatePhoneArray = () => {
            const phones = document.querySelectorAll('.no_hp_input');
            let filled = 0;
            
            // Hanya validasi 2 nomor pertama sebagai wajib
            for (let i = 0; i < Math.min(2, phones.length); i++) {
                if (phones[i].value.trim()) filled++;
            }
            
            const errorEl = document.getElementById('error-no_hp');
            if (filled < 2) {
                if (errorEl) {
                    errorEl.textContent = 'Minimal 2 nomor harus diisi';
                    errorEl.classList.add('show');
                }
                return false;
            }
            if (errorEl) {
                errorEl.textContent = '';
                errorEl.classList.remove('show');
            }
            return true;
        };
    document.querySelectorAll('.no_hp_input').forEach(input => {
        input.addEventListener('blur', validatePhoneArray);
        input.addEventListener('input', () => { if (document.getElementById('error-no_hp')?.classList.contains('show')) validatePhoneArray(); });
    });

    // ===== PROGRESS BAR UI =====
    const showProgressBar = () => {
        // Buat progress bar container jika belum ada
        let progressContainer = document.getElementById('uploadProgressContainer');
        if (!progressContainer) {
            progressContainer = document.createElement('div');
            progressContainer.id = 'uploadProgressContainer';
            progressContainer.style.cssText = `
                position: fixed; top: 0; left: 0; right: 0; 
                background: var(--primary-light); 
                border-bottom: 2px solid var(--primary);
                padding: 8px 24px; z-index: 9999;
                display: flex; align-items: center; gap: 12px;
                animation: slideDown 0.3s ease;
            `;
            progressContainer.innerHTML = `
                <span style="font-weight:600;font-size:0.9rem;color:var(--primary);">📤 Mengupload dokumen...</span>
                <div style="flex:1; height:8px; background:#dbeafe; border-radius:4px; overflow:hidden;">
                    <div id="uploadProgressBar" style="width:0%; height:100%; background:var(--primary); border-radius:4px; transition:width 0.2s;"></div>
                </div>
                <span id="uploadProgressText" style="font-size:0.85rem;color:var(--primary-dark); font-weight:600;">0%</span>
            `;
            document.body.prepend(progressContainer);
            
            // Add animation keyframes
            const style = document.createElement('style');
            style.textContent = `@keyframes slideDown { from { transform: translateY(-100%); } to { transform: translateY(0); } }`;
            document.head.appendChild(style);
        }
        progressContainer.style.display = 'flex';
    };

    const updateProgress = (percent) => {
        const bar = document.getElementById('uploadProgressBar');
        const text = document.getElementById('uploadProgressText');
        if (bar) bar.style.width = percent + '%';
        if (text) text.textContent = Math.round(percent) + '%';
    };

    const hideProgressBar = () => {
        const progressContainer = document.getElementById('uploadProgressContainer');
        if (progressContainer) {
            progressContainer.style.animation = 'slideDown 0.3s ease reverse';
            setTimeout(() => { if (progressContainer) progressContainer.style.display = 'none'; }, 300);
        }
    };

    // ===== AJAX FORM SUBMISSION WITH PROGRESS =====
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // 1. Validasi semua field dulu
        let isValid = true;
        document.querySelectorAll('[data-rule]').forEach(input => {
            if (!validateField(input, input.dataset.rule)) isValid = false;
        });
        if (!validatePhoneArray()) isValid = false;
        
        ['jenis_kelamin', 'agama', 'program_paket', 'tinggal_bersama', 'transportasi', 'pendidikan_ibu', 'pendidikan_ayah'].forEach(name => {
            const radios = document.querySelectorAll(`input[name="${name}"]`);
            if (radios.length && ![...radios].some(r => r.checked)) {
                const errorEl = document.getElementById('error-' + name);
                if (errorEl) { errorEl.textContent = 'Pilih salah satu opsi'; errorEl.classList.add('show'); }
                isValid = false;
            }
        });
        
        if (!isValid) {
            const firstError = document.querySelector('.error-message.show');
            if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        // 2. Disable button & show loading
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span>⏳</span> Memproses...';
        submitNote.textContent = 'Mohon tunggu, jangan tutup halaman ini...';
        
        // 3. Tampilkan progress bar jika ada file
        const hasFiles = [...form.querySelectorAll('input[type="file"]')].some(input => input.files?.[0]);
        if (hasFiles) showProgressBar();

        try {
            // 4. Prepare FormData
            const formData = new FormData(form);
            
            // 5. AJAX Request dengan progress
            const xhr = new XMLHttpRequest();
            const url = form.action;
            
            // Progress upload file
            xhr.upload.addEventListener('progress', (event) => {
                if (event.lengthComputable && hasFiles) {
                    const percent = (event.loaded / event.total) * 100;
                    updateProgress(percent);
                }
            });
            
            // Response handler
            xhr.onload = function() {
                 console.log('Response status:', xhr.status);
    console.log('Response text:', xhr.responseText);
                hideProgressBar();
                if (xhr.status === 302 || xhr.status === 200) {
                    // Coba parse JSON dulu
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert(response.message);
                            window.location.href = response.redirect || window.location.href;
                            return;
                        }
                    } catch (e) {
                        // Jika bukan JSON, mungkin redirect HTML
                        // Redirect manual ke URL yang sama (untuk reload halaman)
                        window.location.reload();
                        return;
                    }
                }
                if (xhr.status === 200 || xhr.status === 302) {
                    // Cek apakah redirect (Laravel biasanya redirect setelah sukses)
                    const responseUrl = xhr.responseURL;
                    if (responseUrl && responseUrl.includes(window.location.hostname)) {
                        // Redirect manual jika perlu
                        window.location.href = responseUrl;
                    } else {
                        // Tampilkan success message
                        const successMsg = '✅ Pendaftaran berhasil! Cek email Anda untuk bukti pendaftaran.';
                        alert(successMsg);
                        form.reset();
                        // Reset file upload UI
                        document.querySelectorAll('.file-upload-card').forEach(card => {
                            card.style.borderColor = '';
                            card.style.background = '';
                            card.querySelector('.upload-icon').textContent = '📄';
                            card.querySelector('.upload-title').textContent = 'Klik untuk unggah';
                            card.querySelector('.upload-hint').textContent = 'JPG, PNG, PDF';
                        });
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                } else {
                    throw new Error('Server error: ' + xhr.status);
                }
            };
            
            xhr.onerror = function() {
                hideProgressBar();
                throw new Error('Koneksi terputus. Periksa internet Anda.');
            };
            
            xhr.open('POST', url, true);
            // Set headers (Laravel butuh CSRF)
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                             document.querySelector('[name="csrf_token"]')?.value ||
                             document.querySelector('[name="_token"]')?.value;
            if (csrfToken) {
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            }
            // Jangan set Content-Type untuk FormData, biar browser set otomatis dengan boundary
            xhr.send(formData);
            
        } catch (error) {
            console.error('Submission error:', error);
            hideProgressBar();
            
            // Tampilkan error ke user
            const errorContainer = document.createElement('div');
            errorContainer.style.cssText = `
                background:#fee2e2; border:1px solid #ef4444; color:#991b1b;
                padding:16px; border-radius:12px; margin-bottom:24px;
            `;
            errorContainer.innerHTML = `<strong>❌ Gagal mengirim:</strong> ${error.message}`;
            form.parentNode.insertBefore(errorContainer, form);
            
            // Scroll ke error
            errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Reset button
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<span>🚀</span> Kirim Pendaftaran';
            submitNote.textContent = 'Konfirmasi akan dikirim ke email Anda dalam 1×24 jam';
        }
    });
});
</script>

</body>
</html>