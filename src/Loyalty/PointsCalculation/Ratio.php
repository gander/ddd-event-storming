<?php

namespace App\Loyalty\PointsCalculation;

use App\Loyalty\OrderDTO;
use App\Loyalty\Points;
use App\Loyalty\PointsCalculation;
use App\Loyalty\StandardPoints;

class Ratio implements PointsCalculation
{
    /**
     * @var float
     */
    private $ratio;

    /**
     * @param float $ratio
     */
    public function __construct(float $ratio)
    {
        $this->ratio = $ratio;
    }


    public function calculate(OrderDTO $orderDTO): Points
    {
        return new StandardPoints(round($orderDTO->getPrice()->getAmount() * $this->ratio));
    }
}
