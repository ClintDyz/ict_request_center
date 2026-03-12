@extends('layouts.admin')

@section('content')

{{-- Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:root {
    --navy:       #0f1e3c;
    --navy-mid:   #1a2f5a;
    --gold:       #c9a84c;
    --gold-light: #e8c97a;
    --cream:      #f8f5ef;
    --slate:      #4a5568;
    --muted:      #8a95a3;
    --white:      #ffffff;
    --border:     #e2ddd4;
    --success:    #2d7a4f;
    --danger:     #c0392b;
    --shadow-sm:  0 2px 8px rgba(15,30,60,.08);
    --shadow-md:  0 8px 32px rgba(15,30,60,.12);
    --shadow-lg:  0 20px 60px rgba(15,30,60,.18);
    --radius:     12px;
    --radius-lg:  20px;
}

* { box-sizing: border-box; }

body {
    background: var(--cream);
    font-family: 'DM Sans', sans-serif;
    color: var(--navy);
}

/* ── Page Header ── */
.page-hero {
    background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 60%, #243a6e 100%);
    padding: 48px 40px 36px;
    position: relative;
    overflow: hidden;
    border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    margin-bottom: 36px;
    box-shadow: var(--shadow-lg);
}

.page-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,.18) 0%, transparent 70%);
}

.page-hero::after {
    content: '';
    position: absolute;
    bottom: -40px; left: 10%;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,.10) 0%, transparent 70%);
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(201,168,76,.15);
    border: 1px solid rgba(201,168,76,.3);
    color: var(--gold-light);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 50px;
    margin-bottom: 16px;
}

.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    color: var(--white);
    margin: 0 0 8px;
    line-height: 1.2;
}

.hero-title span { color: var(--gold-light); }

.hero-subtitle {
    color: rgba(255,255,255,.55);
    font-size: 14px;
    font-weight: 300;
    margin: 0;
}

.hero-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}

.autosave-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.15);
    color: rgba(255,255,255,.7);
    font-size: 12px;
    padding: 8px 16px;
    border-radius: 50px;
    backdrop-filter: blur(10px);
}

.autosave-dot {
    width: 7px; height: 7px;
    background: #4ade80;
    border-radius: 50%;
    animation: pulse-dot 2s infinite;
}

@keyframes pulse-dot {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.5; transform:scale(1.3); }
}

.btn-clear {
    background: rgba(192,57,43,.2);
    border: 1px solid rgba(192,57,43,.4);
    color: #ff8a80;
    font-size: 12px;
    font-weight: 500;
    padding: 8px 16px;
    border-radius: 50px;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
}
.btn-clear:hover { background: rgba(192,57,43,.35); color: #fff; }

/* ── Progress Bar ── */
.progress-wrapper {
    padding: 0 40px 28px;
    margin-top: -8px;
}

.progress-steps {
    display: flex;
    align-items: center;
    gap: 0;
    background: var(--white);
    border-radius: var(--radius);
    padding: 16px 24px;
    box-shadow: var(--shadow-sm);
    overflow-x: auto;
    border: 1px solid var(--border);
}

.step-item {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
    cursor: pointer;
    padding: 6px 12px;
    border-radius: 8px;
    transition: background .2s;
}
.step-item:hover { background: rgba(201,168,76,.08); }

.step-num {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: var(--border);
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    transition: all .3s;
    flex-shrink: 0;
}

.step-item.active .step-num {
    background: var(--gold);
    color: var(--navy);
    box-shadow: 0 0 0 4px rgba(201,168,76,.2);
}

.step-item.done .step-num {
    background: var(--success);
    color: #fff;
}

.step-label {
    font-size: 12px;
    font-weight: 500;
    color: var(--muted);
    white-space: nowrap;
    transition: color .3s;
}
.step-item.active .step-label { color: var(--navy); font-weight: 600; }
.step-item.done .step-label { color: var(--success); }

.step-divider {
    flex: 1;
    min-width: 20px;
    height: 1px;
    background: var(--border);
    margin: 0 4px;
}

/* ── Main Form Card ── */
.form-wrapper {
    padding: 0 40px 40px;
    max-width: 1200px;
    margin: 0 auto;
}

.section-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    margin-bottom: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: box-shadow .3s;
}
.section-card:hover { box-shadow: var(--shadow-md); }

.section-header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px 28px;
    cursor: pointer;
    user-select: none;
    transition: background .2s;
    border-bottom: 1px solid transparent;
}
.section-header:hover { background: rgba(201,168,76,.04); }
.section-card.open .section-header {
    border-bottom-color: var(--border);
    background: rgba(15,30,60,.02);
}

.section-icon {
    width: 42px; height: 42px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold);
    font-size: 16px;
    flex-shrink: 0;
}

.section-title-group { flex: 1; }
.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 600;
    color: var(--navy);
    margin: 0 0 2px;
}
.section-desc {
    font-size: 11px;
    color: var(--muted);
    margin: 0;
}

