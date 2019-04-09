<?php

namespace DeviceDetectorNet;

use DeviceDetector\Parser\Client\Browser;
use DeviceDetector\Parser\Client\Browser\Engine;
use DeviceDetector\Parser\Client\FeedReader;
use DeviceDetector\Parser\Client\Library;
use DeviceDetector\Parser\Client\MediaPlayer;
use DeviceDetector\Parser\Client\MobileApp;
use DeviceDetector\Parser\Client\PIM;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use DeviceDetector\Parser\OperatingSystem;
use Spyc;

require_once '../vendor/autoload.php';

$config = parse_ini_file("../config.ini");


if ($config["debug"]) {
    header('Access-Control-Allow-Origin: *');
}


$cacheloader = new CacheLoader();


$item = $cacheloader->cache->getItem("supported");

if ($item->isHit() and false) {
    $data = $item->get();
} else {

    $bots = [];
    $ymlParser = new Spyc();
    $parsedBots = $ymlParser->loadFile(__DIR__ . '/../vendor/piwik/device-detector/regexes/bots.yml');
    foreach ($parsedBots as $parsedBot) {
        $bots[] = $parsedBot['name'];
    }

    function get_values(array $dict) {
        natsort($dict);
        $values = array_values($dict);
        return $values;
    }


    $data = [
        "operatingSystems" => get_values(OperatingSystem::getAvailableOperatingSystems()),
        "browsers" => get_values(Browser::getAvailableBrowsers()),
        "engines" => get_values(Engine::getAvailableEngines()),
        "libraries" => get_values(Library::getAvailableClients()),
        "mediaPlayer" => get_values(MediaPlayer::getAvailableClients()),
        "mobileApps" => get_values(MobileApp::getAvailableClients()),
        "PIM" => get_values(PIM::getAvailableClients()),
        "feedReaders" => get_values(FeedReader::getAvailableClients()),
        "brands" => get_values(DeviceParserAbstract::$deviceBrands),
        "bots" => get_values($bots)


    ];


    $item->set($data);
    $item->expiresAfter(60 * 60 * 24);
    $cacheloader->cache->save($item);
}


header("Content-Type: application/json; charset=UTF-8");
echo json_encode($data);

