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

.form-wrap{padding:0 40px 120px;max-width:1200px;margin:0 auto;}

.form-toolbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:14px;padding:12px 18px;background:var(--white);border-radius:var(--r);border:1px solid var(--border);box-shadow:var(--sh-sm);}
.toolbar-left{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:6px;}
.toolbar-right{display:flex;gap:8px;}
.btn-toolbar{font-size:11px;font-weight:600;padding:6px 14px;border-radius:6px;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;border:1px solid var(--border);background:var(--white);color:var(--slate);}
.btn-toolbar:hover{background:var(--navy);color:var(--white);border-color:var(--navy);}

.section-search-wrap{margin-bottom:14px;position:relative;}
.section-search-wrap .bi{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);}
#sectionSearch{width:100%;padding:10px 14px 10px 36px;border:1.5px solid var(--border);border-radius:var(--r);font-family:'DM Sans',sans-serif;font-size:13px;background:var(--white);color:var(--navy);outline:none;transition:all .2s;}
#sectionSearch:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,168,76,.12);}

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
}

.image-upload-zone{border:2px dashed var(--border);border-radius:var(--r);padding:28px 18px;text-align:center;cursor:pointer;transition:all .3s;background:var(--cream);position:relative;}
.image-upload-zone:hover,.image-upload-zone.dragover{border-color:var(--gold);background:rgba(201,168,76,.05);}
.image-upload-zone input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
.upload-icon{font-size:28px;color:var(--gold);margin-bottom:6px;}
.upload-text{font-size:12px;color:var(--slate);}
.upload-text strong{color:var(--navy);}
.upload-hint{font-size:10px;color:var(--muted);margin-top:3px;}
#imagePreview{width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid var(--gold);display:block;margin:0 auto 10px;box-shadow:var(--sh-sm);}

.repeater-entry{background:var(--cream);border:1px solid var(--border);border-radius:var(--r);padding:20px 20px 14px;margin-bottom:10px;position:relative;transition:box-shadow .2s;}
.repeater-entry:hover{box-shadow:var(--sh-sm);}
.entry-num{position:absolute;top:-9px;left:14px;background:var(--navy);color:var(--gold);font-size:9px;font-weight:800;letter-spacing:.6px;padding:2px 10px;border-radius:50px;}
.btn-remove{position:absolute;top:12px;right:12px;background:rgba(192,57,43,.08);border:1px solid rgba(192,57,43,.25);color:var(--danger);font-size:11px;padding:4px 11px;border-radius:6px;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;}
.btn-remove:hover{background:var(--danger);color:#fff;}
.btn-add{display:inline-flex;align-items:center;gap:8px;background:rgba(15,30,60,.05);border:1.5px dashed rgba(15,30,60,.18);color:var(--navy);font-size:12px;font-weight:500;padding:9px 18px;border-radius:8px;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;margin-top:6px;}
.btn-add:hover{background:var(--navy);color:var(--gold);border-color:var(--navy);}

.submit-bar{background:var(--white);border-radius:var(--r-lg);border:1px solid var(--border);padding:22px 26px;display:flex;align-items:center;justify-content:space-between;gap:14px;box-shadow:var(--sh-md);margin-top:6px;}
.submit-note{font-size:11px;color:var(--muted);display:flex;align-items:center;gap:6px;line-height:1.6;}
.btn-submit{display:inline-flex;align-items:center;gap:10px;background:linear-gradient(135deg,var(--navy) 0%,var(--navy-light) 100%);color:var(--white);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;padding:13px 32px;border-radius:10px;border:none;cursor:pointer;transition:all .3s;box-shadow:0 4px 16px rgba(15,30,60,.22);white-space:nowrap;}
.btn-submit:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(15,30,60,.32);}
.btn-submit:active{transform:translateY(0);}
.btn-icon{width:26px;height:26px;background:var(--gold);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--navy);font-size:12px;}

