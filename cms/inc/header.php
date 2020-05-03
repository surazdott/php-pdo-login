<?php

/** 
 * @Package: Meropasal
 * @Author: SurajDott
 * @Date: 2018-11-21
*/

require $_SERVER['DOCUMENT_ROOT'].'/login/config/init.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo SITE_NAME; ?> | <?php echo (isset($page_title)) ? $page_title : 'Dashboard' // page name should be defined in to $page_tite otherwise it prints Admin as a default value ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo CMS_CSS; ?>bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo CMS_CSS; ?>font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo CMS_CSS; ?>nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo CMS_CSS; ?>animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo CMS_CSS; ?>custom.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?php echo CMS_JS; ?>jquery.min.js"></script>
  </head>

    <body class="<?php echo (getCurrentPage() == 'index' || getCurrentPage() == 'reset') ? 'login' : 'nav-md'; // index = page name, login and nav-md = css class name ?>">