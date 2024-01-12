<?php

class LanguageGame
{
    private $words;

    public function __construct()
    {
        // :: is used for static functions
        // They can be called without an instance of that class being created
        // and are used mostly for more *static* types of data (a fixed set of translations in this case)
        foreach (Data::words() as $frenchTranslation => $englishTranslation) {
            // TODO: create instances of the Word class to be added to the words array
            $this->words[] = new Word($frenchTranslation, $englishTranslation);
        }
    }

    // TODO: check for option A or B
    // Option A: user visits site first time (or wants a new word)
    public function run()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processAnswer();
        } else {
            $this->selectRandomWord();
        }
    }

    // TODO: select a random word for the user to translate
    private function selectRandomWord()
    {
        if (!empty($this->words)) {
            $randomKey = array_rand($this->words);
            $randomWord = $this->words[$randomKey];

            session_start();
            $_SESSION['random_word'] = $randomWord;

            // Display the random word for translation in the HTML form
            echo "Translate the word: {$randomWord->getFrenchTranslation()}";
        } else {
            echo "No words available for translation.";
        }
    }


    // Option B: user has just submitted an answer
    private function processAnswer()
    {
        session_start();

        if (isset($_SESSION['random_word'])) {
            $randomWord = $_SESSION['random_word'];
            $userAnswer = $_POST['user_answer'];

            //TODO: verify the answer (use the verify function in the word class) - you'll need to get the used word from the array first
            if ($randomWord->verify($userAnswer)) {
                // TODO: generate a message for the user that can be shown
                echo "Correct! Well done.";
            } else {
                echo "Incorrect. Try again.";
            }
        } else {
            echo "Session variable 'random_word' not set.";
        }
    }
}
