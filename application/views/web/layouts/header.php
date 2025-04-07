<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Project CI-3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .nav-link {
            font-weight: 500;
            color: #333 !important;
            transition: all 0.2s;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #0d6efd !important;
        }

        .navbar-toggler {
            border: none;
            box-shadow: none !important;
        }

        .user_icon {
            font-size: 28px;
            color: #666;
            transition: all 0.3s;
        }

        .user_icon:hover {
            color: #0d6efd;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu>.dropdown-menu {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            margin-top: 0;
            border-radius: 0 6px 6px 6px;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                padding-top: 1rem;
            }

            .nav-item {
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }

            .dropdown-menu {
                box-shadow: none;
                border-radius: 0;
                background-color: rgba(245, 245, 245, 0.9);
            }

            .dropdown-submenu>.dropdown-menu {
                position: static;
                margin-left: 1rem;
                display: none;
            }

            .dropdown-submenu.show>.dropdown-menu {
                display: block;
            }
        }
    </style>
</head>


<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-2">
        <div class="container">
            <?php if (!empty($logo)): ?>
                <a class="navbar-brand" href="#">
                    <img src="<?php echo base_url('public/WebBannersImage/' . $logo->image); ?>" alt="Logo" height="45">
                </a>
            <?php else: ?>
                <a class="navbar-brand" href="#">
                    <img src="<?php echo base_url('public/banners/logo1.jpg'); ?>" alt="Logo" height="45">
                </a>
            <?php endif; ?>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="<?php echo site_url('/'); ?>">Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">
                                    Electronics <i class="bi bi-chevron-right ms-2"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Smartphones</a></li>
                                    <li><a class="dropdown-item" href="#">Laptops</a></li>
                                    <li><a class="dropdown-item" href="#">Accessories</a></li>
                                </ul>
                            </li>

                            <li class="dropdown-submenu">
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">
                                    Fashion <i class="bi bi-chevron-right ms-2"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Men's Wear</a></li>
                                    <li><a class="dropdown-item" href="#">Women's Wear</a></li>
                                    <li><a class="dropdown-item" href="#">Kids' Fashion</a></li>
                                </ul>
                            </li>

                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">All Categories</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#">About Us</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-lg-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle user_icon"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end w-auto" style="min-width: 200px;">
                            <li>
                                <h6 class="dropdown-header">User Account</h6>
                            </li>

                            <?php if ($this->session->userdata('logged_in')): ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo site_url('WebController/user_profile/' . $this->session->userdata('user_id')); ?>">
                                        <i class="bi bi-person-circle me-2"></i>
                                        <?php echo $this->session->userdata('user_name'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo site_url('WebController/logout'); ?>">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </a>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo site_url('WebController/login'); ?>">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo site_url('WebController/registration'); ?>">
                                        <i class="bi bi-person-plus me-2"></i>Register
                                    </a>
                                </li>
                            <?php endif; ?>

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="bi bi-question-circle me-2"></i>Help Center</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

   