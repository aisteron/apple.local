<?php

include 'config.php';
include 'functions.php';

$categories = get_cat();
$categories_tree = map_tree($categories);
$categories_menu = categories_to_string($categories_tree);


// крошки

$id = (int)$_GET['category'];

$breadcrumbs_array = breadcrumbs($categories, $id); 
// "линейный" массив $categories. функция лежит в function.php

// return true (array not empty) || return false

if($breadcrumbs_array)
{
	$breadcrumbs .= '<a href="/">Главная</a> / ';
	foreach ($breadcrumbs_array as $id => $title) {
		$breadcrumbs .= "<a href='?category={$id}'>{$title}</a> / ";
	}
	$breadcrumbs = rtrim($breadcrumbs, " / ");
	$breadcrumbs = preg_replace("#(.+)?<a.+>(.+)</a>$#", "$1$2", $breadcrumbs);
} else 
{
	$breadcrumbs .= '<a href="/">Главная</a> / 404 not found';
}

// все ID дочерних категорий

$ids = cats_id($categories, $id); // functions.php
$ids = !$ids ? $id : rtrim($ids, ',');

//$products = get_products($ids);

// пагинация

// кол-во товаров на страницу

$perpage = 5;

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
