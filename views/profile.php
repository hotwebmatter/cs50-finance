    <table class="table table-striped">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Cash</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td><?= $profile[0]["username"] ?></td>
            <td><?= $profile[0]["email"] ?></td>
            <td>$<?= $profile[0]["cash"] ?></td>
        </tr>
        <tr>
            <td>
                <form action="profile.php" method="post">
                    <fieldset>
                        <span class="form-group">
                            <input type="hidden" name="referer" value="password_reset_form">
                            <button class="btn btn-default" type="submit">
                                Change Password
                            </button>
                        </span>
                    </fieldset>
                </form>
            </td>
            <td>
                <form action="profile.php" method="post">
                    <fieldset>
                        <span class="form-group">
                            <input type="hidden" name="referer" value="email_reset_form">
                            <button class="btn btn-default" type="submit">
                                Change Email
                            </button>
                        </span>
                    </fieldset>
                </form>            
            </td>
            <td>
                <form action="profile.php" method="post">
                    <fieldset>
                        <span class="form-group">
                            <input type="hidden" name="referer" value="add_cash">
                            <button class="btn btn-default" type="submit">
                                Add Cash
                            </button>
                        </span>
                    </fieldset>
                </form>            
            </td>
        </tr>
        </tbody>
    </table>