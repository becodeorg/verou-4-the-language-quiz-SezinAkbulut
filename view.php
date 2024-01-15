<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Game</title>
    <!--
    <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    }

    #game-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    }

    #word-container {
    font-size: 24px;
    margin-bottom: 20px;
    }

    label {
    font-size: 18px;
    margin-right: 10px;
    }

    input[type="text"] {
    padding: 10px;
    font-size: 16px;
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
    </style>
    -->

</head>
<body>
<div id="game-container">

	<!-- TODO: add a form for the user to play the game -->
    <form  method="post">
        <p>Player: <?php echo $game->getPlayerName(); ?></p>
        <p>Score: <?php echo $game->getPlayerScore(); ?></p>

        <label for="user_answer">English:</label>
        <input type="text" id="user_answer" name="user_answer" required>
        <br>
        <button type="submit" name="submit">Submit Answer</button>
    </form>


    <!-- Add a reset form -->
    <form method="post">
        <input type="submit" name="reset" value="Reset">
    </form>
</div>


</body>
</html>