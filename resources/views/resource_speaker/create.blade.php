@extends('layouts.admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:root {
    --navy:#0f1e3c; --navy-mid:#1a2f5a; --navy-light:#243a6e;
    --gold:#c9a84c; --gold-light:#e8c97a; --gold-pale:rgba(201,168,76,.08);
    --cream:#f7f4ee; --cream-dark:#ede9e0;
    --slate:#4a5568; --muted:#8a95a3; --white:#ffffff; --border:#e0dbd0;
    --success:#2d7a4f; --danger:#c0392b; --warning:#d97706;
    --sh-sm:0 2px 8px rgba(15,30,60,.07); --sh-md:0 8px 32px rgba(15,30,60,.11); --sh-lg:0 20px 60px rgba(15,30,60,.17);
    --r:12px; --r-lg:20px;
}
*,*::before,*::after{box-sizing:border-box;}
body{background:var(--cream);font-family:'DM Sans',sans-serif;color:var(--navy);margin:0;}

/* COMPLETION WIDGET */
.completion-widget{
    position:fixed;bottom:28px;right:28px;z-index:1000;
    background:var(--navy);border-radius:16px;padding:16px 20px;
    box-shadow:var(--sh-lg);min-width:200px;border:1px solid rgba(201,168,76,.25);
    transition:transform .3s;
}
.completion-widget:hover{transform:translateY(-3px);}
.cw-label{font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--gold);margin-bottom:8px;}
.cw-percent{font-family:'Playfair Display',serif;font-size:2rem;color:var(--white);line-height:1;margin-bottom:8px;}
.cw-percent span{font-size:13px;font-weight:400;color:rgba(255,255,255,.5);}
.cw-bar-track{height:4px;background:rgba(255,255,255,.1);border-radius:4px;overflow:hidden;}
.cw-bar-fill{height:100%;background:linear-gradient(90deg,var(--gold),var(--gold-light));border-radius:4px;transition:width .6s cubic-bezier(.34,1.56,.64,1);}
.cw-fields{font-size:11px;color:rgba(255,255,255,.45);margin-top:6px;}

/* HERO */
.page-hero{
    background:linear-gradient(135deg,var(--navy) 0%,var(--navy-mid) 55%,var(--navy-light) 100%);
    padding:44px 40px 32px;position:relative;overflow:hidden;
    border-radius:0 0 var(--r-lg) var(--r-lg);margin-bottom:28px;box-shadow:var(--sh-lg);
}
.page-hero::before{content:'';position:absolute;top:-80px;right:-80px;width:360px;height:360px;border-radius:50%;background:radial-gradient(circle,rgba(201,168,76,.15) 0%,transparent 70%);}
.page-hero::after{content:'';position:absolute;bottom:-50px;left:8%;width:250px;height:250px;border-radius:50%;background:radial-gradient(circle,rgba(201,168,76,.08) 0%,transparent 70%);}
.hero-inner{position:relative;z-index:1;display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px;}
.hero-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(201,168,76,.15);border:1px solid rgba(201,168,76,.3);color:var(--gold-light);font-size:10px;font-weight:700;letter-spacing:1.8px;text-transform:uppercase;padding:5px 14px;border-radius:50px;margin-bottom:14px;}
.hero-title{font-family:'Playfair Display',serif;font-size:2.1rem;color:var(--white);margin:0 0 6px;line-height:1.2;}
.hero-title span{color:var(--gold-light);}
.hero-sub{color:rgba(255,255,255,.5);font-size:13px;font-weight:300;margin:0;}
.hero-right{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.autosave-pill{display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.13);color:rgba(255,255,255,.65);font-size:12px;padding:8px 15px;border-radius:50px;}
.live-dot{width:7px;height:7px;background:#4ade80;border-radius:50%;animation:pulse-g 2s infinite;}
@keyframes pulse-g{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.5;transform:scale(1.4);}}
.btn-clear-hero{background:rgba(192,57,43,.18);border:1px solid rgba(192,57,43,.38);color:#ff8a80;font-size:12px;font-weight:500;padding:8px 15px;border-radius:50px;cursor:pointer;transition:all .2s;white-space:nowrap;font-family:'DM Sans',sans-serif;}
.btn-clear-hero:hover{background:rgba(192,57,43,.35);color:#fff;}
.kbd-hint{display:inline-flex;align-items:center;gap:4px;font-size:10px;color:rgba(255,255,255,.4);}
.kbd{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:4px;padding:1px 6px;font-size:10px;font-family:monospace;color:rgba(255,255,255,.6);}

/* PROGRESS */
.progress-wrap{padding:0 40px 24px;}
.progress-steps{display:flex;align-items:center;background:var(--white);border-radius:var(--r);padding:14px 20px;box-shadow:var(--sh-sm);overflow-x:auto;border:1px solid var(--border);gap:0;scrollbar-width:none;}
.progress-steps::-webkit-scrollbar{display:none;}
.step-item{display:flex;align-items:center;gap:8px;flex-shrink:0;cursor:pointer;padding:5px 10px;border-radius:8px;transition:background .2s;}
.step-item:hover{background:var(--gold-pale);}
.step-num{width:28px;height:28px;border-radius:50%;background:var(--border);color:var(--muted);font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;transition:all .3s;flex-shrink:0;}
.step-item.active .step-num{background:var(--gold);color:var(--navy);box-shadow:0 0 0 4px rgba(201,168,76,.2);}
.step-item.done .step-num{background:var(--success);color:#fff;}
.step-label{font-size:11px;font-weight:500;color:var(--muted);white-space:nowrap;transition:color .3s;}
.step-item.active .step-label{color:var(--navy);font-weight:700;}
.step-item.done .step-label{color:var(--success);}
.step-div{flex:1;min-width:16px;height:1px;background:var(--border);margin:0 2px;}

/* FORM WRAPPER */
.form-wrap{padding:0 40px 120px;max-width:1200px;margin:0 auto;}

/* TOOLBAR */
.form-toolbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:14px;padding:12px 18px;background:var(--white);border-radius:var(--r);border:1px solid var(--border);box-shadow:var(--sh-sm);}
.toolbar-left{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:6px;}
.toolbar-right{display:flex;gap:8px;}
.btn-toolbar{font-size:11px;font-weight:600;padding:6px 14px;border-radius:6px;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;border:1px solid var(--border);background:var(--white);color:var(--slate);}
.btn-toolbar:hover{background:var(--navy);color:var(--white);border-color:var(--navy);}

/* SEARCH */
.section-search-wrap{margin-bottom:14px;position:relative;}
.section-search-wrap .bi{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);}
#sectionSearch{width:100%;padding:10px 14px 10px 36px;border:1.5px solid var(--border);border-radius:var(--r);font-family:'DM Sans',sans-serif;font-size:13px;background:var(--white);color:var(--navy);outline:none;transition:all .2s;}
#sectionSearch:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,168,76,.12);}

/* SECTION CARDS */
.section-card{background:var(--white);border-radius:var(--r-lg);border:1px solid var(--border);margin-bottom:12px;overflow:hidden;box-shadow:var(--sh-sm);transition:box-shadow .3s,border-color .3s;}
.section-card:hover{box-shadow:var(--sh-md);}
.section-card.has-data{border-left:3px solid var(--success);}
.section-header{display:flex;align-items:center;gap:14px;padding:18px 26px;cursor:pointer;user-select:none;transition:background .2s;border-bottom:1px solid transparent;}
.section-header:hover{background:rgba(201,168,76,.03);}
.section-card.open .section-header{border-bottom-color:var(--border);background:rgba(15,30,60,.02);}
.section-icon{width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,var(--navy) 0%,var(--navy-mid) 100%);display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:15px;flex-shrink:0;}
.section-title-grp{flex:1;}
.section-title{font-family:'Playfair Display',serif;font-size:.95rem;font-weight:600;color:var(--navy);margin:0 0 2px;}
.section-desc{font-size:10px;color:var(--muted);margin:0;}
.section-meta{display:flex;align-items:center;gap:10px;}
.section-filled-badge{font-size:10px;font-weight:600;padding:3px 10px;border-radius:50px;background:rgba(45,122,79,.1);color:var(--success);display:none;}
.section-card.has-data .section-filled-badge{display:inline-block;}
.section-toggle{width:26px;height:26px;border-radius:50%;background:var(--cream);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:12px;transition:all .3s;flex-shrink:0;}
.section-card.open .section-toggle{background:var(--navy);color:var(--white);transform:rotate(180deg);border-color:var(--navy);}
.section-body{display:none;padding:26px;animation:slideIn .3s ease;}
.section-card.open .section-body{display:block;}
@keyframes slideIn{from{opacity:0;transform:translateY(-6px);}to{opacity:1;transform:translateY(0);}}

