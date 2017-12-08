<?php

namespace SilverStripe\Addons\Services\Rating;

/**
 * The Calculator class takes the number of points given for a module and converts it into a relative score out
 * of 100
 */
class Calculator
{
    /**
     * @var int
     */
    protected $maxPoints = 0;

    public function calculate($totalPoints)
    {
        return ceil(($totalPoints / $this->getMaxPoints()) * 100);
    }

    /**
     * Calculate the maximum number of check points a module could possibly receive by loading a check suite,
     * mocking a successful result and getting the points from every check
     *
     * @return int
     */
    public function getMaxPoints()
    {
        if (!$this->maxPoints) {
            $suite = new CheckSuite;
            foreach ($suite->getChecks() as $check) {
                $check->setSuccessful(true);
                $this->maxPoints += $check->getPoints();
            }
        }
        return $this->maxPoints;
    }
}
