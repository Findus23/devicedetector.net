<?php

namespace DeviceDetectorNet;
//system("composer update");

$lockstring = file_get_contents("composer.lock");
$composerLock = json_decode($lockstring, true);

$key = array_search("piwik/device-detector", array_column($composerLock["packages"], 'name'));
$ddPackage = $composerLock["packages"][$key];

$commitHash = $ddPackage["source"]["reference"];
$currentDate =
    print_r($composerLock["packages"][$key]);

$cacheLoader = new CacheLoader();

$cacheLoader->cache->clear();
echo "Cache cleared";