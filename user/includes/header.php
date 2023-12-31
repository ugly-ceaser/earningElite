<?php



session_start();

include("../scripts/functions.php");



 if(!isset($_SESSION['id'])){
  
  header('Location: ../login.php');

}


$user_id = $_SESSION['id'];

if(isset($_SESSION['vendor'])){

  header('Location: ./vendor.php');

}



$userDetalis = getUserDetails($user_id  ,"user_id") ;

$userAccountDetails = UserAccountDetails($user_id ,"user_id");




?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Earnining Elite</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/logo.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="row p-0 m-0 proBanner" id="proBanner">
        <div class="col-md-12 p-0 m-0">
          
        </div>
      </div>
      <!-- partial:partials/_navbar.php -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="index.php"><img src="assets/images/logo.png" alt="logo" /></a>
          <a class="navbar-brand brand-logo-mini" href="index.php"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
              </div>
            </form>
          </div>
          <ul class="navbar-nav navbar-nav-right">

          


            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="assets/images/faces/face1.jpg" alt="image">
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black"><?=$userDetalis['fullname'] ?></p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
              </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>
         
          
          
           
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.php -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
              <li class="nav-item nav-profile">
                <a href="#" class="nav-link">
                  <div class="nav-profile-image">
                    <img src="assets/images/faces/face1.jpg" alt="profile">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                  </div>
                  <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2"><?=$userDetalis['fullname'] ?></span>
                    <span class="text-secondary text-small">User</span>
                  </div>
                  <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                </a>
              </li>
              <?php 
                 if(isset($_SESSION['vendor'])){?>

                    <li class="nav-item">
                    <a class="nav-link" href="./vendor.php">
                      <span class="menu-title">Dashboard</span>
                      <i class="mdi mdi-home menu-icon"></i>
                    </a>
                  </li>

                <?php }else{ ?>

                    <li class="nav-item">
                <a class="nav-link" href="./index.php">
                  <span class="menu-title">Dashboard</span>
                  <i class="mdi mdi-home menu-icon"></i>
                </a>
              </li>

               <?php  }
                 ?>
              
         
            
              <li class="nav-item">
                <a class="nav-link" href="./profile.php">
                  <span class="menu-title">User Profile</span>
                  <i class="mdi mdi-contacts menu-icon"></i>
                </a>
              </li>
  
              <li class="nav-item">
                <a class="nav-link" href="./withdrawal.php">
                  <span class="menu-title">Withdraw</span>
                  <i class="mdi mdi-contacts menu-icon"></i>
                </a>
              </li>
             
              <li class="nav-item" id="refLink">
                <a class="nav-link" href="#">
                  <span class="menu-title">Copy Referal Link</span>
                  <i class="mdi mdi-chart-bar menu-icon"></i>
                </a>
              </li>
              
              
            </ul>
          </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span>User | Dashboard | Profile
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Referal link : https://earninglite.com/signup.php?ref=<?=$userDetalis['referal_code'] ?> <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
            </div>