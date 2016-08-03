<form action="profile.php" method="post">
    <fieldset>
        <div class="form-group">
            <input class="form-control" name="old_password" placeholder="Current Password" type="password"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="new_password" placeholder="New Password" type="password"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="new_confirmation" placeholder="Confirm New Password" type="password"/>
        </div>
        <div class="form-group">
            <input type="hidden" name="referer" value="password_reset_action">
            <button class="btn btn-default" type="submit">
                Change Password
            </button>
        </div>
    </fieldset>
</form>