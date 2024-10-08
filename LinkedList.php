<?php

class Node
{
    public ?Node $next = null;
    public mixed $data = null;

    public function __construct(mixed $data)
    {
        $this->data = $data;
    }
}

class LinkedList implements Iterator, Countable
{
    private ?Node $next = null;
    private ?Node $cursor = null;
    private int $count = 0;

    public function __construct()
    {
        $this->cursor = $this->next;
    }

    public function append(mixed $data)
    {
        $node = new Node($data);
        if ($this->next === null) {
            $this->next = $node;
        } else {
            $next = $this->next;
            while ($next->next) {
               $next = $next->next;
            }
            $next->next = $node;
        }
        $this->count++;
    }

    public function remove(mixed $data): bool
    {
        $prev = null;
        $cursor = $this->next;
        while ($cursor) {
            if ($cursor->data === $data) {
                if ($prev)
                    $prev->next = $cursor->next;
                else
                    $this->next = $cursor->next;
                $cursor = null;
                $this->count--;
                return true;
            }
            $prev = $cursor;
            $cursor = $cursor->next;
        }
        return false;
    }

    public function count(): int
    {
        return $this->count;
    }

    public function current(): mixed
    {
        return $this->cursor->data;
    }

    public function key(): mixed
    {
        $i = 0;
        $node = $this->next;
        while ($node) {
            if ($node === $this->cursor) {
                return $i;
            }
            $i++;
            $node = $node->next;
        }
        return null;
    }

    public function next(): void
    {
        $this->cursor = $this->cursor->next;
    }

    public function rewind(): void
    {
        $this->cursor = $this->next;
    }

    public function valid(): bool
    {
        return $this->cursor !== null;
    }
}

function main(): int
{
    $linkedList = new LinkedList();
    for ($i = 1; $i <= 10; $i++) {
        $linkedList->append($i);
    }

    printf("We have %d items\n", count($linkedList));
    foreach ($linkedList as $idx => $item) {
        printf("%d: %d\n", $idx, $item);
    }

    if ($linkedList->remove(1)) {
        printf("Removed\n");
    }
    $linkedList->remove(5);
    $linkedList->remove(10);
    if (!$linkedList->remove(12)) {
        printf("Not removed\n");
    }

    printf("We have %d items\n", count($linkedList));
    foreach ($linkedList as $idx => $item) {
        printf("%d: %d\n", $idx, $item);
    }

    return 0;
}

exit(main());

