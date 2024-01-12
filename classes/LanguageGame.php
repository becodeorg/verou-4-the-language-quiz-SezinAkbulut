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

        if (!isset($_SESSION['player'])) {
            $this->askNickname(); // Ask for the nickname if the player session is not set
        }

        $this->player = $_SESSION['player'];

        foreach (Data::words() as $frenchTranslation => $englishTranslation) {
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

    private function askNickname()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nickname'])) {
            $nickname = $_POST['nickname'];
            $this->player = new Player($nickname);
            $_SESSION['player'] = $this->player;
        } else {
            $this->showNicknameForm();
            exit; // Stop further execution until a nickname is provided
        }
    }
    private function showNicknameForm()
    {
        echo 'Please enter your nickname:';
        echo '<form method="post">';
        echo '<input type="text" name="nickname" required>';
        echo '<input type="submit" value="Start Quiz">';
        echo '</form>';
    }

    // TODO: check for option A or B
    // Option A: user visits site first time (or wants a new word)
    public function run()
    {
        // Check if the game is reset
        if (isset($_POST['reset'])) {
            $this->player->resetScore();
            $this->player->setName(""); // Reset player name
            $this->selectRandomWord();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($this->player->getName())) {
                // Ask for the player's name if it's not set
                $this->player->setName($_POST['player_name']);
                echo "Welcome, {$this->player->getName()}!";
                echo "<br>";
            }
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
        if (!isset($_POST['user_answer'])) {
            echo "Please enter an answer.";
            return;
        }

        $userAnswer = $_POST['user_answer'];

        if (isset($_SESSION['random_word'])) {
            $randomWord = $_SESSION['random_word'];

            // TODO: verify the answer (use the verify function in the word class) - you'll need to get the used word from the array first
            if ($randomWord->verify($userAnswer)) {
                // TODO: generate a message for the user that can be shown
                echo "Correct! Well done.";
                echo "<br>";
                $this->player->increaseScore();
            } else {
                echo "Incorrect. Try again.";
                echo "<br>";
                $this->player->decreaseScore();
            }
            // Get a new random word after the message
            $this->selectRandomWord();
        } else {
            echo "Session variable 'random_word' not set.";
        }
    }
}
