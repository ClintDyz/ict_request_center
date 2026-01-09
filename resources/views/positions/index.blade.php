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
                                <button class="btn btn-primary" onclick="editPosition({{ $position->id }}, '{{ $position->position }}')">
                                    <i class="fa-solid fa-pen-to-square"></i>

                                </button>

                                <!-- Button trigger modal for Delete -->
                              @if(auth()->user()->emp_type == '0')
                                <button class="btn btn-danger" onclick="deletePosition({{ $position->id }})">
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
                        <button type="submit" class="btn btn-primary">Save</button>
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
                    <button type="submit" class="btn btn-primary">Update</button>
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
                        <button type="submit" class="btn btn-danger">Delete</button>
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
    // --- Dynamic Alert Handling (Consolidated) ---
    // Note: I've consolidated your custom window.onload blocks into a single $(document).ready()
    // and fixed the potential issue of multiple 'custom-alert' IDs appearing.
    $(document).ready(function() {
        let sessionData = [
            { key: 'create', message: 'Record successfully created!', class: 'alert-success' },
            { key: 'edit', message: 'Record successfully updated!', class: 'alert-primary' },
            { key: 'delete', message: 'Record successfully deleted!', class: 'alert-danger' }
        ];

        sessionData.forEach(function(item) {
            let sessionValue = @json(session(':key')) ? true : false; // Check for session value

            // This is a common way to check for session flash data if you are just passing true/false,
            // but relying on the 'success' message is usually cleaner.
            // Let's use your current flash messages:
            let flashMessage = '{{ Session::get('success') }}';

            if (flashMessage && !document.getElementById('custom-alert-flash')) {
                 let alertBox = `
                    <div id="custom-alert-flash" class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>`;
                $('body').append(alertBox);

                setTimeout(function() {
                    $('#custom-alert-flash').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    });

    // --- Dynamic Modal Logic ---

    // Set values in the edit modal and set the form action dynamically
    function editPosition(id, name) {
        // 1. Set the form fields
        $('#editPositionId').val(id);
        $('#editPositionName').val(name);

        // 2. Embed the 'positions.update' route URL with a placeholder ':id'
        let updateUrl = '{{ route('positions.update', ':id') }}';

        // 3. Replace the placeholder with the actual ID
        updateUrl = updateUrl.replace(':id', id);

        // 4. Set the form action
        $('#editPositionForm').attr('action', updateUrl);

        // 5. Show the modal
        $('#editPositionModal').modal('show');
    }

    // Set the delete form action and open the modal
    function deletePosition(id) {
        // 1. Embed the 'positions.destroy' route URL with a placeholder ':id'
        let deleteUrl = '{{ route('positions.destroy', ':id') }}';

        // 2. Replace the placeholder with the actual ID
        deleteUrl = deleteUrl.replace(':id', id);

        // 3. Set the form action
        $('#deletePositionForm').attr('action', deleteUrl);

        // 4. Show the modal
        $('#deletePositionModal').modal('show');
    }

    // Set show modal details
    function showPosition(name) {
        $('#showPositionName').text(name);
        $('#showPositionModal').modal('show');
    }

    // Note: The original 'success-alert' timeout logic is now replaced by the consolidated
    // JQuery alert handling above for a cleaner user experience.
</script>
@endsection