.section-toggle {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: var(--cream);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--muted);
    font-size: 13px;
    transition: all .3s;
    flex-shrink: 0;
}
.section-card.open .section-toggle {
    background: var(--navy);
    color: var(--white);
    transform: rotate(180deg);
    border-color: var(--navy);
}

.section-body {
    display: none;
    padding: 28px;
    animation: slideDown .3s ease;
}
.section-card.open .section-body { display: block; }

@keyframes slideDown {
    from { opacity:0; transform:translateY(-8px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── Form Fields ── */
.field-group { margin-bottom: 20px; }

.field-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .8px;
    text-transform: uppercase;
    color: var(--slate);
    margin-bottom: 6px;
}

.field-label .required { color: var(--gold); margin-left: 2px; }

.form-control, .form-select {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: var(--navy);
    background: var(--white);
    transition: all .2s;
    outline: none;
}

.form-control:focus, .form-select:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(201,168,76,.15);
    background: #fffdf7;
}

.form-control::placeholder { color: #bbb; }

/* Image Upload */
.image-upload-zone {
    border: 2px dashed var(--border);
    border-radius: var(--radius);
    padding: 32px 20px;
    text-align: center;
    cursor: pointer;
    transition: all .3s;
    background: var(--cream);
    position: relative;
}
.image-upload-zone:hover, .image-upload-zone.dragover {
    border-color: var(--gold);
    background: rgba(201,168,76,.05);
}
.image-upload-zone input[type="file"] {
    position: absolute; inset: 0;
    opacity: 0; cursor: pointer;
    width: 100%; height: 100%;
}
.upload-icon { font-size: 32px; color: var(--gold); margin-bottom: 8px; }
.upload-text { font-size: 13px; color: var(--slate); }
.upload-text strong { color: var(--navy); }
.upload-hint { font-size: 11px; color: var(--muted); margin-top: 4px; }

#imagePreview {
    width: 90px; height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--gold);
    display: none;
    margin: 0 auto 10px;
    box-shadow: var(--shadow-sm);
}

/* Section divider within body */
.field-row { display: grid; gap: 16px; margin-bottom: 16px; }
.cols-4 { grid-template-columns: repeat(4,1fr); }
.cols-3 { grid-template-columns: repeat(3,1fr); }
.cols-2 { grid-template-columns: repeat(2,1fr); }
.cols-1 { grid-template-columns: 1fr; }

@media(max-width:992px) {
    .cols-4 { grid-template-columns: repeat(2,1fr); }
    .cols-3 { grid-template-columns: repeat(2,1fr); }
}
@media(max-width:576px) {
    .cols-4, .cols-3, .cols-2 { grid-template-columns: 1fr; }
    .form-wrapper, .progress-wrapper { padding-left: 16px; padding-right: 16px; }
    .page-hero { padding: 32px 20px 28px; }
    .hero-title { font-size: 1.5rem; }
}

/* ── Repeater Rows ── */
.repeater-entry {
    background: var(--cream);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px;
    margin-bottom: 12px;
    position: relative;
    transition: box-shadow .2s;
}
.repeater-entry:hover { box-shadow: var(--shadow-sm); }

.repeater-entry-num {
    position: absolute;
    top: -10px; left: 16px;
    background: var(--navy);
    color: var(--gold);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .5px;
    padding: 2px 10px;
    border-radius: 50px;
}

.btn-remove {
    position: absolute;
    top: 12px; right: 12px;
    background: rgba(192,57,43,.1);
    border: 1px solid rgba(192,57,43,.3);
    color: var(--danger);
    font-size: 12px;
    padding: 5px 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: all .2s;
    font-family: 'DM Sans', sans-serif;
}
.btn-remove:hover { background: var(--danger); color: #fff; }

.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(15,30,60,.06);
    border: 1.5px dashed rgba(15,30,60,.2);
    color: var(--navy);
    font-size: 13px;
    font-weight: 500;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    transition: all .2s;
    font-family: 'DM Sans', sans-serif;
    margin-top: 8px;
}
.btn-add:hover {
    background: var(--navy);
    color: var(--gold);
    border-color: var(--navy);
}

/* ── Submit Section ── */
.submit-bar {
    background: var(--white);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    padding: 24px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    box-shadow: var(--shadow-md);
    margin-top: 8px;
}