.alert-ok{background:linear-gradient(135deg,#d4edda,#c3e6cb);border:1px solid #b8dab6;color:#155724;border-radius:var(--r);padding:13px 18px;display:flex;align-items:center;gap:9px;margin:0 40px 18px;font-size:13px;font-weight:500;box-shadow:var(--sh-sm);}
.alert-err{background:linear-gradient(135deg,#fde8e8,#fbd5d5);border:1px solid #f5c0c0;color:#7b1a1a;border-radius:var(--r);padding:13px 18px;display:flex;align-items:center;gap:9px;margin:0 40px 18px;font-size:13px;font-weight:500;box-shadow:var(--sh-sm);}

.back-btn{display:inline-flex;align-items:center;gap:8px;background:var(--white);border:1.5px solid var(--border);color:var(--navy);font-size:12px;font-weight:600;padding:8px 16px;border-radius:8px;cursor:pointer;transition:all .2s;text-decoration:none;font-family:'DM Sans',sans-serif;}
.back-btn:hover{background:var(--cream);border-color:var(--navy);color:var(--navy);}
</style>

@if(session('success'))
<div class="alert-ok"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert-err"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
@endif

<div class="page-hero">
    <div class="hero-inner">
        <div>
            <div class="hero-badge"><i class="bi bi-pencil-square"></i> Edit Record</div>
            <h1 class="hero-title">Update Resource Speaker <span>Profile</span></h1>
            <p class="hero-sub">Modify the information for {{ $speaker->given_name ?? '' }} {{ $speaker->last_name ?? 'this speaker' }}.</p>
        </div>
        <div class="hero-right">
            <a href="{{ route('resource_speaker.view', $speaker->id) }}" class="back-btn">
                <i class="bi bi-arrow-left"></i> Back to View
            </a>
        </div>
    </div>
</div>

<div class="form-wrap">
    <div class="form-toolbar">
        <div class="toolbar-left"><i class="bi bi-layout-text-sidebar-reverse"></i> Update Speaker Information</div>
        <div class="toolbar-right">
            <button type="button" class="btn-toolbar" onclick="expandAll()"><i class="bi bi-arrows-expand"></i> Expand All</button>
            <button type="button" class="btn-toolbar" onclick="collapseAll()"><i class="bi bi-arrows-collapse"></i> Collapse All</button>
        </div>
    </div>

    <div class="section-search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="sectionSearch" placeholder="Search sections… (e.g. 'email', 'education', 'office')">
    </div>

<form action="{{ route('resource_speaker.update', $speaker->id) }}" method="POST" enctype="multipart/form-data" novalidate>
@csrf
@method('PUT')
<input type="hidden" name="updated_by" value="{{ auth()->id() }}">

{{-- 1. PERSONAL INFO --}}
<div class="section-card open" data-section="1" data-keywords="personal name email gender birth address phone contact">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-person-circle"></i></div>
        <div class="section-title-grp"><p class="section-title">Personal Information</p><p class="section-desc">Basic details, contact, and home address</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div style="max-width:270px;margin-bottom:22px;">
            <label class="field-label">Profile Photo</label>
            <div class="image-upload-zone" id="uploadZone">
                @if($speaker->img)
                <img id="imagePreview" src="{{ asset($speaker->img) }}" alt="Preview" style="display:block;">
                @else
                <img id="imagePreview" src="" alt="Preview">
                @endif
                <div id="uploadPlaceholder" @if($speaker->img) style="display:none;" @endif>
                    <div class="upload-icon"><i class="bi bi-camera"></i></div>
                    <div class="upload-text"><strong>Click to upload</strong> or drag & drop</div>
                    <div class="upload-hint">JPG, PNG, WEBP — max 5MB</div>
                </div>
                <input type="file" id="img" name="img" accept="image/*" onchange="previewImage(event)">
            </div>
            <div class="field-hint"><i class="bi bi-info-circle"></i> Upload a new photo to replace existing.</div>
        </div>
        <div class="frow c4">
            <div class="field-grp"><label class="field-label">Last Name <span class="required-star">*</span></label><div class="input-icon-wrap"><i class="bi bi-person input-icon"></i><input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $speaker->last_name ?? '') }}" placeholder="Santos" required></div></div>
            <div class="field-grp"><label class="field-label">Given Name <span class="required-star">*</span></label><input type="text" class="form-control" id="given_name" name="given_name" value="{{ old('given_name', $speaker->given_name ?? '') }}" placeholder="Maria" required></div>
            <div class="field-grp"><label class="field-label">Middle Name</label><input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name', $speaker->middle_name ?? '') }}" placeholder="Cruz"></div>
            <div class="field-grp"><label class="field-label">Extension</label><input type="text" class="form-control" id="ext_name" name="ext_name" value="{{ old('ext_name', $speaker->ext_name ?? '') }}" placeholder="Jr., Sr., III"></div>
        </div>
        <div class="frow c4">
            <div class="field-grp"><label class="field-label">Date of Birth</label><input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $speaker->date_of_birth ?? '') }}"></div>
            <div class="field-grp"><label class="field-label">Place of Birth</label><input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', $speaker->place_of_birth ?? '') }}" placeholder="City / Municipality"></div>
            <div class="field-grp"><label class="field-label">Age</label><input type="number" class="form-control" id="age" name="age" min="1" max="150" value="{{ old('age', $speaker->age ?? '') }}" placeholder="0"></div>
            <div class="field-grp"><label class="field-label">Email</label><div class="input-icon-wrap"><i class="bi bi-envelope input-icon"></i><input type="email" class="form-control" id="email" name="email" value="{{ old('email', $speaker->email ?? '') }}" placeholder="email@example.com"></div></div>
        </div>
        <div class="frow c2">
            <div class="field-grp"><label class="field-label">Home Address</label><input type="text" class="form-control" id="home_address" name="home_address" value="{{ old('home_address', $speaker->home_address ?? '') }}" placeholder="Street / Purok"></div>
            <div class="field-grp"><label class="field-label">Building No</label><input type="text" class="form-control" id="home_building_no" name="home_building_no" value="{{ old('home_building_no', $speaker->home_building_no ?? '') }}" placeholder="#00"></div>
        </div>
        <div class="frow c4">
            <div class="field-grp"><label class="field-label">Barangay</label><input type="text" class="form-control" id="home_barangay" name="home_barangay" value="{{ old('home_barangay', $speaker->home_barangay ?? '') }}" placeholder="Barangay"></div>
            <div class="field-grp"><label class="field-label">Municipality</label><input type="text" class="form-control" id="home_municipality" name="home_municipality" value="{{ old('home_municipality', $speaker->home_municipality ?? '') }}" placeholder="Municipality / City"></div>
            <div class="field-grp"><label class="field-label">Province</label><input type="text" class="form-control" id="home_province" name="home_province" value="{{ old('home_province', $speaker->home_province ?? '') }}" placeholder="Province"></div>
            <div class="field-grp"><label class="field-label">Zip Code</label><input type="text" class="form-control" id="home_zip_code" name="home_zip_code" value="{{ old('home_zip_code', $speaker->home_zip_code ?? '') }}" placeholder="0000"></div>
        </div>
        <div class="frow c2">
            <div class="field-grp"><label class="field-label">Telephone No</label><input type="text" class="form-control" id="home_tel_no" name="home_tel_no" value="{{ old('home_tel_no', $speaker->home_tel_no ?? '') }}" placeholder="(074) XXX-XXXX"></div>
            <div class="field-grp"><label class="field-label">Cellphone No</label><input type="text" class="form-control" id="home_cell_no" name="home_cell_no" value="{{ old('home_cell_no', $speaker->home_cell_no ?? '') }}" placeholder="+63 9XX XXX XXXX"></div>
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
            @if(isset($speaker->expertises) && $speaker->expertises->count())
                @foreach($speaker->expertises as $index => $expertise)
                <div class="repeater-entry"><span class="entry-num">Entry #{{ $index + 1 }}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                    <div class="frow c1" style="max-width:500px;margin-top:10px;"><div class="field-grp"><label class="field-label">Expertise / Specialization</label><input type="text" class="form-control" name="expertis[]" value="{{ $expertise->expertis }}" placeholder="e.g. Data Science, Public Speaking"></div></div>
                </div>
                @endforeach
            @else
            <div class="repeater-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c1" style="max-width:500px;margin-top:10px;"><div class="field-grp"><label class="field-label">Expertise / Specialization</label><input type="text" class="form-control" name="expertis[]" placeholder="e.g. Data Science, Public Speaking"></div></div>
            </div>
            @endif
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
            <div class="field-grp"><label class="field-label">Organization / Agency</label><input type="text" class="form-control" name="office_organization" value="{{ old('office_organization', optional($speaker->office)->office_organization ?? '') }}" placeholder="Agency name"></div>
            <div class="field-grp"><label class="field-label">Position / Designation</label><input type="text" class="form-control" name="off_position" value="{{ old('off_position', optional($speaker->office)->position ?? '') }}" placeholder="e.g. Director"></div>
            <div class="field-grp"><label class="field-label">Office Address</label><input type="text" class="form-control" name="off_address" value="{{ old('off_address', optional($speaker->office)->address ?? '') }}" placeholder="Street"></div>
            <div class="field-grp"><label class="field-label">Building No</label><input type="text" class="form-control" name="off_building_no" value="{{ old('off_building_no', optional($speaker->office)->building_no ?? '') }}" placeholder="#00"></div>
        </div>
        <div class="frow c4">
            <div class="field-grp"><label class="field-label">Barangay</label><input type="text" class="form-control" name="off_barangay" value="{{ old('off_barangay', optional($speaker->office)->barangay ?? '') }}" placeholder="Barangay"></div>
            <div class="field-grp"><label class="field-label">Municipality</label><input type="text" class="form-control" name="off_municipality" value="{{ old('off_municipality', optional($speaker->office)->municipality ?? '') }}" placeholder="Municipality"></div>
            <div class="field-grp"><label class="field-label">Province</label><input type="text" class="form-control" name="off_province" value="{{ old('off_province', optional($speaker->office)->province ?? '') }}" placeholder="Province"></div>
            <div class="field-grp"><label class="field-label">Zip Code</label><input type="text" class="form-control" name="off_zip_code" value="{{ old('off_zip_code', optional($speaker->office)->zip_code ?? '') }}" placeholder="0000"></div>
        </div>
        <div class="frow c3">
            <div class="field-grp"><label class="field-label">Telephone No</label><input type="text" class="form-control" name="off_tel_no" value="{{ old('off_tel_no', optional($speaker->office)->tel_no ?? '') }}" placeholder="(074) XXX-XXXX"></div>
            <div class="field-grp"><label class="field-label">Cellphone No</label><input type="text" class="form-control" name="off_cell_no" value="{{ old('off_cell_no', optional($speaker->office)->cell_no ?? '') }}" placeholder="+63 9XX XXX XXXX"></div>
            <div class="field-grp"><label class="field-label">Fax No</label><input type="text" class="form-control" name="off_fax_no" value="{{ old('off_fax_no', optional($speaker->office)->fax_no ?? '') }}" placeholder="Fax number"></div>
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
            @if($speaker->educationalBackground->count())
                @foreach($speaker->educationalBackground as $index => $education)
                <div class="repeater-entry"><span class="entry-num">Entry #{{ $index + 1 }}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                    <div class="frow c3" style="margin-top:10px;">
                        <div class="field-grp"><label class="field-label">Level</label><input type="text" class="form-control" name="level[]" value="{{ $education->level }}" placeholder="e.g. College, Post-grad"></div>
                        <div class="field-grp"><label class="field-label">School / University</label><input type="text" class="form-control" name="school[]" value="{{ $education->school }}" placeholder="School name"></div>
                        <div class="field-grp"><label class="field-label">Year Graduated</label><input type="text" class="form-control" name="year_graduated[]" value="{{ $education->year_graduated }}" placeholder="YYYY"></div>
                    </div>
                    <div class="frow c3">
                        <div class="field-grp"><label class="field-label">From Year</label><input type="text" class="form-control" name="from_year[]" value="{{ $education->from_year }}" placeholder="YYYY"></div>
                        <div class="field-grp"><label class="field-label">To Year</label><input type="text" class="form-control" name="to_year[]" value="{{ $education->to_year }}" placeholder="YYYY"></div>
                        <div class="field-grp"><label class="field-label">Honors / Awards</label><input type="text" class="form-control" name="awards[]" value="{{ $education->awards }}" placeholder="e.g. Cum Laude"></div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="repeater-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c3" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Level</label><input type="text" class="form-control" name="level[]" placeholder="e.g. College, Post-grad"></div>
                    <div class="field-grp"><label class="field-label">School / University</label><input type="text" class="form-control" name="school[]" placeholder="School name"></div>
                    <div class="field-grp"><label class="field-label">Year Graduated</label><input type="text" class="form-control" name="year_graduated[]" placeholder="YYYY"></div>
                </div>
                <div class="frow c3">
                    <div class="field-grp"><label class="field-label">From Year</label><input type="text" class="form-control" name="from_year[]" placeholder="YYYY"></div>
                    <div class="field-grp"><label class="field-label">To Year</label><input type="text" class="form-control" name="to_year[]" placeholder="YYYY"></div>
                    <div class="field-grp"><label class="field-label">Honors / Awards</label><input type="text" class="form-control" name="awards[]" placeholder="e.g. Cum Laude"></div>
                </div>
            </div>
            @endif
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
            @if($speaker->workExperiences->count())
                @foreach($speaker->workExperiences as $index => $experience)
                <div class="repeater-entry"><span class="entry-num">Entry #{{ $index + 1 }}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                    <div class="frow c3" style="margin-top:10px;">
                        <div class="field-grp"><label class="field-label">Company / Agency</label><input type="text" class="form-control" name="work_name_company[]" value="{{ $experience->name_company }}" placeholder="Company name"></div>
                        <div class="field-grp"><label class="field-label">Position</label><input type="text" class="form-control" name="work_position[]" value="{{ $experience->position }}" placeholder="Job title"></div>
                        <div class="field-grp"><label class="field-label">Division / Dept</label><input type="text" class="form-control" name="work_division[]" value="{{ $experience->division }}" placeholder="Department"></div>
                    </div>
                    <div class="frow c3">
                        <div class="field-grp"><label class="field-label">Date Started</label><input type="date" class="form-control" name="work_date_started[]" value="{{ $experience->date_started }}"></div>
                        <div class="field-grp"><label class="field-label">Date Ended</label><input type="date" class="form-control" name="work_date_ended[]" value="{{ $experience->date_ended }}"></div>
                        <div class="field-grp"><label class="field-label">Address</label><input type="text" class="form-control" name="work_address[]" value="{{ $experience->address }}" placeholder="Company address"></div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="repeater-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c3" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Company / Agency</label><input type="text" class="form-control" name="work_name_company[]" placeholder="Company name"></div>
                    <div class="field-grp"><label class="field-label">Position</label><input type="text" class="form-control" name="work_position[]" placeholder="Job title"></div>
                    <div class="field-grp"><label class="field-label">Division / Dept</label><input type="text" class="form-control" name="work_division[]" placeholder="Department"></div>
                </div>
                <div class="frow c3">
                    <div class="field-grp"><label class="field-label">Date Started</label><input type="date" class="form-control" name="work_date_started[]"></div>
                    <div class="field-grp"><label class="field-label">Date Ended</label><input type="date" class="form-control" name="work_date_ended[]"></div>
                    <div class="field-grp"><label class="field-label">Address</label><input type="text" class="form-control" name="work_address[]" placeholder="Company address"></div>
                </div>
            </div>
            @endif
        </div>
        <button type="button" class="btn-add" id="addMoreWorkExperience"><i class="bi bi-plus-lg"></i> Add Another Work Experience</button>
    </div>
