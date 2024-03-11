<?php

namespace App;

use PHPUnit\Framework\TestCase;

/**
 * @todo запрограммировать контроль Exception
 */
class TechnicalLiquidTest extends TestCase
{
    protected $fixture;

    public function providerGetWeight()
    {
        return [
            [0.5, 4, 2],
            [1, null, false],
            [true, '3', '4'],
            [[], 5, []]
        ];
    }

    protected function setUp(): void
    {
        $this->fixture = new TechnicalLiquid();
    }

    protected function tearDown(): void
    {
        $this->fixture = null;
    }

    /**
     * @dataProvider providerGetWeight
     */
    public function testGetWeight($den, $vol, $expectedWeight)
    {
        $this->fixture->setDensity($den)->setVolume($vol);
        $this->assertEquals($expectedWeight, $this->fixture->getWeight());
    }
}
