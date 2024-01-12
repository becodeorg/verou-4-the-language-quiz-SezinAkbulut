<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class LanguageGame
{
    private $words;
    private $player;


        public function __construct()
    {
        // Start the session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->player = new Player();

        // :: is used for static functions
        foreach (Data::words() as $frenchTranslation => $englishTranslation) {
            // TODO: create instances of the Word class to be added to the words array
            $this->words[] = new Word($frenchTranslation, $englishTranslation);
        }
    }


    public function getPlayerName(): string
    {
        return $this->player->getName();
    }

    public function getPlayerScore(): int
    {
        return $this->player->getScore();
    }
    // TODO: check for option A or B
    // Option A: user visits site first time (or wants a new word)
    public function run()
    {
        // Check if the game is reset
        if (isset($_POST['reset'])) {
            $this->player->resetScore();
            $this->selectRandomWord();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyAnswer();
        } else {
            $this->selectRandomWord();
        }
    }

    // TODO: select a random word for the user to translate
    private function selectRandomWord()
    {
        if (session_status() == PHP_SESSION_NONE) {

        }

        if (!empty($this->words)) {
            $randomKey = array_rand($this->words);
            $randomWord = $this->words[$randomKey];

            $_SESSION['random_word'] = $randomWord;

            // Display the random word for translation in the HTML form
            echo "Translate the word:";
            echo "<br>";
            echo "French: {$randomWord->getFrenchTranslation()}";
            echo "<br>";
        } else {
            echo "No words available for translation.";
            echo "<br>";
        }
    }


    // Option B: user has just submitted an answer
    private function verifyAnswer()
    {
        if (isset($_SESSION['random_word'])) {
            $randomWord = $_SESSION['random_word'];
            $userAnswer = $_POST['user_answer'];

            //TODO: verify the answer (use the verify function in the word class) - you'll need to get the used word from the array first
            if ($randomWord->verify($userAnswer)) {
                // TODO: generate a message for the user that can be shown
                echo "Correct! Well done.";
                echo "<br>";
                $this->player->increaseScore();
                echo "<br>";
            } else {
                echo "Incorrect. Try again.";
                echo "<br>";
                $this->player->decreaseScore(); // Decrease score on incorrect answer
                echo "<br>";
            }
            // Get a new random word after the message
            $this->selectRandomWord();
        } else {
            echo "Session variable 'random_word' not set.";
        }
    }
}