</div>

{{-- 6. TRAININGS — uses rt_title[] to save into trainings() --}}
<div class="section-card" data-section="6" data-keywords="training seminar attended hours venue date">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-journal-text"></i></div>
        <div class="section-title-grp"><p class="section-title">Trainings / Seminars Attended</p><p class="section-desc">Relevant training and seminar participation</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div id="training-container">
            @if(!empty($speaker->trainings) && $speaker->trainings->count())
                @foreach($speaker->trainings as $index => $training)
                <div class="repeater-entry"><span class="entry-num">Entry #{{ $index + 1 }}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                    <div class="frow c4" style="margin-top:10px;">
                        <div class="field-grp"><label class="field-label">Training Title</label><input type="text" class="form-control" name="rt_title[]" value="{{ $training->rt_title }}" placeholder="Training name"></div>
                        <div class="field-grp"><label class="field-label">Venue</label><input type="text" class="form-control" name="rt_venue[]" value="{{ $training->rt_venue }}" placeholder="Location"></div>
                        <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control" name="rt_date[]" value="{{ $training->rt_date }}"></div>
                        <div class="field-grp"><label class="field-label">No. of Hours</label><input type="number" class="form-control" name="rt_no_hours[]" value="{{ $training->rt_no_hours }}" placeholder="0" min="0"></div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="repeater-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c4" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Training Title</label><input type="text" class="form-control" name="rt_title[]" placeholder="Training name"></div>
                    <div class="field-grp"><label class="field-label">Venue</label><input type="text" class="form-control" name="rt_venue[]" placeholder="Location"></div>
                    <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control" name="rt_date[]"></div>
                    <div class="field-grp"><label class="field-label">No. of Hours</label><input type="number" class="form-control" name="rt_no_hours[]" placeholder="0" min="0"></div>
                </div>
            </div>
            @endif
        </div>
        <button type="button" class="btn-add" id="addMoreTraining"><i class="bi bi-plus-lg"></i> Add Another Training</button>
    </div>
