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
    public function getPlayer(): Player
    {
        return $this->player;
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
        echo "<div>";
        echo '<form method="post">';
        echo '<label> Please enter your nickname: </label>';
        echo "<br>";
        echo '<input type="text" name="nickname" required>';
        echo '<input type="submit" value="Start Quiz">';

        echo '</form>';
        echo "</div>";
    }

    // TODO: check for option A or B
    // Option A: user visits site first time (or wants a new word)

    function run()
    {
        // Start the session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the player session is not set
        if (!isset($_SESSION['player'])) {
            $this->askNickname(); // Ask for the nickname if the player session is not set
            return; // Stop further execution until a nickname is provided
        }

        $this->player = $_SESSION['player'];


        // Check if the player has just submitted their name
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nickname'])) {

            $this->player->setName($_POST['nickname']);
            echo "Welcome, {$this->player->getName()}!";
            echo "<br>";
            $this->selectRandomWord();
        }

        // Check if the game is reset
        if (isset($_POST['reset'])) {
            $this->askNickname();
            $this->player->resetScore();
            $this->player->setName("");
            $this->selectRandomWord();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyAnswer();
        } else {
            $this->showNicknameForm();
        }
    }

    // TODO: select a random word for the user to translate
    private function selectRandomWord()
    {
        //if (session_status() == PHP_SESSION_NONE) {

        //}
        // Check if the player's name is set
        if (empty($this->player->getName())) {
            $this->showNicknameForm();
            return;
        }

        if (!empty($this->words)) {
            $randomKey = array_rand($this->words);
            $randomWord = $this->words[$randomKey];

            $_SESSION['random_word'] = $randomWord;

            // Display the random word for translation in the HTML form
            echo '<div id="word-container">';
            echo 'Translate the word:<br>';
            echo 'French: ' . $randomWord->getFrenchTranslation();
            echo '</div>';
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

            // Verify the answer (use the verify function in the word class) - you'll need to get the used word from the array first
            if ($randomWord->verify($userAnswer)) {
                // Generate a message for the user that can be shown
                echo "Correct! Well done.";
                echo "<br>";
                $this->player->increaseScore();
                $this->player-> getRightScore();
            } else {
                echo "Incorrect. Try again.";
                echo "<br>";
                $this->player->decreaseScore();
                $this->player->getWrongScore();
            }
            // Get a new random word after the message
            $this->selectRandomWord();
        } else {
            echo "Session variable 'random_word' not set.";
        }
    }
}

?>

<!--
<style>

    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    div {
        background-color: steelblue;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    form {

        margin-top: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    input {
        padding: 8px;
        margin-bottom: 10px;
    }

    button {
        padding: 10px 20px;
        font-size: 18px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }
    #word-container {
        font-size: 24px;
        margin-bottom: 20px;
    }
</style>
-->