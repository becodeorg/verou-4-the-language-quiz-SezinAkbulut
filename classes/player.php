<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Player
{
    // TODO: add name and score
    private $name;
    private $score;

    public function __construct()
    {
        // TODO: add 👤 automatically to their name
        $this->name = "👤";
        $this->score = 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function increaseScore()
    {
        $this->score++;
        var_dump($this->score); // Debug statement
    }

    public function decreaseScore()
    {
        if ($this->score > 0) {
            $this->score--;
        }
    }

    public function resetScore()
    {
        $this->score = 0;
    }
}