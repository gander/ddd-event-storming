<?php

namespace App\Loyalty\PointsCalculation;

use App\Loyalty\OrderDTO;
use App\Loyalty\Points;
use App\Loyalty\PointsCalculation;
use App\Loyalty\StandardPoints;

class Multiply implements PointsCalculation
{
    /**
     * @var int
     */
    private $multiply;

    /**
     * @param int $multiply
     */
    public function __construct(int $multiply)
    {
        $this->multiply = $multiply;
    }

    public function calculate(OrderDTO $orderDTO): Points
    {
        return new StandardPoints(round($orderDTO->getPrice()->getAmount() * $this->multiply));
    }

}
