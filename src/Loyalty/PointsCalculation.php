<?php

namespace App\Loyalty;

interface PointsCalculation
{
    public function calculate(OrderDTO $orderDTO): Points;
}
