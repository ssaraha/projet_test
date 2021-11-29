<?php

namespace App\Entity;

use App\Repository\SaleDetailRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Traits\Timestampable;

/**
 * @ORM\Entity(repositoryClass=SaleDetailRepository::class)
 */
class SaleDetail
{
    use Timestampable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Sale::class, inversedBy="saleDetails")
     */
    private $slae;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="saleDetails")
     */
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSlae(): ?Sale
    {
        return $this->slae;
    }

    public function setSlae(?Sale $slae): self
    {
        $this->slae = $slae;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
