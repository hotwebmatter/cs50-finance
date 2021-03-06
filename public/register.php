<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must provide your username.");
        }
        else if (empty($_POST["password"]) || empty($_POST["confirmation"]))
        {
            apologize("You must provide your password.");
        }
        else if ($_POST["password"] != $_POST["confirmation"])
        {
            apologize("Passwords do not match!");
        }
        else if (empty($_POST["email"]) || empty($_POST["emailconfirm"]))
        {
            apologize("You must provide an email address.");
        }
        else if ($_POST["email"] != $_POST["emailconfirm"])
        {
            apologize("Email addresses do not match!");
        }
        else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        {
            apologize("Invalid email address.");
        }

        // query database for user
        $rows = CS50::query("SELECT * FROM users WHERE username = ?", $_POST["username"]);

        // if we found user, do not register
        if (count($rows) == 1)
        {
            apologize("Username is already taken.");
        }
        
        // otherwise, register user
        $result = CS50::query("INSERT IGNORE INTO users (username, email, hash, cash) VALUES(?, ?, ?, 10000.0000)", $_POST["username"], $_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT));
        if ($result === false)
        {
            apologize("ERROR: Could not register new user.");
        }

        $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
          $id = $rows[0]["id"];
        //  dump($rows);

        // remember that user's now logged in by storing user's ID in session
        $_SESSION["id"] = $id;
        // dump($_SESSION);
  
        // redirect to portfolio
        redirect("/");

        // else apologize
        apologize("Invalid username and/or password.");
    }

?>
