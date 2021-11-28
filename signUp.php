<?php
session_start();
include "./conn.php";
$nameError = $emailError = $imageError = $passwordError = $conPasswordError = $dobError = "";
$name = $email = $password = $conPassword = $dob = $age = "";
$image["size"] = [];
$ok = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = ($_POST["name"]);
  $email = strtolower($_POST["email"]);
  $image = ($_FILES["image"]);
  $password = ($_POST["password"]);
  $conPassword = ($_POST["password_confirmation"]);
  $dob = ($_POST["dob"]);

  if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
    $nameError = "Only letters and white space allowed";
    $ok = 0;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailError = ("$email is not a valid email address");
    $ok = 0;
  }
  if (!filter_var($password, FILTER_VALIDATE_REGEXP,  array("options" => array("regexp" => "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/")))) {
    $passwordError = ("your password is not a valid");
    $ok = 0;
  }

  if ($name == "") {
    $ok = 0;
    $nameError = "The name shouldn't be empty!";
  }
  if ($email == "") {
    $ok = 0;
    $emailError = "The email shouldn't be empty!";
  }
  if ($image["size"] == 0 && !isset($_POST["image-profile"])) {
    $ok = 0;
    $imageError = "Please make sure to select an image";
  }
  if ($password == "") {
    $ok = 0;
    $passwordError = "The password shouldn't be empty!";
  }
  if ($password != $conPassword) {
    $ok = 0;
    $conPasswordError = "password don't match";
  }
  if ($dob != "") {
    //explode the date to get month, day and year
    $dob = explode("-", $dob);
    //get age from date or birthdate
    $age = (date("md", date("U", mktime(0, 0, 0, $dob[2], $dob[1], $dob[0]))) > date("md")
      ? ((date("Y") - $dob[0]) - 1)
      : (date("Y") - $dob[0]));
  }
  if ($age < 18) {
    $dobError = "18+";
    $ok = 0;
  }
  if ($dob == "") {
    $dobError = "The day of birth shouldn't be empty!";
    $ok = 0;
  }
  $sql = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $emailError = 'this email is already exist';
    $ok = 0;
  }

  $target_dir = "uploads/";
  if ($image["size"] != 0 && $ok == 1) {
    if (getimagesize($image["tmp_name"]) != 0) {
      if ($image["type"] == "image/jpeg") {
        $newImage = $target_dir . "IMG-" . uniqid() . $image["name"];
        move_uploaded_file($image["tmp_name"], $newImage);
      }
    }
  }
  if ($ok == 1) {
    if ($_POST["image-profile"] == "bt1") {
      $newImage = 'img/bt1.png';
    }
    if ($_POST["image-profile"] == "bt2") {
      $newImage = 'img/bt2.png';
    }
    if ($_POST["image-profile"] == "bt3") {
      $newImage = 'img/bt3.png';
    }

    $sql2 = "INSERT INTO users (name, email, password, image, dob) VALUES('$name', '$email', '$password', '$newImage', '$age')";
    if ($conn->query($sql2) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql2 . "<br>" . $conn->error;
    }
    $conn->close();
    header('Location: login.php');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>sign up</title>
  <link href="https://kit-pro.fontawesome.com/releases/v5.15.4/css/pro.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="img/logo.svg" alt="Turtles" />
      </a>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <span class="nav-link quiz-link">Quizes</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
        </ul>
        <a href="login.php" class="btn secondaryBtn me-2">Login</a>
      </div>
    </div>
  </nav>
  <section class="Login">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
          <div class="card mb-5">
            <div class="login-card-header mt-3">
              Sign Up and Start Learning!
            </div>
            <div class="card-body">
              <form id="form-register" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="name" class="control-label">Name</label>
                  <input id="name" type="text" class="form-control full-name-input" name="name" value="<?php echo $name ?>" />
                  <div class="error"><?php echo $nameError ?></div>
                </div>
                <div class="form-group">
                  <label for="email" class="control-label">E-Mail Address</label>
                  <input id="email" type="text" class="form-control email-input" name="email" value="<?php echo $email ?>" autocomplete="off" />
                  <div class="error"><?php echo $emailError ?></div>
                </div>
                <div class="form-group">
                  <label>Profile image</label>
                  <div class="d-flex flex-wrap mt-3">
                    <label>
                      <input type="radio" class="checkbox" name="image-profile" value="bt1" />
                      <div class="avatar">
                        <img class="avatar-img mini-avatar" src="img/bt1.png" id="avatar-1" alt="" />
                      </div>
                    </label>
                    <label>
                      <input type="radio" class="checkbox" name="image-profile" value="bt2" />
                      <div class="avatar">
                        <img class="avatar-img mini-avatar" src="img/bt2.png" id="avatar-2" alt="" />
                      </div>
                    </label>
                    <label>
                      <input type="radio" class="checkbox" name="image-profile" value="bt3" />
                      <div class="avatar">
                        <img class="avatar-img mini-avatar" src="img/bt3.png" id="avatar-3" alt="" />
                      </div>
                    </label>
                    <label>
                      <div class="avatar">
                        <img class="avatar-img mini-avatar" src="./img/Icons8_flat_add_image.png" id="avatar-4" alt="" />
                        <input style="display: none" name="image" type="file" />
                      </div>
                    </label>
                  </div>
                  <div class="error"><?php echo $imageError ?></div>
                </div>
                <div class="form-group">
                  <label for="password" class="control-label">Password</label>
                  <input id="password" type="password" class="form-control password-input" autocomplete="off" value="<?php echo $password ?>" name="password" />
                  <div class="error"><?php echo $passwordError ?></div>
                </div>
                <div class="form-group">
                  <label for="password-confirm" class="control-label">Confirm Password</label>
                  <input id="password-confirm" type="password" class="form-control conf-password-input" autocomplete="off" name="password_confirmation" />
                  <div class="error"><?php echo $conPasswordError ?></div>
                </div>
                <div class="form-group">
                  <label for="dob" class="control-label">Select your date of birth</label>
                  <input id="dob" type="date" class="form-control" name="dob" value="1000-01-01" />
                  <div class="error"><?php echo $dobError ?></div>
                </div>
                <button type="submit" class="
                        btn
                        primaryBtn
                        full-width
                        signup-button
                        register
                        white
                      " id="signup">
                  Register
                </button>
            </div>
            </form>
            <div class="mt-4">
              <span>Already have an account?
                <a class="ms-1 regster-href" href="login.php">Login</a>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <aside class="floaty-bar">
    <div class="main-header box-shadow-header floaty">
      <div class="container">
        <div class="footer d-flex align-items-center">
          <div class="col-md-4 center">
            <i class="fas fa-book-open me-1"></i>
            <span class="white">Quizes</span>
          </div>
          <div class="border"></div>
          <div class="col-md-4 center">
            <i class="fas fa-rabbit me-1"></i><a class="white" href="about.html">About</a>
          </div>
        </div>
      </div>
    </div>
  </aside>
  <footer>
    <div class="container">
      <div class="footer-link d-flex justify-content-between">
        <div class="d-flex">
          <div><a class="link" href="about.html">About</a></div>
          <div><a class="link" href="#">Help</a></div>
          <div><a class="link" href="#">Privacy</a></div>
          <div><a class="link" href="#"> Terms </a></div>
          <div><a class="link" href="#">Contact</a></div>
        </div>
        <div class="link copyright">Copyright © 2021 Turtles.</div>
      </div>
    </div>
  </footer>
</body>

</html>