.submit-note {
    font-size: 12px;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, var(--navy) 0%, #243a6e 100%);
    color: var(--white);
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    padding: 14px 36px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: all .3s;
    box-shadow: 0 4px 16px rgba(15,30,60,.25);
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(15,30,60,.35);
    background: linear-gradient(135deg, #1a2f5a 0%, #0f1e3c 100%);
}
.btn-submit:active { transform: translateY(0); }

.btn-submit .btn-icon {
    width: 28px; height: 28px;
    background: var(--gold);
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    color: var(--navy);
    font-size: 13px;
}

/* ── Toast Notification ── */
.toast-autosave {
    position: fixed;
    top: 24px; right: 24px;
    z-index: 9999;
    background: var(--navy);
    color: var(--white);
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: var(--shadow-lg);
    transform: translateX(120%);
    transition: transform .4s cubic-bezier(.34,1.56,.64,1);
    border-left: 3px solid var(--gold);
}
.toast-autosave.show { transform: translateX(0); }
.toast-autosave .toast-icon { color: var(--gold); font-size: 15px; }

/* ── Alert Banner ── */
.alert-success-banner {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    border: 1px solid #b8dab6;
    color: #155724;
    border-radius: var(--radius);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 40px 20px;
    font-size: 14px;
    font-weight: 500;
    box-shadow: var(--shadow-sm);
}

/* Image note */
.field-hint {
    font-size: 11px;
    color: var(--muted);
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
}
</style>

{{-- Toast --}}
<div class="toast-autosave" id="toastSave">
    <span class="toast-icon"><i class="bi bi-cloud-check-fill"></i></span>
    <span id="toastMsg">Draft saved</span>
</div>

{{-- Success Banner --}}
@if(session('success'))
<div class="alert-success-banner">
    <i class="bi bi-check-circle-fill"></i>
    {{ session('success') }}
</div>
@endif

{{-- Hero Header --}}
<div class="page-hero">
    <div class="d-flex justify-content-between align-items-flex-start flex-wrap gap-3">
        <div>
            <div class="hero-badge"><i class="bi bi-person-badge"></i> New Registration</div>
            <h1 class="hero-title">Resource Speaker <span>Profile</span></h1>
            <p class="hero-subtitle">Complete all sections to register a new specialist in the system.</p>
        </div>
        <div class="hero-actions">
            <div class="autosave-pill">
                <span class="autosave-dot"></span>
                <span id="lastSavedTime">Auto-save on</span>
            </div>
            <button type="button" class="btn-clear" onclick="clearSavedData()">
                <i class="bi bi-trash3"></i> Clear Draft
            </button>
        </div>
    </div>
</div>

{{-- Step Progress --}}
<div class="progress-wrapper">
    <div class="progress-steps" id="progressSteps">
        {{-- Steps rendered by JS --}}
    </div>
</div>

{{-- Form --}}
<div class="form-wrapper">
<form id="resourceSpeakerForm" action="{{ route('resource_speaker.store') }}" method="POST" enctype="multipart/form-data" novalidate>
@csrf

{{-- ══════════════════════════════════
     1. PERSONAL INFORMATION
══════════════════════════════════ --}}
<div class="section-card open" data-section="1">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-person-circle"></i></div>
        <div class="section-title-group">
            <p class="section-title">Personal Information</p>
            <p class="section-desc">Basic details, contact, and home address</p>
        </div>
        <div class="section-toggle"><i class="bi bi-chevron-down"></i></div>
    </div>
    <div class="section-body">

        {{-- Image Upload --}}
        <div class="field-row cols-1" style="max-width:280px; margin-bottom:24px;">
            <div class="field-group">
                <label class="field-label">Profile Photo <span class="required">*</span></label>
                <div class="image-upload-zone" id="uploadZone">
                    <img id="imagePreview" src="" alt="Preview">
                    <div id="uploadPlaceholder">
                        <div class="upload-icon"><i class="bi bi-camera"></i></div>
                        <div class="upload-text"><strong>Click to upload</strong> or drag & drop</div>
                        <div class="upload-hint">JPG, PNG, WEBP — max 5MB</div>
                    </div>
                    <input type="file" id="img" name="img" accept="image/*" onchange="previewImage(event)">
                </div>
                <div class="field-hint"><i class="bi bi-info-circle"></i> Image cannot be auto-saved.</div>
            </div>
        </div>

        {{-- Name --}}
        <div class="field-row cols-4">
            <div class="field-group">
                <label class="field-label">Last Name <span class="required">*</span></label>
                <input type="text" class="form-control auto-save" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="e.g. Santos" required>
            </div>
            <div class="field-group">
                <label class="field-label">Given Name <span class="required">*</span></label>
                <input type="text" class="form-control auto-save" id="given_name" name="given_name" placeholder="e.g. Maria" required>
            </div>
            <div class="field-group">
                <label class="field-label">Middle Name <span class="required">*</span></label>
                <input type="text" class="form-control auto-save" id="middle_name" name="middle_name" placeholder="e.g. Cruz" required>
            </div>
            <div class="field-group">
                <label class="field-label">Extension</label>
                <input type="text" class="form-control auto-save" id="ext_name" name="ext_name" placeholder="Jr., Sr., III">
            </div>
        </div>

        {{-- Birth & Demographics --}}
        <div class="field-row cols-4">
            <div class="field-group">
                <label class="field-label">Date of Birth <span class="required">*</span></label>
                <input type="date" class="form-control auto-save" id="date_of_birth" name="date_of_birth" required>
            </div>
            <div class="field-group">
                <label class="field-label">Place of Birth <span class="required">*</span></label>
                <input type="text" class="form-control auto-save" id="place_of_birth" name="place_of_birth" placeholder="City / Municipality" required>
            </div>
            <div class="field-group">
                <label class="field-label">Age <span class="required">*</span></label>
                <input type="number" class="form-control auto-save" id="age" name="age" min="1" max="150" placeholder="0" required>
            </div>
            <div class="field-group">
                <label class="field-label">Sex <span class="required">*</span></label>
                <select class="form-select auto-save" id="gender" name="gender" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>

        {{-- Contact --}}
        <div class="field-row cols-4">
            <div class="field-group">
                <label class="field-label">Email <span class="required">*</span></label>
                <input type="email" class="form-control auto-save" id="email" name="email" placeholder="email@example.com" required>
            </div>
            <div class="field-group">
                <label class="field-label">Cellphone No</label>
                <input type="text" class="form-control auto-save" id="home_cell_no" name="home_cell_no" placeholder="+63 9XX XXX XXXX">
            </div>
            <div class="field-group">
                <label class="field-label">Telephone No</label>
                <input type="text" class="form-control auto-save" id="home_tel_no" name="home_tel_no" placeholder="(074) XXX-XXXX">
            </div>
            <div class="field-group">
                <label class="field-label">Fax No</label>
                <input type="text" class="form-control auto-save" id="home_fax_no" name="home_fax_no" placeholder="Fax number">
            </div>
        </div>

        {{-- Address --}}
        <div class="field-row cols-4">
            <div class="field-group">
                <label class="field-label">Home Address</label>
                <input type="text" class="form-control auto-save" id="home_address" name="home_address" placeholder="Street / Purok">
            </div>
            <div class="field-group">
                <label class="field-label">Building No</label>
                <input type="text" class="form-control auto-save" id="home_building_no" name="home_building_no" placeholder="#00">
            </div>
            <div class="field-group">
                <label class="field-label">Barangay</label>
                <input type="text" class="form-control auto-save" id="home_barangay" name="home_barangay" placeholder="Barangay">
            </div>
            <div class="field-group">
                <label class="field-label">Zip Code <span class="required">*</span></label>
                <input type="text" class="form-control auto-save" id="home_zip_code" name="home_zip_code" placeholder="0000" required>
            </div>
        </div>

        <div class="field-row cols-2">
            <div class="field-group">
                <label class="field-label">Municipality <span class="required">*</span></label>
                <input type="text" class="form-control auto-save" id="home_municipality" name="home_municipality" placeholder="Municipality / City" required>
            </div>
            <div class="field-group">
                <label class="field-label">Province <span class="required">*</span></label>
                <input type="text" class="form-control auto-save" id="home_province" name="home_province" placeholder="Province" required>
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════
     2. EXPERTISE
══════════════════════════════════ --}}
<div class="section-card" data-section="2">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-stars"></i></div>
        <div class="section-title-group">
            <p class="section-title">Expertise</p>
            <p class="section-desc">Areas of specialization and skills</p>
        </div>
        <div class="section-toggle"><i class="bi bi-chevron-down"></i></div>
    </div>
    <div class="section-body">
        <div id="expertise-container">
            <div class="repeater-entry">
                <span class="repeater-entry-num">Entry #1</span>
                <button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="field-row cols-1" style="max-width:500px; margin-top:8px;">
                    <div class="field-group">
                        <label class="field-label">Expertise / Specialization</label>
                        <input type="text" class="form-control auto-save-array" name="expertis[]" placeholder="e.g. Data Science, Public Speaking">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMoreExpertise">
            <i class="bi bi-plus-lg"></i> Add Another Expertise
        </button>
    </div>
