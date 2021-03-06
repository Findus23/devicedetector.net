<?php

namespace DeviceDetectorNet;

require_once 'vendor/autoload.php';

system("composer update matomo/device-detector -q", $returnCode);

if ($returnCode) {
    die();
}

system("cd matomo-icons/ && git pull", $returncode);

if ($returnCode) {
    die();
}

$lockstring = file_get_contents("composer.lock");
$composerLock = json_decode($lockstring, true);

$key = array_search("matomo/device-detector", array_column($composerLock["packages"], 'name'));
$ddPackage = $composerLock["packages"][$key];

$commitHash = $ddPackage["source"]["reference"];
$currentDate = (new \DateTime())->format('c');

$version = [
    "commitHash" => $commitHash,
    "date" => $currentDate
];

file_put_contents("public/version.json", json_encode($version, JSON_PRETTY_PRINT));

$cacheLoader = new CacheLoader();
$cacheLoader->cache->clear();
echo "Cache cleared\n";
