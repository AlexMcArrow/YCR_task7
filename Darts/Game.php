<?php

namespace Darts;

class Game
{
    private $players = [];

    private $drop_limit = 5;

    private $point_counter;

    function __construct(callable $point_counter)
    {
        $this->point_counter = $point_counter;
    }

    public function set_drop_limit(int $limit): void
    {
        $this->drop_limit = $limit;
    }

    public function join_player(string $player_name): void
    {
        $this->players[$this->_player_name_hash($player_name)] = new Player($player_name, $this->point_counter);
    }

    public function drop_dart(string $player_name, float $x, float $y): bool
    {
        if ($this->players[$this->_player_name_hash($player_name)]->get_drops_count() >= $this->drop_limit) {
            return false;
        }
        $this->players[$this->_player_name_hash($player_name)]->drop_dart($x, $y);
        return true;
    }

    public function is_game_end(): bool
    {
        foreach ($this->players as $player_class) {
            if ($player_class->get_drops_count() < $this->drop_limit) {
                return false;
            }
        }
        return true;
    }

    public function who_need_drop(): bool|string
    {
        foreach ($this->players as $player_class) {
            if ($player_class->get_drops_count() < $this->drop_limit) {
                return $player_class->get_name();
            }
        }
        return false;
    }

    public function get_result(): bool|array
    {
        $leader_board = [];
        if (!$this->is_game_end()) {
            return false;
        }
        foreach ($this->players as $player_class) {
            $leader_board[$player_class->get_name()] = $player_class->get_points();
        }
        arsort($leader_board, SORT_NUMERIC);
        return array_slice($leader_board, 0, 3);;
    }

    public function get_tech_result(): bool|array
    {
        $leader_board = [];
        if (!$this->is_game_end()) {
            return false;
        }
        foreach ($this->players as $player_class) {
            $leader_board[$player_class->get_name()] = $player_class->get_drops();
        }
        return $leader_board;
    }

    private function _player_name_hash(string $player_name): string
    {
        return hash('sha1', mb_strtolower(trim($player_name)));
    }
}
