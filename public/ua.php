<?php

namespace DeviceDetectorNet;

require_once '../vendor/autoload.php';

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Client\Browser;
use DeviceDetector\Parser\Device\AbstractDeviceParser;
use DeviceDetector\Parser\OperatingSystem;
use DeviceDetector\Yaml\Symfony;

AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);

$cacheloader = new CacheLoader();

if (!empty($_GET["ua"])) {
    $userAgent = $_GET["ua"];
} else {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
}

if (strlen($userAgent) > 1000) {
    echo "The user agent has to be shorter than 1000 characters.";
    http_response_code(400);
    exit();
}

$dd = new DeviceDetector($userAgent);
$dd->setYamlParser(new Symfony());

$cacheloader->configureDeviceDetector($dd);
$dd->parse();
$icons = new IconPath($dd);
if ($dd->isBot()) {
    $data = [
        "isBot" => true,
        "botInfo" => $dd->getBot()
    ];
} else {
    $data = [
        "isBot" => false,
        "clientInfo" => $dd->getClient(),
        "browserFamily" => Browser::getBrowserFamily($dd->getClient('short_name')),
        "isMobileOnlyBrowser" => Browser::isMobileOnlyBrowser($dd->getClient('short_name')),
        "osInfo" => $dd->getOs(),
        "osFamily" => OperatingSystem::getOsFamily($dd->getOs('short_name')),
        "device" => $dd->getDevice(),
        "deviceName" => $dd->getDeviceName(),
        "deviceBrand" => [
            "name" => $dd->getBrandName(),
            "short_name" => $dd->getBrand()
        ],
        "model" => $dd->getModel(),
        "icons" => [
            "browser" => $icons->getBrowserLogo(),
            "os" => $icons->getOsLogo(),
            "device" => $icons->getDeviceTypeLogo(),
            "brand" => $icons->getBrandLogo()
        ]
    ];
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($data, JSON_FORCE_OBJECT);

