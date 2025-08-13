<div class = "admin-form">

<h2>Login</h2>

<form action="index.php?page=../admin/adminlogin" method="post">
    <p>Username: <input name="username" placeholder="Username"/></p>
    <p>Password: <input name="password" placeholder="Password" type="password" /></p>

    <?php

    if (isset($_GET['error'])) {
        ?>
        <span class="error">
            <?php echo $_GET['error']; ?>
        </span>

        <?php
        //end of get error if
    }

    ?>

    <p><input name="login" type="submit" value="Log In" /></p>
</form>
</div>