@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    {{-- Success Message Alert --}}
    @if ($message = Session::get('success'))
    <div class="alert alert-success" id="success-alert">
        {{ $message }}
    </div>
    @endif

    <div class="card mb-4 mt-4">
        <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <div class="col-md-6" style="color: white">
                <i class="fas fa-table me-1"></i>
                Division
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDivisionModal">
                Create
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
                    @foreach ($divisions as $division)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $division->division }}</td>
                            <td>{{ \Carbon\Carbon::parse($division->created_at)->format('d F Y') }}</td>
                            <td>
                                <button class="btn btn-primary" onclick="editDivision({{ $division->id }}, '{{ $division->division }}')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                @if(auth()->user()->emp_type == '0')
                                <button class="btn btn-danger" onclick="deleteDivision({{ $division->id }})">
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

{{-- --- MODALS --- --}}

<div class="modal fade" id="createDivisionModal" tabindex="-1" aria-labelledby="createDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('divisions.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="createDivisionModalLabel">Create Division</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="division" class="form-label">Division Name</label>
                        <input type="text" class="form-control" name="division" id="division" required>
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

<div class="modal fade" id="editDivisionModal" tabindex="-1" aria-labelledby="editDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- REMOVED STATIC action="{{ route('divisions.update', $division->id) }}" --}}
            <form method="POST" id="editDivisionForm">
                @csrf
                @method('PUT')
                <div class="modal-header bg-info"> {{-- Changed to warning for contrast --}}
                    <h5 class="modal-title" id="editDivisionModalLabel">Edit Division</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- The hidden input is not strictly needed since the ID is in the route URL, but it doesn't hurt --}}
                    <input type="hidden" id="editDivisionId" name="id">
                    <div class="mb-3">
                        <label for="division" class="form-label">Division Name</label>
                        <input type="text" class="form-control" id="editDivisionName" name="division" required>
                    </div>
                </div>
                <div class="modal-footer bg-success">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteDivisionModal" tabindex="-1" aria-labelledby="deleteDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="deleteDivisionForm">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deleteDivisionModalLabel">Delete Division</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this division?
                </div>
                <div class="modal-footer bg-warning"> {{-- Changed to danger for contrast --}}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="showDivisionModal" tabindex="-1" aria-labelledby="showDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showDivisionModalLabel">Division Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong>Division Name: </strong> <span id="showDivisionName"></span>
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
    // Set values in the edit modal and set the form action dynamically
    function editDivision(id, name) {
        // 1. Set the form fields
        $('#editDivisionId').val(id);
        $('#editDivisionName').val(name);

        // 2. Embed the 'divisions.update' route URL with a placeholder ':id'
        let updateUrl = '{{ route('divisions.update', ':id') }}';

        // 3. Replace the placeholder with the actual ID
        updateUrl = updateUrl.replace(':id', id);

        // 4. Set the form action
        $('#editDivisionForm').attr('action', updateUrl);

        // 5. Show the modal
        $('#editDivisionModal').modal('show');
    }

    // Set the delete form action and open the modal
    function deleteDivision(id) {
        // 1. Embed the 'divisions.destroy' route URL with a placeholder ':id'
        let deleteUrl = '{{ route('divisions.destroy', ':id') }}';

        // 2. Replace the placeholder with the actual ID
        deleteUrl = deleteUrl.replace(':id', id);

        // 3. Set the form action
        $('#deleteDivisionForm').attr('action', deleteUrl);

        // 4. Show the modal
        $('#deleteDivisionModal').modal('show');
    }

    // Set show modal details
    function showDivision(name) {
        $('#showDivisionName').text(name);
        $('#showDivisionModal').modal('show');
    }

    // Automatically hide the success message after 5 seconds (5000 milliseconds)
    setTimeout(function() {
        var alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 5000); // 5000ms = 5 seconds
</script>
@endsection
