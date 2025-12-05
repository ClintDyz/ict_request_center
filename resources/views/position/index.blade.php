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
</style>


        <!-- Content header -->
        <div class="d-flex align-items-center mb-3">
            <h1 class="h3 mb-0 me-auto">Position</h1>
        </div>

        <!-- Card with table -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-success text-white">
                <div><i class="fa fa-table me-2"></i> Position</div>
                <div class="small">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUnitModal">
                    <i class="fa-solid fa-circle-plus me-1"></i> Create
                </button>
                </div>
            </div>
            <div class="card-body">

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
                    <table id="positionTable" class="table table-striped table-bordered display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <tbody>
                            @foreach($position as $position)
                            <tr>
                                <td>{{ $position->position }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateUnitModal-{{ $position->id }}">Edit</button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUnitModal-{{ $position->id }}">Delete</button>
                                </td>
                            </tr>

                                <!-- Update Modal -->
                                    <div class="modal fade" id="updateUnitModal-{{ $position->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('position.update', $position->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header bg-info">
                                                        <h5 class="modal-title">Update Position</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="text" class="form-control" name="position" id="position" value="{{ $position->position }}" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteUnitModal-{{ $position->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('position.destroy', $position->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title">Delete position</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete "{{ $position->position }}"?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


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


<!-- Create Unit Modal (Bootstrap 5) -->
<div class="modal fade" id="createUnitModal" tabindex="-1" aria-labelledby="createUnitModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('position.store') }}" method="POST">
        @csrf
        <div class="modal-header bg-info">
            <h5 class="modal-title" id="createUnitModalLabel">Create Position</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="unit" class="form-label">Position</label>
                <input type="text" class="form-control" name="position" id="position" required>
            </div>
        </div>
        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script>
document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector("#positionTable tbody");
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
</script>

  @endsection
