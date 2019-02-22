<?php

namespace Tests\App\Loyalty\PromoActivator;

use App\Loyalty\OrderDTO;
use App\Loyalty\PromoActivator\OrderPriceGreaterThan;
use Money\Money;
use PHPUnit\Framework\TestCase;

class OrderPriceGreaterThanTest extends TestCase
{
    /**
     * @param Money $limit
     * @param Money $orderPrice
     * @param bool $expectedResult
     *
     * @dataProvider getData
     */
    public function test(Money $limit, Money $orderPrice, bool $expectedResult)

    {
        // Arrange
        $promoActivator = new OrderPriceGreaterThan($limit);
        $orderDTO = $this->buildOrderDTO($orderPrice);

        // Act
        $result = $promoActivator->isSatisfiedFor($orderDTO);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }


    private function buildOrderDTO(Money $money)
    {
        $orderDTO = $this->prophesize(OrderDTO::class);
        $orderDTO->getPrice()->willReturn($money);
        return $orderDTO->reveal();
    }

    public function getData()
    {
        return [
            'greater than' => [Money::PLN(100), Money::PLN(150), true],
            'less than' => [Money::PLN(100), Money::PLN(50), false],
            'equals' => [Money::PLN(100), Money::PLN(100), false],
        ];
    }
}
