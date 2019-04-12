<?php
// Entity who represents a search about property by criteria. no persit needed with database
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch 
{
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     */
    private $minPrice;

     /**
     * @var int|null
     *  * @Assert\Range(
     *      min = 10,
     *      max = 400,
     *      minMessage = "You cannot be smaller than 10cm",
     *      maxMessage = "You cannot be taller than 400cm"
     * )
     */
    private $minSurface;


    /*      GETTERS     */
    public function getMaxPrice(): ?int { return $this->maxPrice; }

    public function getMinPrice(): ?int { return $this->minPrice; }

    public function getMinSurface(): ?int { return $this->minSurface; }


    /*      SETTERS     */
    public function setMaxPrice(int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    public function setMinPrice(int $minPrice): self
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    public function setMinSurface(int $minSurface): self
    {
        $this->minSurface = $minSurface;

        return $this;
    }
}