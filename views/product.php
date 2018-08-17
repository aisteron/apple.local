<?php defined("DIRECT_ACCESS") or die('Access denied');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Каталог</title>
	<link rel="stylesheet" href="<?=PATH?>views/style.css">
</head>
<body>
	<div class="wrapper">

		<div class="sidebar">
			<?php include 'sidebar.php';?>
		</div>
		<div class="content">
			
			<p class="breadcrumb-string"><?=$breadcrumbs; ?></p>
			<hr>

		<?php 
			if($get_one_product)
			{
				print_arr($get_one_product);
			}
			else 
			{
				echo '<p>Такого товара не существует</p>';
			}
		?>
		</div>
	</div>

<div class="footer-scripts">
	<script src="<?=PATH?>views/js/jquery-1.9.0.min.js"></script>
	<script src="<?=PATH?>views/js/jquery.accordion.js"></script>
	<script src="<?=PATH?>views/js/jquery.cookie.js"></script>
	<script>
		$(document).ready(function(){
			$('.category').dcAccordion();
		});
	</script>
</div>	
	
</body>
</html>