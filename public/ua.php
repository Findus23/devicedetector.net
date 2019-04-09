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
$data = [];
$data["isBot"] = $dd->isBot();
if ($dd->isBot()) {
    $data["botInfo"] = $dd->getBot();
} else {
    $data["clientInfo"] = $dd->getClient();
    $data["osInfo"] = $dd->getOs();
    $data["deviceName"] = $dd->getDeviceName();
    $data["deviceBrand"] = $dd->getBrandName();
    $data["model"] = $dd->getModel();
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($data);

