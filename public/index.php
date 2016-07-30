<?php

    // configuration
    require("../includes/config.php"); 

    // look up user's stock portfolio
    $rows = CS50::query("SELECT * FROM portfolios WHERE user_id = ?", $_SESSION["id"]);
    
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
                "price" => $stock["price"],
                "total" => $row["shares"] * $stock["price"]
            ];
        }
    }

    // render portfolio
    render("portfolio.php", ["positions" => $positions, "title" => "Portfolio"]);

?>
