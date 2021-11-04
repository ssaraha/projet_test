<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Traits\Timestampable;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\Table(name="Articles")
 * @Vich\Uploadable
 */
class Article
{
    use Timestampable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(message="ce champs est obligatoire, veuillez le remplir")
     * 
     */
    private $designation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="article_image", fileNameProperty="image")
     * 
     * @Assert\Image(maxSize="8M", maxSizeMessage="Votre image depasse la limite de taille accepté")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="ce champs est obligatoire, veuillez le remplir")
     */
    private $quantity_available;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="ce champs est obligatoire, veuillez le remplir")
     */
    private $critical_quantity;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="ce champs est obligatoire, veuillez le remplir")
     */
    private $unit_price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPromo;

    /**
     * @ORM\ManyToOne(targetEntity=ArticleType::class, inversedBy="articles")
     * @Assert\NotBlank(message="ce champs est obligatoire, veuillez le remplir")
     */
    private $typeArticle;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="article")
     */
    private $promos;

    public function __construct()
    {
        $this->promos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getQuantityAvailable(): ?int
    {
        return $this->quantity_available;
    }

    public function setQuantityAvailable(int $quantity_available): self
    {
        $this->quantity_available = $quantity_available;

        return $this;
    }

    public function getCriticalQuantity(): ?int
    {
        return $this->critical_quantity;
    }

    public function setCriticalQuantity(int $critical_quantity): self
    {
        $this->critical_quantity = $critical_quantity;

        return $this;
    }

    public function getUnitPrice(): ?int
    {
        return $this->unit_price;
    }

    public function setUnitPrice(int $unit_price): self
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    public function getIsPromo(): ?bool
    {
        return $this->isPromo;
    }

    public function setIsPromo(bool $isPromo): self
    {
        $this->isPromo = $isPromo;

        return $this;
    }

    public function getTypeArticle(): ?ArticleType
    {
        return $this->typeArticle;
    }

    public function setTypeArticle(?ArticleType $typeArticle): self
    {
        $this->typeArticle = $typeArticle;

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->setArticle($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            // set the owning side to null (unless already changed)
            if ($promo->getArticle() === $this) {
                $promo->setArticle(null);
            }
        }

        return $this;
    }
}
