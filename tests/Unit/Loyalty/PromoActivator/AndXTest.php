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
     * @param bool $exceptedResult
     * @dataProvider getData
     */
    public function test(array $promoActivators, bool $exceptedResult)
    {
        $promoActivator = new AndX($promoActivators);
        $result = $promoActivator->isSatisfiedFor(
            $this->prophesize(OrderDTO::class)->reveal()
        );

        $this->assertEquals($exceptedResult, $result);
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

    private function buildPromoActivator(bool $exceptedResult)
    {
        $promoActivator = $this->prophesize(PromoActivator::class);
        $promoActivator->isSatisfiedFor(Argument::type(OrderDTO::class))->willReturn($exceptedResult);
        return $promoActivator->reveal();
    }
}
