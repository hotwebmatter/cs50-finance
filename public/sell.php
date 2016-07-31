<?php

    // configuration
    require("../includes/config.php"); 

    // look up user's stock portfolio
    $rows = CS50::query("SELECT * FROM portfolios WHERE user_id = ?", $_SESSION["id"]);

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // build an array of stocks owned by user
        $positions = [];
        foreach ($rows as $row)
        {
            $stock = lookup($row["symbol"]);
            if ($stock !== false)
            {
                $positions[] = [
                    "symbol" => $row["symbol"],
                    "name" => $stock["name"],
                    "shares" => $row["shares"],
                    "price" => number_format($stock["price"], 2),
                    "total" => number_format($row["shares"] * $stock["price"], 2)
                ];
            }
        }
        
        // then render form
        render("sell_form.php", ["positions" => $positions, "title" => "Sell"]);
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
