<?php

declare(strict_types=1);

class User
{
    private string $password;

    public function __construct(
        private string $username,
    )
    {

    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }
}

class UsersReader
{
    private array $users = [];

    public function __construct()
    {
        try {
            $f = new \SplFileObject('/etc/passwd', 'r');
        } catch (Exception $e) {
            printf("Error: %s\n", $e->getMessage());
            exit(1);
        }

        while (!$f->eof()) {
            $line = $f->fgets();
            if (preg_match('/^([A-Za-z0-9_]+).*?$/', $line, $matches)) {    
                $this->users[] = $matches[1];
            }
        }
    }

    public function getUsers(): array
    {
        return $this->users;
    }
}

function main(): int
{
    $users = [];
    $reader = new UsersReader();
    $usernames = $reader->getUsers();
    foreach ($usernames as $username) {
        $user = new User($username);
        $user->setPassword(bin2hex(random_bytes(12)));
        $users[] = $user;
    }

    print_r($users);
    
    return 0;
}

exit(main());
