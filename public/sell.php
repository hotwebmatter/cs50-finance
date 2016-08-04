<?php

    // configuration
    require("../includes/config.php"); 
    
    // phpmailer configuration
    require("libphp-phpmailer/class.phpmailer.php");
    
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
            $row = $rows[0];
            $stock = lookup($row["symbol"]);
            if ($stock !== false)
            {
                // add cash to user's balance
                $value = $row["shares"] * $stock["price"];
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
                // look up username, email and new cash balance
                $userdata = CS50::query("SELECT cash, username, email FROM users WHERE id = ?", $_SESSION["id"]);
                $cash = number_format($userdata["cash"], 2);
                $username = $userdata["username"];
                $recipient = $userdata["email"];
                if ($row["shares"] == 1)
                {
                    $purchase = "{$row["shares"]} share";
                }
                else if ($row["shares"] > 1)
                {
                    $purchase = "{$row["shares"]} shares";
                }
                else
                {
                    $purchase = ", somehow, less than one share";
                }
                // email user a receipt -- see http://php.net/manual/en/function.mail.php
                $message = "Congratualations, {$username}!\r\nYou just sold {$purchase} of stock in {$stock["name"]} ({$symbol}) for \${$value}.\r\nThanks for using CS50 Finance!";
                $subject = "CS50 Finance: {$symbol} Sale";
                $headers = "From: cs50@hotwebmatter.com" . "\r\n" . "Reply-To: cs50@hotwebmatter.com" . "\r\n" . "X-Mailer: PHP/" . phpversion();

                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPDebug = 1;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->Host = "smtp.gmail.com"; // change to your email host
                $mail->Port = 587; // change to your email port
                $mail->Username = "cs50@hotwebmatter.com"; // change to your username
                $mail->Password = "v1kCjsvLYytrBTGV"; // change to your email password
                $mail->setFrom("cs50@hotwebmatter.com"); // change to your email password
                $mail->AddAddress($recipient); // change to user's email address
                $mail->Subject = $subject; // change to email's subject
                $mail->Body = $message; // change to email's body, add the needed link here

                if ($mail->Send() == false)
                {
                    apologize("Error: Couldn't send confirmation email.");
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
        
            // look up user's cash balance
            // $rows = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
            // $cash = number_format($rows[0]["cash"], 2);
        
            // render portfolio
            render("portfolio.php", ["positions" => $positions, "cash" => $cash, "title" => "Portfolio"]);

        }
        else
        {
            apologize("Something went wrong, quite unexpectedly! :P");
        }

    }

?>
