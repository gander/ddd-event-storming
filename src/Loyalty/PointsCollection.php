<?php


namespace App\Loyalty;


class PointsCollection implements \Iterator
{
    /** @var Points[] */
    private $points = [];
    /**
     * @var Sorter
     */
    private $sorter;

    public function __construct(array $points, Sorter $sorter)
    {
        $this->points = array_values($points);
        $this->sorter = $sorter;
    }

    public function current()
    {
        return current($this->points);
    }

    public function next()
    {
        return next($this->points);
    }

    public function key()
    {
        return key($this->points);
    }

    public function valid()
    {
        return key($this->points) !== null;
    }

    public function rewind()
    {
        reset($this->points);
    }

    public function addPoints(Points $points)
    {
        $this->points[] = $points;
    }

    /**
     * @param Points $pointsToRemove
     */
    function subPoints($pointsToRemove)
    {

        $this->points = $this->sorter->sort($this->points);


//        $removedPoints = 0;
//        foreach ($this->points as $index => $points) {
//            if ($points->getAmount() <= $pointsToRemove->getAmount()) {
//                $removedPoints += $points->getAmount();
//                unset($this->points[$index]);
//            } else {
//                $this->points[$index] = $points->subPoints($pointsToRemove->getAmount() - $removedPoints);
//                break;
//            }
//
//            if ($removedPoints === $pointsToRemove->getAmount()) {
//                break;
//            }
//        }


        $amountToRemove = $pointsToRemove->getAmount();

        if ($amountToRemove > 0) {
            foreach ($this->points as $index => $points) {
                if ($points->getAmount() < $amountToRemove) {
                    $this->points[$index] = $points->subPoints($points->getAmount());
                    $amountToRemove -= $points->getAmount();
                } else {
                    $this->points[$index] = $points->subPoints($points->getAmount() - $amountToRemove);
                    break;
                }
            }
        }
    }
}
