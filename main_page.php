<?php
   session_start();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta content="text/html;charset=UTF-8" http-equiv="Content-Type">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <meta content="UTF-8" http-equiv="encoding">
      <title>Main Page</title>
   </head>
   <body>
      <div class="container">
         <div class = "row justify-content-center">
            <div class="col-md-8">
               </br></br>
               <div class="row" style="border: thin solid black; padding: 20px">
                  <div class="col-sm-7">
                     <a href="main_page.php" target="_self"><?php echo $_SESSION['username']?></a>
                  </div>
                  <div class="col-sm-1">
                     <form action="logout.php" method="POST">
                        <button class="btn btn-dark" type="submit">Logout</button>
                     </form>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               </br></br>
               <div style="border: thin solid black; padding: 20px">
                  <h5>Subscribed Music</h5>
                  <table style="width:100%">
                     <tr>
                        <th style= "border: 1px solid black; padding: 10px">Title</th>
                        <th style= "border: 1px solid black; padding: 10px">Artist</th>
                        <th style= "border: 1px solid black; padding: 10px">Year</th>
                        <th style= "border: 1px solid black; padding: 10px">Image</th>
                        <th style= "border: 1px solid black; padding: 10px">Remove</th>
                     </tr>
                     <?php
                        include "subscribedMusic.php";
                        ?>
                  </table>
               </div>
               <hr>
			   <div style="border: thin solid black; padding: 20px">
               <h5>Query Area</h5>
               <table style="width:100%">
                  <tr>
				  <form action="main_page.php" method="POST">
                     <th style= "border: 1px solid black; padding: 10px">
                        <label for="labelMessage">Title</label>
                        <input type="text" name="title" class="form-control" id="title"  placeholder="Enter title">
                     </th>
                     <th style= "border: 1px solid black; padding: 10px">
					 <label for="labelMessage">Artist</label>
                        <input ype="text" name="artist" class="form-control" id="artist"  placeholder="Enter artist">
					 </th>
					 
                     <th style= "border: 1px solid black; padding: 10px">
					 <label for="labelMessage">Year</label>
                        <input type="text" name="year" class="form-control" id="year"  placeholder="Enter year">
					 </th>
					 <th style= "border: 1px solid black; padding: 10px">
					 <label for="labelMessage">Image</label>
					 </th>
                     <th style= "border: 1px solid black; padding: 10px">
                        <button class="btn btn-dark" type="submit">Query</button>
                     </form>
					 </th>
                  </tr>
				  <?php
				  include "query.php";
				  ?>
               </table>
			   </div>
            </div>
         </div>
      </div>
   </body>
</html>