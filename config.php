<?php

define("DBHOST", "localhost");
define("DBPASS", "");
define("DBUSER", "root");
define("DB", "apple");
define("PATH", "http://apple.local/");
define("PERPAGE", 5);
$option_perpage = array(5,10,15);


$connection = @mysqli_connect(DBHOST, DBUSER, DBPASS, DB) or die('Ошибка соединения с БД');
mysqli_set_charset($connection, "utf8") or die('Не установлена кодировка соединения');

