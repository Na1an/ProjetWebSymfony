<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

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

    

}