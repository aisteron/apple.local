<?php
defined("DIRECT_ACCESS") or die('Access denied');
// Получение массива категорий

function get_cat()
{
	global $connection;
	$query = "SELECT * FROM categories";
	$res = mysqli_query($connection, $query);

	$arr_car = array();

	while($row = mysqli_fetch_assoc($res))
	{
		$arr_cat[$row['id']] = $row;
	}

	return $arr_cat;
}

//функция распечатки массива

function print_arr($array)
{
	echo '<pre>'.print_r($array, true).'</pre>';
}


/**
* Построение дерева
**/

function map_tree($dataset) {
	$tree = array();

	foreach ($dataset as $id=>&$node) {    
		if (!$node['parent']){
			$tree[$id] = &$node;
		}else{ 
            $dataset[$node['parent']]['childs'][$id] = &$node;
		}
	}

	return $tree;
}

// Дерево в строку HTML-кода

function categories_to_string($data)
{
	$data = $data;
	$string = null; // просто инициализируем переменную
	foreach($data as $item)
	{
		$string .= categories_to_template($item);
	}
	return $string;
}

// Шаблон вывода категорий

function categories_to_template($category)
{
	ob_start();
	include 'views/category_template.php';
	return ob_get_clean();
}



// Постраничная навигация

function pagination ($page, $count_pages, $modrew = true)
{
	// $modrew - флаг включения ЧПУ

	// << < 3 4 5 6 7 > >>
	// $back - ссылка НАЗАД
	// $forward - ссылка ВПЕРЕД
	// $start_page - ссылка В НАЧАЛО
	// $end_page - ссылка В КОНЕЦ
	// $page2left - вторая страница слева
	// $page1left - первая страница слева
	// $page2right - вторая страница справа
	// $page1right - первая страница справа
	$back = $forward = $start_page = $end_page = $page2left = $page1left = $page2right = $page1right = null;// просто инициализация
	$uri = '?';

	if(!$modrew)
	{
		// если есть параметры в запросе (адресной строке)
		if($_SERVER['QUERY_STRING'])
		{
			foreach ($_GET as $key => $value) {
				//echo "$key => $value <br>";
				if($key !='page')
				{
					$uri .= "{$key}={$value}&";
				}
			}
		}
	} else 
	{
		$url = $_SERVER['REQUEST_URI'];
		$url = explode('?', $url);
		//print_arr($url);
		if(isset($url[1]) &&$url[1] != '')
		{
			$params = explode("&", $url[1]);
			foreach ($params as $param) {
				if(!preg_match('#page#', $param)) $uri .= "{$param}&amp;";
			}

		}

	}
	

	if($page > 1) $back = "<a href='{$uri}page=".($page-1)."'>&lt;</a> ";

	if($page < $count_pages) $forward = " <a href='{$uri}page=".($page+1)."'>&gt;</a> ";
	
	if($page > 3) $start_page = "<a href='{$uri}page=1'>&lt;&lt;</a> ";

	if($page < ($count_pages - 2)) $end_page = " <a href='{$uri}page={$count_pages}'>&gt;&gt;</a> ";

	if($page - 2 > 0 ) $page2left = " <a href='{$uri}page=".($page-2)."'>".($page-2)."</a> ";
	
	if($page - 1 > 0 ) $page1left = " <a href='{$uri}page=".($page-1)."'>".($page-1)."</a> ";
	
	if($page + 1 <= $count_pages ) $page1right = " <a href='{$uri}page=".($page+1)."'>".($page+1)."</a> ";

	if($page + 2 <= $count_pages ) $page2right = " <a href='{$uri}page=".($page+2)."'>".($page+2)."</a> ";


	return $start_page.$back.$page2left.$page1left.$page.$page1right.$page2right.$forward.$end_page;
}



// крошки

function breadcrumbs($array, $id)
{

	if(!$id) return false;
	

	$breadcrumbs_array = array();
	
	for($i = 0; $i < count($array); $i++) {

		if(isset($array[$id]) && $array[$id])
		{
			$breadcrumbs_array[$array[$id]['id']] = $array[$id]['title'];
			$id = $array[$id]['parent'];
		} else break;
	}

	return array_reverse($breadcrumbs_array, true);
}


