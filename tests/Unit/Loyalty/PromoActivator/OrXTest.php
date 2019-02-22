<?php

namespace Tests\App\Loyalty\PromoActivator;

use App\Loyalty\OrderDTO;
use App\Loyalty\PromoActivator;
use App\Loyalty\PromoActivator\OrX;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class OrXTest extends TestCase
{
    /**
     * @param array $promoActivators
     * @param bool $expectedResult
     * @dataProvider getData
     */
    public function test(array $promoActivators, bool $expectedResult)
    {
        $promoActivator = new OrX($promoActivators);

        $result = $promoActivator->isSatisfiedFor($this->prophesize(OrderDTO::class)->reveal());

        $this->assertEquals($expectedResult, $result);
    }

    public function getData()
    {
        return [
            [[$this->buildPromoActivator(false), $this->buildPromoActivator(false)], false],
            [[$this->buildPromoActivator(true), $this->buildPromoActivator(false)], true],
            [[$this->buildPromoActivator(false), $this->buildPromoActivator(true)], true],
            [[$this->buildPromoActivator(true), $this->buildPromoActivator(true)], true],
        ];
    }

    private function buildPromoActivator(bool $expectedResult)
    {
        $promoActivator = $this->prophesize(PromoActivator::class);

        $promoActivator->isSatisfiedFor(Argument::type(OrderDTO::class))->willReturn($expectedResult);

        return $promoActivator->reveal();
    }

}