</div>

{{-- ══════════════════════════════════
     3. OFFICE INFORMATION
══════════════════════════════════ --}}
<div class="section-card" data-section="3">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-building"></i></div>
        <div class="section-title-group">
            <p class="section-title">Office Information</p>
            <p class="section-desc">Current employer and office address</p>
        </div>
        <div class="section-toggle"><i class="bi bi-chevron-down"></i></div>
    </div>
    <div class="section-body">
        <div class="field-row cols-4">
            <div class="field-group">
                <label class="field-label">Organization / Agency</label>
                <input type="text" class="form-control auto-save" id="office_organization" name="office_organization" placeholder="Agency name">
            </div>
            <div class="field-group">
                <label class="field-label">Position / Designation</label>
                <input type="text" class="form-control auto-save" name="off_position" placeholder="e.g. Director">
            </div>
            <div class="field-group">
                <label class="field-label">Office Address</label>
                <input type="text" class="form-control auto-save" name="off_address" placeholder="Street">
            </div>
            <div class="field-group">
                <label class="field-label">Building No</label>
                <input type="text" class="form-control auto-save" name="off_building_no" placeholder="#00">
            </div>
        </div>
        <div class="field-row cols-4">
            <div class="field-group">
                <label class="field-label">Barangay</label>
                <input type="text" class="form-control auto-save" name="barangay" placeholder="Barangay">
            </div>
            <div class="field-group">
                <label class="field-label">Municipality</label>
                <input type="text" class="form-control auto-save" name="municipality" placeholder="Municipality">
            </div>
            <div class="field-group">
                <label class="field-label">Province</label>
                <input type="text" class="form-control auto-save" name="province" placeholder="Province">
            </div>
            <div class="field-group">
                <label class="field-label">Zip Code</label>
                <input type="text" class="form-control auto-save" name="zip_code" placeholder="0000">
            </div>
        </div>
        <div class="field-row cols-3">
            <div class="field-group">
                <label class="field-label">Telephone No</label>
                <input type="text" class="form-control auto-save" name="off_tel_no" placeholder="(074) XXX-XXXX">
            </div>
            <div class="field-group">
                <label class="field-label">Cellphone No</label>
                <input type="text" class="form-control auto-save" name="off_cell_no" placeholder="+63 9XX XXX XXXX">
            </div>
            <div class="field-group">
                <label class="field-label">Fax No</label>
                <input type="text" class="form-control auto-save" name="off_fax_no" placeholder="Fax number">
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════
     4. EDUCATIONAL BACKGROUND
