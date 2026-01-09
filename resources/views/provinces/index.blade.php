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
                Province
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProvinceModal">
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
                    @foreach ($provinces as $province)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $province->province }}</td>
                            <td>{{ \Carbon\Carbon::parse($province->created_at)->format('d F Y') }}</td>
                            <td>
                                <!-- Edit button for Province -->
                                <button class="btn btn-primary" onclick="editProvince({{ $province->id }}, '{{ $province->province }}')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- Delete button for Province -->
                              @if(auth()->user()->emp_type == '0')
                                <button class="btn btn-danger" onclick="deleteProvince({{ $province->id }})">
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
<div class="modal fade" id="createProvinceModal" tabindex="-1" aria-labelledby="createProvinceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('provinces.store') }}" method="POST"> <!-- Corrected route -->
                @csrf
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="createProvinceModalLabel">Create Province</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="province" class="form-label">Province Name</label>
                        <input type="text" class="form-control" name="province" id="province" required>
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
<div class="modal fade" id="editProvinceModal" tabindex="-1" aria-labelledby="editProvinceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('provinces.update', 'placeholder') }}" id="editProvinceForm">
                @csrf
                @method('PUT')
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="editProvinceModalLabel">Edit Province</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editProvinceId" name="id">
                    <div class="mb-3">
                        <label for="province" class="form-label">Province Name</label>
                        <input type="text" class="form-control" id="editProvinceName" name="province" required>
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
<div class="modal fade" id="deleteProvinceModal" tabindex="-1" aria-labelledby="deleteProvinceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="deleteProvinceForm">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deleteProvinceModalLabel">Delete Province</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this province?
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
<div class="modal fade" id="showProvinceModal" tabindex="-1" aria-labelledby="showProvinceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showProvinceModalLabel">Province Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong>Province Name: </strong> <span id="showProvinceName"></span>
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
    function editProvince(id, name) {
        // 1. Set the form fields
        $('#editProvinceId').val(id);
        $('#editProvinceName').val(name);

        // 2. Embed the 'provinces.update' route URL with a placeholder ':id'
        let updateUrl = '{{ route('provinces.update', ':id') }}';

        // 3. Replace the placeholder with the actual ID
        updateUrl = updateUrl.replace(':id', id);

        // 4. Set the form action
        $('#editProvinceForm').attr('action', updateUrl);

        // 5. Show the modal
        $('#editProvinceModal').modal('show');
    }

    // Set the delete form action and open the modal
    function deleteProvince(id) {
        // 1. Embed the 'provinces.destroy' route URL with a placeholder ':id'
        let deleteUrl = '{{ route('provinces.destroy', ':id') }}';

        // 2. Replace the placeholder with the actual ID
        deleteUrl = deleteUrl.replace(':id', id);

        // 3. Set the form action
        $('#deleteProvinceForm').attr('action', deleteUrl);

        // 4. Show the modal
        $('#deleteProvinceModal').modal('show');
    }

    // Set show modal details (No change needed here)
    function showProvince(name) {
        $('#showProvinceName').text(name);
        $('#showProvinceModal').modal('show');
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
