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
	<script src="<?=PATH?>views/js/jquery-1.9.0.min.js"></script>
	<script src="<?=PATH?>views/js/jquery.accordion.js"></script>
	<script src="<?=PATH?>views/js/jquery.cookie.js"></script>
	<script>
		$(document).ready(function(){
			$('.category').dcAccordion();
			$('#perpage').change(function(){
				let perpage = $(this).val();
				$.cookie('perpage', perpage, {expires:1, path:'/'});
				window.location = location.href;
			})
		});
	</script>
</div>	
	
</body>
</html>