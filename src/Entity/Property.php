<?php
// Class who represents one House of presented by the agency

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 * @UniqueEntity("title")
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

    /*      CONSTRUCTOR     */
    public function __construct() 
    {
         $this->created_at = new \DateTime(); 
         $this->sold = false; 
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
}