<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quidlab FoQus Admin Panel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href=<?= assets('/assets/plugins/fontawesome-free/css/all.min.css') ?> />
  <!-- Toastr -->
  <link rel="stylesheet" href=<?= assets('/assets/plugins/toastr/toastr.min.css') ?> />
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= assets('/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= assets('/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= assets('/assets/plugins/jqvmap/jqvmap.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= assets('/assets/css/adminlte.min.css') ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href=<?= assets("/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css") ?> />
  <!-- Daterange picker -->
  <link rel="stylesheet" href=<?= assets("/assets/plugins/daterangepicker/daterangepicker.css") ?> />
  <!-- summernote -->
  <link rel="stylesheet" href=<?= assets("/assets/plugins/summernote/summernote-bs4.min.css") ?> />
  <!-- flag-icon-css -->
  <link rel="stylesheet" href=<?= assets("/assets/plugins/flag-icon-css/css/flag-icon.min.css") ?> />
  <!-- jsgrid-css -->
  <link rel="stylesheet" href=<?= assets("/assets/plugins/jsgrid/jsgrid.min.css") ?> />
  <link rel="stylesheet" href=<?= assets("/assets/plugins/jsgrid/jsgrid-theme.min.css") ?> />
  <link rel="stylesheet" href=<?= assets("/assets/plugins/bs-stepper/css/bs-stepper.min.css") ?> />



  <style>
    .hideoverflow {
      overflow: hidden;
    }
  </style>
  <style>
    .w-full {
      width: 100%;
    }

    .jsgrid-nodata-row .jsgrid-cell {
      color: red;
    }

    .cursor-pointer {
      cursor: pointer;
    }

    .w-max {
      width: max-content;
    }

    .btn-excel {
      background-color: #21a366;
      color: #fff;
      cursor: pointer;
    }

    .global-loading {
      position: fixed;
      z-index: 10000;
      inset: 0;
      top: 0px;
      width: max-content;
      top: 1rem;
      margin: auto;
      display: none;
    }

    .jsgrid-pager {
      padding: 1rem;
    }
  </style>
  <style>
    .row {
      display: flex;
    }

    .row>* {
      flex: 1;
    }

    .popup {
      position: fixed;
      inset: 0;
      background-color: #ffffff56;
      z-index: 10000;

    }

    .popup-body {
      display: flex;
      justify-content: center;
      margin-top: 10vh;
    }
  </style>
  <style>
    .upload-btn-wrapper {
      position: relative;
      overflow: hidden;
      display: inline-block;
    }

    .upload-btn-wrapper input[type=file] {
      font-size: 100px;
      position: absolute;
      left: 0;
      top: 0;
      opacity: 0;
    }

    .bar {
      grid-column: 1/3;
      margin: 10px 0 10px 0;
    }
  </style>
</head>