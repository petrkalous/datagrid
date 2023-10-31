<?php declare(strict_types=1);

namespace App\Model\Database\Service;

use App\Model\Database\Entity\Content;
use Doctrine\ORM\EntityManagerInterface;

class ContentService
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {}

    public function findAll(): ?Content
    {
        /** @var Content|null $items */
        $items = $this->em->getRepository(Content::class)->findAll();
        return $items;
    }
}