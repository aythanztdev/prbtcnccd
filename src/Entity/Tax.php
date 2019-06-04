<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"tax"}},
 *     collectionOperations={
 *         "get",
 *     },
 *     itemOperations={
 *         "get"
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TaxRepository")
 */
class Tax
{
    const IVA = 'IVA';
    const IGIC = 'IGIC';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\NotBlank
     * @Assert\Type("numeric")
     */
    private $value;

    
    public $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setTax($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getTax() === $this) {
                $product->setTax(null);
            }
        }

        return $this;
    }
}
