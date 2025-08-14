<?php
// check user is logged on
if (isset($_SESSION['admin'])) {

// retrieve subjects and authors to populate combo box
include("sub_author.php");

// retrieve current values for quote...
$Movie_ID = $_REQUEST['Movie_ID'];

// get values from DB
$edit_query = get_data($dbconnect, "WHERE m.Movie_ID = $Movie_ID");

$edit_results_query = $edit_query[0];
$edit_results_rs = mysqli_fetch_assoc($edit_results_query);

$director_ID = $edit_results_rs['Director_ID'];
$director_full_name = $edit_results_rs['Full_Name'];
$movie = $edit_results_rs['Title'];

?>

<div class = "admin-form">
    <h2>Edit a Movie</h2>

    <form action="index.php?page=../admin/change_quote&Movie_ID=<?php echo $Movie_ID; ?>&
    directorID=<?php echo $director_ID; ?>" method="post">
        <p>
            <textarea name="movie" placeholder="Movie (Required)"
            required><?php echo $movie; ?></textarea>
        </p>

        <div class="important">
            If you edit an director, it will change the director name for the movie 
            being edited. It does not edit the director name on all movies
            attributed to that director.
        </div>

        <div class="autocomplete">
            <p><input name="director_full" id="director_full" value="<?php
            echo str_replace(' ', ' ', $director_full_name); ?>"
            /></p>
        </div>

        <br /><br />

        <p><input class="form-submit" type="submit" name="submit"
        value="Edit Movie" /></p>

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