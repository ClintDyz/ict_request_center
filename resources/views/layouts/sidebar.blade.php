<style>
#sidebar {
    width: 260px;
    overflow-y: auto;
}

#sidebar .nav-item a {
    color: #333;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: 0.2s;
}

/* Hover */
#sidebar .nav-item a:hover {
    background: #f0f0f0;
    padding-left: 20px;
}

/* Parent dropdown container */
.nav-treeview {
    padding-left: 20px;
    display: none;       /* Hidden by default */
    flex-direction: column;
    background: #f8f9fa;
}

/* Show submenu when opened */
.nav-treeview.show {
    display: flex;
}

/* Submenu links */
.nav-treeview a {
    font-size: 14px;
}

/* Arrow rotation */
.menu-arrow {
    margin-left: auto;
    transition: transform 0.3s ease;
}
.menu-arrow.rotate {
    transform: rotate(90deg);
}

/* Active link highlight */
.active-link {
    background: #0d6efd !important;
    color: white !important;
    border-left: 4px solid #ffc107;
}
</style>

<nav id="sidebar" class="bg-light border-end h-100 position-fixed">
    <div class="p-3">

        <a class="navbar-brand d-block mb-3" href="{{ url('/welcome') }}">
            ICT Request Center
        </a>

        <ul class="nav flex-column">

            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ url('/welcome') }}" class="nav-link">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>

            <!-- Zoom Dropdown -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle-menu" data-target="menuZoom">
                    <i class="fa fa-video-camera"></i> Zoom
                    <i class="fa fa-angle-right menu-arrow"></i>
                </a>

                <ul id="menuZoom" class="nav nav-treeview">
                    <li><a class="nav-link" href="{{ url('/zoom_request') }}">Zoom Request</a></li>
                    <li><a class="nav-link" href="{{ url('/approved') }}">Approved</a></li>
                    <li><a class="nav-link" href="{{ url('/declined') }}">Declined</a></li>
                </ul>
            </li>

            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ url('/id_request') }}" class="nav-link">
                    <i class="fa fa-id-card" aria-hidden="true"></i> ID Create
                </a>
            </li>


            <!-- Report -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle-menu" data-target="menuReport">
                    <i class="fa fa-file-alt"></i> Report
                    <i class="fa fa-angle-right menu-arrow"></i>
                </a>

                <ul id="menuReport" class="nav nav-treeview">
                    <li><a class="nav-link" href="{{ url('/zoom_report') }}">Zoom Report</a></li>
                    {{-- <li><a class="nav-link" href="{{ url('/id_report') }}">ID Report</a></li> --}}

                </ul>
            </li>

            <!-- Libraries -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle-menu" data-target="menuLibrary">
                    <i class="fa fa-folder-open"></i> Libraries
                    <i class="fa fa-angle-right menu-arrow"></i>
                </a>

                <ul id="menuLibrary" class="nav nav-treeview">
                    <li><a class="nav-link" href="{{ url('/positions') }}">Position</a></li>
                    <li><a class="nav-link" href="{{ url('/units') }}">Division/Unit</a></li>
                    {{-- <li><a class="nav-link" href="{{ url('/ict_equipment') }}">ICT Equipment</a></li> --}}
                </ul>
            </li>

            <!-- Users -->
            <li class="nav-item">
                <a href="{{ url('/users') }}" class="nav-link">
                    <i class="fa fa-users"></i> Users
                </a>
            </li>

        </ul>

    </div>
</nav>

<script>
// Open/close dropdown (AdminLTE behavior)
document.querySelectorAll(".dropdown-toggle-menu").forEach(menu => {
    menu.addEventListener("click", function (e) {
        e.preventDefault();

        const target = document.getElementById(this.dataset.target);
        const arrow = this.querySelector(".menu-arrow");

        target.classList.toggle("show");
        arrow.classList.toggle("rotate");
    });
});

// Highlight active link + auto-open dropdown
const currentURL = window.location.href;

document.querySelectorAll("#sidebar a.nav-link").forEach(link => {
    if (link.href === currentURL) {
        link.classList.add("active-link");

        // If inside submenu → open its parent
        if (link.closest(".nav-treeview")) {
            let menu = link.closest(".nav-treeview");
            let menuToggle = menu.previousElementSibling;
            let arrow = menuToggle.querySelector(".menu-arrow");

            menu.classList.add("show");
            arrow.classList.add("rotate");
            menuToggle.classList.add("active-link");
        }
    }
});
</script>
