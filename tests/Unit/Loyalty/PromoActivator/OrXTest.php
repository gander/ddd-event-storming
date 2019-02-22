<?php

namespace Tests\App\Loyalty\PromoActivator;

use App\Loyalty\OrderDTO;
use App\Loyalty\PromoActivator;
use App\Loyalty\PromoActivator\AndX;
use App\Loyalty\PromoActivator\OrX;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class OrXTest extends TestCase
{

    /**
     * @param array $promoActivators
     * @param bool $exceptedResult
     * @dataProvider getData
     */
    public function test(array $promoActivators, bool $exceptedResult)
    {
        $promoActivator = new OrX($promoActivators);
        $result = $promoActivator->isSatisfiedFor(
            $this->prophesize(OrderDTO::class)->reveal()
        );

        $this->assertEquals($exceptedResult, $result);
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

    private function buildPromoActivator(bool $exceptedResult)
    {
        $promoActivator = $this->prophesize(PromoActivator::class);
        $promoActivator->isSatisfiedFor(Argument::type(OrderDTO::class))->willReturn($exceptedResult);
        return $promoActivator->reveal();
    }
}
