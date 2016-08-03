<?php

    // configuration
    require("../includes/config.php"); 

    // look up user's stock portfolio
    $rows = CS50::query("SELECT * FROM portfolios WHERE user_id = ? ORDER BY symbol", $_SESSION["id"]);

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // build an array of stocks owned by user
        $positions = [];
        foreach ($rows as $row)
        {
            $stock = lookup($row["symbol"]);
            if ($stock == false)
            {
                apologize("Symbol not found.");
            }
            else
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

        // if valid, sell that stock
        $rows = CS50::query("SELECT symbol, shares FROM portfolios WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
        
        if (count($rows) == 1)
        {
            $stock = lookup($rows[0]["symbol"]);
            if ($stock !== false)
            {
                // add cash to user's balance
                $value = $rows[0]["shares"] * $stock["price"];
                $result = CS50::query("UPDATE users SET cash = cash + ? WHERE id = ?", $value, $_SESSION["id"]);
                if ($result === false)
                {
                    apologize("ERROR: Could not access the database to add cash.");
                }
                // delete stock from portfolio
                $result = CS50::query("DELETE FROM portfolios WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
                if ($result === false)
                {
                    apologize("ERROR: Could not access the database to delete stock.");
                }
                // log transaction in history
                $result = CS50::query("INSERT INTO history (user_id, transaction, datetime, symbol, shares, price) VALUES(?, 'SELL', NOW(), ?, ?, ?)", $_SESSION["id"], $_POST["symbol"], $rows[0]["shares"], $stock["price"]);
                if ($result === false)
                {
                    apologize("ERROR: Could not access the database to log transaction.");
                }
                // email user a receipt -- see http://php.net/manual/en/function.mail.php
                
            }
            
            // look up user's updated stock portfolio
            $rows = CS50::query("SELECT * FROM portfolios WHERE user_id = ? ORDER BY symbol", $_SESSION["id"]);
            
            // if 
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
        
            // look up user's cash balance
            $rows = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
            $cash = number_format($rows[0]["cash"], 2);
        
            // render portfolio
            render("portfolio.php", ["positions" => $positions, "cash" => $cash, "title" => "Portfolio"]);

        }
        else
        {
            apologize("Something went wrong, quite unexpectedly! :P");
        }

    }

?>
