<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Game</title>
</head>
<body>


<div>
    <p>Player: <?php echo $game->getPlayerName(); ?></p>
    <p>Score: <?php echo $game->getPlayerScore(); ?></p>
</div>

	<!-- TODO: add a form for the user to play the game -->
    <form action="index.php" method="post">
        <label for="user_answer">English:</label>
        <input type="text" id="user_answer" name="user_answer" required>
        <br>
        <button type="submit" name="submit">Submit Answer</button>
    </form>


    <!-- Add a reset form -->
    <form action="index.php" method="post">
        <input type="submit" name="reset" value="Reset">


    </form>


<form method="post">
    <?php if (empty($game->getPlayerName())) : ?>
        <!-- Ask for player's name -->
        <label for="player_name">Enter your name: </label>
        <input type="text" name="player_name" required>
        <input type="submit" name="submit_name" value="Start Quiz">
    <?php else : ?>
        <!-- Display player's name and continue with the game -->
        <p>Welcome, <?php echo $game->getPlayerName(); ?>!</p>
        <!-- ... existing code ... -->
    <?php endif; ?>

</form>



</body>
</html>