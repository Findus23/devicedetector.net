<?php


namespace DeviceDetectorNet;


use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Client\Browser;
use DeviceDetector\Parser\OperatingSystem;

class IconPath {
    private $dd;
    private $iconDir = __DIR__ . "/../public";

    public function __construct(DeviceDetector $dd) {
        $this->dd = $dd;
    }

    /**
     * modified from plugins/DevicesDetection/functions.php:17
     * @return string
     */
    public function getBrandLogo() {
        $label = $this->dd->getBrandName();
        $path = '/icons/brand/%s.png';
        $label = preg_replace("/[^a-z0-9_-]+/i", "_", $label);
        if (!file_exists($this->iconDir . sprintf($path, $label))) {
            return null;
        }
        return sprintf($path, $label);
    }

    /**
     * from plugins/DevicesDetection/functions.php:27
     * @param $label
     * @return string
     * @throws \Exception
     */
    private function getBrowserFamilyFullName($label) {
        foreach (Browser::getAvailableBrowserFamilies() as $name => $family) {
            if (in_array($label, $family)) {
                return $name;
            }
        }
        throw new \Exception("TEST");
    }

    /**
     * modified from from plugins/DevicesDetection/functions.php:80
     * @return string
     * @throws \Exception
     */
    public function getBrowserLogo() {
        $client = $this->dd->getClient();
        if (empty($client["shortname"])) {
            return null;
        }
        $short = $this->dd->getClient()["short_name"];
        $path = '/icons/browsers/%s.png';


        $family = $this->getBrowserFamilyFullName($short);

        $browserFamilies = Browser::getAvailableBrowserFamilies();
        if (!empty($short) &&
            array_key_exists($short, Browser::getAvailableBrowsers()) &&
            file_exists($this->iconDir . sprintf($path, $short))) {

            return sprintf($path, $short);

        } elseif (!empty($short) &&
            array_key_exists($family, $browserFamilies) &&
            file_exists($this->iconDir . sprintf($path, $browserFamilies[$family][0]))) {

            return sprintf($path, $browserFamilies[$family][0]);
        }
        return null;
    }

    /**
     * modified from plugins/DevicesDetection/functions.php:153
     * @return string
     */
    public function getDeviceTypeLogo() {
        $label = $this->dd->getDeviceName();
        if (empty($label)) {
            return null;
        }
        $label = strtolower($label);
        $label = str_replace(' ', '_', $label);

        $path = '/icons/devices/' . $label . ".png";
        return $path;
    }

    /**
     * modified from plugins/DevicesDetection/functions.php:282
     * @return string
     */
    function getOsLogo() {
        $path = '/icons/os/%s.png';
        $client = $this->dd->getClient();
        if (empty($client["shortname"])) {
            return null;
        }
        $short = $client["short_name"];

        $family = OperatingSystem::getOsFamily($short);
        $osFamilies = OperatingSystem::getAvailableOperatingSystemFamilies();
//        print_r(sprintf($path, $short));
        if (!empty($short) &&
            array_key_exists($short, OperatingSystem::getAvailableOperatingSystems()) &&
            file_exists($this->iconDir . sprintf($path, $short))) {

            return sprintf($path, $short);

        } elseif (!empty($family) &&
            array_key_exists($family, $osFamilies) &&
            file_exists($this->iconDir . sprintf($path, $osFamilies[$family][0]))) {

            return sprintf($path, $osFamilies[$family][0]);
        }
        return null;
    }
}
