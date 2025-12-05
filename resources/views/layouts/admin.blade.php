{{-- resources/views/admin/tables.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Smart Request Center</title>

    <!-- Bootstrap 5 -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- DataTables + Bootstrap 5 styling -->
<link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">


    <!-- Optional DataTables Responsive CSS (if you have it) -->
    {{-- <link href="{{ asset('css/dataTables/responsive.bootstrap5.min.css') }}" rel="stylesheet"> --}}

    <!-- Font Awesome -->
    <link href="{{ asset('font/css/all.min.css') }}" rel="stylesheet">

    <!-- Your custom styles (Startmin) -->
    <link href="{{ asset('css/startmin.css') }}" rel="stylesheet">

    <style>
        /* Small adjustments to mimic SB Admin spacing */
        body { font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; }
        #sidebar { min-width: 220px; max-width: 220px; }
        #page-wrapper { margin-left: 220px; padding: 24px; }
        .sidebar .nav-link { color: #333; }
        .sidebar .nav-link.active { background-color: #e9ecef; }
        .sidebar {
    width: 250px;
    background: #fff;
    height: 100vh;
    border-right: 1px solid #e5e5e5;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
    transition: all 0.3s ease;
    z-index: 1030;
}

.sidebar.collapsed {
    margin-left: -250px;
}

/* Page Content */
.content {
    margin-left: 225px;
    transition: all 0.3s ease;
}

.content.expanded {
    margin-left: 0;
}

/* Mobile responsive */
@media (max-width: 992px) {
    .sidebar {
        margin-left: -250px;
    }
    .sidebar.active {
        margin-left: 0;
    }
    .content {
        margin-left: 0 !important;
    }
}
</style>
</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <nav id="sidebar" class="sidebar active">
        @include('layouts.sidebar')
    </nav>

    <!-- CONTENT AREA -->
    <div id="content" class="content flex-grow-1">
        @include('layouts.navbar')

        <main class="p-4">
            @yield('content')
        </main>
    </div>

</div>

    <!-- SCRIPTS -->
<!-- ✅ jQuery (already loaded) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- ✅ DataTables JS (Core + Bootstrap 5) -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<!-- Optional MetisMenu (if used) -->
<script src="{{ asset('js/metisMenu.min.js') }}"></script>

<!-- Your custom JS -->
<script src="{{ asset('js/startmin.js') }}"></script>

<script>
    $(document).ready(function () {
        // Initialize MetisMenu if you want collapsible side menus
        if (typeof MetisMenu !== 'undefined') {
            try {
                new MetisMenu('#side-menu');
            } catch (e) { /* ignore if not available */ }
        }

        // Initialize DataTable (Bootstrap 5 styling)
        $('#dataTables-example').DataTable({
            responsive: true,
            paging: true,
            searching: true
            // For Bootstrap 5 look & feel with DataTables, you may configure language/layout options here.
            // dom: 'lfrtip' // default layout
        });

        // Optional: keep sidebar collapse behavior for mobile
        // (Bootstrap collapse uses data-bs-* attributes already on the toggle button)
    });
</script>
<script>
document.getElementById("toggleSidebar").addEventListener("click", function () {
    const sidebar = document.getElementById("sidebar");
    const content = document.getElementById("content");

    sidebar.classList.toggle("collapsed");
    content.classList.toggle("expanded");
});
</script>


</body>
</html>

