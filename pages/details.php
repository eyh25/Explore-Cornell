<?php
$parameter = $_GET["id"] ?? null;

$result_location = exec_sql_query($db,
"SELECT locations.id AS 'locations.id', locations.file_ext AS 'locations.file_ext', locations.file_name AS 'locations.file_name', locations.source AS 'locations.source', locations.name AS 'locations.name', locations.address AS 'locations.address', locations.description AS 'locations.description'
FROM locations
WHERE (id == $parameter)"
);
$record_locations = $result_location->fetchAll();

$result_tag = exec_sql_query($db,
"SELECT tags.tag AS 'tags.tag'
FROM location_tags INNER JOIN tags ON (location_tags.tag_id = tags.id)
WHERE (location_tags.location_id == $parameter)"
);
$record_tags = $result_tag->fetchAll();
?>



<!DOCTYPE html>
<html lang="en">

<title>Details Page</title>
<?php include('includes/header.php'); ?>
  <main>

  <li class="details-page">

    <?php
    $file_url = '/public/uploads/locations/' . $record_locations[0]['locations.id'] . '.' . $record_locations[0]['locations.file_ext'];?>

    <p class="tag-name"><?php echo htmlspecialchars($record_locations[0]['locations.name']); ?></p>

    <p>
      <img src="<?php echo htmlspecialchars($file_url); ?>"
      width="320"
      height="221"
      alt="<?php echo htmlspecialchars($record_locations[0]['locations.file_name']); ?>">
    </p>

    <p class="cite"><?php echo htmlspecialchars($record_locations[0]['locations.source']); ?></p>

    <p><?php echo htmlspecialchars($record_locations[0]['locations.address']); ?></p>
    <p class="description"><?php echo htmlspecialchars($record_locations[0]['locations.description']); ?></p>

    <?php foreach ($record_tags as $record) { ?>
      <p class="tags"><?php echo htmlspecialchars($record['tags.tag']); ?></p>
    <?php } ?>
  </li>

  </main>

</body>

</html>
