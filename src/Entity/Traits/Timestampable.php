<?php

namespace App\Entity\Traits;

trait Timestampable
{
	/**
     * @ORM\Column(type="datetime_immutable", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true, options={"default":"CURRENT_TIMESTAMP"})
     */
    private $updated_at;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }


    /**
     * 
     * @ORM\PrePersist
     * 
     * @ORM\PreUpdate
     * 
     * 
     */ 
    public function updateTimestamp()
    {
    	if($this->getCreatedAt() === null )
        {
            $this->setCreatedAt(new \DateTimeImmutable);

        }
        else{
            $this->setUpdatedAt(new \DateTimeImmutable);
        }
    }

}