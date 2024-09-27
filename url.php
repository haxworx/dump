<?php

class Url
{
    private ?\CurlHandle $curl = null;

    public function __construct(private string $url)
    {
        $this->curl = curl_init($url);
        curl_setopt($this->curl,CURLOPT_RETURNTRANSFER, true);
    }

    public function execute(): ?string
    {
        return curl_exec($this->curl);
    }

    public function close(): void
    {
        curl_close($this->curl);
    }
}
function main(array $args): int
{
    if (count($args) !== 2) {
        printf("Usage: %s <host>\n", $args[0]);
        return 1;
    }

    $url = $args[1];

    $url = new Url($url);;
    $data = $url->execute();
    printf("%s\n", $data);
    $url->close();
    return 0;
}

exit(main($argv));
