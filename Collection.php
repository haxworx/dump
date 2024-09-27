<?php

declare(strict_types=1);

class Collection implements Iterator, Countable
{
    private array $items = [];
    private int $count = 0;
    private int $idx = 0;

    public function __construct()
    {
    }

    public function add(mixed $item): void
    {
        $this->items[] = $item;
        $this->count++;
    }

    public function remove(mixed $item): bool
    {
        $index = array_search($item, $this->items, true);
        if ($index === false) return false;
        array_splice($this->items, $index, 1);
        $this->count--;
        return true;
    }

    public function count(): int
    {
        return $this->count;
    }

    public function current(): mixed
    {
        return $this->items[$this->idx];
    }

    public function key(): mixed
    {
        return $this->idx;
    }

    public function next(): void
    {
        $this->idx++;
    }

    public function rewind(): void
    {
        $this->idx = 0;
    }

    public function valid(): bool
    {
        return $this->idx < $this->count;
    }
}

function main(): int
{
    $collection = new Collection();

    for ($i = 1; $i <= 10; $i++) {
        $collection->add($i);
    }

    foreach ($collection as $idx => $value) {
        printf("%d: => %d\n", $idx, $value);
    }

    $collection->remove(8);
    $collection->remove(1);

    printf("We have %d items\n", count($collection));

    foreach ($collection as $idx => $value) {
        printf("%d: => %d\n", $idx, $value);
    }

    return 0;
}

exit(main());

