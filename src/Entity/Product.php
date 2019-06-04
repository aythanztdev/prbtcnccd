<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ApiResource(
 *     normalizationContext={"groups"={"product"}},
 *     collectionOperations={
 *         "post",
 *         "get",
 *     },
 *     itemOperations={
 *         "get"
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
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
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\NotBlank
     * @Assert\Type("numeric")
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\NotBlank
     * @Assert\Type("numeric")
     */
    private $priceWithTax;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     */
    public $category;

    public $tax;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceWithTax()
    {
        return $this->priceWithTax;
    }

    public function setPriceWithTax($priceWithTax): self
    {
        $this->priceWithTax = $priceWithTax;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTax(): ?Tax
    {
        return $this->tax;
    }

    public function setTax(?Tax $tax): self
    {
        $this->tax = $tax;

        return $this;
    }
}
