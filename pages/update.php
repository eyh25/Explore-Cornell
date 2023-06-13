<?php
$showform = True;
$showconfirmation = False;

$parameter = $_GET["id"] ?? null;

$result_location = exec_sql_query($db,
"SELECT locations.id AS 'locations.id', locations.file_ext AS 'locations.file_ext', locations.file_name AS 'locations.file_name', locations.source AS 'locations.source', locations.name AS 'locations.name', locations.address AS 'locations.address', locations.description AS 'locations.description'
FROM locations
WHERE (id == $parameter)"
);
$record_locations = $result_location->fetchAll();

if ($delete) {
  // Delete session from database.
  // Note: You probably also need a "cron" job that cleans up expired sessions.
  exec_sql_query(
    $db,
    "DELETE FROM locations WHERE (id = :id);",
        array(':id' => $location['id'])
  );
}

if(isset($_POST["delete-button"])) {
  exec_sql_query(
    $db,
    "DELETE FROM locations WHERE (id = $parameter);"
  );
  exec_sql_query(
    $db,
    "DELETE FROM location_tags WHERE (location_id = $parameter)"
  );
  unlink($file_url);
  $showform = False;
  $showconfirmation = True;
}
?>


<!DOCTYPE html>
<html lang="en">

<title>Update Locations</title>

<?php include('includes/header.php'); ?>

<body>

  <main>
  <div class="update-delete">
  <?php if ($showform) { ?>
    <p class="delete"> Are you sure you want to delete this location?</p>

    <?php
      $file_url = '/public/uploads/locations/' . $record_locations[0]['locations.id'] . '.' . $record_locations[0]['locations.file_ext'];?>
    <p class="delete"><?php echo htmlspecialchars($record_locations[0]['locations.name']); ?></p>

    <p>
        <img src="<?php echo htmlspecialchars($file_url); ?>"
        width="320"
        height="221"
        alt="<?php echo htmlspecialchars($record_locations[0]['locations.file_name']); ?>">
      </p>
    <form method="post">
    <input type="submit" value="Confirm Delete" name="delete-button"><br/><br/>
  <?php } ?>
    </form>
  </div>


<?php if ($showconfirmation) { ?>

<section class="notice">
  <h2>Location Deletion Confirmation</h2>

  <p><?php echo htmlspecialchars($record_locations[0]['locations.name']); ?> has been deleted</p>
  <p><a class="return" href="/">Return to Home</a></p>


</section>

<?php } ?>
  </main>

</body>

</html>
