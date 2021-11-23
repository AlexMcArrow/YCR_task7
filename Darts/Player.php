<?php

namespace Darts;

class Player
{
    private $name;

    private $point_counter;

    private $drops = [];

    private $points = 0;

    function __construct(string $name, callable $point_counter)
    {
        $this->name = $name;
        $this->point_counter = $point_counter;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function drop_dart(float $x, float $y): void
    {
        $point = call_user_func($this->point_counter, $x, $y);
        $this->drops[] = [
            'x' => $x,
            'y' => $y,
            'point' => $point
        ];
        $this->points = $this->points + $point;
    }

    public function get_drops_count(): int
    {
        return count($this->drops);
    }

    public function get_drops(): array
    {
        return $this->drops;
    }

    public function get_points(): int
    {
        return $this->points;
    }
}
