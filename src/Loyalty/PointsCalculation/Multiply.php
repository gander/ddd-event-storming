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
    private $multiplier;

    /**
     * @var PointsCalculation
     */
    private $pointsCalculation;

    /**
     * Multiply constructor.
     * @param int $multiplier
     * @param PointsCalculation $pointsCalculation
     */
    public function __construct(int $multiplier, PointsCalculation $pointsCalculation)
    {
        $this->multiplier = $multiplier;
        $this->pointsCalculation = $pointsCalculation;
    }


    public function calculate(OrderDTO $orderDTO): Points
    {
        // gubi sie rodzaj klasy!
        return new StandardPoints($this->pointsCalculation->calculate($orderDTO)->getAmount() * $this->multiplier);
    }
}