</div>

{{-- 7. TRAINER EXPERIENCE — uses rst_title[] to save into experienceTrainer() --}}
<div class="section-card" data-section="7" data-keywords="trainer resource speaker experience facilitated conducted">
    <div class="section-header" onclick="toggleSection(this)">
        <div class="section-icon"><i class="bi bi-people"></i></div>
        <div class="section-title-grp"><p class="section-title">Experience as Trainer / Resource Speaker</p><p class="section-desc">Trainings conducted or facilitated</p></div>
        <div class="section-meta"><span class="section-filled-badge"><i class="bi bi-check2"></i> Filled</span><div class="section-toggle"><i class="bi bi-chevron-down"></i></div></div>
    </div>
    <div class="section-body">
        <div id="trainerExperienceRepeater">
            @if(!empty($speaker->experienceTrainer) && $speaker->experienceTrainer->count())
                @foreach($speaker->experienceTrainer as $index => $exper)
                <div class="repeater-entry"><span class="entry-num">Entry #{{ $index + 1 }}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                    <div class="frow c4" style="margin-top:10px;">
                        <div class="field-grp"><label class="field-label">Training Title</label><input type="text" class="form-control" name="rst_title[]" value="{{ $exper->rst_title }}" placeholder="Training name"></div>
                        <div class="field-grp"><label class="field-label">Venue</label><input type="text" class="form-control" name="rst_venue[]" value="{{ $exper->rst_venue }}" placeholder="Location"></div>
                        <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control" name="rst_date[]" value="{{ $exper->rst_date }}"></div>
                        <div class="field-grp"><label class="field-label">No. of Hours</label><input type="number" class="form-control" name="rst_no_hours[]" value="{{ $exper->rst_no_hours }}" placeholder="0" min="0"></div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="repeater-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c4" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Training Title</label><input type="text" class="form-control" name="rst_title[]" placeholder="Training name"></div>
                    <div class="field-grp"><label class="field-label">Venue</label><input type="text" class="form-control" name="rst_venue[]" placeholder="Location"></div>
                    <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control" name="rst_date[]"></div>
                    <div class="field-grp"><label class="field-label">No. of Hours</label><input type="number" class="form-control" name="rst_no_hours[]" placeholder="0" min="0"></div>
                </div>
            </div>
            @endif
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
            @if(!empty($speaker->publications) && $speaker->publications->count())
                @foreach($speaker->publications as $index => $publication)
                <div class="repeater-entry"><span class="entry-num">Entry #{{ $index + 1 }}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                    <div class="frow c4" style="margin-top:10px;">
                        <div class="field-grp"><label class="field-label">Publication Title</label><input type="text" class="form-control" name="publication_title[]" value="{{ $publication->p_title }}" placeholder="Title"></div>
                        <div class="field-grp"><label class="field-label">Nature</label><input type="text" class="form-control" name="p_nature[]" value="{{ $publication->p_nature }}" placeholder="e.g. Journal, Book"></div>
                        <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control" name="p_date[]" value="{{ $publication->p_date }}"></div>
                        <div class="field-grp"><label class="field-label">Publisher / Venue</label><input type="text" class="form-control" name="p_venue[]" value="{{ $publication->p_venue }}" placeholder="Publisher name"></div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="repeater-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c4" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Publication Title</label><input type="text" class="form-control" name="publication_title[]" placeholder="Title"></div>
                    <div class="field-grp"><label class="field-label">Nature</label><input type="text" class="form-control" name="p_nature[]" placeholder="e.g. Journal, Book"></div>
                    <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control" name="p_date[]"></div>
                    <div class="field-grp"><label class="field-label">Publisher / Venue</label><input type="text" class="form-control" name="p_venue[]" placeholder="Publisher name"></div>
                </div>
            </div>
            @endif
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
            @if(isset($speaker) && $speaker->referencesTrainings->count())
                @foreach($speaker->referencesTrainings as $index => $ref)
                <div class="repeater-entry"><span class="entry-num">Entry #{{ $index + 1 }}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                    <div class="frow c4" style="margin-top:10px;">
                        <div class="field-grp"><label class="field-label">Agency Name</label><input type="text" class="form-control" name="name_agency[]" value="{{ $ref->name_agency }}" placeholder="Agency"></div>
                        <div class="field-grp"><label class="field-label">Address</label><input type="text" class="form-control" name="ref_address[]" value="{{ $ref->address }}" placeholder="Address"></div>
                        <div class="field-grp"><label class="field-label">Contact Person</label><input type="text" class="form-control" name="contact_person[]" value="{{ $ref->contact_person }}" placeholder="Full name"></div>
                        <div class="field-grp"><label class="field-label">Position</label><input type="text" class="form-control" name="ref_position[]" value="{{ $ref->position }}" placeholder="Position"></div>
                    </div>
                    <div class="frow c3">
                        <div class="field-grp"><label class="field-label">Telephone No</label><input type="text" class="form-control" name="ref_tel_no[]" value="{{ $ref->tel_no }}" placeholder="Tel number"></div>
                        <div class="field-grp"><label class="field-label">Cellphone No</label><input type="text" class="form-control" name="ref_cell_no[]" value="{{ $ref->cell_no }}" placeholder="Cell number"></div>
                        <div class="field-grp"><label class="field-label">Fax No</label><input type="text" class="form-control" name="ref_fax_no[]" value="{{ $ref->fax_no }}" placeholder="Fax number"></div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="repeater-entry"><span class="entry-num">Entry #1</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
                <div class="frow c4" style="margin-top:10px;">
                    <div class="field-grp"><label class="field-label">Agency Name</label><input type="text" class="form-control" name="name_agency[]" placeholder="Agency"></div>
                    <div class="field-grp"><label class="field-label">Address</label><input type="text" class="form-control" name="ref_address[]" placeholder="Address"></div>
                    <div class="field-grp"><label class="field-label">Contact Person</label><input type="text" class="form-control" name="contact_person[]" placeholder="Full name"></div>
                    <div class="field-grp"><label class="field-label">Position</label><input type="text" class="form-control" name="ref_position[]" placeholder="Position"></div>
                </div>
                <div class="frow c3">
                    <div class="field-grp"><label class="field-label">Telephone No</label><input type="text" class="form-control" name="ref_tel_no[]" placeholder="Tel number"></div>
                    <div class="field-grp"><label class="field-label">Cellphone No</label><input type="text" class="form-control" name="ref_cell_no[]" placeholder="Cell number"></div>
                    <div class="field-grp"><label class="field-label">Fax No</label><input type="text" class="form-control" name="ref_fax_no[]" placeholder="Fax number"></div>
                </div>
            </div>
            @endif
        </div>
        <button type="button" class="btn-add" id="addMoreReferences"><i class="bi bi-plus-lg"></i> Add Another Reference</button>
    </div>
