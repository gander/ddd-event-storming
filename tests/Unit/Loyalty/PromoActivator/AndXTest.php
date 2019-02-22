<?php

namespace Tests\App\Loyalty\PromoActivator;

use App\Loyalty\OrderDTO;
use App\Loyalty\PromoActivator;
use App\Loyalty\PromoActivator\AndX;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class AndXTest extends TestCase
{
    /**
     * @param array $promoActivators
     * @param bool $expectedResult
     * @dataProvider getData
     */
    public function test(array $promoActivators, bool $expectedResult)
    {
        $promoActivator = new AndX($promoActivators);

        $result = $promoActivator->isSatisfiedFor($this->prophesize(OrderDTO::class)->reveal());

        $this->assertEquals($expectedResult, $result);
    }

    public function getData()
    {
        return [
            [[$this->buildPromoActivator(false), $this->buildPromoActivator(false)], false],
            [[$this->buildPromoActivator(true), $this->buildPromoActivator(false)], false],
            [[$this->buildPromoActivator(false), $this->buildPromoActivator(true)], false],
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