══════════════════════════════════ --}}
<div class="section-card" data-section="4">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-mortarboard"></i></div>
        <div class="section-title-group">
            <p class="section-title">Educational Background</p>
            <p class="section-desc">Formal education and academic achievements</p>
        </div>
        <div class="section-toggle"><i class="bi bi-chevron-down"></i></div>
    </div>
    <div class="section-body">
        <div id="education-container">
            <div class="repeater-entry">
                <span class="repeater-entry-num">Entry #1</span>
                <button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="field-row cols-3" style="margin-top:8px;">
                    <div class="field-group">
                        <label class="field-label">Level</label>
                        <input type="text" class="form-control auto-save-array" name="level[]" placeholder="e.g. College, Post-grad">
                    </div>
                    <div class="field-group">
                        <label class="field-label">School / University</label>
                        <input type="text" class="form-control auto-save-array" name="school[]" placeholder="School name">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Year Graduated</label>
                        <input type="text" class="form-control auto-save-array" name="year_graduated[]" placeholder="YYYY">
                    </div>
                </div>
                <div class="field-row cols-3">
                    <div class="field-group">
                        <label class="field-label">From Year</label>
                        <input type="text" class="form-control auto-save-array" name="from_year[]" placeholder="YYYY">
                    </div>
                    <div class="field-group">
                        <label class="field-label">To Year</label>
                        <input type="text" class="form-control auto-save-array" name="to_year[]" placeholder="YYYY">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Honors / Awards</label>
                        <input type="text" class="form-control auto-save-array" name="awards[]" placeholder="e.g. Cum Laude">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMoreEducation">
            <i class="bi bi-plus-lg"></i> Add Another Education
        </button>
    </div>
</div>

{{-- ══════════════════════════════════
     5. WORK EXPERIENCE
══════════════════════════════════ --}}
<div class="section-card" data-section="5">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-briefcase"></i></div>
        <div class="section-title-group">
            <p class="section-title">Work Experience</p>
            <p class="section-desc">Previous and current employment history</p>
        </div>
        <div class="section-toggle"><i class="bi bi-chevron-down"></i></div>
    </div>
    <div class="section-body">
        <div id="work-experience-container">
            <div class="repeater-entry work-experience-entry">
                <span class="repeater-entry-num">Entry #1</span>
                <button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="field-row cols-3" style="margin-top:8px;">
                    <div class="field-group">
                        <label class="field-label">Company / Agency</label>
                        <input type="text" class="form-control auto-save-array" name="work_name_company[]" placeholder="Company name">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Position</label>
                        <input type="text" class="form-control auto-save-array" name="work_position[]" placeholder="Job title">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Division / Department</label>
                        <input type="text" class="form-control auto-save-array" name="work_division[]" placeholder="Department">
                    </div>
                </div>
                <div class="field-row cols-3">
                    <div class="field-group">
                        <label class="field-label">Date Started</label>
                        <input type="date" class="form-control auto-save-array" name="work_date_started[]">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Date Ended</label>
                        <input type="date" class="form-control auto-save-array" name="work_date_ended[]">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Address</label>
                        <input type="text" class="form-control auto-save-array" name="work_address[]" placeholder="Company address">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMoreWorkExperience">
            <i class="bi bi-plus-lg"></i> Add Another Work Experience
        </button>
    </div>
</div>

{{-- ══════════════════════════════════
     6. TRAININGS / SEMINARS
══════════════════════════════════ --}}
<div class="section-card" data-section="6">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-journal-text"></i></div>
        <div class="section-title-group">
            <p class="section-title">Trainings / Seminars Attended</p>
            <p class="section-desc">Relevant training and seminar participation</p>
        </div>
        <div class="section-toggle"><i class="bi bi-chevron-down"></i></div>
    </div>
    <div class="section-body">
        <div id="training-container">
            <div class="repeater-entry training-entry">
                <span class="repeater-entry-num">Entry #1</span>
                <button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="field-row cols-4" style="margin-top:8px;">
                    <div class="field-group">
                        <label class="field-label">Training Title</label>
                        <input type="text" class="form-control auto-save-array" name="rst_title[]" placeholder="Training name">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Venue</label>
                        <input type="text" class="form-control auto-save-array" name="rst_venue[]" placeholder="Location">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Date</label>
                        <input type="date" class="form-control auto-save-array" name="rst_date[]">
                    </div>
                    <div class="field-group">
                        <label class="field-label">No. of Hours</label>
                        <input type="number" class="form-control auto-save-array" name="rst_no_hours[]" placeholder="0" min="0">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMoreTraining">
            <i class="bi bi-plus-lg"></i> Add Another Training
        </button>
    </div>
