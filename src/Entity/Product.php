<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product extends AbstractEntity
{
    /**
     * the name of the product, not unique because two retailers can have the same name for a product
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * the external id is equal to the sku name, we only have one sku by product, we only use the sku as a reference, not unique because two retailers can have the same externalId for a product
     *
     * @ORM\Column(type="string", length=255)
     */
    private $externalId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supplier")
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $supplier;

    /**
     * @ORM\Column(type="integer")
     */
    private $aquired = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $sold = 0;

    /**
     * average number of products sold by week
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rotation;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param mixed $externalId
     */
    public function setExternalId($externalId): void
    {
        $this->externalId = $externalId;
    }

    /**
     * @return mixed
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * @param mixed $supplier
     */
    public function setSupplier($supplier): void
    {
        $this->supplier = $supplier;
    }

    /**
     * @return mixed
     */
    public function getRotation()
    {
        return $this->rotation;
    }

    /**
     * @param mixed $rotation
     */
    public function setRotation($rotation): void
    {
        $this->rotation = $rotation;
    }

    /**
     * @return mixed
     */
    public function getAquired()
    {
        return $this->aquired;
    }

    /**
     * @param mixed $aquired
     */
    public function setAquired($aquired): void
    {
        $this->aquired = $aquired;
    }

    /**
     * @return mixed
     */
    public function getSold()
    {
        return $this->sold;
    }

    /**
     * @param mixed $sold
     */
    public function setSold($sold): void
    {
        $this->sold = $sold;
    }

}
