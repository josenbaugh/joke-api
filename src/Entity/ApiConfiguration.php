<?php

namespace App\Entity;

use App\Repository\ApiConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApiConfigurationRepository::class)
 */
class ApiConfiguration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $Type;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $Value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->Value;
    }

    public function setValue(string $Value): self
    {
        $this->Value = $Value;

        return $this;
    }
}
