<?php


namespace DeviceDetectorNet;


use DeviceDetector\DeviceDetector;

class IconPath {
    private $dd;

    public function __construct(DeviceDetector $dd) {
        $this->dd = $dd;
    }

}