<?php
require_once 'vendor/autoload.php';

use DeviceDetector\Cache\PSR16Bridge;
use DeviceDetector\Cache\PSR6Bridge;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Simple\FilesystemCache;

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');

// OPTIONAL: Set version truncation to none, so full versions will be returned
// By default only minor versions will be returned (e.g. X.Y)
// for other options see VERSION_TRUNCATION_* constants in DeviceParserAbstract class
DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);

$userAgent = $_GET["ua"];

//$userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse

$dd = new DeviceDetector($userAgent);

// OPTIONAL: Set caching method
// By default static cache is used, which works best within one php process (memory array caching)
// To cache across requests use caching in files or memcache
//$dd->setCache(new Doctrine\Common\Cache\PhpFileCache('./tmp/'));

//$cache = new FilesystemCache('device_detector', $ttl = 20,"tmp");
$redis = new Redis();
$redis->connect('127.0.0.1');
$redis->select(9);
$cache = new RedisAdapter($redis, 'device_detector_net');
//$deviceDetector = new DeviceDetector();
$dd->setCache(
    new PSR6Bridge($cache)
);


// OPTIONAL: Set custom yaml parser
// By default Spyc will be used for parsing yaml files. You can also use another yaml parser.
// You may need to implement the Yaml Parser facade if you want to use another parser than Spyc or [Symfony](https://github.com/symfony/yaml)
// $dd->setYamlParser(new DeviceDetector\Yaml\Symfony());

// OPTIONAL: If called, getBot() will only return true if a bot was detected  (speeds up detection a bit)
// $dd->discardBotInformation();

// OPTIONAL: If called, bot detection will completely be skipped (bots will be detected as regular devices then)
// $dd->skipBotDetection();

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
echo json_encode($data);

