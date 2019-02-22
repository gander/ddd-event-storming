<?php

namespace Tests\App\Loyalty\PromoActivator;

use App\Loyalty\Email;
use App\Loyalty\OrderDTO;
use App\Loyalty\OrderHistoryProvider;
use App\Loyalty\PromoActivator\FirstOrder;
use PHPUnit\Framework\TestCase;

class FirstOrderTest extends TestCase
{
    public function test()
    {
        $email = $this->prophesize(Email::class)->reveal();

        $orderDTO = $this->prophesize(OrderDTO::class);
        $orderDTO->getCustomerEmail()->willReturn($email);
        $orderDTO = $orderDTO->reveal();

        $orderHistoryProvider = $this->prophesize(OrderHistoryProvider::class);
        $orderHistoryProvider->getOrdersCount($email)->willReturn(0);
        $orderHistoryProvider = $orderHistoryProvider->reveal();

        $promoActivation = new FirstOrder($orderHistoryProvider);

        $result = $promoActivation->isSatisfiedFor($orderDTO);

        $this->assertTrue($result);
    }

}
