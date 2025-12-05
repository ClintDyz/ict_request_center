@extends('layouts.admin')

@section('content')
<style>
            /* Pagination Style */
.pagination-container {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-top: 15px;
    gap: 15px;
}

.pagination {
    display: flex;
    gap: 5px;
    align-items: center;
}

.pagination button {
    padding: 6px 12px;
    border: 1px solid #dee2e6;
    background: white;
    color: #0d6efd;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
    min-width: 38px;
}

.pagination button:hover:not(.disabled):not(.active) {
    background: #e7f1ff;
    border-color: #0d6efd;
}

.pagination button.active {
    background: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.pagination button.disabled {
    background: #e9ecef;
    color: #6c757d;
    cursor: not-allowed;
    border-color: #dee2e6;
}

.page-size-selector {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.page-size-selector select {
    padding: 6px 10px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.search-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.search-input-wrapper {
    margin-left: auto;
}
@media print {
    body * {
        visibility: hidden;
    }

    .printable-id-card,
    .printable-id-card * {
        visibility: visible;
    }

    .printable-id-card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .no-print {
        display: none !important;
    }

    .id-card-front,
    .id-card-back {
        page-break-after: always;
        margin: 0;
        box-shadow: none !important;
    }
}

#signatureCanvas {
    touch-action: none;
}
</style>

<!-- Content header -->
<div class="d-flex align-items-center mb-3">
    <h1 class="h3 mb-0 me-auto">ID Create</h1>
</div>

<!-- Card with table -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center bg-success text-white">
        <div><i class="fa fa-table me-2"></i>ID Create</div>
        <div class="small">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createZoomRequestModal">
                <i class="fa-solid fa-circle-plus me-1"></i> Create
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Search and Page Size Controls -->
        <div class="search-container">
            <div class="page-size-selector">
                <label for="pageSizeSelect">Show:</label>
                <select id="pageSizeSelect">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span>entries</span>
            </div>
            <div class="search-input-wrapper">
                <input type="text" id="searchInput" class="form-control" placeholder="Search..." style="width: 250px;">
            </div>
        </div>
        <div class="table-responsive">
            <table id="idRequestsTable" class="table table-striped table-bordered auto-paginate" style="width:100%">
                <thead>
                    <tr>
                        <th>Requested By</th>
                        <th>Position</th>
                        <th>Division/ Unit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($id_requests as $id_request)
                    <tr>
                        <td>{{ $id_request->f_name }} {{ $id_request->m_name }} {{ $id_request->l_name }}</td>
                        <td>{{ optional($id_request->position)->position }}</td>
                        <td>{{ optional($id_request->divisionUnit)->division_unit }}</td>
                        <td>{{ $id_request->status }}</td>
                        <td>
                            <!-- View button -->
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#viewIDCardBackModal-{{ $id_request->id }}">
                                <i class="fa fa-id-card me-1"></i> Small ID
                            </button>

                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewIDCardModal-{{ $id_request->id }}">
                                 <i class="fa fa-id-badge me-1"></i> Big ID</button>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateIDRequestModal-{{ $id_request->id }}">
                                 <i class="fa fa-edit me-1"></i> Edit</button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteIDRequestModal-{{ $id_request->id }}">
                                <i class="fa fa-trash me-1"></i> Delete</button>
                        </td>
                    </tr>
@endforeach
</tbody>
</table>
</div>

        <!-- Pagination Container -->
        <div class="pagination-container">
            <div class="pagination" id="pagination"></div>
        </div>
    </div>
</div>

@foreach($id_requests as $id_request)
<!-- Update Modal -->
<div class="modal fade" id="updateIDRequestModal-{{ $id_request->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('id_request.update', $id_request->id) }}" method="POST" enctype="multipart/form-data" id="updateIDForm-{{ $id_request->id }}">
                @csrf
                @method('PUT')

                <!-- Modal Header -->
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>Update ID Request
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" style="background-color: #f8f9fa;">

                    <!-- Photos Section -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="bi bi-camera-fill me-2" style="color: #667eea;"></i>Images
                            </h6>

                            <div class="row">
                                <!-- Employee Photo -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Employee Photo</label>
                                    <input type="file" class="form-control mb-2" name="image" accept="image/*" id="image-update-{{ $id_request->id }}">
                                    <small class="text-muted">Recommended: 3x2 photo, white background, max 5MB</small>
                                    @if($id_request->image)
                                        <div class="mt-2">
                                            <p class="small text-muted mb-1">Current Photo:</p>
                                            <img src="{{ asset('storage/' . $id_request->image) }}" alt="Current Photo" class="img-thumbnail" style="max-width: 150px;">
                                        </div>
                                    @endif
                                    <div id="imagePreview-update-{{ $id_request->id }}" class="mt-2" style="display: none;">
                                        <p class="small text-muted mb-1">New Photo Preview:</p>
                                        <img id="imagePreviewImg-update-{{ $id_request->id }}" src="" alt="Preview" class="img-thumbnail" style="max-width: 150px;">
                                    </div>
                                </div>

                                <!-- Signature Pad -->
                                {{-- <div class="col-md-6">
                                    <label class="form-label fw-semibold">Signature</label>

                                    @if($id_request->signature_path)
                                        <div class="mb-2">
                                            <p class="small text-muted mb-1">Current Signature:</p>
                                            <img src="{{ asset('storage/' . $id_request->signature_path) }}" alt="Current Signature" class="img-thumbnail" style="max-width: 200px; background: #f0f0f0;">
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary mb-2" id="showSignaturePad-{{ $id_request->id }}">
                                            <i class="fa fa-signature me-1"></i> Update Signature
                                        </button>
                                    @endif

                                    <div id="signaturePadContainer-{{ $id_request->id }}" style="display: {{ $id_request->signature_path ? 'none' : 'block' }};">
                                        <div class="card border">
                                            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                                <span class="small text-muted">Draw your signature below</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger" id="clearSignature-update-{{ $id_request->id }}">
                                                    <i class="fa fa-eraser me-1"></i> CLEAR
                                                </button>
                                            </div>
                                            <div class="card-body p-0">
                                                <canvas id="signatureCanvas-update-{{ $id_request->id }}" style="width: 100%; height: 200px; border: 2px dashed #ddd; cursor: crosshair; display: block;"></canvas>
                                            </div>
                                        </div>
                                        <small class="text-muted d-block mt-1">Sign using your mouse or touch screen</small>
                                    </div>
                                    <input type="hidden" name="signature_path" id="signatureData-update-{{ $id_request->id }}">
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="bi bi-person-fill me-2" style="color: #667eea;"></i>Personal Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="f_name" value="{{ $id_request->f_name }}" placeholder="Juan" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="l_name" value="{{ $id_request->l_name }}" placeholder="Dela Cruz" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Middle Name</label>
                                    <input type="text" class="form-control" name="m_name" value="{{ $id_request->m_name }}" placeholder="Santos">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Nick Name</label>
                                    <input type="text" class="form-control" name="nick_name" value="{{ $id_request->nick_name }}" placeholder="Jun">
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Birthdate <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="birthdate" value="{{ $id_request->birthdate }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Blood Type <span class="text-danger">*</span></label>
                                    <select class="form-select" name="blood_type" required>
                                        <option value="">Select Blood Type</option>
                                        <option value="A+" @if($id_request->blood_type == 'A+') selected @endif>A+</option>
                                        <option value="A-" @if($id_request->blood_type == 'A-') selected @endif>A-</option>
                                        <option value="B+" @if($id_request->blood_type == 'B+') selected @endif>B+</option>
                                        <option value="B-" @if($id_request->blood_type == 'B-') selected @endif>B-</option>
                                        <option value="O+" @if($id_request->blood_type == 'O+') selected @endif>O+</option>
                                        <option value="O-" @if($id_request->blood_type == 'O-') selected @endif>O-</option>
                                        <option value="AB+" @if($id_request->blood_type == 'AB+') selected @endif>AB+</option>
                                        <option value="AB-" @if($id_request->blood_type == 'AB-') selected @endif>AB-</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Position <span class="text-danger">*</span></label>
                                    <select class="form-select" name="id_position" required>
                                        <option value="">Select Position</option>
                                        @foreach($positions as $pos)
                                            <option value="{{ $pos->id }}" @if($id_request->id_position == $pos->id) selected @endif>{{ $pos->position }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Division Unit <span class="text-danger">*</span></label>
                                    <select class="form-select" name="id_division_unit" required>
                                        <option value="">Select Division Unit</option>
                                        @foreach($division_units as $unit)
                                            <option value="{{ $unit->id }}" @if($id_request->id_division_unit == $unit->id) selected @endif>{{ $unit->division_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Employment Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Permanent" @if($id_request->status == 'Permanent') selected @endif>Permanent</option>
                                        <option value="Contractual" @if($id_request->status == 'Contractual') selected @endif>Contractual</option>
                                        <option value="Intern" @if($id_request->status == 'Intern') selected @endif>Intern</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Valid Until</label>
                                    <input type="date" class="form-control" name="valid_until" value="{{ $id_request->valid_until ? date('Y-m-d', strtotime($id_request->valid_until)) : '' }}">
                                    <small class="text-muted">ID expiration date</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact Information Section -->
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="bi bi-telephone-fill me-2" style="color: #667eea;"></i>Emergency Contact Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Emergency Contact Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="emergency_contact_name" value="{{ $id_request->emergency_contact_name }}" placeholder="Full Name" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Emergency Contact Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="emergency_contact_address" value="{{ $id_request->emergency_contact_address }}" placeholder="Complete Address" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Emergency Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="emergency_contact_number" value="{{ $id_request->emergency_contact_number }}" placeholder="09XX-XXX-XXXX" required>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Close
                    </button>
                    <button type="submit" class="btn px-4 bg-warning text-white">
                         <i class="fa fa-edit me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Small ID Card Modal -->
<div class="modal fade" id="viewIDCardBackModal-{{ $id_request->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">ID Small Card Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row" id="printable-area-{{ $id_request->id }}">
                    <!-- FRONT SIDE -->
                    <div class="col-md-6">
                        <h6 class="text-center mb-2 no-print">Front Side</h6>
                        <div id="id-card-front-{{ $id_request->id }}" class="id-card-front" style="width: 100%; max-width: 500px; height: 315px; margin: 0 auto; background: url('{{ asset('img/front.jpg') }}') center/cover no-repeat; border-radius: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); position: relative;">

                            <!-- Photo -->
                            <div style="position: absolute; left: 20px; top: 110px; width: 140px; height: 165px; background: #f0f0f0; border: 2px solid #ddd; border-radius: 5px; overflow: hidden;">
                                @if($id_request->image)
                                    <img src="{{ asset('storage/' . $id_request->image) }}" alt="ID Photo" style="width: 100%; height: 100%; object-fit: cover;" crossorigin="anonymous">
                                @else
                                    <span style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc; font-size: 10px;">No Photo</span>
                                @endif
                            </div>

                            <!-- ID Number -->
                            @php
                                $firstInitial = strtoupper(substr($id_request->f_name, 0, 1));
                                $lastInitial = strtoupper(substr($id_request->l_name, 0, 1));
                                $birthDate = \Carbon\Carbon::parse($id_request->birthdate)->format('d');
                                $birthMonth = \Carbon\Carbon::parse($id_request->birthdate)->format('m');
                                $customId = $firstInitial . $lastInitial . '-' . $birthDate . $birthMonth;
                            @endphp
                            <div style="position: absolute; left: 70px; top: 272px; padding: 3px 18px; text-align: center; border-radius: 3px; font-size: 16px; font-weight: bold; color: #333;">
                                {{ $customId }}
                            </div>

                            {{-- Signature --}}
                             <div style="position: absolute; left: 95px; top: 83px; right: 20px; font-size: 16px; font-weight: bold; text-transform: uppercase; line-height: 1.2;">
                                @if($id_request->signature)
                                    <img src="{{ asset('storage/' . $id_request->signature) }}" alt="ID Photo" style="width: 100%; height: 100%; object-fit: cover;" crossorigin="anonymous">
                                @else
                                    <span style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc; font-size: 10px;"></span>
                                @endif
                            </div>

                            <!-- Name -->
                            <div style="position: absolute; left: 170px; top: 155px; right: 20px; font-size: 16px; font-weight: bold; color: #1e3c72; text-transform: uppercase; line-height: 1.2; text-shadow: 1px 1px 2px rgba(255,255,255,0.9);">
                                {{ $id_request->f_name }} {{ $id_request->m_name ? substr($id_request->m_name, 0, 1) . '.' : '' }} {{ $id_request->l_name }}
                            </div>

                            <!-- Position -->
                            <div style="position: absolute; left: 170px; top: 175px; right: 20px; font-size: 14px; color: #333; font-weight: 600; text-shadow: 1px 1px 2px rgba(255,255,255,0.9);">
                                {{ optional($id_request->position)->position }}
                            </div>

                            <!-- Division -->
                            <div style="position: absolute; left: 170px; top: 195px; right: 20px; font-size: 13px; color: #666; text-shadow: 1px 1px 2px rgba(255,255,255,0.9);">
                                {{ optional($id_request->divisionUnit)->division_unit }}
                            </div>

                            <!-- Date Issued -->
                            <div style="position: absolute; left: 180px; top: 250px; right: 20px; font-size: 15px; color: #333; text-shadow: 1px 1px 2px rgba(255,255,255,0.9);">
                                Date Issued: {{ \Carbon\Carbon::parse($id_request->created_at)->format('M d, Y') }}
                            </div>

                            <!-- Valid Until -->
                            <div style="position: absolute; left: 180px; top: 270px; right: 20px; font-size: 15px;text-shadow: 1px 1px 2px rgba(255,255,255,0.9);"">
                                Valid Until: {{ \Carbon\Carbon::parse($id_request->valid_until)->format('M d, Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- BACK SIDE -->
                    <div class="col-md-6">
                        <h6 class="text-center mb-2 no-print">Back Side</h6>
                        <div id="id-card-back-{{ $id_request->id }}" class="id-card-back" style="width: 100%; max-width: 500px; height: 315px; margin: 0 auto; background: url('{{ asset('img/back.jpg') }}') center/cover no-repeat; border-radius: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); position: relative;">

                            <!-- QR Code -->
                            <div style="position: absolute; right: 2px; top: 2px;">
                                @php
                                    $emergencyInfo = "Emergency Contact: " . $id_request->emergency_contact_name . " | " . $id_request->emergency_contact_address . " | " . $id_request->emergency_contact_number;
                                @endphp
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=85x85&data={{ urlencode($emergencyInfo) }}"
                                     alt="Emergency QR" style="width: 45px; height: 45px; border: 2px solid #ddd; border-radius: 5px; background: white;" crossorigin="anonymous">
                            </div>

                            <!-- Birthday -->
                            <div style="position: absolute; left: 90px; top: 224px; font-size: 12px; color: #333; text-shadow: 1px 1px 2px rgba(255,255,255,0.9);">
                                {{ \Carbon\Carbon::parse($id_request->birthdate)->format('M d, Y') }}
                            </div>

                            <!-- Address -->
                            <div style="position: absolute; left: 90px; top: 236px; right: 230px; font-size: 12px; color: #333; text-shadow: 1px 1px 2px rgba(255,255,255,0.9);">
                                {{ $id_request->emergency_contact_address }}
                            </div>

                            <!-- Blood Type -->
                            <div style="position: absolute; left: 105px; top: 247px; font-size: 12px; color: #333; text-shadow: 1px 1px 2px rgba(255,255,255,0.9);">
                                {{ $id_request->blood_type }}
                            </div>

                            <!-- Emergency Contact - Name -->
                            <div style="position: absolute; left: 70px; top: 273px; font-size: 12px; color: #333; text-shadow: 1px 1px 2px rgba(255,255,255,0.9);">
                                {{ $id_request->emergency_contact_name }}
                            </div>

                            <!-- Emergency Contact - Address -->
                            <div style="position: absolute; left: 85px; top: 283px; right: 20px; font-size: 12px; color: #333; text-shadow: 1px 1px 2px rgba(255,255,255,0.9);">
                                {{ $id_request->emergency_contact_address }}
                            </div>

                            <!-- Emergency Contact - Number -->
                            <div style="position: absolute; left: 108px; top: 295px; font-size: 12px; color: #333; text-shadow: 1px 1px 2px rgba(255,255,255,0.9);">
                                {{ $id_request->emergency_contact_number }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="mt-3 p-3 no-print" style="background: #f8f9fa; border-radius: 8px;">
                    <h6 class="mb-2">Employee Details</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <small><strong>Full Name:</strong> {{ $id_request->f_name }} {{ $id_request->m_name }} {{ $id_request->l_name }}</small>
                        </div>
                        <div class="col-md-4">
                            <small><strong>Nickname:</strong> {{ $id_request->nick_name }}</small>
                        </div>
                        <div class="col-md-4">
                            <small><strong>Employment Status:</strong> {{ $id_request->status }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer no-print">
                <button type="button" class="btn btn-success" onclick="downloadIDCard({{ $id_request->id }}, 'front')">
                    <i class="fa fa-download me-1"></i> Download Front
                </button>
                <button type="button" class="btn btn-info" onclick="downloadIDCard({{ $id_request->id }}, 'back')">
                    <i class="fa fa-download me-1"></i> Download Back
                </button>
                <button type="button" class="btn btn-warning" onclick="downloadBothIDCards({{ $id_request->id }})">
                    <i class="fa fa-download me-1"></i> Download Both
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteIDRequestModal-{{ $id_request->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('id_request.destroy', $id_request->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fa fa-trash me-2"></i>Delete ID Request</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fa fa-exclamation-triangle text-danger" style="font-size: 48px;"></i>
                    </div>
                    <p class="text-center">Are you sure you want to delete this ID request?</p>
                    <div class="alert alert-danger">
                        <strong>Employee:</strong> {{ $id_request->f_name }} {{ $id_request->l_name }}<br>
                        <strong>Position:</strong> {{ optional($id_request->position)->position }}<br>
                        <strong>Division:</strong> {{ optional($id_request->divisionUnit)->division_unit }}
                    </div>
                    <p class="text-muted small text-center">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash me-1"></i> Delete Permanently
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View BIG ID Card Modal -->
<div class="modal fade" id="viewIDCardModal-{{ $id_request->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">ID Card Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="id-card" style="width: 730px; height: 1068px; margin: 0 auto; background: url('{{ asset('img/ID_Format.jpg') }}') center/cover no-repeat; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); position: relative; overflow: hidden;">

                    <!-- QR Codes Section - Left Side -->
                    <div style="position: absolute; left: 25px; top: 160px; display: flex; flex-direction: column; gap: 15px;">
                        @php
                            $emergencyInfo = "In Case of Emergency\n";
                            $emergencyInfo .= "Name: " . $id_request->emergency_contact_name . "\n";
                            $emergencyInfo .= "Address: " . $id_request->emergency_contact_address . "\n";
                            $emergencyInfo .= "Contact Number: " . $id_request->emergency_contact_number;
                        @endphp

                        @for ($i = 0; $i < 3; $i++)
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($emergencyInfo) }}"
                                alt="Emergency QR Code {{ $i + 1 }}"
                                style="width: 150px; height: 150px; padding: 8px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                        @endfor
                    </div>

                    <!-- Photo Section - Center Right -->
                    <div style="position: absolute; right: 50px; top: 160px; text-align: center;">
                        <div style="width: 420px; height: 490px; background: white; border: 5px solid #001a33; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            @if($id_request->image)
                            <img src="{{ asset('storage/' . $id_request->image) }}" alt="ID Photo" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc; font-size: 24px;">
                                    No Photo
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Name Section -->
                    <div style="position: absolute; left: 40px; right: 40px; top: 650px; text-align: center;">
                        <div style="font-size: 35px; font-weight: 700; color: #001a33; text-transform: uppercase; letter-spacing: 2px; text-shadow: 2px 2px 4px rgba(255,255,255,0.9);">
                            {{ $id_request->l_name }}, {{ $id_request->f_name }} {{ $id_request->m_name ? substr($id_request->m_name, 0, 1) . '.' : '' }}
                        </div>
                    </div>

                    <!-- Nickname Badge -->
                    <div style="position: absolute; left: 40px; right: 40px; top: 640px; text-align: center; margin-top: 4px;">
                        <div style="padding: 25px 80px;">
                            <div style="font-size: 130px; font-weight: bold; letter-spacing: 5px; color: #001a33; text-shadow: 2px 2px 4px rgba(255,255,255,0.8);">
                                {{ strtoupper($id_request->nick_name ?? 'N/A') }}
                            </div>
                        </div>
                    </div>

                    <!-- Position and Division -->
                    <div style="position: absolute; left: 40px; right: 40px; top: 815px; text-align: center; margin-top: 4px;">
                        <div style="font-size: 35px; font-weight: 700; color: #001a33; margin-bottom: 5px; text-shadow: 2px 2px 4px rgba(255,255,255,0.9);">
                            {{ optional($id_request->position)->position }}
                        </div>
                    </div>
                    <div style="position: absolute; left: 40px; right: 40px; top: 860px; text-align: center; margin-top: 4px;">
                        <div style="font-size: 25px; font-weight: 600; color: #001a33; text-shadow: 2px 2px 4px rgba(255,255,255,0.9);">
                            {{ optional($id_request->divisionUnit)->division_unit }}
                        </div>
                    </div>
                </div>

                <!-- Additional Info Below Card -->
                <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 10px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 13px;">
                        <div><strong>Birthdate:</strong> {{ \Carbon\Carbon::parse($id_request->birthdate)->format('M d, Y') }}</div>
                        <div><strong>Blood Type:</strong> {{ $id_request->blood_type }}</div>
                        <div><strong>Status:</strong> {{ $id_request->status }}</div>
                        <div><strong>Emergency Contact:</strong> {{ $id_request->emergency_contact_name }}</div>
                        <div style="grid-column: 1 / -1;"><strong>Emergency Address:</strong> {{ $id_request->emergency_contact_address }}</div>
                        <div><strong>Emergency Number:</strong> {{ $id_request->emergency_contact_number }}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="downloadIDCardBtn-{{ $id_request->id }}">
                    <i class="fa fa-download me-1"></i> Download Image
                </button>
            </div>
        </div>
    </div>
</div>

@endforeach


<!-- Create Modal -->
<div class="modal fade" id="createZoomRequestModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('id_request.store') }}" method="POST" enctype="multipart/form-data" id="createIDForm">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="modal-title text-white"><i class="fa fa-plus-circle me-2"></i>Create ID Request</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <!-- Photos Section -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="fa fa-images me-2" style="color: #667eea;"></i>Upload Images
                            </h6>
                            <div class="row">
                                <!-- Employee Photo -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fa fa-camera me-2"></i>Employee Photo <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <label class="input-group-text">
                                            <i class="fa fa-upload me-2"></i>Choose File
                                        </label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                    </div>
                                    <small class="text-muted d-block mt-1">Recommended: 2x2 ID photo, white background, max 5MB</small>
                                    <!-- Preview -->
                                    <div id="imagePreview" class="mt-2" style="display: none;">
                                        <img id="imagePreviewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                    </div>
                                </div>

                                <!-- Signature Pad -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fa fa-signature me-2"></i>Signature <span class="text-danger">*</span>
                                    </label>
                                    <div class="card border">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                            <span class="small text-muted">Draw your signature below</span>
                                            <button type="button" class="btn btn-sm btn-outline-danger" id="clearSignature">
                                                <i class="fa fa-eraser me-1"></i> CLEAR
                                            </button>
                                        </div>
                                        <div class="card-body p-0">
                                            <canvas id="signatureCanvas" style="width: 100%; height: 200px; border: 2px dashed #ddd; cursor: crosshair; display: block;"></canvas>
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-1">Sign using your mouse or touch screen</small>
                                    <input type="hidden" name="signature" id="signatureData" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Personal Information Section -->
                    <h6 class="fw-bold mb-3"><i class="fa fa-user me-2"></i>Personal Information</h6>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="f_name" required placeholder="Juan">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="l_name" required placeholder="Dela Cruz">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="m_name" placeholder="Santos">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nick Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nick_name" placeholder="Jun" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Birthdate <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="birthdate" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Blood Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="blood_type" required>
                                <option value="">Select Blood Type</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Position <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_position" required>
                                <option value="">Select Position</option>
                                @foreach($positions as $pos)
                                    <option value="{{ $pos->id }}">{{ $pos->position }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Division Unit <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_division_unit" required>
                                <option value="">Select Division Unit</option>
                                @foreach($division_units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->division_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Employment Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Permanent">Permanent</option>
                                <option value="Contractual">Contractual</option>
                                <option value="Intern">Intern</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Valid Until <span class="text-danger">*</span> </label>
                            <input type="date" class="form-control" name="valid_until" value="{{ now()->addYear()->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}" required>
                            <small class="text-muted">Default: 1 year from today</small>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Emergency Contact Section -->
                    <h6 class="fw-bold mb-3"><i class="fa fa-phone me-2"></i>Emergency Contact Information</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Emergency Contact Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="emergency_contact_name" required placeholder="Full Name">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Emergency Contact Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="emergency_contact_address" required placeholder="Complete Address">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Emergency Contact Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="emergency_contact_number" required placeholder="09XX-XXX-XXXX">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i> Save ID Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Add html2canvas library (add this once in your layout file, before closing </body> tag) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


<script>
// Signature Pad Implementation Create
document.addEventListener('DOMContentLoaded', function() {
    // Wait for modal to be shown before initializing canvas
    const modal = document.getElementById('createZoomRequestModal');

    modal?.addEventListener('shown.bs.modal', function() {
        initializeSignaturePad();
    });

    function initializeSignaturePad() {
        const canvas = document.getElementById('signatureCanvas');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;

        // Set canvas size properly
        function resizeCanvas() {
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = 200; // Fixed height

            // Set drawing styles
            ctx.strokeStyle = '#000000';
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
        }

        resizeCanvas();

        // Get coordinates relative to canvas
        function getCoordinates(e) {
            const rect = canvas.getBoundingClientRect();
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;

            let clientX, clientY;

            if (e.touches && e.touches.length > 0) {
                clientX = e.touches[0].clientX;
                clientY = e.touches[0].clientY;
            } else {
                clientX = e.clientX;
                clientY = e.clientY;
            }

            return {
                x: (clientX - rect.left) * scaleX,
                y: (clientY - rect.top) * scaleY
            };
        }

        // Start drawing
        function startDrawing(e) {
            isDrawing = true;
            const coords = getCoordinates(e);
            lastX = coords.x;
            lastY = coords.y;

            // Draw a dot for single clicks
            ctx.beginPath();
            ctx.arc(coords.x, coords.y, 1, 0, Math.PI * 2);
            ctx.fill();

            e.preventDefault();
        }

        // Draw
        function draw(e) {
            if (!isDrawing) return;

            const coords = getCoordinates(e);

            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(coords.x, coords.y);
            ctx.stroke();

            lastX = coords.x;
            lastY = coords.y;

            e.preventDefault();
        }

        // Stop drawing
        function stopDrawing(e) {
            if (isDrawing) {
                isDrawing = false;
            }
        }

        // Mouse events
        canvas.addEventListener('mousedown', startDrawing, false);
        canvas.addEventListener('mousemove', draw, false);
        canvas.addEventListener('mouseup', stopDrawing, false);
        canvas.addEventListener('mouseleave', stopDrawing, false);

        // Touch events
        canvas.addEventListener('touchstart', startDrawing, false);
        canvas.addEventListener('touchmove', draw, false);
        canvas.addEventListener('touchend', stopDrawing, false);
        canvas.addEventListener('touchcancel', stopDrawing, false);

        // Clear button
        const clearBtn = document.getElementById('clearSignature');
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById('signatureData').value = '';
            });
        }

        // Form submission - convert canvas to base64
        const form = document.getElementById('createIDForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Check if signature is drawn
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = imageData.data;
                let hasDrawing = false;

                for (let i = 0; i < data.length; i += 4) {
                    if (data[i + 3] !== 0) { // Check alpha channel
                        hasDrawing = true;
                        break;
                    }
                }

                if (hasDrawing) {
                    // Convert canvas to PNG base64
                    const signatureDataURL = canvas.toDataURL('image/png');
                    document.getElementById('signatureData').value = signatureDataURL;
                }
            });
        }
    }
});

// Image Preview for Photo
document.getElementById('image')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreviewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});


//dat

document.addEventListener('DOMContentLoaded', function() {
    // Attach event listeners to all download buttons
    @foreach($id_requests as $id_request)
    const downloadBtn{{ $id_request->id }} = document.getElementById('downloadIDCardBtn-{{ $id_request->id }}');

    if (downloadBtn{{ $id_request->id }}) {
        downloadBtn{{ $id_request->id }}.addEventListener('click', function() {
            const modal = document.getElementById('viewIDCardModal-{{ $id_request->id }}');
            const idCardElement = modal.querySelector('.id-card');

            if (idCardElement) {
                downloadBtn{{ $id_request->id }}.disabled = true;
                downloadBtn{{ $id_request->id }}.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

                html2canvas(idCardElement, {
                    useCORS: true,
                    scale: 2
                }).then(function(canvas) {
                    const imageURL = canvas.toDataURL('image/png');
                    const a = document.createElement('a');
                    const fileName = '{{ $id_request->l_name }}_{{ $id_request->f_name }}_ID_Card'.replace(/[^a-z0-9]/gi, '_');

                    a.href = imageURL;
                    a.download = fileName + '.png';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);

                    downloadBtn{{ $id_request->id }}.disabled = false;
                    downloadBtn{{ $id_request->id }}.innerHTML = '<i class="fa fa-download me-1"></i> Download Image';
                }).catch(error => {
                    console.error('Error during html2canvas generation:', error);
                    alert('Could not generate the image. Check the console for errors.');
                    downloadBtn{{ $id_request->id }}.disabled = false;
                    downloadBtn{{ $id_request->id }}.innerHTML = '<i class="fa fa-download me-1"></i> Download Image';
                });
            }
        });
    }
    @endforeach
});

// DataTable

document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector("#idRequestsTable tbody");
    const rows = Array.from(table.querySelectorAll("tr"));
    const searchInput = document.getElementById("searchInput");
    const pageSizeSelect = document.getElementById("pageSizeSelect");
    const paginationContainer = document.getElementById("pagination");

    let currentPage = 1;
    let rowsPerPage = 10;

    function renderTable() {
        table.innerHTML = "";

        // Filter rows based on search
        let filteredRows = rows.filter(row =>
            row.textContent.toLowerCase().includes(searchInput.value.toLowerCase())
        );

        // Calculate pagination
        let totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        currentPage = Math.min(currentPage, totalPages) || 1;

        // Display rows for current page
        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        filteredRows.slice(start, end).forEach(row => table.appendChild(row));

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        paginationContainer.innerHTML = "";

        // Previous button
        let prevBtn = document.createElement("button");
        prevBtn.textContent = "‹";
        prevBtn.disabled = currentPage === 1;
        prevBtn.classList.toggle("disabled", currentPage === 1);
        prevBtn.onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        };
        paginationContainer.appendChild(prevBtn);

        // Page number buttons
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);

        // Show first page if not in range
        if (startPage > 1) {
            let firstBtn = createPageButton(1);
            paginationContainer.appendChild(firstBtn);

            if (startPage > 2) {
                let dots = document.createElement("button");
                dots.textContent = "...";
                dots.classList.add("disabled");
                dots.disabled = true;
                paginationContainer.appendChild(dots);
            }
        }

        // Page number buttons in range
        for (let i = startPage; i <= endPage; i++) {
            let pageBtn = createPageButton(i);
            paginationContainer.appendChild(pageBtn);
        }

        // Show last page if not in range
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                let dots = document.createElement("button");
                dots.textContent = "...";
                dots.classList.add("disabled");
                dots.disabled = true;
                paginationContainer.appendChild(dots);
            }

            let lastBtn = createPageButton(totalPages);
            paginationContainer.appendChild(lastBtn);
        }

        // Next button
        let nextBtn = document.createElement("button");
        nextBtn.textContent = "›";
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.classList.toggle("disabled", currentPage === totalPages);
        nextBtn.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        };
        paginationContainer.appendChild(nextBtn);
    }

    function createPageButton(pageNum) {
        let btn = document.createElement("button");
        btn.textContent = pageNum;
        btn.classList.toggle("active", pageNum === currentPage);
        btn.onclick = () => {
            currentPage = pageNum;
            renderTable();
        };
        return btn;
    }

    // Event listeners
    searchInput.addEventListener("input", () => {
        currentPage = 1;
        renderTable();
    });

    pageSizeSelect.addEventListener("change", () => {
        rowsPerPage = parseInt(pageSizeSelect.value);
        currentPage = 1;
        renderTable();
    });

    // Initial render
    renderTable();
});


