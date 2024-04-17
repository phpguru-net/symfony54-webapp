<?php

namespace App\Tests\Service;

use App\Service\CalculatorService;
use PHPUnit\Framework\TestCase;

class CalculatorServiceTest extends TestCase
{
    private $calculator;

    protected function setUp(): void
    {
        $this->calculator = new CalculatorService();
    }

    public function testSumPositiveNumbers()
    {
        $result = $this->calculator->sum(1, 2, 3, 4, 5);
        $this->assertEquals(15, $result);
    }

    public function testSumNegativeNumbers()
    {
        $result = $this->calculator->sum(-1, -2, -3, -4, -5);
        $this->assertEquals(-15, $result);
    }

    public function testSumMixedNumbers()
    {
        $result = $this->calculator->sum(-1, 2, -3, 4, -5, 6);
        $this->assertEquals(3, $result);
    }

    public function testSumWithNoArguments()
    {
        $result = $this->calculator->sum();
        $this->assertEquals(0, $result);
    }

    protected function tearDown(): void
    {
        $this->calculator = null;
    }
}
