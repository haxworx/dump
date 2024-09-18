<?php

declare(strict_types=1);

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
            $verses[] = [
                'title' => $matches[1],
                'text' => $matches[2],
            ];
        }
    }

    $f = null;

    $verse = $verses[array_rand($verses)];
    printf("%s\n\n- %s\n", $verse['text'], $verse['title']);

    return 0;
}

exit(main());
