<?php
$result = exec_sql_query($db, 'SELECT * FROM locations;');

// get records from query
$records = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<title>Explore Cornell</title>
<?php include('includes/header.php'); ?>

  <main>
      <div class="table">
      <?php
      // write a table row for each record
      foreach ($records as $record) {
        $file_url = '/public/uploads/locations/' . $record['id'] . '.' . $record['file_ext'];?>


        <div class="table-contents">
          <li class="table">

          <div class = "image-button">
            <p class="image-home"><a class="image-home" href="/details?<?php echo http_build_query(array('id' => $record['id'])); ?>"><img src="<?php echo htmlspecialchars($file_url); ?>"
            width="320"
            height="221"
            alt="<?php echo htmlspecialchars($record['file_name']); ?>"></a></p>


            <?php if (is_user_logged_in() && $is_admin) { ?>
              <td class="min">
                <form class="edit center-flex" method="get" action="/update">

                <input type="hidden" name="record" value="<?php echo htmlspecialchars($record['locations.id']); ?>" />

                <a class="center-flex" type="submit" href="/update?<?php echo http_build_query(array('id' => $record['id'])); ?>"> click to delete
            </a>


                </form>
              </td>
            <?php } ?>
          </div>

            <p class="cite"><?php echo htmlspecialchars($record['source']); ?></p>

            <p class="name"><a href="/details?<?php echo http_build_query(array('id' => $record['id'])); ?>"><?php echo htmlspecialchars($record['name']); ?></a></p>
            </li>
        </div>

      <?php } ?>
      </div>

  </main>

</body>

</html>