/* FIELDS */
.field-grp{margin-bottom:16px;position:relative;}
.field-label{display:block;font-size:10px;font-weight:700;letter-spacing:.9px;text-transform:uppercase;color:var(--slate);margin-bottom:5px;}
.required-star{color:var(--gold);margin-left:2px;}
.field-hint{font-size:10px;color:var(--muted);margin-top:4px;display:flex;align-items:center;gap:4px;}
.form-control,.form-select{width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:8px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--navy);background:var(--white);transition:all .2s;outline:none;}
.form-control:focus,.form-select:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,168,76,.13);background:#fffdf7;}
.form-control.filled{border-color:rgba(45,122,79,.35);background:rgba(45,122,79,.02);}
.form-control.input-error{border-color:var(--danger)!important;background:rgba(192,57,43,.03)!important;animation:shake .4s ease;}
@keyframes shake{0%,100%{transform:translateX(0);}25%{transform:translateX(-4px);}75%{transform:translateX(4px);}}
.form-control::placeholder{color:#bbb;}
.input-icon-wrap{position:relative;}
.input-icon-wrap .form-control{padding-left:38px;}
.input-icon-wrap .input-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:14px;pointer-events:none;}
.frow{display:grid;gap:14px;margin-bottom:14px;}
.c4{grid-template-columns:repeat(4,1fr);}
.c3{grid-template-columns:repeat(3,1fr);}
.c2{grid-template-columns:repeat(2,1fr);}
.c1{grid-template-columns:1fr;}
@media(max-width:992px){.c4,.c3{grid-template-columns:repeat(2,1fr);}}
@media(max-width:576px){
    .c4,.c3,.c2{grid-template-columns:1fr;}
    .form-wrap,.progress-wrap{padding-left:14px;padding-right:14px;}
    .page-hero{padding:28px 18px 24px;}
    .hero-title{font-size:1.5rem;}
    .completion-widget{bottom:16px;right:16px;min-width:160px;}
}

/* IMAGE UPLOAD */
.image-upload-zone{border:2px dashed var(--border);border-radius:var(--r);padding:28px 18px;text-align:center;cursor:pointer;transition:all .3s;background:var(--cream);position:relative;}
.image-upload-zone:hover,.image-upload-zone.dragover{border-color:var(--gold);background:rgba(201,168,76,.05);}
.image-upload-zone input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
.upload-icon{font-size:28px;color:var(--gold);margin-bottom:6px;}
.upload-text{font-size:12px;color:var(--slate);}
.upload-text strong{color:var(--navy);}
.upload-hint{font-size:10px;color:var(--muted);margin-top:3px;}
#imagePreview{width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid var(--gold);display:none;margin:0 auto 10px;box-shadow:var(--sh-sm);}

