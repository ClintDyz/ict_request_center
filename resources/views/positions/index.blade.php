@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    @if ($message = Session::get('success'))
    <div class="alert alert-success" id="success-alert">
        {{ $message }}
    </div>
@endif
<script>
    window.onload = function() {
        $(document).ready(function() {
            let editValue = @json(session('create'));

            if (editValue) {
                // Show alert
                let alertMessage = "Record successfully created!";
                let alertBox = `
                    <div id="custom-alert" class="alert alert-success" role="alert">
                        ${alertMessage}
                    </div>`;
                $('body').append(alertBox); // Add alert to the body

                // Automatically remove the alert after 5 seconds
                setTimeout(function() {
                    $('#custom-alert').fadeOut('slow', function() {
                        $(this).remove(); // Remove alert element after fading out
                    });
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    }

window.onload = function() {
        $(document).ready(function() {
            let editValue = @json(session('edit'));

            if (editValue) {
                // Show alert
                let alertMessage = "Record successfully updated!";
                let alertBox = `
                    <div id="custom-alert" class="alert alert-primary" role="alert">
                        ${alertMessage}
                    </div>`;
                $('body').append(alertBox); // Add alert to the body

                // Automatically remove the alert after 5 seconds
                setTimeout(function() {
                    $('#custom-alert').fadeOut('slow', function() {
                        $(this).remove(); // Remove alert element after fading out
                    });
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    }

    window.onload = function() {
        $(document).ready(function() {
            let editValue = @json(session('delete'));

            if (editValue) {
                // Show alert
                let alertMessage = "Record successfully deleted!";
                let alertBox = `
                    <div id="custom-alert" class="alert alert-danger" role="alert">
                        ${alertMessage}
                    </div>`;
                $('body').append(alertBox); // Add alert to the body

                // Automatically remove the alert after 5 seconds
                setTimeout(function() {
                    $('#custom-alert').fadeOut('slow', function() {
                        $(this).remove(); // Remove alert element after fading out
                    });
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    }

</script>

<style>
    #custom-alert {
        position: fixed;
        top: 20px; /* Distance from the top */
        right: 20px; /* Distance from the right */
        z-index: 1050; /* Ensure it's above other elements */
        min-width: 250px; /* Minimum width of the alert */
        padding: 15px; /* Add some padding */
        border-radius: 5px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional shadow */
    }
</style>

    <div class="card mb-4 mt-4">
        <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <div class="col-md-6" style="color: white">
                <i class="fas fa-table me-1"></i>
                Positions
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPositionModal">
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
                    @foreach ($positions as $position) <!-- Correct variable name -->
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $position->position }}</td> <!-- Use correct field name -->
                            <td>{{ \Carbon\Carbon::parse($position->created_at)->format('d F Y') }}</td>
                            <td>
                                <!-- Show Position -->
                                {{-- <button class="btn btn-info" onclick="showPosition('{{ $position->position }}')">Show</button> --}}

                                <!-- Button trigger modal for Edit -->
                                <button class="btn btn-primary" onclick="editPosition({{ $position->id }}, '{{ $position->position }}')">Edit</button>

                                <!-- Button trigger modal for Delete -->
                                <button class="btn btn-danger" onclick="deletePosition({{ $position->id }})">Delete</button>
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
    <div class="modal fade" id="createPositionModal" tabindex="-1" aria-labelledby="createPositionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('positions.store') }}" method="POST"> <!-- Corrected route -->
                    @csrf
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="createDivisionModalLabel">Create Position</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="division" class="form-label">Position Name</label>
                            <input type="text" class="form-control" name="position" id="position" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-success">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Division</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Edit Modal -->
<div class="modal fade" id="editPositionModal" tabindex="-1" aria-labelledby="editPositionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="editPositionForm"> <!-- Form action will be set dynamically -->
                @csrf
                @method('PUT')
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="editPositionModalLabel">Edit Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editPositionId" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Position Name</label>
                        <input type="text" class="form-control" id="editPositionName" name="position" required>
                    </div>
                </div>
                <div class="modal-footer bg-success">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Position</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Delete Modal -->
    <div class="modal fade" id="deletePositionModal" tabindex="-1" aria-labelledby="deletePositionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="deletePositionForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="deletePositionModalLabel">Delete Position</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this position?
                    </div>
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete Position</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Show Modal -->
    <div class="modal fade" id="showPositionModal" tabindex="-1" aria-labelledby="showPositionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showPositionModalLabel">Position Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <strong>Position Name: </strong> <span id="showPositionName"></span>
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
    function editPosition(id, name) {
        $('#editPositionId').val(id);
        $('#editPositionName').val(name);
        $('#editPositionForm').attr('action', '/positions/' + id); // Dynamically set the form action
        $('#editPositionModal').modal('show');
    }

    // Set the delete form action and open the modal
    function deletePosition(id) {
        $('#deletePositionForm').attr('action', '/positions/' + id); // Dynamically set the form action
        $('#deletePositionModal').modal('show');
    }

    // Set show modal details
    function showPosition(name) {
        $('#showPositionName').text(name);
        $('#showPositionModal').modal('show');
    }

           // Automatically hide the success message after 5 seconds (5000 milliseconds)
           setTimeout(function() {
        document.getElementById('success-alert').style.display = 'none';
    }, 5000); // 5000ms = 5 seconds
</script>
@endsection
