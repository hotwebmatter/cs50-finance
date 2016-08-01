<?php

    // configuration
    require("../includes/config.php"); 

    // look up user's transaction history
    $rows = CS50::query("SELECT transaction, datetime, symbol, shares, price FROM history WHERE user_id = ? ORDER BY datetime", $_SESSION["id"]);
    

    // render history
    render("history.php", ["rows" => $rows, "title" => "History"]);

?>
