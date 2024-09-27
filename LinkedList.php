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

    public function remove(mixed $data): void
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
                return;
            }
            $prev = $cursor;
            $cursor = $cursor->next;
        }
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
        return false;
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
    foreach ($linkedList as $item) {
        printf("%d\n", $item);
    }

    $linkedList->remove(1);
    $linkedList->remove(5);
    $linkedList->remove(10);

    printf("We have %d items\n", count($linkedList));
    foreach ($linkedList as $item) {
        printf("%d\n", $item);
    }

    return 0;
}

exit(main());

