<?php

namespace App\Loyalty\PointsCalculation;

use App\Loyalty\OrderDTO;
use App\Loyalty\Points;
use App\Loyalty\PointsCalculation;

class Fixed implements PointsCalculation
{
    /**
     * @var Points
     */
    private $points;

    /**
     * @param Points $points
     */
    public function __construct(Points $points)
    {
        $this->points = $points;
    }

    public function calculate(OrderDTO $orderDTO): Points
    {
        return $this->points;
    }

}