// Small ID
// Improved Small ID Download Function - No Gray Background
function downloadIDCard(id, side) {
    const elementId = side === 'front' ? `id-card-front-${id}` : `id-card-back-${id}`;
    const element = document.getElementById(elementId);

    if (!element) {
        alert('ID card element not found!');
        return;
    }

    // Show loading indicator
    const loadingDiv = document.createElement('div');
    loadingDiv.innerHTML = '<div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.8); color: white; padding: 20px; border-radius: 10px; z-index: 10000;">Generating high-resolution image (2027x1276)...</div>';
    document.body.appendChild(loadingDiv);

    // Target dimensions
    const targetWidth = 2027;
    const targetHeight = 1276;

    // Get background image URL
    const bgStyle = window.getComputedStyle(element);
    const bgImage = bgStyle.backgroundImage;
    let bgUrl = bgImage.slice(5, -2); // Remove url(" and ")

    // Handle relative URLs
    if (!bgUrl.startsWith('http')) {
        bgUrl = window.location.origin + bgUrl;
    }

    console.log('Background URL:', bgUrl);

    // Calculate scale factor
    const originalWidth = element.offsetWidth;
    const originalHeight = element.offsetHeight;
    const scaleFactor = targetWidth / originalWidth;

    // Create final canvas
    const finalCanvas = document.createElement('canvas');
    finalCanvas.width = targetWidth;
    finalCanvas.height = targetHeight;
    const ctx = finalCanvas.getContext('2d');

    // Load background image
    const bgImg = new Image();
    bgImg.crossOrigin = 'anonymous';

    bgImg.onload = function() {
        // Draw background at full resolution
        ctx.drawImage(bgImg, 0, 0, targetWidth, targetHeight);

        // Get all text and image overlays
        const overlayElements = element.querySelectorAll('div, img, span, label');

        // Create promises for all images that need to be loaded
        const imagePromises = [];
        const imageElements = [];

        overlayElements.forEach(elem => {
            const img = elem.querySelector('img');
            if (img && img.src) {
                const promise = new Promise((resolve, reject) => {
                    const tempImg = new Image();
                    tempImg.crossOrigin = 'anonymous';
                    tempImg.onload = () => resolve({ img: tempImg, elem: img });
                    tempImg.onerror = () => resolve(null); // Continue even if image fails
                    tempImg.src = img.src;
                });
                imagePromises.push(promise);
            }
        });

        // Wait for all images to load
        Promise.all(imagePromises).then(loadedImages => {
            // Draw all overlay elements
            overlayElements.forEach(elem => {
                const rect = elem.getBoundingClientRect();
                const parentRect = element.getBoundingClientRect();

                // Calculate scaled position
                const x = (rect.left - parentRect.left) * scaleFactor;
                const y = (rect.top - parentRect.top) * scaleFactor;
                const width = rect.width * scaleFactor;
                const height = rect.height * scaleFactor;

                // Get computed style
                const style = window.getComputedStyle(elem);

                // Check if it's an image container
                const img = elem.querySelector('img');
                if (img) {
                    const loadedImg = loadedImages.find(li => li && li.elem === img);
                    if (loadedImg) {
                        ctx.save();

                        // Apply border radius if present
                        const borderRadius = parseFloat(style.borderRadius) * scaleFactor;
                        if (borderRadius > 0) {
                            ctx.beginPath();
                            ctx.roundRect(x, y, width, height, borderRadius);
                            ctx.clip();
                        }

                        ctx.drawImage(loadedImg.img, x, y, width, height);
                        ctx.restore();
                    }
                } else if (elem.textContent && elem.textContent.trim()) {
                    // Draw text
                    const text = elem.textContent.trim();
                    const fontSize = parseFloat(style.fontSize) * scaleFactor;
                    const fontWeight = style.fontWeight;
                    const fontFamily = style.fontFamily;
                    const color = style.color;
                    const textAlign = style.textAlign || 'left';
                    const textShadow = style.textShadow;

                    ctx.save();
                    ctx.font = `${fontWeight} ${fontSize}px ${fontFamily}`;
                    ctx.fillStyle = color;
                    ctx.textBaseline = 'top';

                    // Apply text shadow if present
                    if (textShadow && textShadow !== 'none') {
                        const shadowParts = textShadow.split('px');
                        if (shadowParts.length >= 3) {
                            ctx.shadowOffsetX = parseFloat(shadowParts[0]) * scaleFactor;
                            ctx.shadowOffsetY = parseFloat(shadowParts[1]) * scaleFactor;
                            ctx.shadowBlur = parseFloat(shadowParts[2]) * scaleFactor;
                            // Extract color from shadow
                            const colorMatch = textShadow.match(/rgba?\([^)]+\)/);
                            if (colorMatch) {
                                ctx.shadowColor = colorMatch[0];
                            }
                        }
                    }

                    // Adjust x position based on text alignment
                    let textX = x;
                    if (textAlign === 'center') {
                        textX = x + width / 2;
                        ctx.textAlign = 'center';
                    } else if (textAlign === 'right') {
                        textX = x + width;
                        ctx.textAlign = 'right';
                    }

                    ctx.fillText(text, textX, y);
                    ctx.restore();
                }
            });

            // Convert to blob and download
            finalCanvas.toBlob(function(blob) {
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.download = `DOST-ID-Card-${side.toUpperCase()}-L-${String(id).padStart(4, '0')}.png`;
                link.href = url;
                link.click();

                // Clean up
                URL.revokeObjectURL(url);
                document.body.removeChild(loadingDiv);
            }, 'image/png', 1.0);
        });
    };

    bgImg.onerror = function() {
        console.error('Failed to load background image:', bgUrl);
        alert('Error loading background image: ' + bgUrl + '\nPlease check the image path and CORS settings.');
        document.body.removeChild(loadingDiv);
    };

    bgImg.src = bgUrl;
}

