<?php declare(strict_types=1);

namespace App\Model\Database\Entity;

use DateTime;
use Nette;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Strings;

#[ORM\Entity]
#[ORM\Table(name: 'content')]
class Content
{
    use Nette\SmartObject;

    #[ORM\Id]
    #[ORM\Column(type: 'integer', unique: true, options: ['unsigned:'])]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private ?int $order;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'integer')]
    private ?int $author_id;

    #[ORM\Column(type: 'string')]
    private ?string $status;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $created_at;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $public_at;

    /**
     * @param $id
     * @param int|null $order
     * @param string|null $title
     * @param int|null $author_id
     * @param string|null $status
     * @param DateTime|null $created_at
     * @param DateTime|null $public_at
     */
    public function __construct($id, ?int $order, ?string $title, ?int $author_id, ?string $status, ?DateTime $created_at, ?DateTime $public_at)
    {
        $this->id = $id;
        $this->setorder($order);
        $this->setTitle($title);
        $this->setAuthorId($author_id);
        $this->setStatus($status);
        $this->setCreatedAt($created_at);
        $this->setPublicAt($public_at);

    }

    // gettery
    public function getId(): int
    {
        return $this->id;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function getPublicAt(): ?DateTime
    {
        return $this->public_at;
    }

    // settery
    public function setOrder(int $order):void
    {
        $this->order = $order;
    }

    public function setTitle(string $title): void
    {
        $this->title = Strings::firstUpper(trim($title));
        if ($title === '')
            throw new \InvalidArgumentException('Title cannot be empty');
        $this->title = $title;
    }

    public function setAuthorId(?int $author_id): void
    {
        $this->author_id = $author_id;
    }

    public function setStatus(?string $status): void
    {
        $status = 'public';
        $this->status = $status;
    }

    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setPublicAt(?DateTime $public_at): void
    {
        $this->public_at = $public_at;
    }
}