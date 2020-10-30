<?php

namespace DeviceDetectorNet;

require_once "./vendor/autoload.php";
$dir = "vendor/matomo/device-detector/Tests/fixtures/";

$testfiles = scandir($dir);

foreach ($testfiles as $testfile) {
    if ($testfile == "." || $testfile == "..") {
        continue;
    }
    $ymlParser = new \Spyc();
    $userAgentList = $ymlParser->loadFile($dir . $testfile);
    echo "$testfile\n";
    $i = 0;
    foreach ($userAgentList as $group) {
        $i++;
        $ua = $group["user_agent"];
        if ($i % 100 == 0) {
            echo "$i\n";
        }
        $ua = urlencode($ua);
        $ch = curl_init("http://localhost:9000/ua.php?ua=$ua");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        @curl_setopt($ch, CURLOPT_HEADER, true);
//        @curl_setopt($ch, CURLOPT_NOBODY, true);
        $response = curl_exec($ch);
        json_decode($response);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpcode != 200) { // for now only check if there is a error
            echo "error:\n";
            echo "$httpcode\n";
            echo "$ua\n";
            die(1);
        }
        curl_close($ch);
    }

}
