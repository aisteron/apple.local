<?php 
defined("DIRECT_ACCESS") or die('Access denied');
// крошки и крошки для продукта

$breadcrumbs_array = breadcrumbs($categories, $id);
$breadcrumbs = null; // просто инициализация


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

