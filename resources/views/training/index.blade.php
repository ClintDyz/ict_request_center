@extends('layouts.admin')

@section('content')

<style>
    .jio{
        pointer-events: none;
    }

    .form-box {
      padding: 15px;
      margin-bottom: 20px;
    }
    .score-box {
      width: 80px;
      border-bottom: 1px solid #000;
      display: inline-block;
    }
    .section-title {
      font-weight: bold;
    }
    .rating-box {
      border-top: 1px solid #000;
      padding-top: 10px;
      margin-top: 30px;
    }
    /* Tooltip text */
    .tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;

    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
    }
    /* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>

<div class="container-fluid px-4">
    @if (session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4 mt-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-user me-1"></i>
                Request Resource Speakers
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRequestModal">
                <i class="fa-solid fa-circle-plus"></i> Create
            </button>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Agency</th>
                        <th>Training Title</th>
                        <th>Venue</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        <tr>
                            <td>{{ optional($request->speaker)->given_name }} {{ optional($request->speaker)->last_name }}</td>
                            <td>{{ $request->gender }}</td>
                            <td>{{ $request->agency }}</td>
                            <td>{{ $request->training_title }}</td>
                            <td>{{ $request->venue }}</td>
                            <td>{{ $request->date }}</td>
                            <td>
                                <!-- Edit Button -->
                                {{-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editRequestModal-{{ $request->id }}">
                                    <i class="fa fa-edit"></i>
                                </button> --}}

                                <!-- Button to redirect to Edit page -->
                                           <a href="{{ route('request_resource_speaker.edit', $request->id) }}" class="btn btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                <form action="{{ route('training.destroy', $request->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-btn"
                                        data-name="{{ optional($request->speaker)->given_name }} {{ optional($request->speaker)->last_name }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <!-- Trigger Button -->
                                {{-- <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" title="Open Accreditation Form" data-bs-target="#accreditationModal-{{ $request->id }}">
                                    <i class="fa fa-folder-open" aria-hidden="true"></i>
                                </button> --}}
                                {{-- <a href="{{ route('request_resource_speaker.edit', $request->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('request_resource_speaker.destroy', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    <div class="card-footer bg-success"></div>
    </div>
</div>

<!-- Create Request Modal -->
<!-- Create Request Modal -->
<div class="modal fade" id="createRequestModal" tabindex="-1" aria-labelledby="createRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('training.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="createRequestModalLabel">New Request Resource Speaker</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="training_title" class="form-label">Training Title</label>
                                <input type="text" class="form-control" name="training_title">
                            </div>
                            <div class="mb-3">
                                <label for="venue" class="form-label">Venue</label>
                                <input type="text" class="form-control" name="venue">
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" name="date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_hours" class="form-label">No. of Hours</label>
                                <input type="number" class="form-control" name="no_hours">
                            </div>
                            <div class="mb-3">
                                <label for="no_participants" class="form-label">No. of Participants</label>
                                <input type="number" class="form-control" name="no_participants">
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">Attach File</label>
                                <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.jpg,.png">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rstbl_id" class="form-label">Speaker</label>
                                <select class="form-control select2" name="rstbl_id" required id="select-speaker" style="width: 100%">
                                    <option value="">Select Speaker</option>
                                    @foreach ($speakers as $speaker)
                                        <option value="{{ $speaker->id }}"
                                                data-gender="{{ $speaker->gender }}"
                                                data-agency="{{ $speaker->office->office_organization ?? '' }}">
                                            {{ $speaker->given_name }} {{ $speaker->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <input type="text" class="form-control jio" name="gender" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="agency" class="form-label">Agency</label>
                                <input type="text" class="form-control jio" name="agency" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="division" class="form-label">Requesting Division</label>
                                {{-- <input type="text" class="form-control" name="division"> --}}
                                <select class="form-select" name="division" id="division" required>
                                <option value="" selected disabled>Select Division</option>
                                @foreach ($divisions as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Update Request Modal -->
{{-- <div class="modal fade" id="editRequestModal-{{ $request->id }}" tabindex="-1" aria-labelledby="editRequestModalLabel-{{ $request->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
    </div>
</div> --}}
@endsection

@section('scripts')
<script>
    setTimeout(() => {
        const alert = document.getElementById('success-alert');
        if (alert) alert.style.display = 'none';
    }, 5000);

  document.addEventListener('DOMContentLoaded', function () {
        // Initialize Select2 on the speaker dropdown
        $('#select-speaker').select2({
            dropdownParent: $('#createRequestModal')
        });

        // Autofill Gender and Agency when a speaker is selected
        $('#select-speaker').on('change.select2', function () {
            const selected = $(this).find('option:selected');
            const gender = selected.data('gender') || '';
            const agency = selected.data('agency') || '';

            $('input[name="gender"]').val(gender);
            $('input[name="agency"]').val(agency);
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const select = document.getElementById("select-speaker");
        const displaySpeaker = document.getElementById("display-speaker");
        const displayExpertise = document.getElementById("display-expertise");

        select.addEventListener("change", function () {
            const selected = select.options[select.selectedIndex];
            const name = selected.getAttribute("data-name") || "—";
            const expertise = selected.getAttribute("data-expertise") || "—";

            displaySpeaker.textContent = name;
            displayExpertise.textContent = expertise;
        });
    });

    document.querySelectorAll('.score-box').forEach(input => {
    input.addEventListener('input', () => {
        let total = 0;
        document.querySelectorAll('input.score-box[name]:not([name=total])').forEach(field => {
            total += parseInt(field.value) || 0;
        });
        document.querySelector('input[name="total"]').value = total;
    });
});

</script>

@endsection
