<?php

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
    }

    public function resetScore()
    {
        $this->score = 0;
    }
}