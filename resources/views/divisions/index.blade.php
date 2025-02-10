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
                        <!-- Show Division -->
                        {{-- <button class="btn btn-info" onclick="showDivision('{{ $division->division }}')">Show</button> --}}

                        <!-- Button trigger modal for Edit -->
                        <button class="btn btn-primary" onclick="editDivision({{ $division->id }}, '{{ $division->division }}')">Edit</button>

                        <!-- Button trigger modal for Delete -->
                        <button class="btn btn-danger" onclick="deleteDivision({{ $division->id }})">Delete</button>
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
    <div class="modal fade" id="createDivisionModal" tabindex="-1" aria-labelledby="createDivisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('divisions.store') }}" method="POST"> <!-- Corrected route -->
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editDivisionModal" tabindex="-1" aria-labelledby="editDivisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('divisions.update', $division->id) }}" id="editDivisionForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDivisionModalLabel">Edit Division</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editDivisionId" name="id">
                        <div class="mb-3">
                            <label for="division" class="form-label">Division Name</label>
                            <input type="text" class="form-control" id="editDivisionName" name="division" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Division</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteDivisionModal" tabindex="-1" aria-labelledby="deleteDivisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="deleteDivisionForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteDivisionModalLabel">Delete Division</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this division?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete Division</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Show Modal -->
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
    // Set values in the edit modal
    function editDivision(id, name) {
        $('#editDivisionId').val(id);
        $('#editDivisionName').val(name);
        $('#editDivisionForm').attr('action', '/divisions/' + id); // Dynamically set the form action
        $('#editDivisionModal').modal('show');
    }

    // Set the delete form action and open the modal
    function deleteDivision(id) {
        $('#deleteDivisionForm').attr('action', '/divisions/' + id); // Dynamically set the form action
        $('#deleteDivisionModal').modal('show');
    }

    // Set show modal details
    function showDivision(name) {
        $('#showDivisionName').text(name);
        $('#showDivisionModal').modal('show');
    }

       // Automatically hide the success message after 5 seconds (5000 milliseconds)
       setTimeout(function() {
        document.getElementById('success-alert').style.display = 'none';
    }, 5000); // 5000ms = 5 seconds
</script>
@endsection
