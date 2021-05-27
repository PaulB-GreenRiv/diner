<?php

class Order
{
    private $_food;
    private $_meal;
    private $_condiments;

    /**
     * Order constructor.
     */
    public function __construct($food = "", $meal = "", $condiments = "")
    {
        $this->_food = $food;
        $this->_meal = $meal;
        $this->_condiments = $condiments;
    }

    /**
     * @return string
     */
    public function getFood()
    {
        return $this->_food;
    }

    /**
     * @param string $food
     */
    public function setFood($food)
    {
        $this->_food = $food;
    }

    /**
     * @return string
     */
    public function getMeal()
    {
        return $this->_meal;
    }

    /**
     * @param string $meal
     */
    public function setMeal($meal)
    {
        $this->_meal = $meal;
    }

    /**
     * @return string
     */
    public function getCondiments()
    {
        return $this->_condiments;
    }

    /**
     * @param string $condiments
     */
    public function setCondiments($condiments)
    {
        $this->_condiments = $condiments;
    }


}