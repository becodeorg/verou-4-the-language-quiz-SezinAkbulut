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
        echo "<div id='ask-nickname'>";
        echo '<form id="asking-form" method="post">';
        echo '<label id="player_name"> Please enter your nickname: </label>';
        echo "<br>";
        echo '<input id="player_name" type="text" name="nickname" required>';
        echo '<input id="submit-btn" type="submit" value="Start Quiz">';

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
            $this->player->resetScore();
            $this->player->setName($_POST['nickname']);
            echo "<br>";
            echo "<h1> Welcome, {$this->player->getName()}!</h1>";

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

        } else {
            echo "No words available for translation.";
            echo "<br>";
        }
    }


    // Option B: user has just submitted an answer

    private function verifyAnswer()
    {
        if (!isset($_POST['user_answer'])) {
           echo "<h1>Please enter an answer.</h1>";
           return;
        }

        $userAnswer = $_POST['user_answer'];


        if (isset($_SESSION['random_word'])) {
            $randomWord = $_SESSION['random_word'];

            // Verify the answer (use the verify function in the word class) - you'll need to get the used word from the array first
            if ($randomWord->verify($userAnswer)) {


                // Generate a message for the user that can be shown
                echo "<h1>Correct! Well done.</h1>";
                $this->player->increaseScore();
                $this->player->increaseRightScore(); // Increment the correct score
            } else {
                echo "<h1>Incorrect. Try again.</h1>";
                echo "<br>";
                $this->player->decreaseScore();
                $this->player->increaseWrongScore();
            }

            // Display the count of correct and incorrect answers
           // echo "<p>Correct Answers: {$this->player->getRightScore()} / Incorrect Answers: {$this->player->getWrongScore()}</p>";

            // Get a new random word after the message
            $this->selectRandomWord();
        } else {
            echo "<p>Session variable 'random_word' not set.</p>";
        }
    }

}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        h1 {
            color: darkslateblue;
        }
        #ask-nickname{
            margin-top: 5rem;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            background-color: darkslateblue;
            color: white;
            margin-bottom: 2rem;
        }
        #asking-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

        }

        #player_name {
            margin-bottom: 10px;
            padding: 8px;
            font-size: 16px;
        }
        #submit-btn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            color: white;
            background-color: green;
            border-radius: 25px;
        }

        #submit-btn:hover {
            background-color: rgba(116, 125, 140, 0.65);
        }
    </style>
</head>
<body>
</body>
</html>


