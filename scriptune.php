<?php

declare(strict_types=1);

class Verse
{
    public function __construct(
        private string $title,
        private string $text
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }
}

function main(): int
{
    $verses = [];

    try {
        $f = new \SplFileObject('data/kjv.txt');
    } catch (Exception $e) {
        printf("Error: %s\n", $e->getMessage());
        return 1;
    }

    while (!$f->eof()) {
        $line = $f->fgets();
        if (preg_match('/(\w+\s+\d+:\d+)\s(.*?)$/', $line, $matches)) {
            $verse = new Verse($matches[1], $matches[2]);
            $verses[] = $verse;
        }
    }

    $f = null;

    $verse = $verses[array_rand($verses)];
    printf("%s\n\n- %s\n", $verse->getText(), $verse->getTitle());

    return 0;
}

exit(main());
