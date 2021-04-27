<?php

namespace App\Entity;

use App\Repository\InformationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InformationRepository::class)
 */
class Information
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $society;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domain;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $provider_society;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $provider_domain;

    /**
     * @ORM\Column(type="datetime")
     */
    private $valide_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expire_date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="information")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSociety(): ?string
    {
        return $this->society;
    }

    public function setSociety(string $society): self
    {
        $this->society = $society;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getProviderSociety(): ?string
    {
        return $this->provider_society;
    }

    public function setProviderSociety(string $provider_society): self
    {
        $this->provider_society = $provider_society;

        return $this;
    }

    public function getProviderDomain(): ?string
    {
        return $this->provider_domain;
    }

    public function setProviderDomain(string $provider_domain): self
    {
        $this->provider_domain = $provider_domain;

        return $this;
    }

    public function getValideDate(): ?\DateTimeInterface
    {
        return $this->valide_date;
    }

    public function setValideDate(\DateTimeInterface $valide_date): self
    {
        $this->valide_date = $valide_date;

        return $this;
    }

    public function getExpireDate(): ?\DateTimeInterface
    {
        return $this->expire_date;
    }

    public function setExpireDate(\DateTimeInterface $expire_date): self
    {
        $this->expire_date = $expire_date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