</div>

{{-- ══════════════════════════════════
     7. EXPERIENCE AS TRAINER
══════════════════════════════════ --}}
<div class="section-card" data-section="7">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-people"></i></div>
        <div class="section-title-group">
            <p class="section-title">Experience as Trainer / Resource Speaker</p>
            <p class="section-desc">Trainings conducted or facilitated</p>
        </div>
        <div class="section-toggle"><i class="bi bi-chevron-down"></i></div>
    </div>
    <div class="section-body">
        <div id="trainerExperienceRepeater">
            <div class="repeater-entry trainer-entry">
                <span class="repeater-entry-num">Entry #1</span>
                <button type="button" class="btn-remove btn-remove-trainer">✕ Remove</button>
                <div class="field-row cols-4" style="margin-top:8px;">
                    <div class="field-group">
                        <label class="field-label">Training Title</label>
                        <input type="text" class="form-control auto-save-array" name="rt_title[]" placeholder="Training name">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Venue</label>
                        <input type="text" class="form-control auto-save-array" name="rt_venue[]" placeholder="Location">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Date</label>
                        <input type="date" class="form-control auto-save-array" name="rt_date[]">
                    </div>
                    <div class="field-group">
                        <label class="field-label">No. of Hours</label>
                        <input type="number" class="form-control auto-save-array" name="rt_no_hours[]" placeholder="0" min="0">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addTrainerExperience">
            <i class="bi bi-plus-lg"></i> Add Another Entry
        </button>
    </div>
</div>

{{-- ══════════════════════════════════
     8. PUBLICATIONS
══════════════════════════════════ --}}
<div class="section-card" data-section="8">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-file-earmark-text"></i></div>
        <div class="section-title-group">
            <p class="section-title">Publications</p>
            <p class="section-desc">Research papers, articles, and publications</p>
        </div>
        <div class="section-toggle"><i class="bi bi-chevron-down"></i></div>
    </div>
    <div class="section-body">
        <div id="publication-container">
            <div class="repeater-entry publication-entry">
                <span class="repeater-entry-num">Entry #1</span>
                <button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="field-row cols-4" style="margin-top:8px;">
                    <div class="field-group">
                        <label class="field-label">Publication Title</label>
                        <input type="text" class="form-control auto-save-array" name="publication_title[]" placeholder="Title">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Nature</label>
                        <input type="text" class="form-control auto-save-array" name="p_nature[]" placeholder="e.g. Journal, Book">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Date</label>
                        <input type="date" class="form-control auto-save-array" name="p_date[]">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Publisher / Venue</label>
                        <input type="text" class="form-control auto-save-array" name="p_venue[]" placeholder="Publisher name">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMorePublication">
            <i class="bi bi-plus-lg"></i> Add Another Publication
        </button>
    </div>
</div>

{{-- ══════════════════════════════════
     9. REFERENCES
══════════════════════════════════ --}}
<div class="section-card" data-section="9">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-person-lines-fill"></i></div>
        <div class="section-title-group">
            <p class="section-title">References</p>
            <p class="section-desc">Agency references and contact persons</p>
        </div>
        <div class="section-toggle"><i class="bi bi-chevron-down"></i></div>
    </div>
    <div class="section-body">
        <div id="references-container">
            <div class="repeater-entry references-entry">
                <span class="repeater-entry-num">Entry #1</span>
                <button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="field-row cols-4" style="margin-top:8px;">
                    <div class="field-group">
                        <label class="field-label">Agency Name</label>
                        <input type="text" class="form-control auto-save-array" name="name_agency[]" placeholder="Agency">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Address</label>
                        <input type="text" class="form-control auto-save-array" name="ref_address[]" placeholder="Address">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Contact Person</label>
                        <input type="text" class="form-control auto-save-array" name="contact_person[]" placeholder="Full name">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Position</label>
                        <input type="text" class="form-control auto-save-array" name="ref_position[]" placeholder="Position">
                    </div>
                </div>
                <div class="field-row cols-3">
                    <div class="field-group">
                        <label class="field-label">Telephone No</label>
                        <input type="text" class="form-control auto-save-array" name="ref_tel_no[]" placeholder="Tel number">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Cellphone No</label>
                        <input type="text" class="form-control auto-save-array" name="ref_cell_no[]" placeholder="Cell number">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Fax No</label>
                        <input type="text" class="form-control auto-save-array" name="ref_fax_no[]" placeholder="Fax number">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMoreReferences">
            <i class="bi bi-plus-lg"></i> Add Another Reference
        </button>
    </div>