function downloadBothIDCards(id) {
    downloadIDCard(id, 'front');
    setTimeout(() => {
        downloadIDCard(id, 'back');
    }, 1500);
}

function printIDCard(id) {
    const printArea = document.getElementById(`printable-area-${id}`);

    if (!printArea) {
        alert('Print area not found!');
        return;
    }

    const clone = printArea.cloneNode(true);
    clone.classList.add('printable-id-card');

    const printWindow = window.open('', '_blank');

    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Print ID Card - L-${String(id).padStart(4, '0')}</title>
            <style>
                @page {
                    size: auto;
                    margin: 10mm;
                }

                body {
                    margin: 0;
                    padding: 20px;
                    font-family: Arial, sans-serif;
                }

                .row {
                    display: flex;
                    gap: 20px;
                    justify-content: center;
                }

                .col-md-6 {
                    flex: 0 0 auto;
                }

                .no-print {
                    display: none !important;
                }

                .id-card-front,
                .id-card-back {
                    page-break-inside: avoid;
                }
            </style>
        </head>
        <body>
            ${clone.innerHTML}
        </body>
        </html>
    `);

    printWindow.document.close();

    printWindow.onload = function() {
        setTimeout(() => {
            printWindow.print();
            printWindow.onafterprint = function() {
                printWindow.close();
            };
        }, 500);
    };
}
</script>
@endsection
