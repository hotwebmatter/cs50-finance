<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("quote_form.php", ["title" => "Get Quote"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["symbol"]))
        {
            apologize("You must provide a symbol.");
        }

        // Look up that stock
        $s = lookup($_POST["symbol"]);
        
        // if symbol not found, apologize
        if ($s === false)
        {
            apologize("Symbol not found.");
        }
        
        // else render quote
        render("quote.php", $s);

    }

?>
