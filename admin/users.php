<?php
session_start();
include("../conn.php");
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$nameError = $emailError = $imageError = $passwordError = $conPasswordError = $dobError  = "";
$name = $email = $password = $conPassword = $dob = $age = "";

if (isset($_GET["do"])) {
  $do = $_GET["do"];
  $id = $_GET["id"];
  if ($do == "edit") {
    $sql = "SELECT * FROM users WHERE id =$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $ok = 1;
      $name = ($_POST["name"]);
      $email = strtolower($_POST["email"]);
      // $image = ($_FILES["image"]);
      $password = ($_POST["password"]);
      $conPassword = ($_POST["password_confirmation"]);
      $dob = ($_POST["dob"]);
      $status = ($_POST["status"]);

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
      // if ($image["size"] == 0) {
      //   $ok = 0;
      //   $imageError = "Please make sure to select an image";
      // }
      if ($password == "") {
        $ok = 0;
        $passwordError = "The password shouldn't be empty!";
      }
      if ($password != $conPassword) {
        $ok = 0;
        $conPasswordError = "password don't match";
      }
      // if ($dob != "") {
      //explode the date to get month, day and year
      //   $dob = explode("-", $dob);
      //get age from date or birthdate
      //   $age = (date("md", date("U", mktime(0, 0, 0, $dob[2], $dob[1], $dob[0]))) > date("md")
      //     ? ((date("Y") - $dob[0]) - 1)
      //     : (date("Y") - $dob[0]));
      // }
      if ($dob < 18) {
        $dobError = "18+";
        $ok = 0;
      }
      if ($ok == 1) {
        $sql2 = "UPDATE users SET name = '$name', email='$email', password ='$password', dob = '$dob', admin = '$status' WHERE id = '$id'";
        if ($conn->query($sql2) === TRUE) {
          echo "New record created successfully";
        } else {
          echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
        $conn->close();
        header('Location: admin.php');
        exit;
      }
    }
?>
    <div class="px-5 grid  grid-cols-3  py-24 mx-auto bg-gray-100 text-gray-900 rounded-lg">
      <form class="col-start-2" enctype="multipart/form-data" method="POST">
        <div>
          <span class="uppercase text-sm text-gray-600 font-bold">
            Full Name
          </span>
          <input name="name" value="<?php echo $row["name"] ?>" class="w-full bg-gray-200 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-indigo-400" type="text" required />
          <div class="error text-red-500"><?php echo $nameError ?></div>
        </div>
        <div class="mt-8">
          <span class="uppercase text-sm text-gray-600 font-bold">
            Email
          </span>
          <input name="email" value="<?php echo $row["email"] ?>" class="w-full bg-gray-200 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-indigo-400" type="text" required />
          <div class="error text-red-500"><?php echo $emailError ?></div>
        </div>
        <div class="mt-8">
          <span class="uppercase text-sm text-gray-600 font-bold">
            Password
          </span>
          <!-- <input hidden value="<?php echo $row["password"] ?>" class="w-full bg-gray-200 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-indigo-400" type="text" required /> -->
          <input name="password" class="w-full bg-gray-200 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-indigo-400" type="password" required />
          <div class="error text-red-500"><?php echo $passwordError ?></div>
        </div>
        <div class="mt-8">
          <span class="uppercase text-sm text-gray-600 font-bold">
            Password Confirmation
          </span>
          <input name="password_confirmation" class="w-full bg-gray-200 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-indigo-400" type="password" required />
          <div class="error text-red-500"><?php echo $conPasswordError ?></div>
        </div>
        <div class="mt-8">
          <span class="uppercase text-sm text-gray-600 font-bold">
            Age
          </span>
          <input name="dob" value="<?php echo $row["dob"] ?>" class="w-full bg-gray-200 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-indigo-400" type="text" required />
          <div class="error text-red-500"><?php echo $dobError ?></div>
        </div>
        <div class="mt-8">
          <span class="uppercase text-sm text-gray-600 font-bold">
            Status
          </span><br><br>
          <select name="status" id="cars">
            <option value="0">Member</option>
            <option value="1">Admin</option>
          </select>
        </div>
        <!-- <div class="mt-8 relative">
          <span class="uppercase text-sm text-gray-600 font-bold">
            Image
          </span>
          <input name="image" class="w-full bg-gray-200 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-indigo-400" type="file" required />
          <img width="50px" class="top-7 absolute right-0" src="../<?php // echo $row["image"] 
                                                                    ?>" alt="">
        </div> -->
        <div class="mt-8">
          <button class="uppercase text-sm font-bold tracking-wide bg-indigo-500 text-gray-100 p-3 rounded-lg w-full focus:outline-none focus:shadow-outline hover:bg-indigo-700" type="submit">
            Save
          </button>
        </div>
      </form>
    </div>
<?php
  } elseif ($do == "delete") {
    $sql3 = "DELETE FROM users WHERE id = '$id'";
    if ($conn->query($sql3) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql3 . "<br>" . $conn->error;
    }
    $conn->close();
    header('Location: admin.php');
    exit;
  } else {
    header('Location: users.php');
    exit;
  }
}
?>

<?php include "./inc/header.php";
if (!isset($_GET['do'])) { ?>
  <div class="container flex justify-center mx-auto">
    <div class="flex flex-col">
      <div class="w-full">
        <div class="border-b border-gray-200 shadow">
          <table class="divide-y divide-gray-300 ">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-2 text-xs text-gray-500">
                  ID
                </th>
                <th class="px-6 py-2 text-xs text-gray-500">
                  Name
                </th>
                <th class="px-6 py-2 text-xs text-gray-500">
                  Email
                </th>
                <th class="px-6 py-2 text-xs text-gray-500">
                  Age
                </th>
                <th class="px-6 py-2 text-xs text-gray-500">
                  Status
                </th>
                <th class="px-6 py-2 text-xs text-gray-500">
                  Created_at
                </th>
                <th class="px-6 py-2 text-xs text-gray-500">
                  Edit
                </th>
                <th class="px-6 py-2 text-xs text-gray-500">
                  Delete
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
              <?php foreach ($result as $key => $value) { ?>
                <tr class="whitespace-nowrap">
                  <td class="px-6 py-4 text-sm text-gray-500">
                    <?php echo $value["id"] ?>
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 flex justify-center items-center">,
                      <img src="<?php echo "../" . $value["image"] ?>" class="mr-3" width="50px" alt="">
                      <?php echo $value["name"] ?>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-500"><?php echo $value["email"] ?></div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-500"><?php echo $value["dob"] ?></div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-500"><?php echo $value["admin"] == 0 ? "Member" : "Admin" ?></div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    <?php echo $value["created"] ?>
                  </td>
                  <td class="px-6 py-4">
                    <a href="users.php?do=edit&id=<?php echo $value["id"] ?>" class="px-4 py-1 text-sm text-indigo-600 bg-indigo-200 rounded-full">Edit</a>
                  </td>
                  <td class="px-6 py-4">
                    <a href="users.php?do=delete&id=<?php echo $value["id"] ?>" class="px-4 py-1 text-sm text-red-400 bg-red-200 rounded-full">Delete</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php }
include "./inc/footer.php" ?>