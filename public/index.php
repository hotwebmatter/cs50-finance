<?php

    // configuration
    require("../includes/config.php"); 

    // look up user's stock portfolio
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

?>
