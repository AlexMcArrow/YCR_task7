<?php

namespace Darts\Сircular;

class PointCounter
{
    private $radiuses = [
        1 => 10,
        5 => 5,
        10 => 1
    ];

    public function set_radius_point(array $circles_radiuses_point): void
    {
        $newradiuses = [];
        foreach ($circles_radiuses_point as $rad => $point) {
            if (!is_int($rad) && !is_float($rad) && !is_int($point) && !is_float($point)) {
                throw new \Exception("Error radius and point must contain only integer or float");
            }
            $newradiuses[$rad] = $point;
        }
        $this->radiuses = $newradiuses;
    }

    public function get_radius(): array
    {
        return $this->radiuses;
    }

    public function __invoke(float $x, float $y): int
    {
        foreach ($this->radiuses as $rad => $point) {
            if ($this->_check_dart_placed_in_circle($rad, $x, $y)) {
                return $point;
            }
        }
        return 0;
    }

    private function _check_dart_placed_in_circle(float $r, float $x, float $y): bool
    {
        return (pow($x, 2) + pow($y, 2)) <= pow($r, 2);
    }
}
