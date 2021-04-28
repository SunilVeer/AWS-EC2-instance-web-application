<!DOCTYPE html>
<html>
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <link rel="stylesheet" href="style.css">
<title>Login</title>
   </head>
   <body>
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      <!-- Login form creation starts-->
      <section class="container-fluid">
         <!-- row and justify-content-center class is used to place the form in center -->
         <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-md-4">
               <form class="form-container" action="login_input.php" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                     <h4 class="text-center font-weight-bold"> User Login </h4>
                     <label for="email">Email Id</label>
                     <input type="text" class="form-control" name= "email" id="email" placeholder="Enter Email Id">
                  </div>
                  <div class="form-group">
                     <label for="password">User Password</label>
                     <input type="password" class="form-control" name="password" id="password" placeholder="Enter User Password">
                  </div>
                  <span style="color:red"><?php echo $_GET['user_error']; session_destroy(); ?></span>
                  <button type="submit" class="btn btn-primary btn-block">Submit</button>
                  </br>
                  <div class="form-footer">
                     <p> Don't have an account? <a href="register.php">Sign Up</a></p>
                  </div>
               </form>
            </section>
         </section>
      </section>
      <!-- Login form creation ends -->
   </body>
</html>
