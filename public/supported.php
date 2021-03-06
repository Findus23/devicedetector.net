<?php

namespace DeviceDetectorNet;

use DeviceDetector\Parser\Client\Browser;
use DeviceDetector\Parser\Client\Browser\Engine;
use DeviceDetector\Parser\Client\FeedReader;
use DeviceDetector\Parser\Client\Library;
use DeviceDetector\Parser\Client\MediaPlayer;
use DeviceDetector\Parser\Client\MobileApp;
use DeviceDetector\Parser\Client\PIM;
use DeviceDetector\Parser\Device\AbstractDeviceParser;
use DeviceDetector\Parser\OperatingSystem;
use Symfony\Component\Yaml\Yaml;

require_once '../vendor/autoload.php';

function get_values(array $dict): array
{
    natcasesort($dict);
    $values = array_values($dict);
    return $values;
}


$cacheloader = new CacheLoader();


$item = $cacheloader->cache->getItem("supported");

if ($item->isHit()) {
    $data = $item->get();
} else {
    $bots = [];
    $parsedBots = Yaml::parse(file_get_contents(__DIR__ . '/../vendor/matomo/device-detector/regexes/bots.yml'));
    foreach ($parsedBots as $parsedBot) {
        $bots[] = $parsedBot['name'];
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
        "brands" => get_values(AbstractDeviceParser::$deviceBrands),
        "bots" => get_values($bots)
    ];

    $item->set($data);
    $item->expiresAfter(60 * 60 * 24);
    $cacheloader->cache->save($item);
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($data);