/* REPEATER */
.repeater-entry{background:var(--cream);border:1px solid var(--border);border-radius:var(--r);padding:20px 20px 14px;margin-bottom:10px;position:relative;transition:box-shadow .2s;}
.repeater-entry:hover{box-shadow:var(--sh-sm);}
.entry-num{position:absolute;top:-9px;left:14px;background:var(--navy);color:var(--gold);font-size:9px;font-weight:800;letter-spacing:.6px;padding:2px 10px;border-radius:50px;}
.btn-remove{position:absolute;top:12px;right:12px;background:rgba(192,57,43,.08);border:1px solid rgba(192,57,43,.25);color:var(--danger);font-size:11px;padding:4px 11px;border-radius:6px;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;}
.btn-remove:hover{background:var(--danger);color:#fff;}
.btn-add{display:inline-flex;align-items:center;gap:8px;background:rgba(15,30,60,.05);border:1.5px dashed rgba(15,30,60,.18);color:var(--navy);font-size:12px;font-weight:500;padding:9px 18px;border-radius:8px;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;margin-top:6px;}
.btn-add:hover{background:var(--navy);color:var(--gold);border-color:var(--navy);}

/* SUBMIT BAR */
.submit-bar{background:var(--white);border-radius:var(--r-lg);border:1px solid var(--border);padding:22px 26px;display:flex;align-items:center;justify-content:space-between;gap:14px;box-shadow:var(--sh-md);margin-top:6px;}
.submit-note{font-size:11px;color:var(--muted);display:flex;align-items:center;gap:6px;line-height:1.6;}
.btn-submit{display:inline-flex;align-items:center;gap:10px;background:linear-gradient(135deg,var(--navy) 0%,var(--navy-light) 100%);color:var(--white);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;padding:13px 32px;border-radius:10px;border:none;cursor:pointer;transition:all .3s;box-shadow:0 4px 16px rgba(15,30,60,.22);white-space:nowrap;}
.btn-submit:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(15,30,60,.32);}
.btn-submit:active{transform:translateY(0);}
.btn-submit:disabled{opacity:.6;cursor:not-allowed;transform:none;}
.btn-icon{width:26px;height:26px;background:var(--gold);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--navy);font-size:12px;}

/* TOAST */
.toast-box{position:fixed;top:22px;right:22px;z-index:9999;background:var(--navy);color:var(--white);padding:11px 18px;border-radius:10px;font-size:12px;font-weight:500;display:flex;align-items:center;gap:9px;box-shadow:var(--sh-lg);transform:translateX(130%);transition:transform .4s cubic-bezier(.34,1.56,.64,1);border-left:3px solid var(--gold);max-width:280px;}
.toast-box.show{transform:translateX(0);}
.toast-box .ti{color:var(--gold);font-size:14px;}

