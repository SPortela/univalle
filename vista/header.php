<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keyword" content="CRM, Dashboard, Conjunto Digital, Bermudez">	
    <title><?php echo $title; ?></title>
    <?php recursos_css(); ?>
</head>
<body>
    <!--HEADER BEGIN-->
    <?php header_admin(); ?>
    <!--HEADER END-->
    <section id="container" class=""> 
        <!--pinta menu-->
        <?php getMenu($db); ?>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
			<section class="wrapper">
				<!--overview start-->