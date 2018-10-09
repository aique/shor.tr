<?php

namespace App\Tests;

use App\Services\DeviceDetector;
use PHPUnit\Framework\TestCase;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;

class DeviceDetectorTest extends TestCase {

    private $deviceDetector;

    public function testIsMobile() {
        $mobileDetectorMock = $this->createDeviceDetectorMock(['isMobile'], [true]);
        $this->deviceDetector = new DeviceDetector($mobileDetectorMock);

        $this->assertEquals(DeviceDetector::MOBILE_DEVICE, $this->deviceDetector->getDevice());
    }

    public function testIsTablet() {
        $mobileDetectorMock = $this->createDeviceDetectorMock(['isMobile', 'isTablet'], [false, true]);
        $this->deviceDetector = new DeviceDetector($mobileDetectorMock);

        $this->assertEquals(DeviceDetector::TABLET_DEVICE, $this->deviceDetector->getDevice());
    }

    public function testIsDesktop() {
        $mobileDetectorMock = $this->createDeviceDetectorMock(['isMobile', 'isTablet'], [false, false]);
        $this->deviceDetector = new DeviceDetector($mobileDetectorMock);

        $this->assertEquals(DeviceDetector::DESKTOP_DEVICE, $this->deviceDetector->getDevice());
    }

    private function createDeviceDetectorMock(array $methods, array $values) {
        $mobileDetectorMock = $this->getMockBuilder(MobileDetector::class)
            ->setMethods($methods)
            ->getMock();

        $numMethods = count($methods);

        for ($i = 0 ; $i < $numMethods ; $i++) {
            $methodName = $methods[$i];
            $methodValue = $values[$i];

            $mobileDetectorMock
                ->expects($this->once())
                ->method($methodName)
                ->willReturn($methodValue);
        }

        return $mobileDetectorMock;
    }
}