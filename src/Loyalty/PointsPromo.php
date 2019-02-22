<?php

namespace App\Loyalty;

class PointsPromo
{
    /**
     * @var PointsCalculation
     */
    private $pointsCalculation;

    /**
     * @var PromoActivator
     */
    private $promoActivator;

    /**
     * PointsPromo constructor.
     * @param PointsCalculation $pointsCalculation
     * @param PromoActivator $promoActivator
     */
    public function __construct(PointsCalculation $pointsCalculation, PromoActivator $promoActivator)
    {
        $this->pointsCalculation = $pointsCalculation;
        $this->promoActivator = $promoActivator;
    }

    public function calculatePoints(OrderDTO $orderDTO): Points
    {
        if ($this->promoActivator->isSatisfiedFor($orderDTO)) {
            return $this->pointsCalculation->calculate($orderDTO);
        }

        return new StandardPoints(0);
    }
}