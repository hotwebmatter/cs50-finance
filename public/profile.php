<?php

    // configuration
    require("../includes/config.php");

    // look up user in database
    $profile = CS50::query("SELECT username, email, cash FROM users WHERE id = ?", $_SESSION["id"]);
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render profile
        render("profile.php", ["profile" => $profile, "title" => "Profile"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if ($_POST["referer"] == "password_reset_form")
        {
            // render password reset form
            render("profile_password.php", ["title" => "Reset Password"]);
        }
        if ($_POST["referer"] == "email_reset_form")
        {
            // render email reset form
            render("profile_email.php", ["title" => "Update Email"]);
        }
        else if ($_POST["referer"] == "password_reset_action")
        {
            // validate submission
            if (empty($_POST["old_password"]))
            {
                apologize("You must provide your old password.");
            }
            else if (empty($_POST["new_password"]) || empty($_POST["new_confirmation"]))
            {
                apologize("You must provide your new password.");
            }
            else if ($_POST["new_password"] != $_POST["new_confirmation"])
            {
                apologize("New passwords do not match!");
            }
            // query database for user
            $rows = CS50::query("SELECT hash FROM users WHERE id = ?", $_SESSION["id"]);

            // if we found user, check password
            if (count($rows) == 1)
            {
                // first (and only) row
                $row = $rows[0];

                // compare hash of user's input against hash that's in database
                if (!password_verify($_POST["old_password"], $row["hash"]))
                {
                    apologize("You must enter your current password!");
                }
                else
                {
                    $newhash = password_hash($_POST["old_password"], PASSWORD_DEFAULT);
                    $dump = password_hash($newhash);
                    dump(["oldp" => $_POST["old_password"], "oldp_db_hash" => $row["hash"], "oldp_newhash" => $dump]);
                    // $result = CS50::query("UPDATE users SET hash = ? WHERE id = ?"), password_hash($_POST["new_password"], PASSWORD_DEFAULT), $_SESSION["id"]);
                    if ($result === false)
                    {
                        apologize("ERROR: Could not update password.");
                    }
                }
            }
            else
            {
                apologize("ERROR: Unkown user.");
            }
        }
        else if ($_POST["referer"] == "email_reset_action")
        {
            if (empty($_POST["email"]) || empty($_POST["emailconfirm"]))
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
            else
            {
                
            }
            // otherwise, update email
            $result = CS50::query("UPDATE users SET email = ? WHERE id = ?", $_POST["email"], $_SESSION["id"]);
            if ($result === false)
            {
                apologize("ERROR: Could not update email address.");
            }
    
            // redirect to profile
            redirect("/profile.php");
        }
    }

?>
