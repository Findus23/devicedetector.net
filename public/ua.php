<?php

namespace DeviceDetectorNet;

require_once '../vendor/autoload.php';

use DeviceDetector\ClientHints;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Client\Browser;
use DeviceDetector\Parser\Device\AbstractDeviceParser;
use DeviceDetector\Parser\OperatingSystem;
use DeviceDetector\Yaml\Symfony;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);

$cacheloader = new CacheLoader();

class CustomClientHints extends ClientHints
{
    public function toDict(): array
    {
        return [
            "architecture" => $this->architecture,
            "bitness" => $this->bitness,
            "mobile" => $this->mobile,
            "model" => $this->model,
            "platform" => $this->platform,
            "platformVersion" => $this->platformVersion,
            "uaFullVersion" => $this->uaFullVersion,
            "fullVersionList" => $this->fullVersionList,
        ];
    }

    public static function factory(array $headers): CustomClientHints
    {
        $ch = parent::factory($headers); // TODO: Change the autogenerated stub
        return new self(
            $ch->model,
            $ch->platform,
            $ch->platformVersion,
            $ch->uaFullVersion,
            $ch->fullVersionList,
            $ch->mobile,
            $ch->architecture,
            $ch->bitness
        );
    }

}

if (!empty($_GET["ua"])) {
    $userAgent = $_GET["ua"];
} else {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
}

if (!empty($_GET["ch"])) {
    $ch_string = $_GET["ch"];
    if (strpos($ch_string, "{") === 0) {
        $data = json_decode($_GET["ch"], true);
        unset($data['brands']);
        $clientHints = new CustomClientHints(...$data);
        $headers = NULL;
    } else {
        $lines = explode("\n", $_GET["ch"]);
        try {
            $trimmed = join("\n", array_map("trim", $lines));
            $headers = Yaml::parse($trimmed);
        } catch (ParseException  $e) {
            $headers = [];
            foreach ($lines as $line) {
                list($key, $value) = explode(":", $line, 2);
                $key = trim($key);
                $value = trim($value);
                if (substr($value, -1) == $value[0] and strtolower($key) != "sec-ch-ua") {
                    $value = trim($value, substr($value, -1));
                }
                $headers[$key] = $value;
            }
        }
        $clientHints = CustomClientHints::factory($headers);
    }
} else {
//    $clientHints = CustomClientHints::factory($_SERVER);
    $clientHints = new CustomClientHints();
    $headers = NULL;
}

//sec-ch-ua: "(Not(A:Brand";v="8", "Chromium";v="98"
//sec-ch-ua-mobile: ?0
//sec-ch-ua-platform: "Linux"

if (strlen($userAgent) > 1000) {
    echo "The user agent has to be shorter than 1000 characters.";
    http_response_code(400);
    exit();
}
$dd = new DeviceDetector($userAgent, $clientHints);
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
        ],
        "clientHints" => $clientHints->toDict(),
        "headers" => $headers
    ];
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($data, JSON_FORCE_OBJECT);

