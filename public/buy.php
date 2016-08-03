<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // then render form
        render("buy_form.php", ["title" => "Buy"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["symbol"]) && empty($_POST["shares"]))
        {
            apologize("You must provide a symbol and specify how many shares to buy.");
        }
        else if (empty($_POST["symbol"]))
        {
            apologize("You must provide a symbol.");
        }
        else if (empty($_POST["shares"]))
        {
            apologize("You must specify how many shares to buy.");
        }
        else if (!preg_match("/^\d+$/", $_POST["shares"]))
        {
            apologize("You must provide a non-negative integer!");
        }

        // if valid, buy that stock
        $symbol = strtoupper($_POST["symbol"]);
        
        // look up user's cash balance
        $rows = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
        $cash = $rows[0]["cash"];
        
        // look up current value of shares requested
        $stock = lookup($symbol);
        if ($stock !== false)
        {
            $value = $_POST["shares"] * $stock["price"];
                
            // can user afford this purchase?
            if ($value > $cash)
            {
                apologize("You cannot afford this purchase.");
            }
            else
            {
                // add new row for new stock, or update row for existing stock
                $result = CS50::query("INSERT INTO portfolios (user_id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $_SESSION["id"], $symbol, $_POST["shares"]);
                if ($result === false)
                {
                    apologize("ERROR: Could not access the database to add stock.");
                }
                // debit cash from user's balance
                $result = CS50::query("UPDATE users SET cash = cash - ? WHERE id = ?", $value, $_SESSION["id"]);
                if ($result === false)
                {
                    apologize("ERROR: Could not access the database to debit cash.");
                }
                // log transaction in history
                $result = CS50::query("INSERT INTO history (user_id, transaction, datetime, symbol, shares, price) VALUES(?, 'BUY', NOW(), ?, ?, ?)", $_SESSION["id"], $symbol, $_POST["shares"], $stock["price"]);
                if ($result === false)
                {
                    apologize("ERROR: Could not access the database to log transaction.");
                }
                // email user a receipt -- see http://php.net/manual/en/function.mail.php
                
            }
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
    
        // look up user's updated cash balance
        $rows = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
        $cash = number_format($rows[0]["cash"], 2);
    
        // render portfolio
        render("portfolio.php", ["positions" => $positions, "cash" => $cash, "title" => "Portfolio"]);

    }

?>