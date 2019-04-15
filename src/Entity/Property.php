<?php
// Class who represents one House of presented by the agency

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 * @UniqueEntity("title")
 * @Vich\Uploadable
 */
class Property
{

    const HEAT = [
        0 => 'Electric',
        1 =>  'Gaz'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255))
     */
    private $filename;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="filename")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * Property surafce beetween 10m² and 400m& only
     * 
     * @ORM\Column(type="integer")
     * @Assert\Range(min = 10, max = 400)
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     */
    private $rooms;

    /**
     * @ORM\Column(type="integer")
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer")
     */
    private $floor;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $heat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[a-z0-9][a-z0-9\- ]{0,10}[a-z0-9]/")
     */
    private $postal_code;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $sold;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Option", inversedBy="properties")
     */
    private $options;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /*      CONSTRUCTOR     */
    public function __construct() 
    {
         $this->created_at = new \DateTime(); 
         $this->sold = false;
         $this->options = new ArrayCollection(); 
    }

    /*      GETTERS     */
    public function getId(): ?int { return $this->id; }
    public function getTitle(): ?string { return $this->title; }
    public function getDescription(): ?string { return $this->description; }
    public function getSurface(): ?int { return $this->surface; }
    public function getRooms(): ?int { return $this->rooms; }
    public function getBedrooms(): ?int { return $this->bedrooms; }
    public function getFloor(): ?int { return $this->floor; }
    public function getPrice(): ?int { return $this->price; }

    /*  Custom getter who formated $price in the format i want i can also use number_format in twig but not generic */ 
    public function getFormattedPrice(): ?string { return number_format($this->price, 0, '', ' '); }
    /*  Custom getter who generate a slug for url form slugify component on packagist */
    public function getSlug(): string  { return $slugify = (new Slugify())->slugify($this->title); }   // sdd.com/house-title

    public function getHeat(): ?int { return $this->heat; }

    /* Custom getter */
    public function getHeatType(): ?string { return self::HEAT[$this->heat]; }


    public function getCity(): ?string { return $this->city;}
    public function getAddress(): ?string { return $this->address; }
    public function getSold(): ?bool { return $this->sold; }
    public function getPostalCode(): ?string { return $this->postal_code; }
    public function getCreatedAt(): ?\DateTimeInterface { return $this->created_at; }


    /*      SETTERS     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;
        return $this;
    }


    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;
        return $this;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;
        return $this;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;
        return $this;
    }


    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function setHeat(int $heat): self
    {
        $this->heat = $heat;
        return $this;
    }


    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }


    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;
        return $this;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;
        return $this;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->addProperty($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
            $option->removeProperty($this);
        }

        return $this;
    }

    /**
     * Get the value of filename
     *
     * @return  string|null
     */ 
    public function getFilename() { return $this->filename; }

    /**
     * Set the value of filename
     *
     * @param  string|null  $filename
     *
     * @return  self
     */ 
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get nOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @return  File|null
     */ 
    public function getImageFile(): ?File { return $this->imageFile; }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile)
    {
        $this->imageFile = $imageFile;
        // Only change the updated af if the file is really uploaded to avoid database updates.
        // This is needed when the file should be set when loading the entity.
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
