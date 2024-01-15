<?php


class Word
{
    // TODO: add word (FR) and answer (EN) - (via constructor or not? why?)
    private $frenchTranslation;
    private $englishTranslation;

    public function __construct(string $frenchTranslation, string $englishTranslation)
    {
        $this->frenchTranslation = $frenchTranslation;
        $this->englishTranslation = $englishTranslation;
    }

// TODO: use this function to verify if the provided answer by the user matches the correct one
    public function verify(string $answer): bool
    {
        // TODO: use this function to verify if the provided answer by the user matches the correct one
        $answerLower = strtolower($answer);
        $correctAnswerLower = strtolower($this->englishTranslation);

        //Bonus: Allow answers with different casing and small typo's (max one character different)
        return $answerLower === $correctAnswerLower || levenshtein($answerLower, $correctAnswerLower) <= 1;
    }

    public function getFrenchTranslation(): string
    {
        return $this->frenchTranslation;
    }

    // Additional getter methods if needed
    public function getEnglishTranslation(): string
    {
        return $this->englishTranslation;
    }
}