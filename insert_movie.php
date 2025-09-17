<?php

// check user is logged on
if (isset($_SESSION['admin'])) {

    if (isset($_REQUEST['submit'])) {

        // retrieve data from form
        $movie = $_REQUEST['movie'];
        $director_full = $_REQUEST['director_full'];

        $first = "";
        $last = "";

        // handle blank fields
        if ($director_full == "") {
            $director_full = $first = "Anonymous";
        }

        // check to see if movie is in DB, if it is then tell user this is a duplicate
        $find_movie_sql = "SELECT * FROM movies WHERE Title = '$movie'";
        $find_movie_query = mysqli_query($dbconnect, $find_movie_sql);
        $movie_count = mysqli_num_rows($find_movie_query);

        // if duplicate movie found
        if ($movie_count > 0) {
            ?>
            <div class="error_message">
                <p>Sorry! It looks like the movie you tried to add is already in the database</p>
            </div>
            <?php 
        }
        else {
            // check to see if director is in DB, if it isn't add it
            $find_director_id = "SELECT * FROM director d 
                                 WHERE CONCAT(d.First, ' ', d.Last) LIKE '%$director_full%'";
            $find_director_query = mysqli_query($dbconnect, $find_director_id);
            $find_director_rs = mysqli_fetch_assoc($find_director_query);
            $director_count = mysqli_num_rows($find_director_query);

            include("admin/process_form.php");

            // insert movie
            $stmt = $dbconnect->prepare("INSERT INTO `movies` (`Director_ID`, `Title`) VALUES (?, ?);");
            $stmt->bind_param("is", $director_ID, $movie);
            $stmt->execute();

            $Movie_ID = $dbconnect->insert_id;

            // close stmt once everything has been inserted
            $stmt->close();

            $heading = "Movie Success";
            $sql_conditions = "WHERE Movie_ID = $Movie_ID";

            include("content/results.php");
        }

    } // end submit check

} else {
    // if not logged in
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>
