<?php

declare(strict_types=1);

class PortScanner
{
    private array $services = [];

    public function __construct(
        private string $hostname
    )
    {
        try {
            $f = new \SplFileObject('/etc/services');
        } catch (Exception $e) {
            printf("Error: %s\n", $e->getMessage());
            exit(1);
        }

        while (!$f->eof()) {
            $line = $f->fgets();
            if (preg_match('/([A-Za-z0-9-_]+)\s+(\d+)\/tcp.*?/', $line, $matches)) {
                $this->services[intval($matches[2])] = $matches[1];
            }
        }
        $f = null;
    }

    public function scan(): array
    {
        $ports = [];
        for ($i = 1; $i <= 65535; $i++) {
            $sock = @fsockopen($this->hostname, $i, $errstr, $errno);
            if (!$sock) continue;
            $ports[] = $i;
            fclose($sock);
        }
        return $ports;
    }

    public function getService(int $port): ?string
    {
        return $this->services[$port] ?? null;
    }
}

function main(array $args): int
{
    if (count($args) !== 2) {
        printf("Usage: %s <host>\n", $args[0]);
        return 1;
    }

    $hostname = $args[1];

    $scanner = new PortScanner($hostname);

    $ports = $scanner->scan();

    foreach ($ports as $port) {
        printf("Connected on %d", $port);
        $service = $scanner->getService($port);
        if ($service) printf(" (%s)", $service);
        printf("\n");
    }

    return 0;
}

exit(main($argv));
