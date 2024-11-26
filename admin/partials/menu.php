<?php 
ob_start();

include('../config/constants.php');
include('login-check.php')

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>   

<!-- navbar start -->

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">12th Avenue Cafe</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex">
        <li class="nav-item">
          <a class="nav-link" href="index.php">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage_admin.php">ADMIN MANAGER</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage_category.php">CATEGORY</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage_foods.php">PRODUCTS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage_orders.php">ORDERS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="log.php">USERS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="charts.php">CHARTS</a>
        </li>
        <li class="nav-item ms-auto d-flex justify-content-end">
          <a class="nav-link btn text-white bg-danger px-3 rounded-0 justify-content-end" href="logout.php">LOG OUT</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- navbar end -->

<!--- Menu Section Start--->
<!--
<div class="menu text-center">
    <div class="wrapper">
        <ul>
            <li><a href="index.php">HOME</a></li>
            <li><a href="manage_admin.php">ADMIN MANAGER</a></li>
            <li><a href="manage_category.php">CATEGORY</a></li>
            <li><a href="manage_foods.php">PRODUCTS</a></li>
            <li><a href="manage_orders.php">ORDERS</a></li>
            <li><a href="log.php">USERS</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>
-->
<!--- Menu Section End--->