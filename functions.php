<?php 

// function to 'clean' data
function clean_input($dbconnect, $data) {
    $data = trim($data);    
    $data = htmlspecialchars($data); //  needed for correct special 
    // character rendering
    // removes dodgy characters to prevent SQL injections
    $data = mysqli_real_escape_string($dbconnect, $data);
    return $data;
}

function get_data($dbconnect, $more_condition=null) {
// m => movies table
// d => director table

$find_sql = "SELECT  

m.*,
d.*,
CONCAT(d.First, ' ', d.Last) AS Full_Name

FROM movies m

JOIN director d ON d.Director_ID = m.Director_ID

";
// if we have a where condiiton, add it to the sql
if($more_condition != null) {
    // add extra string onto find sql
    $find_sql .= $more_condition;
}

$find_query = mysqli_query($dbconnect, $find_sql);
$find_count = mysqli_num_rows($find_query);

return $find_query_count = array($find_query, $find_count);

}

function get_item_name($dbconnect, $table, $column, $ID)
{
    $find_sql = "SELECT * FROM $table WHERE $column = $ID";
    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);

    return $find_rs;
}

// entity is subject, country, occupation etc
function autocomplete_list($dbconnect, $item_sql, $entity)    
{
// Get entity / topic list from database
$all_items_query = mysqli_query($dbconnect, $item_sql);
    
// Make item arrays for autocomplete functionality...
while($row=mysqli_fetch_array($all_items_query))
{
  $item=$row[$entity];
  $items[] = $item;
}

$all_items=json_encode($items);
return $all_items;
    
}


// function to get subject, country & career ID's
function get_ID($dbconnect, $table_name, $column_ID, $column_name, $entity)
{
    
    if($entity=="")
    {
        return 0;
    }
    
    
    // get entity ID if it exists
    $findid_sql = "SELECT * FROM $table_name WHERE $column_name LIKE '$entity'";
    $findid_query = mysqli_query($dbconnect, $findid_sql);
    $findid_rs = mysqli_fetch_assoc($findid_query);
    $findid_count=mysqli_num_rows($findid_query);
    
    // If subject ID does exists, return it...
    if($findid_count > 0) {
        $find_ID = $findid_rs[$column_ID];
        return $find_ID;
    }   // end if (entity existed, ID returned)
    

    else {
        $add_entity_sql = "INSERT INTO $table_name ($column_ID, $column_name) VALUES (NULL, '$entity');";
        $add_entity_query = mysqli_query($dbconnect, $add_entity_sql);
        
    $new_id_sql = "SELECT * FROM $table_name WHERE $column_name LIKE '$entity'";
    $new_id_query = mysqli_query($dbconnect, $new_id_sql);
    $new_id_rs = mysqli_fetch_assoc($new_id_query);
        
    $new_id = $new_id_rs[$column_ID];
    
    return $new_id;
        
    }   // end else (entity added to table and ID returned)
    
} // end get ID function


function get_rs($dbconnect, $sql)
{
    $find_sql = $sql;
    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);
    
    return $find_rs;
}

// delete ghost directors
function delete_ghost($dbconnect, $directorID)
{
    // see if there are other movies by that director
    $check_director_sql = "SELECT * FROM `movies` WHERE `Director_ID` = $directorID";
    $check_director_query = mysqli_query($dbconnect, $check_director_sql);

    $count_director = mysqli_num_rows($check_director_query);

    //if there are not movies associated with the old director, we can delete
    if ($count_director <= 1) {
        $delete_ghost = "DELETE FROM `director` WHERE `director`. `Director_ID` = 
        $directorID ";
        $delete_ghost_query = mysqli_query($dbconnect, $delete_ghost);
    }
}

?>