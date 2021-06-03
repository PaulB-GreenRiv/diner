<?php

/* validation.php
 * Validate data for the diner app
 *
*/

class Validation
{
//Return true if a food is valid
    static function validFood($food)
    {
        return strlen(trim($food)) >= 2;
    }

    static function validMeal($mealId)
    {
        $meals = $GLOBALS['dataLayer']->getMeals();
        return array_key_exists($mealId, $meals);
    }

    static function validCondiments($condiments)
    {
        $validCondiments = DataLayer::getConds();

        foreach ($condiments as $userChoice) {
            if (!in_array($userChoice, $validCondiments)) {

                return false;
            }
        }
        return true;
    }
}

