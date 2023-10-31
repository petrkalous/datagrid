<?php declare(strict_types=1);

namespace App\Model\Database\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Nette\Database\Table\ActiveRow;

class User
{

    public function __construct(
        protected int $id,
        protected string $username,
        protected string $password,
        protected string $role
    )
    {
    }

    public static function create(?ActiveRow $activeRow): ?self
    {
        if ($activeRow === null)
            return null;

        return new User(...$activeRow->toArray());
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getRole(): string
    {
        return $this->role;
    }
}