/* ALERTS */
.alert-ok{background:linear-gradient(135deg,#d4edda,#c3e6cb);border:1px solid #b8dab6;color:#155724;border-radius:var(--r);padding:13px 18px;display:flex;align-items:center;gap:9px;margin:0 40px 18px;font-size:13px;font-weight:500;box-shadow:var(--sh-sm);}
.alert-err{background:linear-gradient(135deg,#fde8e8,#fbd5d5);border:1px solid #f5c0c0;color:#7b1a1a;border-radius:var(--r);padding:13px 18px;display:flex;align-items:center;gap:9px;margin:0 40px 18px;font-size:13px;font-weight:500;box-shadow:var(--sh-sm);}

/* UNSAVED DOT */
.unsaved-dot{display:none;width:7px;height:7px;border-radius:50%;background:var(--warning);margin-left:4px;vertical-align:middle;}
</style>

{{-- Toast --}}
<div class="toast-box" id="toastBox">
    <span class="ti bi bi-cloud-check-fill"></span>
    <span id="toastMsg">Draft saved</span>
</div>

{{-- Completion Widget --}}
<div class="completion-widget" id="completionWidget">
    <div class="cw-label"><i class="bi bi-clipboard-check"></i> Form Progress</div>
    <div class="cw-percent" id="cwPercent">0<span>%</span></div>
    <div class="cw-bar-track"><div class="cw-bar-fill" id="cwBar" style="width:0%"></div></div>
    <div class="cw-fields" id="cwFields">0 of 0 required fields filled</div>
</div>

@if(session('success'))
<div class="alert-ok"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert-err"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
@endif

{{-- HERO --}}
<div class="page-hero">
    <div class="hero-inner">
        <div>
            <div class="hero-badge"><i class="bi bi-person-badge-fill"></i> New Registration</div>
            <h1 class="hero-title">Resource Speaker <span>Profile</span></h1>
            <p class="hero-sub">Complete all sections to register a new specialist in the system.</p>
            <div style="margin-top:12px;">
                <span class="kbd-hint">
                    <span class="kbd">Ctrl</span>+<span class="kbd">S</span>&nbsp; Save draft &nbsp;|&nbsp;
                    <span class="kbd">Ctrl</span>+<span class="kbd">Enter</span>&nbsp; Submit &nbsp;|&nbsp;
                    <span class="kbd">Esc</span>&nbsp; Clear search
                </span>
            </div>
        </div>
        <div class="hero-right">
            <div class="autosave-pill">
                <span class="live-dot"></span>
                <span id="lastSavedTime">Auto-save on</span>
            </div>
            <button type="button" class="btn-clear-hero" onclick="clearSavedData()">   
                <i class="bi bi-trash3"></i> Clear Draft
            </button>
        </div>
    </div>
</div>

{{-- PROGRESS --}}
<div class="progress-wrap">
    <div class="progress-steps" id="progressSteps"></div>
</div>

<div class="form-wrap">

    {{-- Toolbar --}}
    <div class="form-toolbar">
        <div class="toolbar-left"><i class="bi bi-layout-text-sidebar-reverse"></i><span id="openSectionCount">1 section open</span></div>
        <div class="toolbar-right">
            <button type="button" class="btn-toolbar" onclick="expandAll()"><i class="bi bi-arrows-expand"></i> Expand All</button>
            <button type="button" class="btn-toolbar" onclick="collapseAll()"><i class="bi bi-arrows-collapse"></i> Collapse All</button>
            <button type="button" class="btn-toolbar" onclick="jumpToError()"><i class="bi bi-exclamation-circle"></i> Jump to Error</button>
        </div>
    </div>

    {{-- Section Search --}}
    <div class="section-search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="sectionSearch" placeholder="Search sections… (e.g. 'email', 'education', 'office')">
    </div>

<form id="resourceSpeakerForm" action="{{ route('resource_speaker.store') }}" method="POST" enctype="multipart/form-data" novalidate>
@csrf

{{-- 1. PERSONAL INFO --}}
<div class="section-card open" data-section="1" data-keywords="personal name email gender birth address phone contact">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-person-circle"></i></div>
        <div class="section-title-grp"><p class="section-title">Personal Information</p><p class="section-desc">Basic details, contact, and home address</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div style="max-width:270px;margin-bottom:22px;">
            <label class="field-label">Profile Photo <span class="required-star">*</span></label>
            <div class="image-upload-zone" id="uploadZone">
                <img id="imagePreview" src="" alt="Preview">
                <div id="uploadPlaceholder">
                    <div class="upload-icon"><i class="bi bi-camera"></i></div>
                    <div class="upload-text"><strong>Click to upload</strong> or drag & drop</div>
                    <div class="upload-hint">JPG, PNG, WEBP — max 5MB</div>
                </div>
                <input type="file" id="img" name="img" accept="image/*" onchange="previewImage(event)">
            </div>
            <div class="field-hint"><i class="bi bi-info-circle"></i> Photo cannot be auto-saved.</div>
        </div>
        <div class="frow c4">
            <div class="field-grp"><label class="field-label">Last Name <span class="required-star">*</span></label><div class="input-icon-wrap"><i class="bi bi-person input-icon"></i><input type="text" class="form-control auto-save required-field" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Santos" required></div></div>
            <div class="field-grp"><label class="field-label">Given Name <span class="required-star">*</span></label><input type="text" class="form-control auto-save required-field" id="given_name" name="given_name" placeholder="Maria" required></div>
            <div class="field-grp"><label class="field-label">Middle Name <span class="required-star">*</span></label><input type="text" class="form-control auto-save required-field" id="middle_name" name="middle_name" placeholder="Cruz" required></div>
            <div class="field-grp"><label class="field-label">Extension</label><input type="text" class="form-control auto-save" id="ext_name" name="ext_name" placeholder="Jr., Sr., III"></div>
        </div>
        <div class="frow c4">
            <div class="field-grp"><label class="field-label">Date of Birth <span class="required-star">*</span></label><input type="date" class="form-control auto-save required-field" id="date_of_birth" name="date_of_birth" required></div>
            <div class="field-grp"><label class="field-label">Place of Birth <span class="required-star">*</span></label><input type="text" class="form-control auto-save required-field" id="place_of_birth" name="place_of_birth" placeholder="City / Municipality" required></div>
            <div class="field-grp"><label class="field-label">Age <span class="required-star">*</span></label><input type="number" class="form-control auto-save required-field" id="age" name="age" min="1" max="150" placeholder="0" required><div class="field-hint" id="ageHint"></div></div>
            <div class="field-grp"><label class="field-label">Sex <span class="required-star">*</span></label><select class="form-select auto-save required-field" id="gender" name="gender" required><option value="">Select</option><option value="Male">Male</option><option value="Female">Female</option></select></div>
        </div>
        <div class="frow c4">
            <div class="field-grp"><label class="field-label">Email <span class="required-star">*</span></label><div class="input-icon-wrap"><i class="bi bi-envelope input-icon"></i><input type="email" class="form-control auto-save required-field" id="email" name="email" placeholder="email@example.com" required></div></div>
            <div class="field-grp"><label class="field-label">Cellphone No</label><div class="input-icon-wrap"><i class="bi bi-phone input-icon"></i><input type="text" class="form-control auto-save" id="home_cell_no" name="home_cell_no" placeholder="+63 9XX XXX XXXX"></div></div>
            <div class="field-grp"><label class="field-label">Telephone No</label><div class="input-icon-wrap"><i class="bi bi-telephone input-icon"></i><input type="text" class="form-control auto-save" id="home_tel_no" name="home_tel_no" placeholder="(074) XXX-XXXX"></div></div>
            <div class="field-grp"><label class="field-label">Fax No</label><input type="text" class="form-control auto-save" id="home_fax_no" name="home_fax_no" placeholder="Fax number"></div>
        </div>
        <div class="frow c4">
            <div class="field-grp"><label class="field-label">Home Address</label><input type="text" class="form-control auto-save" id="home_address" name="home_address" placeholder="Street / Purok"></div>
            <div class="field-grp"><label class="field-label">Building No</label><input type="text" class="form-control auto-save" id="home_building_no" name="home_building_no" placeholder="#00"></div>
            <div class="field-grp"><label class="field-label">Barangay</label><input type="text" class="form-control auto-save" id="home_barangay" name="home_barangay" placeholder="Barangay"></div>
            <div class="field-grp"><label class="field-label">Zip Code <span class="required-star">*</span></label><input type="text" class="form-control auto-save required-field" id="home_zip_code" name="home_zip_code" placeholder="0000" required></div>
        </div>
        <div class="frow c2">
            <div class="field-grp"><label class="field-label">Municipality <span class="required-star">*</span></label><input type="text" class="form-control auto-save required-field" id="home_municipality" name="home_municipality" placeholder="Municipality / City" required></div>
            <div class="field-grp"><label class="field-label">Province <span class="required-star">*</span></label><input type="text" class="form-control auto-save required-field" id="home_province" name="home_province" placeholder="Province" required></div>
        </div>
    </div>
</div>

{{-- 2. EXPERTISE --}}
<div class="section-card" data-section="2" data-keywords="expertise specialization skill area">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-stars"></i></div>
        <div class="section-title-grp"><p class="section-title">Expertise</p><p class="section-desc">Areas of specialization and skills</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div id="expertise-container">
            <div class="repeater-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c1" style="max-width:500px;margin-top:10px;"><div class="field-grp"><label class="field-label">Expertise / Specialization</label><input type="text" class="form-control auto-save-array" name="expertis[]" placeholder="e.g. Data Science, Public Speaking"></div></div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMoreExpertise"><i class="bi bi-plus-lg"></i> Add Another Expertise</button>
    </div>
</div>

{{-- 3. OFFICE --}}
<div class="section-card" data-section="3" data-keywords="office organization position agency employer work address building">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-building"></i></div>
        <div class="section-title-grp"><p class="section-title">Office Information</p><p class="section-desc">Current employer and office address</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div class="frow c4">
            <div class="field-grp"><label class="field-label">Organization / Agency</label><input type="text" class="form-control auto-save" name="office_organization" placeholder="Agency name"></div>
            <div class="field-grp"><label class="field-label">Position / Designation</label><input type="text" class="form-control auto-save" name="off_position" placeholder="e.g. Director"></div>
            <div class="field-grp"><label class="field-label">Office Address</label><input type="text" class="form-control auto-save" name="off_address" placeholder="Street"></div>
            <div class="field-grp"><label class="field-label">Building No</label><input type="text" class="form-control auto-save" name="off_building_no" placeholder="#00"></div>
        </div>
        <div class="frow c4">
            <div class="field-grp"><label class="field-label">Barangay</label><input type="text" class="form-control auto-save" name="barangay" placeholder="Barangay"></div>
            <div class="field-grp"><label class="field-label">Municipality</label><input type="text" class="form-control auto-save" name="municipality" placeholder="Municipality"></div>
            <div class="field-grp"><label class="field-label">Province</label><input type="text" class="form-control auto-save" name="province" placeholder="Province"></div>
            <div class="field-grp"><label class="field-label">Zip Code</label><input type="text" class="form-control auto-save" name="zip_code" placeholder="0000"></div>
        </div>
        <div class="frow c3">
            <div class="field-grp"><label class="field-label">Telephone No</label><input type="text" class="form-control auto-save" name="off_tel_no" placeholder="(074) XXX-XXXX"></div>
            <div class="field-grp"><label class="field-label">Cellphone No</label><input type="text" class="form-control auto-save" name="off_cell_no" placeholder="+63 9XX XXX XXXX"></div>
            <div class="field-grp"><label class="field-label">Fax No</label><input type="text" class="form-control auto-save" name="off_fax_no" placeholder="Fax number"></div>
        </div>
    </div>
</div>

{{-- 4. EDUCATION --}}
<div class="section-card" data-section="4" data-keywords="education school university college degree level graduated awards">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-mortarboard"></i></div>
        <div class="section-title-grp"><p class="section-title">Educational Background</p><p class="section-desc">Formal education and academic achievements</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div id="education-container">
            <div class="repeater-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c3" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Level</label><input type="text" class="form-control auto-save-array" name="level[]" placeholder="e.g. College, Post-grad"></div>
                    <div class="field-grp"><label class="field-label">School / University</label><input type="text" class="form-control auto-save-array" name="school[]" placeholder="School name"></div>
                    <div class="field-grp"><label class="field-label">Year Graduated</label><input type="text" class="form-control auto-save-array" name="year_graduated[]" placeholder="YYYY"></div>
                </div>
                <div class="frow c3">
                    <div class="field-grp"><label class="field-label">From Year</label><input type="text" class="form-control auto-save-array" name="from_year[]" placeholder="YYYY"></div>
                    <div class="field-grp"><label class="field-label">To Year</label><input type="text" class="form-control auto-save-array" name="to_year[]" placeholder="YYYY"></div>
                    <div class="field-grp"><label class="field-label">Honors / Awards</label><input type="text" class="form-control auto-save-array" name="awards[]" placeholder="e.g. Cum Laude"></div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMoreEducation"><i class="bi bi-plus-lg"></i> Add Another Education</button>
    </div>
</div>

{{-- 5. WORK EXPERIENCE --}}
<div class="section-card" data-section="5" data-keywords="work experience company employment job position division">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-briefcase"></i></div>
        <div class="section-title-grp"><p class="section-title">Work Experience</p><p class="section-desc">Previous and current employment history</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div id="work-experience-container">
            <div class="repeater-entry work-experience-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c3" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Company / Agency</label><input type="text" class="form-control auto-save-array" name="work_name_company[]" placeholder="Company name"></div>
                    <div class="field-grp"><label class="field-label">Position</label><input type="text" class="form-control auto-save-array" name="work_position[]" placeholder="Job title"></div>
                    <div class="field-grp"><label class="field-label">Division / Dept</label><input type="text" class="form-control auto-save-array" name="work_division[]" placeholder="Department"></div>
                </div>
                <div class="frow c3">
                    <div class="field-grp"><label class="field-label">Date Started</label><input type="date" class="form-control auto-save-array" name="work_date_started[]"></div>
                    <div class="field-grp"><label class="field-label">Date Ended</label><input type="date" class="form-control auto-save-array" name="work_date_ended[]"></div>
                    <div class="field-grp"><label class="field-label">Address</label><input type="text" class="form-control auto-save-array" name="work_address[]" placeholder="Company address"></div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMoreWorkExperience"><i class="bi bi-plus-lg"></i> Add Another Work Experience</button>
    </div>
</div>

{{-- 6. TRAININGS --}}
<div class="section-card" data-section="6" data-keywords="training seminar attended hours venue date">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-journal-text"></i></div>
        <div class="section-title-grp"><p class="section-title">Trainings / Seminars Attended</p><p class="section-desc">Relevant training and seminar participation</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div id="training-container">
            <div class="repeater-entry training-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c4" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Training Title</label><input type="text" class="form-control auto-save-array" name="rst_title[]" placeholder="Training name"></div>
                    <div class="field-grp"><label class="field-label">Venue</label><input type="text" class="form-control auto-save-array" name="rst_venue[]" placeholder="Location"></div>
                    <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control auto-save-array" name="rst_date[]"></div>
                    <div class="field-grp"><label class="field-label">No. of Hours</label><input type="number" class="form-control auto-save-array" name="rst_no_hours[]" placeholder="0" min="0"></div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMoreTraining"><i class="bi bi-plus-lg"></i> Add Another Training</button>
    </div>
</div>

{{-- 7. TRAINER EXPERIENCE --}}
<div class="section-card" data-section="7" data-keywords="trainer resource speaker experience facilitated conducted">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-people"></i></div>
        <div class="section-title-grp"><p class="section-title">Experience as Trainer / Resource Speaker</p><p class="section-desc">Trainings conducted or facilitated</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div id="trainerExperienceRepeater">
            <div class="repeater-entry trainer-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove btn-remove-trainer">✕ Remove</button>
                <div class="frow c4" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Training Title</label><input type="text" class="form-control auto-save-array" name="rt_title[]" placeholder="Training name"></div>
                    <div class="field-grp"><label class="field-label">Venue</label><input type="text" class="form-control auto-save-array" name="rt_venue[]" placeholder="Location"></div>
                    <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control auto-save-array" name="rt_date[]"></div>
                    <div class="field-grp"><label class="field-label">No. of Hours</label><input type="number" class="form-control auto-save-array" name="rt_no_hours[]" placeholder="0" min="0"></div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addTrainerExperience"><i class="bi bi-plus-lg"></i> Add Another Entry</button>
    </div>
</div>

{{-- 8. PUBLICATIONS --}}
<div class="section-card" data-section="8" data-keywords="publication research paper journal book article nature">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-file-earmark-text"></i></div>
        <div class="section-title-grp"><p class="section-title">Publications</p><p class="section-desc">Research papers, articles, and publications</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div id="publication-container">
            <div class="repeater-entry publication-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c4" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Publication Title</label><input type="text" class="form-control auto-save-array" name="publication_title[]" placeholder="Title"></div>
                    <div class="field-grp"><label class="field-label">Nature</label><input type="text" class="form-control auto-save-array" name="p_nature[]" placeholder="e.g. Journal, Book"></div>
                    <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control auto-save-array" name="p_date[]"></div>
                    <div class="field-grp"><label class="field-label">Publisher / Venue</label><input type="text" class="form-control auto-save-array" name="p_venue[]" placeholder="Publisher name"></div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMorePublication"><i class="bi bi-plus-lg"></i> Add Another Publication</button>
    </div>
</div>

{{-- 9. REFERENCES --}}
<div class="section-card" data-section="9" data-keywords="references agency contact person telephone fax cell">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-person-lines-fill"></i></div>
        <div class="section-title-grp"><p class="section-title">References</p><p class="section-desc">Agency references and contact persons</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div id="references-container">
            <div class="repeater-entry references-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c4" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Agency Name</label><input type="text" class="form-control auto-save-array" name="name_agency[]" placeholder="Agency"></div>
                    <div class="field-grp"><label class="field-label">Address</label><input type="text" class="form-control auto-save-array" name="ref_address[]" placeholder="Address"></div>
                    <div class="field-grp"><label class="field-label">Contact Person</label><input type="text" class="form-control auto-save-array" name="contact_person[]" placeholder="Full name"></div>
                    <div class="field-grp"><label class="field-label">Position</label><input type="text" class="form-control auto-save-array" name="ref_position[]" placeholder="Position"></div>
                </div>
                <div class="frow c3">
                    <div class="field-grp"><label class="field-label">Telephone No</label><input type="text" class="form-control auto-save-array" name="ref_tel_no[]" placeholder="Tel number"></div>
                    <div class="field-grp"><label class="field-label">Cellphone No</label><input type="text" class="form-control auto-save-array" name="ref_cell_no[]" placeholder="Cell number"></div>
                    <div class="field-grp"><label class="field-label">Fax No</label><input type="text" class="form-control auto-save-array" name="ref_fax_no[]" placeholder="Fax number"></div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-add" id="addMoreReferences"><i class="bi bi-plus-lg"></i> Add Another Reference</button>
    </div>
</div>

{{-- SUBMIT BAR --}}
<div class="submit-bar">
    <div class="submit-note">
        <i class="bi bi-shield-check" style="color:var(--success);font-size:15px;"></i>
        Data is securely stored. Fields marked <strong style="color:var(--gold);margin:0 2px;">*</strong> are required.
        <span id="unsavedDot" class="unsaved-dot" title="Unsaved changes"></span>
    </div>
    <button type="submit" class="btn-submit" id="submitBtn">
        <div class="btn-icon"><i class="bi bi-send"></i></div>
        Submit Application
    </button>
</div>

</form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('resourceSpeakerForm');
    const STORAGE_KEY = 'rs_draft_v5';
    let autoSaveTimer, hasUnsaved = false;

    /* STEPS */
    const steps = ['Personal','Expertise','Office','Education','Work','Trainings','Trainer Exp','Publications','References'];
    const stepsEl = document.getElementById('progressSteps');
    steps.forEach((label, i) => {
        if (i > 0) { const d = document.createElement('div'); d.className='step-div'; stepsEl.appendChild(d); }
        const item = document.createElement('div');
        item.className = 'step-item' + (i===0?' active':'');
        item.innerHTML = `<div class="step-num">${i+1}</div><span class="step-label">${label}</span>`;
        item.addEventListener('click', () => {
            const cards = document.querySelectorAll('.section-card');
            if (cards[i]) { cards[i].scrollIntoView({behavior:'smooth',block:'start'}); if (!cards[i].classList.contains('open')) toggleSection(cards[i].querySelector('.section-header')); }
        });
        stepsEl.appendChild(item);
    });

    const io = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const idx = [...document.querySelectorAll('.section-card')].indexOf(entry.target);
                document.querySelectorAll('.step-item').forEach((el,i) => el.classList.toggle('active', i===idx));
            }
        });
    }, {threshold:0.3});
    document.querySelectorAll('.section-card').forEach(c => io.observe(c));

    /* SECTION TOGGLE */
    window.toggleSection = h => { h.closest('.section-card').classList.toggle('open'); updateOpenCount(); };
    window.expandAll = () => { document.querySelectorAll('.section-card').forEach(c=>c.classList.add('open')); updateOpenCount(); };
    window.collapseAll = () => { document.querySelectorAll('.section-card').forEach(c=>c.classList.remove('open')); updateOpenCount(); };
    function updateOpenCount() {
        const n = document.querySelectorAll('.section-card.open').length;
        document.getElementById('openSectionCount').textContent = `${n} section${n!==1?'s':''} open`;
    }

    /* SECTION SEARCH */
    document.getElementById('sectionSearch').addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('.section-card').forEach(card => {
            const kw = (card.dataset.keywords||'') + ' ' + card.querySelector('.section-title').textContent.toLowerCase();
            const match = !q || kw.includes(q);
            card.style.display = match ? '' : 'none';
            if (match && q) card.classList.add('open');
        });
        updateOpenCount();
    });

    /* IMAGE PREVIEW + DRAG DROP */
    window.previewImage = function(e) {
        const file = e.target.files[0]; if (!file) return;
        if (file.size > 5*1024*1024) { showToast('Image exceeds 5MB limit','danger'); return; }
        const r = new FileReader();
        r.onload = ev => { const p=document.getElementById('imagePreview'); p.src=ev.target.result; p.style.display='block'; document.getElementById('uploadPlaceholder').style.display='none'; };
        r.readAsDataURL(file);
    };
    const zone = document.getElementById('uploadZone');
    zone.addEventListener('dragover', e=>{e.preventDefault();zone.classList.add('dragover');});
    zone.addEventListener('dragleave', ()=>zone.classList.remove('dragover'));
    zone.addEventListener('drop', e=>{
        e.preventDefault(); zone.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file&&file.type.startsWith('image/')) { document.getElementById('img').files=e.dataTransfer.files; previewImage({target:{files:[file]}}); }
    });

    /* TOAST */
    function showToast(msg, type='default', dur=3000) {
        const box=document.getElementById('toastBox'), icon=box.querySelector('.ti'), msgEl=document.getElementById('toastMsg');
        msgEl.textContent = msg;
        if (type==='danger') { box.style.borderLeftColor='var(--danger)'; icon.className='ti bi bi-exclamation-triangle-fill'; icon.style.color='#ff8a80'; }
        else if (type==='success') { box.style.borderLeftColor='var(--success)'; icon.className='ti bi bi-check-circle-fill'; icon.style.color='#4ade80'; }
        else { box.style.borderLeftColor='var(--gold)'; icon.className='ti bi bi-cloud-check-fill'; icon.style.color='var(--gold)'; }
        box.classList.add('show');
        setTimeout(()=>box.classList.remove('show'), dur);
    }

    /* COMPLETION TRACKER */
    function updateCompletion() {
        const fields = document.querySelectorAll('.required-field');
        let filled = 0;
        fields.forEach(f => { if (f.value.trim()) filled++; });
        const pct = fields.length ? Math.round(filled/fields.length*100) : 0;
        document.getElementById('cwPercent').innerHTML = `${pct}<span>%</span>`;
        document.getElementById('cwBar').style.width = pct+'%';
        document.getElementById('cwFields').textContent = `${filled} of ${fields.length} required fields filled`;
        document.querySelectorAll('.section-card').forEach(card => {
            let any = false;
            card.querySelectorAll('.form-control,.form-select').forEach(i => { if(i.value.trim()) any=true; });
            card.classList.toggle('has-data', any);
        });
    }

    /* AUTO-FILL AGE FROM DOB */
    document.getElementById('date_of_birth').addEventListener('change', function() {
        const dob = new Date(this.value); if (isNaN(dob)) return;
        const age = Math.floor((new Date()-dob)/(365.25*24*3600*1000));
        if (age > 0 && age < 150) { document.getElementById('age').value=age; document.getElementById('ageHint').textContent=`Calculated: ${age} years old`; }
        updateCompletion();
    });

    /* EMAIL VALIDATION */
    document.getElementById('email').addEventListener('blur', function() {
        if (this.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) { this.classList.add('input-error'); showToast('Invalid email format','danger'); }
        else this.classList.remove('input-error');
    });

    /* FILLED CLASS + COMPLETION */
    document.querySelectorAll('.form-control,.form-select').forEach(el => {
        el.addEventListener('input', function() { this.classList.toggle('filled',!!this.value.trim()); updateCompletion(); markUnsaved(); });
    });

    /* UNSAVED INDICATOR */
    function markUnsaved() { hasUnsaved=true; document.getElementById('unsavedDot').style.display='inline-block'; }
    function markSaved()   { hasUnsaved=false; document.getElementById('unsavedDot').style.display='none'; }
    window.addEventListener('beforeunload', e => { if (hasUnsaved) { e.preventDefault(); e.returnValue=''; } });

    /* AUTO-SAVE */
    function saveFormData() {
        const data = {arrays:{},ts:Date.now()};
        document.querySelectorAll('.auto-save').forEach(el => { if(el.name) data[el.name]=el.value; });
        document.querySelectorAll('.auto-save-array').forEach(el => { if(!data.arrays[el.name]) data.arrays[el.name]=[]; data.arrays[el.name].push(el.value||''); });
        try { localStorage.setItem(STORAGE_KEY, JSON.stringify(data)); } catch(e){return;}
        const t=new Date(data.ts);
        document.getElementById('lastSavedTime').textContent='Saved '+t.toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'});
        showToast('Draft saved ✓','success'); markSaved();
    }

    function loadSavedData() {
        let raw; try{raw=localStorage.getItem(STORAGE_KEY);}catch(e){return;}
        if (!raw) return;
        const data = JSON.parse(raw);
        Object.keys(data).forEach(k => {
            if (k==='arrays'||k==='ts') return;
            const el = document.querySelector(`[name="${k}"]`);
            if (el) { el.value=data[k]; el.classList.toggle('filled',!!el.value.trim()); }
        });
        const btnMap = {'expertis[]':'addMoreExpertise','work_name_company[]':'addMoreWorkExperience','level[]':'addMoreEducation','rst_title[]':'addMoreTraining','rt_title[]':'addTrainerExperience','publication_title[]':'addMorePublication','name_agency[]':'addMoreReferences'};
        if (data.arrays) {
            Object.keys(data.arrays).forEach(name => {
                const values=data.arrays[name], existing=document.querySelectorAll(`[name="${name}"]`).length, btnId=btnMap[name];
                if (btnId) for(let i=0;i<values.length-existing;i++) document.getElementById(btnId)?.click();
                setTimeout(()=>{
                    document.querySelectorAll(`[name="${name}"]`).forEach((el,i)=>{ if(values[i]!==undefined){el.value=values[i];el.classList.toggle('filled',!!el.value.trim());} });
                },200);
            });
        }
        if (data.ts) { const t=new Date(data.ts); document.getElementById('lastSavedTime').textContent='Saved '+t.toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'}); }
        showToast('Draft restored ✓','success');
        setTimeout(updateCompletion, 300);
    }

    loadSavedData(); updateCompletion();

    document.querySelectorAll('.auto-save,.auto-save-array').forEach(el => {
        el.addEventListener('input', ()=>{ clearTimeout(autoSaveTimer); autoSaveTimer=setTimeout(saveFormData,1200); });
    });

    window.clearSavedData = function() {
        Swal.fire({title:'Clear draft data?',text:'All typed data will be erased. This cannot be undone.',icon:'warning',showCancelButton:true,confirmButtonColor:'#c0392b',cancelButtonColor:'#6c757d',confirmButtonText:'Yes, clear it'})
        .then(r=>{ if(r.isConfirmed){localStorage.removeItem(STORAGE_KEY);location.reload();} });
    };

    /* JUMP TO ERROR */
    window.jumpToError = function() {
        const el = document.querySelector('.input-error');
        if (el) { el.scrollIntoView({behavior:'smooth',block:'center'}); el.focus(); showToast('Jumped to error field','danger'); }
        else showToast('No errors found ✓','success');
    };

    /* KEYBOARD SHORTCUTS */
    document.addEventListener('keydown', e => {
        if (e.ctrlKey && e.key==='s') { e.preventDefault(); saveFormData(); }
        if (e.ctrlKey && e.key==='Enter') { e.preventDefault(); document.getElementById('submitBtn').click(); }
        if (e.key==='Escape') { const s=document.getElementById('sectionSearch'); s.value=''; s.dispatchEvent(new Event('input')); }
    });

    /* VALIDATION + SUBMIT */
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const errors = [];
        if (!document.getElementById('img').files[0]) errors.push('Profile photo is required.');
        document.querySelectorAll('.input-error').forEach(el=>el.classList.remove('input-error'));
        const req = {last_name:'Last Name',given_name:'Given Name',middle_name:'Middle Name',date_of_birth:'Date of Birth',place_of_birth:'Place of Birth',age:'Age',gender:'Sex',email:'Email',home_zip_code:'Zip Code',home_municipality:'Municipality',home_province:'Province'};
        Object.entries(req).forEach(([id,label])=>{ const el=document.getElementById(id); if(!el||!el.value.trim()){errors.push(`${label} is required.`);if(el)el.classList.add('input-error');} });
        const age=parseInt(document.getElementById('age')?.value);
        if(!isNaN(age)&&(age<=0||age>150)) errors.push('Please enter a valid age.');
        const emailEl=document.getElementById('email');
        if(emailEl.value&&!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value)){errors.push('Invalid email address.');emailEl.classList.add('input-error');}
        if (errors.length > 0) {
            Swal.fire({icon:'error',title:'Please complete required fields',
                html:`<div style="text-align:left;font-size:13px;line-height:2.2">`+errors.map(err=>`<span style="color:#c0392b;margin-right:6px;">●</span>${err}`).join('<br>')+`</div>`,
                confirmButtonColor:'#0f1e3c',width:'500px',
                footer:`<span style="font-size:12px;color:#888;">${errors.length} issue${errors.length!==1?'s':''} found</span>`});
            const firstErr=document.querySelector('.input-error');
            if(firstErr){const card=firstErr.closest('.section-card');if(card&&!card.classList.contains('open'))toggleSection(card.querySelector('.section-header'));setTimeout(()=>firstErr.scrollIntoView({behavior:'smooth',block:'center'}),300);}
            return;
        }
        Swal.fire({
            title:'Submit Application?',
            html:`<p style="color:#4a5568;font-size:14px;margin:0;">Please ensure all information is accurate. This action cannot be undone.</p>`,
            icon:'question',showCancelButton:true,confirmButtonColor:'#0f1e3c',cancelButtonColor:'#6c757d',
            confirmButtonText:'<i class="bi bi-send"></i> Yes, Submit Now',cancelButtonText:'Review Again'
        }).then(r=>{
            if(r.isConfirmed){
                localStorage.removeItem(STORAGE_KEY);
                const btn=document.getElementById('submitBtn');
                btn.innerHTML='<div class="btn-icon"><i class="bi bi-hourglass-split"></i></div> Submitting…';
                btn.disabled=true; form.submit();
            }
        });
    });

    /* REPEATER */
    function renumber(container) { container.querySelectorAll('.entry-num').forEach((el,i)=>el.textContent=`Entry #${i+1}`); }
    function cloneEntry(container) {
        const entries=container.querySelectorAll('.repeater-entry');
        const clone=entries[entries.length-1].cloneNode(true);
        clone.querySelectorAll('input,select,textarea').forEach(i=>{i.value='';i.classList.remove('filled','input-error');});
        clone.style.opacity='0'; clone.style.transform='translateY(10px)';
        container.appendChild(clone); renumber(container);
        clone.querySelectorAll('.auto-save-array').forEach(el=>{
            el.addEventListener('input',()=>{clearTimeout(autoSaveTimer);autoSaveTimer=setTimeout(saveFormData,1200);updateCompletion();markUnsaved();});
        });
        requestAnimationFrame(()=>{ clone.style.transition='opacity .3s,transform .3s'; clone.style.opacity='1'; clone.style.transform='translateY(0)'; });
        saveFormData();
    }

    document.getElementById('addMoreExpertise').addEventListener('click',()=>cloneEntry(document.getElementById('expertise-container')));
    document.getElementById('addMoreEducation').addEventListener('click',()=>cloneEntry(document.getElementById('education-container')));
    document.getElementById('addMoreWorkExperience').addEventListener('click',()=>cloneEntry(document.getElementById('work-experience-container')));
    document.getElementById('addMoreTraining').addEventListener('click',()=>cloneEntry(document.getElementById('training-container')));
    document.getElementById('addTrainerExperience').addEventListener('click',()=>cloneEntry(document.getElementById('trainerExperienceRepeater')));
    document.getElementById('addMorePublication').addEventListener('click',()=>cloneEntry(document.getElementById('publication-container')));
    document.getElementById('addMoreReferences').addEventListener('click',()=>cloneEntry(document.getElementById('references-container')));

    document.addEventListener('click', e=>{
        if(e.target.classList.contains('remove-entry')||e.target.classList.contains('btn-remove-trainer')){
            const entry=e.target.closest('.repeater-entry'); if(!entry) return;
            const container=entry.parentElement;
            if(container.querySelectorAll('.repeater-entry').length<=1){showToast('At least one entry is required','danger');return;}
            entry.style.transition='opacity .2s,transform .2s'; entry.style.opacity='0'; entry.style.transform='translateX(20px)';
            setTimeout(()=>{entry.remove();renumber(container);saveFormData();updateCompletion();},220);
        }
    });

    updateOpenCount();
});
</script>

@endsection
