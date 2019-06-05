<?php

namespace App\Entity;

use App\Entity\TimestableTrait;
use App\Controller\MediaObject\CreateMediaObjectAction;
use App\Controller\MediaObject\ShowMediaObjectAction;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource(
 *      iri="http://schema.org/MediaObject",
 *      normalizationContext={"groups"={"mediaObject"}},
 *      collectionOperations={
 *          "get",
 *          "post"={
 *              "controller"=CreateMediaObjectAction::class,
 *              "deserialize"=false,
 *              "validation_groups"={"Default", "mediaObjectCreate"},
 *              "swagger_context"={
 *                 "consumes"={
 *                     "multipart/form-data",
 *                 },
 *                 "parameters"={
 *                     {
 *                         "in"="formData",
 *                         "name"="file",
 *                         "type"="file",
 *                         "description"="The file to upload",
 *                     },
 *                 },
 *              },
 *          },
 *      },
 *     itemOperations={
 *         "get", 
 *         "show"={
 *              "method"="GET",
 *              "path"="/media_objects/{id}/show",
 *              "controller"=ShowMediaObjectAction::class
 *          },
 *     }
 * )
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\MediaObjectRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class MediaObject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"mediaObject", "product", "postProduct"})
     */
    private $id;

    /**
     * @var string|null
     *
     * @ApiProperty(iri="http://schema.org/contentUrl")
     */
    public $contentUrl;

    /**
     * @var File|null
     *
     * @Assert\NotNull(groups={"mediaObjectCreate"})
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/png"},
     *     mimeTypesMessage = "Please upload a valid image"
     * )
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath", mimeType="mimeType")
     */
    public $file;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({"mediaObject", "product"})
     */
    public $filePath;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({"mediaObject", "product"})
     */
    public $mimeType;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images")
     */
    public $product;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"mediaObject"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
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

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }
}
