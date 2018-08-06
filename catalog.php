<?php

include 'config.php';
include 'functions.php';

$categories = get_cat();
$categories_tree = map_tree($categories);
$categories_menu = categories_to_string($categories_tree);


// крошки

if(isset($_GET['category'])){

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
}