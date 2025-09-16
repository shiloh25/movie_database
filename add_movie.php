<?php
// check user is logged on
if (isset($_SESSION['admin'])) {

// retrieve directorss to populate combo box
include("sub_director.php");

?>

<div class = "admin-form">
    <h2>Add Movie</h2>

    <form action="index.php?page=../admin/insert_movie" method="post">
        <p>
            <textarea name="movie" placeholder="Movie (Required)"
            required></textarea>
        </p>

        <div class="autocomplete">
            <input name="director_full" id="director_full" placeholder="Director Name (First, Last)"/>
        </div>
        
        <br /><br />

        <input class="form-submit" type="submit" name="submit"
        value="Submit Movie" />

    </form>

    <script>
        <?php include("autocomplete.php"); ?>

        // arrays containing lists
        var all_director = <?php print("$all_directors") ?>;
        autocomplete(document.getElementById("director_full"), all_director);

    </script>

</div>

<?php
    } // end user logged on if

    else {
        $login_error = 'Please login to access this page';
        header("Location: index.php?page=../admin/login&error=$login_error");
    }
?>