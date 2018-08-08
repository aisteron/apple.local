<?php

include 'catalog.php'; // функционал меню в сайдбаре и крошки


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Каталог</title>
	<link rel="stylesheet" href="style.css">
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
			

			<!-- пагинация */-->
			<div class="pagination">
				<?=$pagination?>
			</div>

			<?php
			// вывод товаров
			if($products)
			{
				foreach ($products as $product) {
					echo '<a href="?product='.$product["id"].'">'.$product["title"].'</a><br>';
				}

			} else 
			{
				echo '<p>Товаров не найдено</p>';
			}
			
			?>
		</div>
	</div>

<div class="footer-scripts">
	<script src="js/jquery-1.9.0.min.js"></script>
	<script src="js/jquery.accordion.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<script>
		$(document).ready(function(){
			$('.category').dcAccordion();
		});
	</script>
</div>	
	
</body>
</html>