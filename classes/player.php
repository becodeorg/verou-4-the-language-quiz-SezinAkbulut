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
        $this->name = "";
        $this->score = 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function increaseScore()
    {
        $this->score++;
    }

    public function decreaseScore()
    {
        $this->score--;
    }

    public function resetScore()
    {
        $this->score = 0;
        $this->name = ""; // Reset player name
    }
}