<?php

$data = file_get_contents( 'https://rp5.ru/%D0%9F%D0%BE%D0%B3%D0%BE%D0%B4%D0%B0_%D0%B2_%D0%9B%D1%83%D1%86%D0%BA%D0%B5');
preg_match( '#(\<table id\=\"forecastTable\" class\=\"forecastTable\" style\=\"display\: table\;\"\>(.*)\<\/table\>)#', $data, $m );
echo $m[1];
