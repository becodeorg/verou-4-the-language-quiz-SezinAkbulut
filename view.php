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
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
            }

            #game-container {
                border-radius: 8px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                padding: 30px;
                text-align: center;
                background-color: darkslateblue;
                color: white;
                margin-bottom: 2rem;
            }

            #word-container {
                font-size: 18px;
                margin-bottom: 20px;
                color: white;
            }

            #answer-form {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin-top: 20px;
            }

            #user_answer {
                margin-bottom: 10px;
                padding: 8px;
                font-size: 16px;
            }

            #submit-btn, #reset-btn {
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
            }

            #submit-btn, #reset-btn:hover {
                background-color: rgba(116, 125, 140, 0.65);
            }

            #submit-btn {
                color: white;
                background-color: green;
                border-radius: 25px;
            }

            #reset-btn{
                color: white;
                background-color: darkred;
                border-radius: 25px;
            }

            #error-message {
                color: red;
                font-weight: bold;
                margin-top: 10px;
            }

            #score-count {
                font-size: 16px;
                margin-top: 10px;
                color: white;
            }

            h2 {
                color: white;
            }

            .randomWord{
                font-size: 20px;
                color: #9bdc28;
                font-weight: bold;
            }
            .language{

                font-weight: bold;
            }

        </style>
</head>
<body>

<div id="game-container">
    <!-- TODO: select a random word for the user to translate -->
    <?php
    // Place this PHP code where you want to display the random word
    if (!empty($_SESSION['random_word'])) {
        $randomWord = $_SESSION['random_word'];
        echo '<div id="word-container">';
        echo '<h2>Translate the word:</h2><br>';
        echo '<p class="language"> French: <span class="randomWord">' . $randomWord->getFrenchTranslation() . '</span></p>';
        echo '</div>';
    }
    ?>
    <!-- TODO: add a form for the user to play the game -->
    <form  method="post" id="answer-form">

        <label class="language" for="user_answer">English:</label>
        <input type="text" id="user_answer" name="user_answer" required>
        <br>
        <button type="submit"  id="submit-btn" name="submit">Submit Answer</button>
    </form>



    <div id="score-count">
        <p>Player: <?php echo $game->getPlayerName(); ?></p>
        <p>Score: <?php echo $game->getPlayerScore(); ?></p>
        <p>Correct Answers: <?php echo $game->getPlayer()->getRightScore(); ?></p>
        <p>Wrong Answers: <?php echo $game->getPlayer()->getWrongScore(); ?></p>
    </div>


    <?php
    if (isset($errorMessage)) {
        echo '<div id="error-message">' . $errorMessage . '</div>';
    }
    ?>

    <!-- Add a reset form -->
    <form method="post">
        <input type="submit" id="reset-btn" name="reset" value="Reset">
    </form>
</div>
</body>
</html>


