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
        }

        .navbar-toggler {
            border: none;
            outline: none;
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

        .dropdown-submenu .dropdown-menu {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            margin-top: -8px;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }


        @media (max-width: 991px) {
            .navbar-collapse {
                text-align: right;
            }

            .dropdown-submenu .dropdown-menu {
                position: static;
                display: none;
                margin-left: 15px;
            }

            .dropdown-submenu .dropdown-item::after {
                content: "\25BC";
                float: right;
                font-size: 12px;
            }

            .user-menu {
                width: 100%;
                display: flex;
                justify-content: flex-end;
                margin-top: 10px;
            }
        }
        @media (max-width: 300px) {
            .navbar-collapse {
                text-align: right;
            }

            .dropdown-submenu .dropdown-menu {
                position: static;
                display: none;
                margin-left: 15px;
            }

            .dropdown-submenu .dropdown-item::after {
                content: "\25BC";
                float: right;
                font-size: 12px;
            }

            .user-menu {
                width: 100%;
                display: Column;
                justify-content: flex-end;
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-2">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="<?php echo base_url('public/banners/logo1.jpg'); ?>" alt="Logo" height="45">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-lg-end" id="navbarNav">
                <div class="collapse navbar-collapse justify-content-lg-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link px-3" href="<?php echo site_url('/'); ?>">Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link px-3 dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown">Categories</a>
                            <ul class="dropdown-menu p-3">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">Electronics</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Smartphones</a></li>
                                        <li><a class="dropdown-item" href="#">Laptops</a></li>
                                        <li><a class="dropdown-item" href="#">Accessories</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">Fashion</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Men's Wear</a></li>
                                        <li><a class="dropdown-item" href="#">Women's Wear</a></li>
                                        <li><a class="dropdown-item" href="#">Kids' Fashion</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">All Categories</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link px-3" href="#">Contact</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="#">About Us</a></li>
                    </ul>
                </div>
                <div class="dropdown ms-3 user-menu">
                    <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle user_icon"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <h6 class="dropdown-header">User Account</h6>
                        </li>
                        
                        <?php if ($this->session->userdata('logged_in')): ?>
                            <li><a class="dropdown-item" href="<?php echo site_url('WebController/user_profile/'.$this->session->userdata('user_id')); ?>"><i class="bi bi-person-circle me-2"></i>
                                <?php echo $this->session->userdata('user_name'); ?></a></li>
                            <li><a class="dropdown-item" href="<?php echo site_url('WebController/logout'); ?>">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="<?php echo site_url('WebController/login'); ?>">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login</a></li>
                            <li><a class="dropdown-item" href="<?php echo site_url('WebController/registration'); ?>">
                                <i class="bi bi-person-plus me-2"></i>Register</a></li>
                        <?php endif; ?>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-question-circle me-2"></i>Help Center</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </nav>