<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

class RestaurantSearch{
    /**
     * @var int|null
     * @@Assert\Range(min=10, max=100000)
     */

    private $maxPrice;

     /**
      * @var int|null
      * @Assert\Range(min=10, max=1000)
      */

    private $minPlace;

    /**
     * @return int|null
     */


    /**
     * @var ArrayCollection
     */
    private $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    public function getMaxPrice() :?int
    {
        return $this->maxPrice; 

    }

    /**
     * @param int|null $maxPrice
     * @return RestaurantSearch
     */

    public function setMaxPrice(?int $maxPrice): RestaurantSearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return int|null
     */

    public function getMinPlace() :?int
    {
        return $this->minPlace;
    }
    /**
     * @param int|null $minPlace
     * @return RestaurantSearch
     */

    public function setMinPlace(?int $minPlace): RestaurantSearch
    {
        $this->minPlace = $minPlace;
        return $this;
    }

    /**
     * @return ArrayCollection
     */

    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection|null $options
     * @return ArrayCollection
     */

    public function setOptions(ArrayCollection $options): void
    {
        $this->options = $options;
    }
    

}