</div>

{{-- ── Submit Bar ── --}}
<div class="submit-bar">
    <div class="submit-note">
        <i class="bi bi-shield-check" style="color:var(--success);font-size:16px;"></i>
        All data is encrypted and stored securely. Fields marked <strong style="color:var(--gold);">*</strong> are required.
    </div>
    <button type="submit" class="btn-submit">
        <div class="btn-icon"><i class="bi bi-send"></i></div>
        Submit Application
    </button>
</div>

</form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const form       = document.getElementById('resourceSpeakerForm');
    const STORAGE_KEY = 'rs_draft_v4';
    let autoSaveTimer;

    /* ─── STEPS ─── */
    const steps = [
        { label:'Personal',    icon:'bi-person-circle' },
        { label:'Expertise',   icon:'bi-stars' },
        { label:'Office',      icon:'bi-building' },
        { label:'Education',   icon:'bi-mortarboard' },
        { label:'Work',        icon:'bi-briefcase' },
        { label:'Trainings',   icon:'bi-journal-text' },
        { label:'Trainer Exp', icon:'bi-people' },
        { label:'Publications',icon:'bi-file-earmark-text' },
        { label:'References',  icon:'bi-person-lines-fill' },
    ];

    const stepsEl = document.getElementById('progressSteps');
    steps.forEach((s, i) => {
        if (i > 0) {
            const div = document.createElement('div');
            div.className = 'step-divider';
            stepsEl.appendChild(div);
        }
        const item = document.createElement('div');
        item.className = 'step-item' + (i === 0 ? ' active' : '');
        item.innerHTML = `<div class="step-num">${i+1}</div><span class="step-label">${s.label}</span>`;
        item.addEventListener('click', () => {
            const cards = document.querySelectorAll('.section-card');
            if (cards[i]) {
                cards[i].scrollIntoView({ behavior:'smooth', block:'start' });
                if (!cards[i].classList.contains('open')) toggleSection(cards[i].querySelector('.section-header'));
            }
        });
        stepsEl.appendChild(item);
    });

    /* Highlight step on scroll */
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const idx = [...document.querySelectorAll('.section-card')].indexOf(entry.target);
                document.querySelectorAll('.step-item').forEach((el,i) => {
                    el.classList.toggle('active', i === idx);
                });
            }
        });
    }, { threshold: 0.4 });
    document.querySelectorAll('.section-card').forEach(c => observer.observe(c));

    /* ─── SECTION TOGGLE ─── */
    window.toggleSection = function(header) {
        const card = header.closest('.section-card');
        card.classList.toggle('open');
    };

    /* ─── IMAGE PREVIEW ─── */
    window.previewImage = function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => {
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            preview.src = ev.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    };

    /* ─── TOAST ─── */
    function showToast(msg, duration = 3000) {
        const toast = document.getElementById('toastSave');
        document.getElementById('toastMsg').textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), duration);
    }

    /* ─── AUTO-SAVE ─── */
    function saveFormData() {
        const data = { arrays: {}, ts: Date.now() };
        document.querySelectorAll('.auto-save').forEach(el => {
            if (el.name) data[el.name] = el.value;
        });
        document.querySelectorAll('.auto-save-array').forEach(el => {
            if (!data.arrays[el.name]) data.arrays[el.name] = [];
            data.arrays[el.name].push(el.value || '');
        });
        localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
        const t = new Date(data.ts);
        document.getElementById('lastSavedTime').textContent =
            'Saved ' + t.toLocaleTimeString([], { hour:'2-digit', minute:'2-digit' });
        showToast('Draft auto-saved');
    }

    function loadSavedData() {
        let raw;
        try { raw = localStorage.getItem(STORAGE_KEY); } catch(e) { return; }
        if (!raw) return;
        const data = JSON.parse(raw);

        Object.keys(data).forEach(k => {
            if (k === 'arrays' || k === 'ts') return;
            const el = document.querySelector(`[name="${k}"]`);
            if (el) el.value = data[k];
        });

        const btnMap = {
            'expertis[]':          'addMoreExpertise',
            'work_name_company[]': 'addMoreWorkExperience',
            'level[]':             'addMoreEducation',
            'rst_title[]':         'addMoreTraining',
            'rt_title[]':          'addTrainerExperience',
            'publication_title[]': 'addMorePublication',
            'name_agency[]':       'addMoreReferences',
        };

        if (data.arrays) {
            Object.keys(data.arrays).forEach(name => {
                const values = data.arrays[name];
                const existing = document.querySelectorAll(`[name="${name}"]`).length;
                const btnId = btnMap[name];
                if (btnId) {
                    for (let i = 0; i < values.length - existing; i++) {
                        document.getElementById(btnId)?.click();
                    }
                }
                setTimeout(() => {
                    document.querySelectorAll(`[name="${name}"]`).forEach((el, i) => {
                        if (values[i] !== undefined) el.value = values[i];
                    });
                }, 200);
            });
        }

        if (data.ts) {
            const t = new Date(data.ts);
            document.getElementById('lastSavedTime').textContent =
                'Saved ' + t.toLocaleTimeString([], { hour:'2-digit', minute:'2-digit' });
        }
        showToast('Draft restored ✓');
    }

    loadSavedData();

    document.querySelectorAll('.auto-save, .auto-save-array').forEach(el => {
        el.addEventListener('input', () => {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(saveFormData, 1200);
        });
    });

    window.clearSavedData = function() {
        Swal.fire({
            title: 'Clear draft?',
            text: 'All saved data will be permanently removed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#c0392b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, clear it'
        }).then(r => {
            if (r.isConfirmed) {
                localStorage.removeItem(STORAGE_KEY);
                location.reload();
            }
        });
    };

    /* ─── VALIDATION + SUBMIT ─── */
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const errors = [];

        if (!document.getElementById('img').files[0]) errors.push('Profile photo is required.');

        const required = {
            last_name:'Last Name', given_name:'Given Name', middle_name:'Middle Name',
            date_of_birth:'Date of Birth', place_of_birth:'Place of Birth', age:'Age',
            gender:'Sex', email:'Email', home_zip_code:'Zip Code',
            home_municipality:'Municipality', home_province:'Province'
        };

        Object.entries(required).forEach(([id, label]) => {
            const el = document.getElementById(id);
            if (!el || !el.value.trim()) errors.push(`${label} is required.`);
        });

        const age = parseInt(document.getElementById('age')?.value);
        if (!isNaN(age) && (age <= 0 || age > 150)) errors.push('Please enter a valid age.');

        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Please complete required fields',
                html: `<div style="text-align:left;font-size:14px;line-height:2">` +
                      errors.map(e => `<span style="color:#c0392b">●</span> ${e}`).join('<br>') + `</div>`,
                confirmButtonColor: '#0f1e3c',
                width: '480px'
            });
            // Open first section
            const firstCard = document.querySelector('.section-card');
            if (firstCard && !firstCard.classList.contains('open')) {
                toggleSection(firstCard.querySelector('.section-header'));
            }
            return;
        }

        Swal.fire({
            title: 'Submit Application?',
            html: '<p style="color:#4a5568;font-size:14px;">Please ensure all information is accurate before submitting.</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0f1e3c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-send"></i> Yes, Submit',
            cancelButtonText: 'Review Again',
        }).then(result => {
            if (result.isConfirmed) {
                localStorage.removeItem(STORAGE_KEY);
                form.submit();
            }
        });
    });

    /* ─── REPEATER HELPERS ─── */
    function updateEntryNumbers(container) {
        container.querySelectorAll('.repeater-entry-num').forEach((el, i) => {
            el.textContent = `Entry #${i + 1}`;
        });
    }

    function cloneEntry(container, selector) {
        const entries = container.querySelectorAll(selector);
        const last = entries[entries.length - 1];
        const clone = last.cloneNode(true);
        clone.querySelectorAll('input, select, textarea').forEach(i => i.value = '');
        container.appendChild(clone);
        updateEntryNumbers(container);
        saveFormData();
    }

    /* Expertise */
    document.getElementById('addMoreExpertise').addEventListener('click', () =>
        cloneEntry(document.getElementById('expertise-container'), '.repeater-entry'));

    /* Education */
    document.getElementById('addMoreEducation').addEventListener('click', () =>
        cloneEntry(document.getElementById('education-container'), '.repeater-entry'));

    /* Work */
    document.getElementById('addMoreWorkExperience').addEventListener('click', () =>
        cloneEntry(document.getElementById('work-experience-container'), '.repeater-entry'));

    /* Training */
    document.getElementById('addMoreTraining').addEventListener('click', () =>
        cloneEntry(document.getElementById('training-container'), '.repeater-entry'));

    /* Trainer Experience */
    document.getElementById('addTrainerExperience').addEventListener('click', () =>
        cloneEntry(document.getElementById('trainerExperienceRepeater'), '.repeater-entry'));

    /* Publications */
    document.getElementById('addMorePublication').addEventListener('click', () =>
        cloneEntry(document.getElementById('publication-container'), '.repeater-entry'));

    /* References */
    document.getElementById('addMoreReferences').addEventListener('click', () =>
        cloneEntry(document.getElementById('references-container'), '.repeater-entry'));

    /* ─── GLOBAL REMOVE ─── */
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-entry') || e.target.classList.contains('btn-remove-trainer')) {
            const entry = e.target.closest('.repeater-entry');
            if (!entry) return;
            const container = entry.parentElement;
            const siblings = container.querySelectorAll('.repeater-entry');
            if (siblings.length <= 1) {
                showToast('At least one entry is required');
                return;
            }
            entry.style.transition = 'opacity .2s, transform .2s';
            entry.style.opacity = '0';
            entry.style.transform = 'translateX(20px)';
            setTimeout(() => {
                entry.remove();
                updateEntryNumbers(container);
                saveFormData();
            }, 200);
        }
    });

});
</script>

@endsection
