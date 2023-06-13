<?php
if (is_user_logged_in()) {
  define("MAX_FILE_SIZE", 1000000);
  $upload_feedback = array(
    'general_error' => False,
    'too_large' => False
  );

  $upload_source = NULL;
  $upload_file_name = NULL;
  $upload_file_ext = NULL;


  $insert_values = array(
    'name' => NULL,
    'address' => NULL,
    'description' => NULL,
    'newtag' => NULL,
    'study' => NULL,
    'date' => NULL,
    'nature' => NULL,
    'food' => NULL,
    'tag' => NULL
  );


  $result_tags = exec_sql_query($db, 'SELECT * FROM tags;');
  $records_tags = $result_tags->fetchAll();

  $show_confirmation = False;
  $show_form= True;

  $form_feedback_classes = array(
    'name' => 'hidden',
    'address' => 'hidden',
    'description' => 'hidden',
    'newtag' => 'hidden',
    'tags' => 'hidden'
  );

  $form_values = array(
    'name' => '',
    'address' => '',
    'description' => '',
    'newtag' => '',
    'study' => '',
    'date' => '',
    'nature' => '',
    'food' => ''
  );

  $sticky_values = array(
    'name' => '',
    'address' => '',
    'description' => '',
    'newtag' => '',
    'study' => '',
    'date' => '',
    'nature' => '',
    'food' => ''
  );

  if (isset($_POST['request-location'])) {
    $form_values['name'] = trim($_POST['name']); // untrusted
    $form_values['address'] = trim($_POST['address']); // untrusted
    $form_values['description'] = trim($_POST['description']); // untrusted
    $form_values['newtag'] = trim($_POST['newtag']); // untrusted
    $form_values['study'] = 1; // untrusted
    $form_values['date'] = 2; // untrusted
    $form_values['nature'] = 3; // untrusted
    $form_values['food'] = 4; // untrusted
    $upload_source = trim($_POST['source']); // untrusted
    if (empty($upload_source)) {
      $upload_source = NULL;
    }

    $insert_values['name'] = ($_POST['name'] == '' ? NULL : trim($_POST['name'])); // untrusted
    $insert_values['address'] = ($_POST['address'] == '' ? NULL : trim($_POST['address'])); // untrusted
    $insert_values['description'] = ($_POST['description'] == '' ? NULL : trim($_POST['description'])); // untrusted
    $insert_values['newtag'] = ($_POST['newtag'] == '' ? NULL : trim($_POST['newtag'])); // untrusted
    $insert_values['study'] = (1 ? NULL : 1); // untrusted
    $insert_values['date'] = (2 ? NULL : 2); // untrusted
    $insert_values['nature'] =(3? NULL :3); // untrusted
    $insert_values['food'] =(4 ? NULL : 4); // untrusted


    $upload = $_FILES['svg-file'];

    $form_valid = True;

    // name required
    if ($form_values['name'] == '') {
      $form_valid = False;
      $form_feedback_classes['name'] = '';
    }

    // address required
    if ($form_values['address'] == '') {
      $form_valid = False;
      $form_feedback_classes['address'] = '';
    }

    // description required
    if ($form_values['description'] == '') {
      $form_valid = False;
      $form_feedback_classes['description'] = '';
    }

    // at least one box checked required
    if(
      !$form_values['study']&&
      !$form_values['date']&&
      !$form_values['nature']&&
      !$form_values['food']
    ) {
      $form_valid = False;
      $form_feedback_classes['tags'] = '';
    }

    if ($upload['error'] == UPLOAD_ERR_OK) {
      // The upload was successful!

      // Get the name of the uploaded file without any path
      $upload_file_name = basename($upload['name']);

      // Get the file extension of the uploaded file and convert to lowercase for consistency in DB
      $upload_file_ext = strtolower(pathinfo($upload_file_name, PATHINFO_EXTENSION));

      // This site only accepts SVG files!
      if (!in_array($upload_file_ext, array('jpeg'))&& !in_array($upload_file_ext, array('png'))) {
        $form_valid = False;
        $upload_feedback['general_error'] = True;
      }
    } else if (($upload['error'] == UPLOAD_ERR_INI_SIZE) || ($upload['error'] == UPLOAD_ERR_FORM_SIZE)) {
      // file was too big, let's try again
      $form_valid = False;
      $upload_feedback['too_large'] = True;
    } else {
      // upload was not successful
      $form_valid = False;
      $upload_feedback['general_error'] = True;
    }

    if ($form_valid) {
      $show_confirmation = True;
      $show_form = False;

      $result1 = exec_sql_query(
        $db,
        "INSERT INTO locations (name, address, description, file_name, file_ext, source) VALUES (:names, :addresses, :descriptions, :file_name, :file_ext, :source);",
        array(
          ':names' => $insert_values['name'],
          ':addresses' => $insert_values['address'],
          ':descriptions' => $insert_values['description'],
          ':file_name' => $upload_file_name,
          ':file_ext' => $upload_file_ext,
          ':source' => $upload_source
        )
      );
      $previous_id = $db->lastInsertId('id');

      if ($_POST['newtag']){
      $result3 = exec_sql_query(
        $db,
        "INSERT INTO tags (tag) VALUES (:tags);",
        array(
          ':tags' => $insert_values['newtag'],
        )
        );
      }


      foreach ($records_tags as $record){
        if ($_POST[$record['id']]){
          $result2 = exec_sql_query(
            $db,
            "INSERT INTO location_tags (location_id, tag_id) VALUES (:loca, :tag);",
            array(
              ':loca' => $previous_id,
              ':tag' => ($record['id'])
              )
            )
        ;}
      }

      if ($result1) {
        $upload_storage_path = 'public/uploads/locations/' . $previous_id . '.' . $upload_file_ext;

        if (move_uploaded_file($upload["tmp_name"], $upload_storage_path) == False) {
          error_log("Failed to permanently store the uploaded file on the file server. Please check that the server folder exists.");
        }
      }
    }

    } else {
      // set sticky values
      $sticky_values['name'] = $form_values['name'];
      $sticky_values['address'] = $form_values['address'];
      $sticky_values['description'] = $form_values['description'];
      $sticky_values['tag'] = ($form_values['tag'] ? 'checked' : '');
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<title>Form</title>

<?php include('includes/header.php'); ?>

<main class="form">

<?php if (is_user_logged_in()) { ?>
  <?php if ($show_confirmation) { ?>

    <section class="notice">
      <h2>Location Submission Confirmation</h2>

      <p>Thank you for adding a new location!</p>
      <p><a class="return" href="/">Return to Home</a></p>


    </section>

  <?php } ?>


  <?php if ($show_form) { ?>
  <section class="form">

    <form id="request-form" action="/form" method="post" enctype="multipart/form-data" novalidate>

    <p class="form">Add Location</p>

    <div id="feedback-name" class="feedback <?php echo $form_feedback_classes['name']; ?>">Please enter the name of the location.</div>

    <div class="form-label">
      <label for="request-name">Name of Location:</label>
      <input type="name" name="name" id="request-name" value="<?php echo $sticky_values['name']; ?>" />
    </div>

    <div id="feedback-address" class="feedback <?php echo $form_feedback_classes['address']; ?>">Please enter the address of the location.</div>

    <div class="form-label">
      <label for="request-address">Address of Location:</label>
      <input type="address" name="address" id="request-address" value="<?php echo $sticky_values['address']; ?>" />
    </div>

    <div id="feedback-description" class="feedback <?php echo $form_feedback_classes['description']; ?>">Please enter a description of the location.</div>

    <div class="form-label">
      <label for="request-description">Description of Location:</label>

      <textarea type="description" name="description" id="request-description" value="<?php echo $sticky_values['description']; ?>"> </textarea>
    </div>

    <div class="type-form">
      <?php
        // write a table row for each record
        foreach ($records_tags as $record) {
          ?>
          <li class="tag-table">
            <input id="<?php echo $record['id'] ?>" type="checkbox" name= "<?php echo $record['id'] ?>"/>
            <label for="<?php echo $record['id'] ?>"><?php echo htmlspecialchars($record['tag']); ?></label>
        </li>
        <?php } ?>
    </div>

    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">

        <?php if ($upload_feedback['too_large']) { ?>
          <p class="feedback">We're sorry. The file failed to upload because it was too big. Please select a file that&apos;s no larger than 1MB.</p>
        <?php } ?>

        <?php if ($upload_feedback['general_error']) { ?>
          <p class="feedback">We're sorry. Something went wrong. Please select an SVG file to upload.</p>
        <?php } ?>

        <div class="label-input">
          <label for="upload-file">PNG or JPEG File:</label>
          <!-- This site only accepts SVG files! -->
          <input id="upload-file" type="file" name="svg-file" accept=".png, .jpeg">
        </div>

        <div class="label-input">
          <label for="upload-source" class="optional">Source URL:</label>
          <input id='upload-source' type="url" name="source" placeholder="URL where found. (optional)">
        </div>

    <div class="align-right">
      <button id="request-submit" type="submit" name="request-location">Add</button>
    </div>

  </form>
  <?php } ?>

  </section>
  <?php } ?>



</main>

</body>
</html>
