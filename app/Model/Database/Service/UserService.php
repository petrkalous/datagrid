<?php declare(strict_types=1);

namespace App\Model\Database\Service;

use App\Model\Database\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
//use Nette\Database\Explorer;

class UserService
{
    public function __construct(
        private EntityManagerInterface $em,
        //private Explorer $database,
    )
    {}

    public function findUser(string $username): ?User
    {
        //return User::create($this->database->table('user')->where('username', $username)->fetch());

        /** @var User|null $user */
        $user = $this->em->getRepository(User::class)->findOneBy(['username' => $username]);
        return $user;
    }
}