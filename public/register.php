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

        // query database for user
        $rows = CS50::query("SELECT * FROM users WHERE username = ?", $_POST["username"]);

        // if we found user, do not register
        if (count($rows) == 1)
        {
            apologize("Username is already taken.");
        }
        
        // otherwise, register user
        $result = CS50::query("INSERT IGNORE INTO users (username, hash, cash) VALUES(?, ?, 10000.0000)", $_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT));
        if ($result === false)
        {
            apologize("ERROR: Could not register new user.");
        }

        $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
          $id = $rows[0]["id"];

        // remember that user's now logged in by storing user's ID in session
        $_SESSION["id"] = $row["id"];
  
        // redirect to portfolio
        redirect("/");

/*      // check password
 *      if (count($rows) == 1)
 *      {
 *          // first (and only) row
 *          $row = $rows[0];
 *
 *          // compare hash of user's input against hash that's in database
 *          if (password_verify($_POST["password"], $row["hash"]))
 *          {
 *              // remember that user's now logged in by storing user's ID in session
 *              $_SESSION["id"] = $row["id"];
 *
 *              // redirect to portfolio
 *              redirect("/");
 *          }
 *      }
 */
 
        // else apologize
        apologize("Invalid username and/or password.");
    }

?>
