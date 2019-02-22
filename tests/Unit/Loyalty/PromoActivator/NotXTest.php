<?php

namespace Tests\App\Loyalty\PromoActivator;

use App\Loyalty\OrderDTO;
use App\Loyalty\PromoActivator;
use App\Loyalty\PromoActivator\NotX;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class NotXTest extends TestCase
{

    /**
     * @param PromoActivator $promoActivator
     * @param bool $exceptedResult
     * @dataProvider getData
     */
    public function test(PromoActivator $promoActivator, bool $exceptedResult)
    {
        $promoActivator = new NotX($promoActivator);
        $result = $promoActivator->isSatisfiedFor(
            $this->prophesize(OrderDTO::class)->reveal()
        );

        $this->assertEquals($exceptedResult, $result);
    }

    public function getData()
    {
        return [
            [$this->buildPromoActivator(false), true],
            [$this->buildPromoActivator(true), false],
        ];
    }

    private function buildPromoActivator(bool $exceptedResult)
    {
        $promoActivator = $this->prophesize(PromoActivator::class);
        $promoActivator->isSatisfiedFor(Argument::type(OrderDTO::class))->willReturn($exceptedResult);
        return $promoActivator->reveal();
    }
}
