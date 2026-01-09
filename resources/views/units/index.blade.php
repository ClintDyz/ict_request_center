@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    @if ($message = Session::get('success'))
    <div class="alert alert-success" id="success-alert">
        {{ $message }}
    </div>
    @endif

    <div class="card mb-4 mt-4">
        <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <div class="col-md-6" style="color: white">
                <i class="fas fa-table me-1"></i>
                Unit
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUnitModal">
                <i class="fa-solid fa-circle-plus"></i> Create
            </button>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Date Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($units as $unit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $unit->unit }}</td>
                            <td>{{ \Carbon\Carbon::parse($unit->created_at)->format('d F Y') }}</td>
                            <td>
                                <!-- Edit button for Unit -->
                                <button class="btn btn-primary"
                                        onclick="editUnit({{ $unit->id }}, '{{ $unit->unit }}')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- Delete button for Unit -->
                                @if(auth()->user()->emp_type == '0')
                               <button class="btn btn-danger" onclick="deleteUnit({{ $unit->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-success"></div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createUnitModal" tabindex="-1" aria-labelledby="createUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('units.store') }}" method="POST"> <!-- Corrected route -->
                @csrf
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="createUnitModalLabel">Create Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit Name</label>
                        <input type="text" class="form-control" name="unit" id="unit" required>
                    </div>
                </div>
                <div class="modal-footer bg-success">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editUnitModal" tabindex="-1" aria-labelledby="editUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('units.update', 'placeholder') }}" id="editUnitForm">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="editUnitModalLabel">Edit Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editUnitId" name="id">
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit Name</label>
                        <input type="text" class="form-control" id="editUnitName" name="unit" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteUnitModal" tabindex="-1" aria-labelledby="deleteUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="deleteUnitForm">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="deleteUnitModalLabel">Delete Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this unit?
                </div>
                <div class="modal-footer bg-danger">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Show Modal -->
<div class="modal fade" id="showUnitModal" tabindex="-1" aria-labelledby="showUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showUnitModalLabel">Unit Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong>Unit Name: </strong> <span id="showUnitName"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Set values in the edit modal
// Set values in the edit modal and dynamically set the form action URL
function editUnit(id, name) {
    // 1. Set the values in the form fields
    $('#editUnitId').val(id);
    $('#editUnitName').val(name);

    // 2. Dynamically construct and set the form action for the PUT request
    // This will change the action from '.../units/placeholder' to '.../units/44'
    // The base path should be derived correctly using Laravel's route naming for robustness:
    let updateUrl = '{{ route('units.update', ':id') }}';
    updateUrl = updateUrl.replace(':id', id);

    $('#editUnitForm').attr('action', updateUrl);

    // 3. Show the modal
    $('#editUnitModal').modal('show');
}

    // Set the delete form action and open the modal
// Set the delete form action and open the modal
function deleteUnit(id) {

    // 1. Get the base route URL and use a placeholder
    // We use ':id' as a temporary placeholder in the route helper.
    let deleteUrl = '{{ route('units.destroy', ':id') }}';

    // 2. Replace the placeholder with the actual unit ID
    deleteUrl = deleteUrl.replace(':id', id);

    // 3. Dynamically set the form action
    $('#deleteUnitForm').attr('action', deleteUrl);

    // 4. Show the modal
    $('#deleteUnitModal').modal('show');
}
    // Set show modal details
    function showUnit(name) {
        $('#showUnitName').text(name);
        $('#showUnitModal').modal('show');
    }

    // Automatically hide the success message after 5 seconds (5000 milliseconds)
    setTimeout(function() {
        document.getElementById('success-alert').style.display = 'none';
    }, 5000); // 5000ms = 5 seconds
</script>
@endsection
