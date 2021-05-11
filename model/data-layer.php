<?php

/* data-layer.php
 * Return data for the diner app
 *
*/

// Get the meals for the order form
function getMeals()
{
    return array("breakfast", "lunch", "dinner");
}

/*
 * 1. Help each other
 * 2. Add a getCondiments() function to the Model
 * 3. Modify your Controller to get the condiments from the Model and send them to the View
 * 4. Modify the View page to display the
 */

function getConds()
{
    return array("ketchup", "mustard", "sriracha");
}