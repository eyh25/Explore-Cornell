<?php
$parameter = $_GET["id"] ?? null;

$result_location = exec_sql_query($db, "SELECT locations.id AS 'locations.id', locations.file_ext AS 'locations.file_ext', locations.source AS 'locations.source', locations.file_name AS 'locations.file_name', locations.name AS 'locations.name', locations.address AS 'locations.address', locations.description AS 'locations.description', tags.tag AS 'tags.tag', location_tags.location_id AS 'location_tags.location_id', location_tags.tag_id AS 'location_tags.tag_id'
FROM location_tags
INNER JOIN tags ON (location_tags.tag_id = tags.id)
INNER JOIN locations ON (location_tags.location_id = locations.id)
WHERE (location_tags.tag_id = $parameter)"
);
$record_locations = $result_location->fetchAll();
?>



<!DOCTYPE html>
<html lang="en">
<title>Tags</title>

<?php include('includes/header.php'); ?>


<main>
  <div class="table">

  <?php
  // write a table row for each record
  foreach ($record_locations as $record) {
    $file_url = '/public/uploads/locations/' . $record['locations.id'] . '.' . $record['locations.file_ext'];?>

    <div class="table-tag">
      <p class="image"><a class="image" href="/details?<?php echo http_build_query(array('id' => $record['locations.id'])); ?>"><img src="<?php echo htmlspecialchars($file_url); ?>"
      width="320"
      height="221"
      alt="<?php echo htmlspecialchars($record['locations.file_name']); ?>"></a></p>
      <p class="cite"><?php echo htmlspecialchars($record['locations.source']); ?></p>
      <p class="name"><?php echo htmlspecialchars($record['locations.name']); ?></p>
      </div>


  <?php } ?>
  </div>


  </main>
