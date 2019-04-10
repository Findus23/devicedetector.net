<?php

namespace DeviceDetectorNet;

require_once '../vendor/autoload.php';

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
$config = parse_ini_file("../config.ini");


if ($config["debug"]) {
    header('Access-Control-Allow-Origin: *');
}


// OPTIONAL: Set version truncation to none, so full versions will be returned
// By default only minor versions will be returned (e.g. X.Y)
// for other options see VERSION_TRUNCATION_* constants in DeviceParserAbstract class
DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);

$cacheloader = new CacheLoader();

if (!empty($_GET["ua"])) {
    $userAgent = $_GET["ua"];
} else {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
}


$dd = new DeviceDetector($userAgent);

$cacheloader->configureDeviceDetector($dd);
$dd->parse();
$icons = new IconPath($dd);
$data = [];
$data["isBot"] = $dd->isBot();
if ($dd->isBot()) {
    $data["botInfo"] = $dd->getBot();
} else {
    $data["clientInfo"] = $dd->getClient();
    $data["browserIcon"] = $icons->getBrowserLogo();
    $data["osInfo"] = $dd->getOs();
    $data["osIcon"] = $icons->getOsLogo();
    $data["device"] = $dd->getDevice();
    $data["deviceName"] = $dd->getDeviceName();
    $data["deviceIcon"] = $icons->getDeviceTypeLogo();
    $data["deviceBrand"] = $dd->getBrandName();
    $data["brandIcon"] = $icons->getBrandLogo();
    $data["model"] = $dd->getModel();
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($data);

