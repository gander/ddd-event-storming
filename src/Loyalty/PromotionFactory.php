<?php

namespace App\Loyalty;

use App\Loyalty\PointsCalculation\Fixed;
use App\Loyalty\PointsCalculation\Ratio;
use App\Loyalty\PromoActivator\OrderPriceGreaterThan;
use Money\Money;

class PromotionFactory
{
    public function buildForCustomer(Email $email)
    {
        $promotions = [
            new PointsPromo(
                new Fixed(new StandardPoints(10)),
                new OrderPriceGreaterThan(Money::PLN(100))
            ),
            new PointsPromo(
                new Ratio(0.5),
                new OrderPriceGreaterThan(Money::PLN(200))
            ),
        ];

//        if ($emailFromMoleo) {
//
//        }
//
//        if ($blackFriday) {
//
//        }

        return $promotions;
    }
}