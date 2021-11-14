<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>
   <link href="https://kit-pro.fontawesome.com/releases/v5.15.4/css/pro.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <!-- Start Navbar -->
   <nav class="navbar navbar-expand-lg navbar-light ">
      <div class="container">
         <a class="navbar-brand" href="index.html">
            <img src="img/logo.svg" alt="Turtles">
         </a>
         <ul class="navbar-nav me-auto ">
            <li class="nav-item me-3">
               <a class="nav-link" aria-current="page" href="#">Quizes</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="about.html">About</a>
            </li>
         </ul>
         <div>
            <a href="login.php" class="btn secondaryBtn me-1">Login</a>
            <a href="signUp.php" class="btn primaryBtn">Sign Up</a>
         </div>
      </div>
   </nav>
   <!-- End Navbar -->
   <section class="home-page ">
      <div class="container ">
         <div class="row ">
            <div class="col-lg-7 col-md-6 hero  mt-5">
               <div class="hero-title">
                  Find The Best Quizes!
               </div>
               <div class="hero-des">
                  Hey! would you link to grow up your skill and if you are interested to do just start here.
               </div>
               <a href="signUp.php" class="btn primaryBtn btn-width mt-4 ">Sign Up</a>
            </div>
            <div class="col-lg-5 col-md-6  mt-5">
               <div class="home-img">
                  <img src="img/hero-img.png" alt="">
               </div>
            </div>
         </div>
         <div>
   </section>
   <aside class="floaty-bar">
      <div class="main-header box-shadow-header floaty">
         <div class="container">
            <div class="footer d-flex align-items-center ">
               <div class="col-md-4 center">
                  <i class="fas fa-book-open me-1"></i> <a class="white" href="#">Quizes</a>
               </div>
               <div class="border"></div>
               <div class="col-md-4 center">
                  <i class="fas fa-rabbit me-1"></i><a class="white" href="about.html">About</a>
               </div>
            </div>
         </div>
   </aside>
</body>

</html>