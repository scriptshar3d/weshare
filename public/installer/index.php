<?php
require 'vendor/autoload.php';

use sixlive\DotenvEditor\DotenvEditor;

$editor = new DotenvEditor;
$editor->load(__DIR__ . '/../../.env');

function appUrl()
{
  $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
    "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
    $_SERVER['REQUEST_URI'];
  $link = str_replace("/installer/", "", $link);
  return $link;
}

function fixInValidEnvValue($value)
{
  if ((substr($value, 0, 1) != '"' && (substr($value, 0, 1) != '"')) && strpos($value, ' ') !== false) {
    $value = '"' . $value . '"';
  }
  return $value;
}

if (!is_writable("../../.env")) {
  die("Make sure your .env file in source code is writable by web server's user");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // fix if new env value contains any invalid value
  $_POST['app_name'] =trim(fixInValidEnvValue($_POST['app_name']));

  // update .env values
  $editor->set('APP_NAME', $_POST['app_name']);
  $editor->set('APP_URL', trim($_POST['app_url']));
  $editor->set('DB_CONNECTION', trim($_POST['db_connection']));
  $editor->set('DB_HOST', trim($_POST['db_host']));
  $editor->set('DB_PORT', trim($_POST['db_port']));
  $editor->set('DB_DATABASE', trim($_POST['db_name']));
  $editor->set('DB_USERNAME', trim($_POST['db_user']));
  $editor->set('DB_PASSWORD', trim($_POST['db_password']));
  $editor->set('FIREBASE_ISS', trim($_POST['firebase_project_id']));
  $editor->set('ONESIGNAL_APP_ID', trim($_POST['onesignal_app_id']));
  $editor->set('ONESIGNAL_REST_API', trim($_POST['onesignal_rest_api']));
  $editor->save();

  // prepare config file for admin panel
  $admin_config_path = "assets/appConfig.json";
  $admin_config_content = file_get_contents($admin_config_path);
  $admin_config_content = str_replace('APP_NAME', str_replace('"', "", $_POST['app_name']), $admin_config_content);
  $admin_config_content = str_replace('ADMIN_API_BASE_URL', $_POST['app_url'] . '/api/admin', $admin_config_content);
  file_put_contents($admin_config_path, $admin_config_content);
  copy($admin_config_path, "../admin/".$admin_config_path);
}


