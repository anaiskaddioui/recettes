<?php

namespace App\Entity;

use App\Repository\RecettesRepository;
use App\Entity\Type;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=RecettesRepository::class)
 * @ApiResource(
 *      attributes={
 *          "order"= {"created_at":"DESC"}
 * },
 *      normalizationContext={"groups"={"read:recettes"}},
 *      collectionOperations={"get"},
 *      itemOperations={"get"}
 * )
 */
class Recettes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:recettes"})
     */
    private $id;

    /**
     * @Assert\Length(min=5, max=255)
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:recettes"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read:recettes"})
     * @Groups({"read:recettes"})
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read:recettes"})
     */
    private $preparation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:recettes"})
     */
    private $time;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:recettes"})
     */
    private $personnes;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:recettes"})
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="recettes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:recettes"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="recettes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $auteur;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="recettes", cascade={"persist"})
     * @Groups({"read:recettes"})
     */
    private $images;
    

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPreparation(): ?string
    {
        return $this->preparation;
    }

    public function setPreparation(string $preparation): self
    {
        $this->preparation = $preparation;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getPersonnes(): ?int
    {
        return $this->personnes;
    }

    public function setPersonnes(int $personnes): self
    {
        $this->personnes = $personnes;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt()
    {

        return $this->created_at;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Slugify 
     */
    public function getSlug() : string
    {
        $slug = (new Slugify())->slugify($this->title);
        return $slug;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setRecettes($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getRecettes() === $this) {
                $image->setRecettes(null);
            }
        }

        return $this;
    }

}
