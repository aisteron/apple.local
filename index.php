<?php
error_reporting(E_ALL);
define('DIRECT_ACCESS', TRUE);
include 'config.php';
include 'functions.php';

$id = null;

// функция роутинга (маршрутизации)
// путь к скрипту без имени домена

$url = $_SERVER['REQUEST_URI'];

$routes = array(

	array('url' => '#\/$|\?#', 'view' => 'category'),
	array('url' => '#product/(?P<product_alias>[a-z0-9-]+)#i', 'view' => 'product'),
	array('url' => '#category/(?P<id>\d+)#', 'view' => 'category'),
	
);


foreach ($routes as $route) {
	if(preg_match($route['url'], $url, $match))
	{
		$view = $route['view'];

		break;

	}
}


if(empty($match))
{
	include 'views/404.php';
	exit;
}

extract($match);

// $id - ID категории
// $product_alias - alias продукта
// $view - вид для подключения



$categories = get_cat();
$categories_tree = map_tree($categories);
$categories_menu = categories_to_string($categories_tree);

// крошки и крошки для продукта

if(isset($product_alias))
{
	
	//$get_one_product = get_one_product($product_id); // массив данных продукта
	$get_one_product = get_one_product($product_alias); // массив данных продукта
	$id = $get_one_product['parent'];	// получаем ID категории

}



$breadcrumbs_array = breadcrumbs($categories, $id);
$breadcrumbs = null; // просто инициализация
// "линейный" массив $categories. функция лежит в function.php

// return true (array not empty) || return false

if($breadcrumbs_array)
{
	$breadcrumbs .= '<a href="'.PATH.'">Главная</a> / ';
	foreach ($breadcrumbs_array as $id => $title) {
		$breadcrumbs .= "<a href='".PATH."category/{$id}'>{$title}</a> / ";
	}
	if(!isset($get_one_product)) // когда идет обращение не к продукту, а к категории
	{
		$breadcrumbs = rtrim($breadcrumbs, " / ");
		$breadcrumbs = preg_replace("#(.+)?<a.+>(.+)</a>$#", "$1$2", $breadcrumbs);
	} else 
	{
		$breadcrumbs .= $get_one_product['title'];
	}
	
} else 
{
	$breadcrumbs .= '<a href="/">Главная</a>';
}

// все ID дочерних категорий

$ids = cats_id($categories, $id); // functions.php
$ids = !$ids ? $id : rtrim($ids, ',');

//$products = get_products($ids);

/*
*
*	ПАГИНАЦИЯ
*
*/


// кол-во товаров на страницу

$perpage = (isset($_COOKIE['perpage']) && (int)$_COOKIE['perpage']) ? (int)$_COOKIE['perpage'] : PERPAGE;

// общее кол-во товаров

$count_goods = count_goods($ids);

// расчет кол-ва страниц

$count_pages = ceil($count_goods / $perpage);

// минимум 1 страница, при кол-ве товаров 0
if(!$count_pages) $count_pages = 1;

//номер запрошенной страницы из массива GET

if(isset($_GET['page']))
{
	$page = (int)$_GET['page'];
	if($page < 1) $page = 1;
	// если запрош. страница больше кол-ва страниц
	if($page > $count_pages) $page = $count_pages;
} else 
{
	$page = 1;
}


// начальная позиция для запроса

$start_pos = ($page - 1) * $perpage;
$pagination = pagination($page, $count_pages);

$products = get_products($ids, $start_pos, $perpage);

// Получение отдельного товара

function get_one_product($product_alias)
{
	global $connection;
	$product_alias = mysqli_real_escape_string($connection, $product_alias);
	$query = "SELECT * FROM products WHERE alias = '$product_alias'";
	//exit($query);
	$res = mysqli_query($connection, $query);

 	return mysqli_fetch_assoc($res);

}

include 'views/'.$view.'.php';
