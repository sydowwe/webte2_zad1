<?php
require '../config.php';

if (empty($_SESSION["id"])) {
  header("Location: /zad1/");
}


// Fill these out with the values you got from Google
$googleClientID = '375969918443-v9ojif66mv1abm4tuhhol4evj3l088b0.apps.googleusercontent.com';
$googleClientSecret = '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';

// This is the URL we'll send the user to first to get their authorization
$authorizeURL = 'https://accounts.google.com/o/oauth2/v2/auth';

// This is Google's OpenID Connect token endpoint
$tokenURL = 'https://www.googleapis.com/oauth2/v4/token';

// The URL for this script, used as the redirect URL
$baseURL = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];

// Start a session so we have a place to store things between redirects
session_start();



// Start the login process by sending the user
// to Google's authorization page
if (isset($_GET['action']) && $_GET['action'] == 'login') {
  unset($_SESSION['user_id']);

  // Generate a random hash and store in the session
  $_SESSION['state'] = bin2hex(random_bytes(16));

  $params = array(
    'response_type' => 'code',
    'client_id' => $googleClientID,
    'redirect_uri' => $baseURL,
    'scope' => 'openid email',
    'state' => $_SESSION['state']
  );

  // Redirect the user to Google's authorization page
  header('Location: ' . $authorizeURL . '?' . http_build_query($params));
  die();
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  unset($_SESSION['user_id']);
  header('Location: ' . $baseURL);
  die();
}

// When Google redirects the user back here, there will be a "code" and "state"
// parameter in the query string
if (isset($_GET['code'])) {
  // Verify the state matches our stored state
  if (!isset($_GET['state']) || $_SESSION['state'] != $_GET['state']) {
    header('Location: ' . $baseURL . '?error=invalid_state');
    die();
  }

  // Exchange the auth code for a token
  $ch = curl_init($tokenURL);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'authorization_code',
    'client_id' => $googleClientID,
    'client_secret' => $googleClientSecret,
    'redirect_uri' => $baseURL,
    'code' => $_GET['code']
  ]));
  $response = curl_exec($ch);
  $data = json_decode($response, true);

  // Note: You'd probably want to use a real JWT library
  // but this will do in a pinch. This is only safe to do
  // because the ID token came from the https connection
  // from Google rather than an untrusted browser redirect

  // Split the JWT string into three parts
  $jwt = explode('.', $data['id_token']);

  // Extract the middle part, base64 decode it, then json_decode it
  $userinfo = json_decode(base64_decode($jwt[1]), true);

  $_SESSION['user_id'] = $userinfo['sub'];
  $_SESSION['email'] = $userinfo['email'];

  // While we're at it, let's store the access token and id token
  // so we can use them later
  $_SESSION['access_token'] = $data['access_token'];
  $_SESSION['id_token'] = $data['id_token'];
  $_SESSION['userinfo'] = $userinfo;

  header('Location: ' . $baseURL);
  die();
}

$loggedInTime = date('m/d/Y h:i:s a', time());

// If there is a user ID in the session
// the user is already logged in
if (!isset($_GET['action'])) {
  if (!empty($_SESSION['user_id'])) {
    $user = $_SESSION['email'];
    $password = $_SESSION['user_id'];
    $result = mysqli_query($conn, "SELECT * FROM User WHERE email = '$user'");
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
      if (password_verify($password, $row['password'])) {
        $_SESSION["id"] = $row["id"];
        $_SESSION["email"] = $row["email"];
        $current = $_SESSION["id"];
        $sql = "INSERT INTO user_data (time_when_logged_in,time_when_logged_out,User_id) VALUES ('$loggedInTime','session','$current')";
        mysqli_query($con, $sql);
        header("Location: https://site221.webte.fei.stuba.sk/index.php");
      }
    } else {
      $options = [
        'cost' => 12,
      ];
      $password = password_hash($password, PASSWORD_BCRYPT, $options);

      $sql = "INSERT INTO User (name,surname,username,password,email,role,method) VALUES ('none','none','none','$password','$user','User','Google')";
      $r=mysqli_query($con, $sql);
      while ($row = mysqli_fetch_assoc($r)) {
        $_SESSION["id"] = $row["id"];
        $_SESSION["email"] = $row["email"];
      }

      $current = $_SESSION["id"];
      $sql = "INSERT INTO user_data (time_when_logged_in,time_when_logged_out,User_id) VALUES ('$loggedInTime','session','$current')";
      mysqli_query($conn, $sql);
      $sql = "UPDATE User
      SET verified=1
      WHERE id='$current'";
      mysqli_query($conn, $sql);
      header("Location: https://site221.webte.fei.stuba.sk/index.php");
    }




  }
  die();
}

?>