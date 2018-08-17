<?php
defined("DIRECT_ACCESS") or die('Access denied');
include 'main_controller.php';
include "models/{$view}_model.php";

if( !isset($id) ) $id = null;

include 'libs/breadcrumbs.php';


// все ID дочерних категорий

$ids = cats_id($categories, $id); // functions.php
$ids = !$ids ? $id : rtrim($ids, ',');


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

// </ пагинация


$products = get_products($ids, $start_pos, $perpage);

include "views/{$view}.php";

