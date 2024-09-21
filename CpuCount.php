<?php

declare(strict_types=1);

function cpuCount(): int
{
    $f = new \SplFileObject('/proc/cpuinfo');
    while (!$f->eof()) {
        if (preg_match('/Processor/', $line)) {
            $count++;
        }
    }
    $f = null;
}

function main(): int
{

    return 0;
}

exit(main());
