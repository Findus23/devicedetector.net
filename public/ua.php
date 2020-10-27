<?php

namespace DeviceDetectorNet;

require_once '../vendor/autoload.php';

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Client\Browser;
use DeviceDetector\Parser\Device\AbstractDeviceParser;
use DeviceDetector\Parser\OperatingSystem;
use DeviceDetector\Yaml\Symfony;

// OPTIONAL: Set version truncation to none, so full versions will be returned
// By default only minor versions will be returned (e.g. X.Y)
// for other options see VERSION_TRUNCATION_* constants in DeviceParserAbstract class
AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);

$cacheloader = new CacheLoader();

if (!empty($_GET["ua"])) {
    $userAgent = $_GET["ua"];
} else {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
}

if (strlen($userAgent) > 1000) {
    echo "The user agent has to be shorter than 1000 characters.";
    http_response_code(500);
    exit();
}

$dd = new DeviceDetector($userAgent);
$dd->setYamlParser(new Symfony());

$cacheloader->configureDeviceDetector($dd);
$dd->parse();
$icons = new IconPath($dd);
$data = [];
$data["isBot"] = $dd->isBot();
if ($dd->isBot()) {
    $data["botInfo"] = $dd->getBot();
} else {
    $data["clientInfo"] = $dd->getClient();
    $data["browserFamily"] = Browser::getBrowserFamily($dd->getClient('short_name'));
    $data["isMobileOnlyBrowser"] = Browser::isMobileOnlyBrowser($dd->getClient('short_name'));
    $data["osInfo"] = $dd->getOs();
    $data["osFamily"] = OperatingSystem::getOsFamily($dd->getOs('short_name'));
    $data["device"] = $dd->getDevice();
    $data["deviceName"] = $dd->getDeviceName();
    $data["deviceBrand"] = [
        "name" => $dd->getBrandName(),
        "short_name" => $dd->getBrand()
    ];
    $data["model"] = $dd->getModel();
    $data["icons"] = [
        "browser" => $icons->getBrowserLogo(),
        "os" => $icons->getOsLogo(),
        "device" => $icons->getDeviceTypeLogo(),
        "brand" => $icons->getBrandLogo()
    ];
}
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($data, JSON_FORCE_OBJECT);

