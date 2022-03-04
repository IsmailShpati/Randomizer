<?php

$basePath = "/Randomizer/public";
$queryString = "/Randomizer/public/home/login";
$removedHome = str_replace($basePath, '', $queryString);
echo $removedHome . ' ; ORIGINAL: ' . $queryString;

$split = explode('/', trim(str_replace($basePath, '', $queryString), '/'));
var_dump(explode('/', trim(str_replace($basePath, '', $queryString), '/')));