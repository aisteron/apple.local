<?php

include 'catalog.php'; // функционал меню в сайдбаре и крошки


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Каталог</title>
	<link rel="stylesheet" href="<?=PATH?>style.css">
</head>
<body>
	<div class="wrapper">

		<div class="sidebar">
			<ul class='category'>
				<?php echo $categories_menu; ?>
			</ul>
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
	<script src="<?=PATH?>js/jquery-1.9.0.min.js"></script>
	<script src="<?=PATH?>js/jquery.accordion.js"></script>
	<script src="<?=PATH?>js/jquery.cookie.js"></script>
	<script>
		$(document).ready(function(){
			$('.category').dcAccordion();
		});
	</script>
</div>	
	
</body>
</html>