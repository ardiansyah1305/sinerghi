<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>KEMENKO PMK</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('images/pmklogo.png'); ?>">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
    
    <!-- Additional CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="<?= base_url('css/jquery.mCustomScrollbar.min.css'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Navbar Dropdown Styles */
        .dropdown-menu {
            min-width: 200px;
            padding: 0.5rem 0;
            margin: 0;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            z-index: 1030;
        }
        
        .dropdown-item {
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            color: #333;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .dropdown-item i {
            margin-right: 0.5rem;
        }
        
        /* Hide caret for icons */
        .dropdown-toggle.no-caret::after {
            display: none !important;
        }
        
        /* Responsive navbar adjustments */
        @media (max-width: 991.98px) {
            .navbar .row {
                width: 100%;
            }
            
            .navbar-nav {
                font-size: 0.9rem;
            }
            
            .nav-item.mx-2 {
                margin-left: 0.25rem !important;
                margin-right: 0.25rem !important;
            }
        }
        
        @media (max-width: 991.98px) {
            /* Ensure dropdowns work properly on mobile */
            .navbar-collapse .dropdown-menu {
                border: none;
                box-shadow: none;
                padding-left: 1rem;
                background-color: rgba(0,0,0,0.03);
            }
            
            /* Add spacing between nav items on mobile */
            .navbar-nav .nav-item {
                margin-bottom: 0.5rem;
            }
            
            /* Make dropdown items more visible on mobile */
            .dropdown-item {
                padding: 0.5rem 1rem;
            }
            
            /* Adjust right-aligned items on mobile */
            .navbar-collapse .d-flex {
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid rgba(0,0,0,0.1);
            }
        }
        
        @media (max-width: 767.98px) {
            .navbar-nav {
                font-size: 0.8rem;
            }
            
            .nav-item.mx-2 {
                margin-left: 0.1rem !important;
                margin-right: 0.1rem !important;
            }
            
            .navbar .col-3 {
                flex: 0 0 auto;
                width: 20%;
            }
            
            .navbar .col-7 {
                flex: 0 0 auto;
                width: 60%;
            }
            
            .navbar .col-2 {
                flex: 0 0 auto;
                width: 20%;
            }
            
            /* Adjust dropdown position for smaller screens */
            .dropdown-menu {
                position: absolute;
                right: 0;
                left: auto;
                min-width: 180px;
            }
        }
        
        @media (max-width: 575.98px) {
            .navbar-brand img {
                max-height: 40px !important;
            }
            
            .navbar-nav {
                font-size: 0.75rem;
            }
            
            .nav-link {
                padding: 0.25rem 0.5rem;
            }
            
            .navbar .col-3 {
                width: 15%;
            }
            
            .navbar .col-7 {
                width: 65%;
            }
            
            .navbar .col-2 {
                width: 20%;
            }
            
            /* Further reduce dropdown width on very small screens */
            .dropdown-menu {
                min-width: 160px;
            }
            
            /* Make dropdown items more compact */
            .dropdown-item {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }
        }
        
        /* Extra small devices */
        @media (max-width: 420px) {
            .navbar-nav {
                font-size: 0.7rem;
            }
            
            .nav-link {
                padding: 0.2rem 0.35rem;
            }
            
            .navbar .col-3 {
                width: 12%;
            }
            
            .navbar .col-7 {
                width: 68%;
            }
            
            .navbar .col-2 {
                width: 20%;
            }
        }
        
        /* Navigation styling */
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        
        .nav-link.active {
            color: #0d6efd !important;
            font-weight: 500;
        }
        
        .nav-link.active:after, .nav-link.nav-hover:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #0d6efd;
            transform-origin: center;
            transform: scaleX(1);
            transition: transform 0.3s ease;
        }
        
        .nav-link:not(.active):after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #0d6efd;
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.3s ease;
        }
        
        .nav-link:not(.active):hover:after, .nav-link.nav-hover:after {
            transform: scaleX(1);
        }
        
        /* Ensure dropdown menus display properly */
        .dropdown-menu.show {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        /* Ensure dropdown items are properly styled */
        .dropdown-item {
            display: flex !important;
            align-items: center !important;
        }
        
        .dropdown-item i {
            margin-right: 0.5rem !important;
        }
        
        /* Center dropdown menu */
        .dropdown-menu-center {
            right: auto !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            min-width: 240px !important;
        }
        
        /* Ensure dropdown doesn't go off-screen on mobile */
        @media (max-width: 767.98px) {
            .dropdown-menu-center {
                left: auto !important;
                right: 0 !important;
                transform: none !important;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('layout/navbar'); ?>
    
    <div class="container">
        <?= $this->renderSection('content'); ?>
    </div>
    
    <?= $this->include('layout/footer'); ?>

    <!-- Core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Additional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="<?= base_url('js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize dropdowns with click-only behavior
            var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl, {
                    hover: false
                });
            });
            
            // Add active class to current nav item
            $('.nav-link').each(function() {
                if ($(this).attr('href') && window.location.pathname.indexOf($(this).attr('href')) === 0) {
                    $(this).addClass('active');
                }
            });
            
            // Explicitly disable hover functionality for dropdowns
            $('.dropdown').off('mouseenter mouseleave');
            
            // Prevent hover from opening dropdowns
            $('.dropdown-toggle').on('mouseenter mouseleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            });
            
            // Fix for mobile navbar items
            document.querySelectorAll('[data-bs-toggle="collapse"][data-bs-target="#navbarNav"]').forEach(function(element) {
                element.addEventListener('click', function() {
                    const bsCollapse = bootstrap.Collapse.getInstance(document.getElementById('navbarNav'));
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                });
            });
        });
    </script>

    <?= $this->renderSection('scripts'); ?>
</body>
</html>