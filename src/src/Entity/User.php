<?php declare(strict_types = 1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpSimple\Doctrine\Traits\Entity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Ignore;

use function array_unique;

#[ORM\Entity]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Entity;

    #[Ignore]
    #[ORM\Column]
    private string $password = '-';

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\Column(unique: true)]
    private ?string $email = null;

    #[ORM\Column(options: ['default' => false])]
    private bool $isActive = false;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $blockedAt = null;

    public function eraseCredentials(): void
    {
        /*
         * not needed
         */
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function getBlockedAt(): ?DateTimeImmutable
    {
        return $this->blockedAt;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function setBlockedAt(?DateTimeImmutable $blockedAt): self
    {
        $this->blockedAt = $blockedAt;

        return $this;
    }
}