</div>

{{-- SUBMIT BAR --}}
<div class="submit-bar">
    <div class="submit-note">
        <i class="bi bi-shield-check" style="color:var(--success);font-size:15px;"></i>
        Changes will be saved to the database.
    </div>
    <button type="submit" class="btn-submit">
        <div class="btn-icon"><i class="bi bi-save"></i></div>
        Update Speaker
    </button>
</div>

</form>
</div>

<script>
window.toggleSection = h => { h.closest('.section-card').classList.toggle('open'); };
window.expandAll = () => { document.querySelectorAll('.section-card').forEach(c=>c.classList.add('open')); };
window.collapseAll = () => { document.querySelectorAll('.section-card').forEach(c=>c.classList.remove('open')); };

document.getElementById('sectionSearch').addEventListener('input', function() {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('.section-card').forEach(card => {
        const kw = (card.dataset.keywords||'') + ' ' + card.querySelector('.section-title').textContent.toLowerCase();
        const match = !q || kw.includes(q);
        card.style.display = match ? '' : 'none';
        if (match && q) card.classList.add('open');
    });
});

window.previewImage = function(e) {
    const file = e.target.files[0]; if (!file) return;
    const r = new FileReader();
    r.onload = ev => { const p=document.getElementById('imagePreview'); p.src=ev.target.result; p.style.display='block'; document.getElementById('uploadPlaceholder').style.display='none'; };
    r.readAsDataURL(file);
};

