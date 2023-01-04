
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>PCILLP APP</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?php echo base_url('/assets/css/styles.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('/assets/css/style1.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('/assets/css/custom.css') ?>" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url('/assets/js/select2-4.1.0-rc.0/dist/css/select2.min.css') ?>" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <script src="<?php echo base_url('/assets/js/select2-4.1.0-rc.0/dist/js/select2.min.js') ?>"></script>
    <script src="<?php echo base_url('/assets/js/scripts.js'); ?>"></script>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <?php if (!(isset($excludeNavigation) && !empty($excludeNavigation) && $excludeNavigation == 'YES')) {$this->load->view("theme/side_bar");}?>
        <div id="page-content-wrapper">
            <?php if (!(isset($excludeNavigation) && !empty($excludeNavigation) && $excludeNavigation == 'YES')) {$this->load->view("theme/top_navigation");}?>

