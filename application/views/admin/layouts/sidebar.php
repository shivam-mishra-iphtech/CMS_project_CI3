<!-- Banner -->
<style>
    @import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

    /* Bootstrap Icons */
    @import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");

    .nav-item a {
        font-size: 14px;
    }

    /* Navbar Link Hover Effects */
    .nav-link {
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 0.5rem 1rem !important;
    }

    .nav-link:hover {
        background: rgba(0, 0, 0, 0.05);
        transform: translateX(3px);
    }

    .nav-link.active {
        background: linear-gradient(45deg, #0d6efd, #0b5ed7);
        color: white !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Expanding User Menu */
    .user-menu {
        display: none;
        padding-left: 20px;
        /* Aligns with Users link */
    }

    .user-menu a {
        display: block;
        padding: 8px 15px;
        transition: all 0.2s ease;
    }

    .user-menu a:hover {
        background: rgba(0, 0, 0, 0.03);
        padding-left: 25px;
    }
</style>
<!-- Dashboard -->
<div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
    <!-- Vertical Navbar -->
    <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg"
        id="navbarVertical">
        <div class="container-fluid">
            <!-- Toggler -->
            <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Brand -->
            <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="#">
                <h3>DEMO-PROJECT</h3>
                <!-- <img src="https://preview.webpixels.io/web/img/logos/clever-primary.svg" alt="..."> -->
            </a>
            <!-- User menu (mobile) -->
            <div class="navbar-user d-lg-none">
                <!-- Dropdown -->
                <div class="dropdown">
                    <!-- Toggle -->
                    <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="avatar-parent-child">
                            <img alt="Image Placeholder"
                                src="https://images.unsplash.com/photo-1548142813-c348350df52b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80"
                                class="avatar avatar- rounded-circle">
                            <span class="avatar-child avatar-badge bg-success"></span>
                        </div>
                    </a>
                    <!-- Menu -->
                    <div class="position-relative">
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
                            <a href="#" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Billing</a>
                            <hr class="dropdown-divider">
                            <a href="<?php echo site_url('WebController/logout'); ?>" class="dropdown-item">Logout</a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidebarCollapse">
                <!-- Navigation -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-medium">
                    <!-- Dashboard -->
                    <li class="nav-item mx-2">
                        <a class="nav-link active" aria-current="page"
                            href="<?php echo site_url('AdminController/dashboard')?>">
                            <i class="bi bi-house-door fs-5 me-2"></i>
                            Dashboard
                        </a>
                    </li>

                    <!-- Analytics -->
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="#">
                            <i class="bi bi-bar-chart-line fs-5 me-2"></i>
                            Analytics
                        </a>
                    </li>

                    <!-- Messages with Badge -->
                    <li class="nav-item mx-2 position-relative">
                        <a class="nav-link" href="#">
                            <i class="bi bi-chat-dots fs-5 me-2"></i>
                            Messages
                            <span class="badge bg-danger rounded-pill position-absolute translate-middle">6</span>
                        </a>
                    </li>

                    <!-- Collections -->
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="#">
                            <i class="bi bi-bookmarks fs-5 me-2"></i>
                            Collections
                        </a>
                    </li>

                    <!-- Users Expanding Menu -->
                    <li class="nav-item mx-2">
                        <a class="nav-link d-flex align-items-center user-toggle" href="#">
                            <i class="bi bi-people fs-5 me-2"></i>
                            Users
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul class="user-menu list-unstyled collapse">
                            <li>
                                <a class="dropdown-item py-2 px-4 d-flex align-items-center"
                                    href="<?php echo site_url('AdminController/user_list')?>">
                                    <i class="bi bi-list-task me-1 text-primary"></i>
                                    User List
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 px-4 d-flex align-items-center"
                                    href="<?php echo site_url('AdminController/add_user')?>">
                                    <i class="bi bi-person-plus me-1 text-success"></i>
                                    Add User
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- -------- add post --------- -->

                    <li class="nav-item mx-2">
                        <a class="nav-link d-flex align-items-center post-toggle" href="#">
                        <i class="bi bi-newspaper fs-5 me-2 "></i>
                           Posts
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul class="post-menu list-unstyled collapse">
                            <li>
                                <a class="dropdown-item py-2 px-4 d-flex align-items-center"
                                    href="<?php echo site_url('AdminController/posts_list')?>">
                                    <i class="bi bi-list-task me-1 text-primary"></i>
                                   Post List
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 px-4 d-flex align-items-center"
                                    href="<?php echo site_url('AdminController/add_post')?>">
                                    <i class="bi bi-plus me-2 text-success"></i>
                                    Add Post
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <hr class="navbar-divider my-5 opacity-20">
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-4">
                    <li>
                        <div class="nav-link text-xs font-semibold text-uppercase text-muted ls-wide" href="#">
                            Contacts
                            <span
                                class="badge bg-soft-primary text-primary rounded-pill d-inline-flex align-items-center ms-4">13</span>
                        </div>
                    </li>

                </ul>
                <div class="mt-auto"></div>
                <!-- User (md) -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-person-square"></i> Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('WebController/logout'); ?>">
                            <i class="bi bi-box-arrow-left"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector(".user-toggle").addEventListener("click", function(e) {
                e.preventDefault();
                const userMenu = document.querySelector(".user-menu");
                userMenu.style.display = (userMenu.style.display === "block") ? "none" :
                    "block";
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector(".post-toggle").addEventListener("click", function(e) {
                e.preventDefault();
                const userMenu = document.querySelector(".post-menu");
                userMenu.style.display = (userMenu.style.display === "block") ? "none" :
                    "block";
            });
        });
    </script>