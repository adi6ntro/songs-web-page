<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<html>
	<head>
	<meta charset="utf-8">
   <title>Music Libery App</title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
   <!-- Favicons -->
   <link rel="apple-touch-icon" href="<?php echo base_url();?>assets/img/favicons/apple-touch-icon.png" sizes="180x180">
   <link rel="icon" href="<?php echo base_url();?>assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
   <link rel="icon" href="<?php echo base_url();?>assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/plugin/animate.min.css">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/fontawsome.css">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/responsive.css">
   <!-- this is for mordanizar js link -->
   <script src="<?php echo base_url();?>assets/js/vendor/modernizr-3.6.0.min.js"></script>
	</head>
	<body>
	testing new page
	<?php foreach($picture as $row){
		if($row->picture != ""){
			$pic = explode("|",$row->picture);
			?>
			<p><?php echo $row->song; ?></p>

			<?php if (strpos($pic[1], 'http') !== false) { ?>
			<img src="<?php echo $pic[1]; ?>" alt="<?php echo $pic[0];?>">
			<?php } else { ?>
				<img src="<?php echo base_url().'/assets/img/'.$pic[1]; ?>" alt="<?php echo $pic[0];?>">
			<?php } ?>
			<br/><hr>
	<?php
		}else{?>	
			<img src="#" alt="Image">
	<?php	}
	} ?>
	</body>
</html>