// Expertise
let expertiseCount = document.querySelectorAll('#expertise-container .repeater-entry').length;
document.getElementById('addMoreExpertise').addEventListener('click', function() {
    expertiseCount++;
    const div = document.createElement('div');
    div.className = 'repeater-entry';
    div.innerHTML = `<span class="entry-num">Entry #${expertiseCount}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
        <div class="frow c1" style="max-width:500px;margin-top:10px;"><div class="field-grp"><label class="field-label">Expertise / Specialization</label><input type="text" class="form-control" name="expertis[]" placeholder="e.g. Data Science, Public Speaking"></div></div>`;
    document.getElementById('expertise-container').appendChild(div);
});
document.getElementById('expertise-container').addEventListener('click', e => { if(e.target.classList.contains('remove-entry')) e.target.closest('.repeater-entry').remove(); });

// Education
let eduCount = document.querySelectorAll('#education-container .repeater-entry').length;
document.getElementById('addMoreEducation').addEventListener('click', function() {
    eduCount++;
    const div = document.createElement('div');
    div.className = 'repeater-entry';
    div.innerHTML = `<span class="entry-num">Entry #${eduCount}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
        <div class="frow c3" style="margin-top:10px;">
            <div class="field-grp"><label class="field-label">Level</label><input type="text" class="form-control" name="level[]" placeholder="e.g. College, Post-grad"></div>
            <div class="field-grp"><label class="field-label">School / University</label><input type="text" class="form-control" name="school[]" placeholder="School name"></div>
            <div class="field-grp"><label class="field-label">Year Graduated</label><input type="text" class="form-control" name="year_graduated[]" placeholder="YYYY"></div>
        </div>
        <div class="frow c3">
            <div class="field-grp"><label class="field-label">From Year</label><input type="text" class="form-control" name="from_year[]" placeholder="YYYY"></div>
            <div class="field-grp"><label class="field-label">To Year</label><input type="text" class="form-control" name="to_year[]" placeholder="YYYY"></div>
            <div class="field-grp"><label class="field-label">Honors / Awards</label><input type="text" class="form-control" name="awards[]" placeholder="e.g. Cum Laude"></div>
        </div>`;
    document.getElementById('education-container').appendChild(div);
});
document.getElementById('education-container').addEventListener('click', e => { if(e.target.classList.contains('remove-entry')) e.target.closest('.repeater-entry').remove(); });

