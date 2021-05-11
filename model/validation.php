<?php

/* validation.php
 * Validate data for the diner app
 *
*/

//Return true if a food is valid
function validFood($food)
{
    return strlen(trim($food)) >= 2;
}

function validMeal($meal)
{
    return in_array($meal, getMeals());
}

function validCondiments($condiments)
{
    $validCondiments = getCondiments();

    foreach ($condiments as $userChoice) {
        if (!in_array($userChoice, $validCondiments)) {
            return false;
        }
    }
    return true;
}