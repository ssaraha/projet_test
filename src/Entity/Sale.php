<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Traits\Timestampable;

/**
 * @ORM\Entity(repositoryClass=SaleRepository::class)
 */
class Sale
{
    use Timestampable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_sale;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sales")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=SaleDetail::class, mappedBy="slae", cascade={"persist"})
     */
    private $saleDetails;

    public function __construct()
    {
        $this->saleDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSale(): ?\DateTimeInterface
    {
        return $this->date_sale;
    }

    public function setDateSale(\DateTimeInterface $date_sale): self
    {
        $this->date_sale = $date_sale;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

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

    /**
     * @return Collection|SaleDetail[]
     */
    public function getSaleDetails(): Collection
    {
        return $this->saleDetails;
    }

    public function addSaleDetail(SaleDetail $saleDetail): self
    {
        if (!$this->saleDetails->contains($saleDetail)) {
            $this->saleDetails[] = $saleDetail;
            $saleDetail->setSlae($this);
        }

        return $this;
    }

    public function removeSaleDetail(SaleDetail $saleDetail): self
    {
        if ($this->saleDetails->removeElement($saleDetail)) {
            // set the owning side to null (unless already changed)
            if ($saleDetail->getSlae() === $this) {
                $saleDetail->setSlae(null);
            }
        }

        return $this;
    }
}