// Work Experience
let workCount = document.querySelectorAll('#work-experience-container .repeater-entry').length;
document.getElementById('addMoreWorkExperience').addEventListener('click', function() {
    workCount++;
    const div = document.createElement('div');
    div.className = 'repeater-entry';
    div.innerHTML = `<span class="entry-num">Entry #${workCount}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
        <div class="frow c3" style="margin-top:10px;">
            <div class="field-grp"><label class="field-label">Company / Agency</label><input type="text" class="form-control" name="work_name_company[]" placeholder="Company name"></div>
            <div class="field-grp"><label class="field-label">Position</label><input type="text" class="form-control" name="work_position[]" placeholder="Job title"></div>
            <div class="field-grp"><label class="field-label">Division / Dept</label><input type="text" class="form-control" name="work_division[]" placeholder="Department"></div>
        </div>
        <div class="frow c3">
            <div class="field-grp"><label class="field-label">Date Started</label><input type="date" class="form-control" name="work_date_started[]"></div>
            <div class="field-grp"><label class="field-label">Date Ended</label><input type="date" class="form-control" name="work_date_ended[]"></div>
            <div class="field-grp"><label class="field-label">Address</label><input type="text" class="form-control" name="work_address[]" placeholder="Company address"></div>
        </div>`;
    document.getElementById('work-experience-container').appendChild(div);
});
document.getElementById('work-experience-container').addEventListener('click', e => { if(e.target.classList.contains('remove-entry')) e.target.closest('.repeater-entry').remove(); });

