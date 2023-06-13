<?php
$results_tags = exec_sql_query($db, 'SELECT * FROM tags;');

// get records from query
$records_tags = $results_tags->fetchAll();

?>
<head>
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

</head>

<body>
  <div class="heading">
    <a class="title" href="/">Explore Cornell</a>
    <?php if (!is_user_logged_in()) { ?>
      <a class="heading" href="/login">Log In</a>
    <?php } ?>


      <?php if (is_user_logged_in()) { ?>
        <div class="form-signout">
        <a class="heading" href="/form">Form</a>
        <a class="heading" href="<?php echo logout_url(); ?>">Sign Out</a>
        </div>
      <?php } ?>

  </div>


  <ul class="filter-tag">
  <?php foreach ($records_tags as $record) { ?>
    <p><a class="tags" href="/tag?<?php echo http_build_query(array('id' => $record['id'])); ?>"><?php echo htmlspecialchars($record['tag']); ?></a></p>

    <?php } ?>
    </ul>
