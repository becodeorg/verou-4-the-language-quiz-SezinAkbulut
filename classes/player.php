<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Player
{
    // TODO: add name and score
    private $name;
    private $score;
    private $rightScore;
    private $wrongScore;

    public function __construct(string $name)
    {
        $this->name = '👤';
        $this->score = 0;
        $this->rightScore = 0;
        $this->wrongScore = 0;
    }


    public function getName(): string
    {
      //  return $this->name;
        return empty($this->name) ?  '👤'  :   $this->name ;
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
        $this->score = 0; //Reset player score
        $this->rightScore = 0; // Reset correct score
        $this->wrongScore = 0; // Reset wrong score
        $this->name = ""; // Reset player name
    }

    public function getRightScore(): int
    {
        return $this->rightScore;
    }

    public function increaseRightScore()
    {
        $this->rightScore++;
    }

    public function getWrongScore(): int
    {
        return $this->wrongScore;
    }

    public function increaseWrongScore()
    {
        $this->wrongScore++;
    }
}