// set default values, if required
$appUrl = $editor->getEnv('APP_URL');
if (!$appUrl) {
  $appUrl = appUrl();
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Weshare Installation Wizard</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <!-- Custom styles for this template -->
  <link href="form-validation.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container">
    <div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="assets/logo.png" alt="" width="96" height="96">
      <h2>Weshare Installation Wizard</h2>
      <p class="lead">Below are the configuration values required to make the backend work. After you set the values, wizard will automatically set the environment variable and set up the admin panel</p>
    </div>

    <div class="row">
      <div class="col-md-6 order-md-1 mx-auto">
        <hr class="mb-4">
        <h5 class="mb-2 mt-2 text-center">Application Details</h5>
        <hr class="mb-4">
        <form class="needs-validation" novalidate method="post">
          <div class="mb-3">
            <label for="appName">App Name</label>
            <input type="text" class="form-control" id="appName" name="app_name" value="<?= htmlentities($editor->getEnv('APP_NAME')) ?>" required>
            <div class="invalid-feedback">
              Valid app name is required.
            </div>
            <div class="text-danger" style="<?php isset($errors['app_name']) ? 'display:none' : ''; ?>">
              <?= isset($errors['app_name']) ? $errors['app_name'] : '' ?>
            </div>
          </div>

          <div class="mb-3">
            <label for="appUrl">App Url</label>
            <input type="url" class="form-control" id="appUrl" name="app_url" value="<?= $appUrl ?>" required>
            <div class="invalid-feedback">
              Valid app url is required.
            </div>
          </div>

          <hr class="mb-4 mt-5">
          <h5 class="mb-2 mt-2 text-center">Database Credentials</h5>
          <hr class="mb-4">

          <div class="mb-3">
            <label for="databaseConnection">Database Connection(e.g. mysql)</label>
            <input type="text" class="form-control" id="databaseConnection" name="db_connection" value="<?= $editor->getEnv('DB_CONNECTION') ?>" required>
            <div class="invalid-feedback">
              Valid database connection is required.
            </div>
          </div>

          <div class="mb-3">
            <label for="databaseHost">Database Host(e.g. localhost)</label>
            <input type="text" class="form-control" id="databaseHost" name="db_host" value="<?= $editor->getEnv('DB_HOST') ?>" required>
            <div class="invalid-feedback">
              Valid database host is required.
            </div>
          </div>

          <div class="mb-3">
            <label for="databasePort">Database Port(e.g. 3306)</label>
            <input type="text" class="form-control" id="databasePort" name="db_port" value="<?= $editor->getEnv('DB_PORT') ?>" required>
            <div class="invalid-feedback">
              Valid database port is required.
            </div>
          </div>

          <div class="mb-3">
            <label for="databaseName">Database Name</label>
            <input type="text" class="form-control" id="databaseName" name="db_name" value="<?= $editor->getEnv('DB_DATABASE') ?>" required>
            <div class="invalid-feedback">
              Valid database name is required.
            </div>
          </div>

          <div class="mb-3">
            <label for="databaseUser">Database User</label>
            <input type="text" class="form-control" id="databaseUser" name="db_user" value="<?= $editor->getEnv('DB_USERNAME') ?>" required>
            <div class="invalid-feedback">
              Valid database username is required.
            </div>
          </div>

          <div class="mb-3">
            <label for="databasePassword">Database Password</label>
            <input type="text" class="form-control" id="databasePassword" name="db_password" value="<?= $editor->getEnv('DB_PASSWORD') ?>">
            <div class="invalid-feedback">
              Valid database password is required.
            </div>
          </div>

          <hr class="mb-4 mt-5">
          <h5 class="mb-2 mt-2 text-center">Firebase</h5>
          <hr class="mb-4">
          <div class="mb-3">
            <label for="firebaseProjectId">Firebase ISS</label>
            <input type="text" class="form-control" id="firebaseProjectId" name="firebase_project_id" value="<?= $editor->getEnv('FIREBASE_ISS') ?>" required>
            <label class="text-muted">Example: https://securetoken.google.com/your-firebase-project-id</label>
            <label class="text-muted"><a href="https://firebase.google.com/docs/projects/learn-more#project-id" target="_blank">How to find your firebase project id</a></label>
            <div class="invalid-feedback">
              Valid Firebase Project Id is required.
            </div>
          </div>

          <hr class="mb-4 mt-5">
          <h5 class="mb-2 mt-2 text-center">Push Notifications(<a href="https://documentation.onesignal.com/docs/accounts-and-keys" target="_blank">?</a>)</h5>
          <hr class="mb-4">

          <div class="mb-3">
            <label for="oneSignalAppId">One Signal App ID</label>
            <input type="text" class="form-control" id="oneSignalAppId" name="onesignal_app_id" value="<?= $editor->getEnv('ONESIGNAL_APP_ID') ?>" required>
            <div class="invalid-feedback">
              Valid One Signal App ID is required.
            </div>
          </div>

          <div class="mb-3">
            <label for="oneSignalRestApi">One Signal REST API</label>
            <input type="text" class="form-control" id="oneSignalRestApi" name="onesignal_rest_api" value="<?= $editor->getEnv('ONESIGNAL_REST_API') ?>" required>
            <div class="invalid-feedback">
              Valid One Signal REST API is required.
            </div>
          </div>
          <button class="mt-5 btn btn-primary btn-lg btn-block" type="submit">Install</button>
        </form>
      </div>
    </div>
  </div>
  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2019-2020 Opus Labs</p>
  </footer>
  </div>

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';

      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>

</html>