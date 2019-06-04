<?php

namespace App\Entity;

use App\Entity\TimestableTrait;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ApiResource(
 *     normalizationContext={"groups"={"product"}},
 *     collectionOperations={
 *         "post"={
 *             "denormalization_context"={"groups"={"postProduct"}}
 *         },
 *         "get"
 *     },
 *     itemOperations={
 *         "get"
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={
 *          "category.name": "exact",
 *          "description": "ipartial"
 * })
 * @ApiFilter(RangeFilter::class, properties={
 *          "price"
 * })
 * 
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"product", "postProduct"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Groups({"product", "postProduct"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Groups({"product", "postProduct"})
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\NotBlank
     * @Assert\Type("numeric")
     * @Groups({"product", "postProduct"})
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\Type("numeric")
     * @Groups({"product"})
     */
    private $priceWithTax;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @Assert\NotBlank
     * @Groups({"product", "postProduct"})
     */
    public $category;

    /**
     * @ORM\ManyToOne(targetEntity="Tax", inversedBy="products")
     * @Assert\NotBlank
     * @Groups({"product", "postProduct"})
     */
    public $tax;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"product"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"product"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    use TimestableTrait;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
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
