<?php

namespace App\Services;

use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;

class DeviceDetector
{
    const MOBILE_DEVICE = 'mobile';
    const TABLET_DEVICE = 'tablet';
    const DESKTOP_DEVICE = 'desktop';

    private $mobileDetector;

    public function __construct(MobileDetector $mobileDetector)
    {
        $this->mobileDetector = $mobileDetector;
    }

    public function getDevice() {
        if ($this->mobileDetector->isMobile()) {
            return self::MOBILE_DEVICE;
        } elseif ($this->mobileDetector->isTablet()) {
            return self::TABLET_DEVICE;
        }

        return self::DESKTOP_DEVICE;
    }
}