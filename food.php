<!DOCTYPE html>
<html>

  <?php

     session_start();

     $bdd = new PDO('mysql:host=localhost;dbname=Fast_Quick', 'root', '3jePi8ZD');
     $food = $_POST['food'];

     $add = $_POST['submit'];

     if (empty($_POST))
     header("Location: admin.php");

     if (isset($_POST['submit'])) {
     $val = $bdd->prepare('UPDATE Products SET Stock = Stock + 10 WHERE ID = ?');
  $val->execute(array($add));
  unset($_POST);
  header("Location: admin.php");
  }

  if (isset($_POST['addfood'])) {
  $recipe = ($_POST['recipe']);
  $first = ($_POST['first']);
  $second = ($_POST['second']);
  $third = ($_POST['third']);
  $desc = ($_POST['desc']);
  $image = ($_POST['image']);
  echo $desc . $first . $recipe . $second . $image . $third;
  $add = $bdd->prepare("INSERT INTO Food (`Food`, `Desc`, `First_Product`, `Second_Product`, `Third_Product`, `Image`) VALUES (?, ?, ?, ?, ?, ?)");
  $add->execute(array($recipe, $desc, $first, $second, $third, $image));
  
  //header("Location: home.php");
  }
  ?>
  
  <head>
    <meta charset="UTF-8">
    <title>Etna Food</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
    
  </head>
  
  <body>

    <div id="container">
      <div id="header">
	<form action="logout.php">
	  <input type="submit" value="Log out" class="btn-login" style="position: absolute;margin-top: 126px; margin-left: 35%">
	          </form>
	<?php
	   if ($_SESSION['ID'] == 1)
	   {
	   ?>
	<form action="admin.php">
	  <input type="submit" value="panel admin" style="margin-top: 126.5px; margin-left: 95%; position: absolute">
	</form>
	<?php
	   }
	   ?>
	<img src="etna.png" style="height: auto; width: 110px; margin-top: 126.5px">
      </div>
      <div id="body">
	 <div style="width: 500px; height: 450px; overflow-y: scroll; background-color: rgba(150, 0, 0, 0.5); margin-top: 175px; margin-left:35%; position: absolute">
	   <center><table border="1" style="width: 300px"><br><br><br><br><br><br><br><br><br>
	   <?php
    $req = $bdd->prepare("SELECT Products.ID, Products.Product, Products.Stock FROM Products INNER JOIN Food ON (Food.First_Product = Products.ID OR Food.Second_Product = Products.ID OR Food.Third_Product = Products.ID) WHERE Food.ID = ?");
    $req->execute(array($food));
    $results = $req->fetchALL();
	   foreach ($results as $key) {
	   ?>
	   <tr>
	     <?php
    if ($key['Stock'] == 0){
		?>
	     <td>
	       <p style="color: red"> <?php echo $key['Product'];?></p></td><td>
	       <p style="color: red"> <?php echo$key['Stock']; ?> </p></td><td>
	<form name="Buy" method="post" action="">
	  <button>Buy 10<input type="hidden" name="submit" value=<?php echo $key['ID'] ?>></button>
	</form>
	<td>
	<?php
	   }
	   else
	   {
	   ?>
	<td>
	  <p> <?php echo $key['Product'];?></p></td><td>
	  <p> <?php echo $key['Stock']; ?> </p></td>
	   <?php
	      }
	      ?>
	   </tr>
	   <?php
	   }
	      ?>
	   </table></center>
	   </div>
      </div>
      <div id="footer">
	<?php
	   if(isset($msg))
	   {
	   echo "$msg";
	   }
	   ?>
      </div>
    </div>
  </body>
</html>
