<?php 

$all_results = get_data($dbconnect, $sql_conditions);

$find_query = $all_results[0];
$find_count = $all_results[1];

if($find_count == 1) {
    $result_s = "Result";
}
else {
    $result_s = "Results";
}

// check that we have results
if ($find_count > 0) {

// customise headings!

if ($heading != "") {
    $heading = "<h2>$heading ($find_count)</h2>";
}

elseif ($heading_type == "director") {
    // retrieve director name
    $director_rs = get_item_name($dbconnect, 'director', 'Director_ID',
    $director_ID);

    $director_name = $director_rs['First']." ".$director_rs['Last'];

    $heading = "<h2>$director_name Movies ($find_count $result_s)</h2>";
}

elseif ($heading_type == "movie_success") {
    $heading = "
    <h2>Insert Movie Success</h2>
    <p>You have inserted the following movie...</p>";
}

elseif ($heading_type=="edit_success") {
    $heading = "
    <h2>Edit Movie Success</h2>
    <p>You have edited the movie.   The entry is now...</p>";
}

elseif ($heading_type=="delete_movie") {
    $heading = "
    <h2>Delete Movie - Are you sure?</h2>
    <p>
    Do you really want to delete the movie in the box below?
    </p>
    ";

}

echo $heading;

while ($find_rs = mysqli_fetch_assoc($find_query)) {
    $movie = $find_rs['Title'];

        // create full name of director
        $director_full = $find_rs['Full_Name'];
        $Movie_ID = $find_rs['Movie_ID'];

        // get director ID for clickable director link
        $director_ID = $find_rs['Director_ID'];
    
    ?>

    <div class="results">
        <?php echo $movie; ?>

        <p><i>
            <a href="index.php?page=all_results&search=director&Director_ID=<?php echo $director_ID; ?>">
            <?php echo $director_full; ?>
            </a>
        </i></p>

        <p>
        <?php 
        
        // if user is logged in, show edit / delete option
        if (isset($_SESSION['admin'])) {
            
            ?>
            <div class="tools">
                <a href="index.php?page=../admin/editquote&Movie_ID=<?php echo $Movie_ID; ?>"><i class="fa fa-edit fa-2x"></i></a> &nbsp; &nbsp;
                <a href="index.php?page=deleteconfirm&Movie_ID=<?php echo $Movie_ID; ?>"><i class="fa fa-trash fa-2x"></i></a>
            </div>
            <?php

        }

        ?>
        </p>
    </div>

    <br />

    <?php

} // end of while loop

} // end of 'have results'

// if there are no results, show an error message
else {

    ?>
    <h2>Sorry!</h2>
    <div class = "no-results">
        Unfortunately - there were no results for your search. Please
        try again.
    </div>
    <br />

    <?php
} // end of 'no results' else

?>
