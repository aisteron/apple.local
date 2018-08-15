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

			<div>
				<select name="perpage" id="perpage">
					<?php foreach ($option_perpage as $option): ?>
						<option value="<?=$option?>"
							<?php if ($perpage == $option) echo "selected";?> >
							<?=$option?></option>	
					<?php endforeach ?>
					
				</select>
			</div>			

			<!-- пагинация */-->
			<div class="pagination">
				<?=$pagination?>
			</div>

			<?php
			// вывод товаров
			if($products)
			{
				foreach ($products as $product) {
					echo '<a href="'.PATH.'product/'.$product["alias"].'">'.$product["title"].'</a><br>';
				}

			} else 
			{
				echo '<p>Товаров не найдено</p>';
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
			$('#perpage').change(function(){
				let perpage = $(this).val();
				$.cookie('perpage', perpage, {expires:1});
				window.location = location.href;
			})
		});
	</script>
</div>	
	
</body>
</html>