// Training
let trainCount = document.querySelectorAll('#training-container .repeater-entry').length;
document.getElementById('addMoreTraining').addEventListener('click', function() {
    trainCount++;
    const div = document.createElement('div');
    div.className = 'repeater-entry';
    div.innerHTML = `<span class="entry-num">Entry #${trainCount}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
        <div class="frow c4" style="margin-top:10px;">
            <div class="field-grp"><label class="field-label">Training Title</label><input type="text" class="form-control" name="rst_title[]" placeholder="Training name"></div>
            <div class="field-grp"><label class="field-label">Venue</label><input type="text" class="form-control" name="rst_venue[]" placeholder="Location"></div>
            <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control" name="rst_date[]"></div>
            <div class="field-grp"><label class="field-label">No. of Hours</label><input type="number" class="form-control" name="rst_no_hours[]" placeholder="0" min="0"></div>
        </div>`;
    document.getElementById('training-container').appendChild(div);
});
document.getElementById('training-container').addEventListener('click', e => { if(e.target.classList.contains('remove-entry')) e.target.closest('.repeater-entry').remove(); });

// Trainer Experience
let trainerCount = document.querySelectorAll('#trainerExperienceRepeater .repeater-entry').length;
document.getElementById('addTrainerExperience').addEventListener('click', function() {
    trainerCount++;
    const div = document.createElement('div');
    div.className = 'repeater-entry';
    div.innerHTML = `<span class="entry-num">Entry #${trainerCount}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
        <div class="frow c4" style="margin-top:10px;">
            <div class="field-grp"><label class="field-label">Training Title</label><input type="text" class="form-control" name="rt_title[]" placeholder="Training name"></div>
            <div class="field-grp"><label class="field-label">Venue</label><input type="text" class="form-control" name="rt_venue[]" placeholder="Location"></div>
            <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control" name="rt_date[]"></div>
            <div class="field-grp"><label class="field-label">No. of Hours</label><input type="number" class="form-control" name="rt_no_hours[]" placeholder="0" min="0"></div>
        </div>`;
    document.getElementById('trainerExperienceRepeater').appendChild(div);
});
document.getElementById('trainerExperienceRepeater').addEventListener('click', e => { if(e.target.classList.contains('remove-entry')) e.target.closest('.repeater-entry').remove(); });

// Publications
let pubCount = document.querySelectorAll('#publication-container .repeater-entry').length;
document.getElementById('addMorePublication').addEventListener('click', function() {
    pubCount++;
    const div = document.createElement('div');
    div.className = 'repeater-entry';
    div.innerHTML = `<span class="entry-num">Entry #${pubCount}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
        <div class="frow c4" style="margin-top:10px;">
            <div class="field-grp"><label class="field-label">Publication Title</label><input type="text" class="form-control" name="publication_title[]" placeholder="Title"></div>
            <div class="field-grp"><label class="field-label">Nature</label><input type="text" class="form-control" name="p_nature[]" placeholder="e.g. Journal, Book"></div>
            <div class="field-grp"><label class="field-label">Date</label><input type="date" class="form-control" name="p_date[]"></div>
            <div class="field-grp"><label class="field-label">Publisher / Venue</label><input type="text" class="form-control" name="p_venue[]" placeholder="Publisher name"></div>
        </div>`;
    document.getElementById('publication-container').appendChild(div);
});
document.getElementById('publication-container').addEventListener('click', e => { if(e.target.classList.contains('remove-entry')) e.target.closest('.repeater-entry').remove(); });

// References
let refCount = document.querySelectorAll('#references-container .repeater-entry').length;
document.getElementById('addMoreReferences').addEventListener('click', function() {
    refCount++;
    const div = document.createElement('div');
    div.className = 'repeater-entry';
    div.innerHTML = `<span class="entry-num">Entry #${refCount}</span><button type="button" class="btn-remove remove-entry">✕ Remove</button>
        <div class="frow c4" style="margin-top:10px;">
            <div class="field-grp"><label class="field-label">Agency Name</label><input type="text" class="form-control" name="name_agency[]" placeholder="Agency"></div>
            <div class="field-grp"><label class="field-label">Address</label><input type="text" class="form-control" name="ref_address[]" placeholder="Address"></div>
            <div class="field-grp"><label class="field-label">Contact Person</label><input type="text" class="form-control" name="contact_person[]" placeholder="Full name"></div>
            <div class="field-grp"><label class="field-label">Position</label><input type="text" class="form-control" name="ref_position[]" placeholder="Position"></div>
        </div>
        <div class="frow c3">
            <div class="field-grp"><label class="field-label">Telephone No</label><input type="text" class="form-control" name="ref_tel_no[]" placeholder="Tel number"></div>
            <div class="field-grp"><label class="field-label">Cellphone No</label><input type="text" class="form-control" name="ref_cell_no[]" placeholder="Cell number"></div>
            <div class="field-grp"><label class="field-label">Fax No</label><input type="text" class="form-control" name="ref_fax_no[]" placeholder="Fax number"></div>
        </div>`;
    document.getElementById('references-container').appendChild(div);
});
document.getElementById('references-container').addEventListener('click', e => { if(e.target.classList.contains('remove-entry')) e.target.closest('.repeater-entry').remove(); });
</script>

@endsection
