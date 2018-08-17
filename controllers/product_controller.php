<?php
defined("DIRECT_ACCESS") or die('Access denied');
include 'main_controller.php';
include "models/{$view}_model.php";


$get_one_product = get_one_product($product_alias); // массив данных продукта
$id = $get_one_product['parent'];	// получаем ID категории

include "libs/breadcrumbs.php";



include "views/{$view}.php";
