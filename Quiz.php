<?php

/* Times Tables */

declare(strict_types=1);

class Question
{
    public function __construct(
        private string $text,
        private mixed $answer
    )
    {

    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAnswer(): mixed
    {
        return $this->answer;
    }
}

interface Quiz
{
    public function addQuestion(Question $question);
    public function play();
}

class TimesTableQuiz implements Quiz
{
    const int NUM_QUESTIONS = 12;
    
    public function __construct(
        private array $questions = []
    )
    {

    }

    public function addQuestion(Question $question): static
    {
        $this->questions[] = $question;
        return $this;
    }

    private function getQuestion(): Question
    {
        return $this->questions[array_rand($this->questions)];
    }

    public function play(): void
    {
        $score = 0;

        for ($i = 0; $i < static::NUM_QUESTIONS; $i++) {
            $question = $this->getQuestion();
            $guess = (int) readline(sprintf("%s ", $question->getText()));
            if ($guess !== $question->getAnswer()) {
                printf("Incorrect!\n");
            } else {
                printf("Correct!\n");
                ++$score;
            }
        }
        printf("You scored %d/%d!\n", $score, static::NUM_QUESTIONS);
    }
}

function main(): int
{
    $quiz = new TimesTableQuiz();

    for ($i = 1; $i <= 12; $i++) {
        for ($j = 1; $j <= 12; $j++) {
            $question = new Question("What is $i * $j?", (int) $i * $j);
            $quiz->addQuestion($question);
        }
    }

    $quiz->play();

    return 0;
}

exit(main());
