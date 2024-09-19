<?php

class FileReader
{
    private array $files = [];

    public function __construct(
        private string $directory
    )
    {

    }

    private function scan(string $directory): void
    {
        $directories = [];
        $dh = opendir($directory);
        if (!$dh) return;
        
        while (($file = readdir($dh)) !== false) {
            if ($file === '.' || $file === '..') continue;
            $path = $directory . '/' . $file;
            if (is_dir($path)) {
                $directories[] = $path;
            }
            $this->files[] = $path;
        }

        closedir($dh);

        foreach ($directories as $directory) {
            $this->scan($directory);
        }
    }

    private function reset(): void
    {
        $this->files = [];
    }

    public function read(): array
    {
        $this->reset();
        $this->scan($this->directory);

        return $this->files;
    }
}

function main(array $args): int
{
    if (count($args) !== 2) {
        printf("Usage: %s <dir>\n", $args[0]);
        return 1;
    }

    $reader = new FileReader($args[1]);
    $files = $reader->read();
    foreach ($files as $file) {
        printf("%s\n", $file);
    }
    return 0;
}

exit(main($argv));
