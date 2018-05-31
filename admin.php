]<!DOCTYPE html>
<html>
  <?php
     session_start();
     $bdd = new PDO('mysql:host=localhost;dbname=Fast_Quick', 'root', '3jePi8ZD');
     $add = $_POST['submit'];
     
     if (isset($_POST['submit'])) {
     $val = $bdd->prepare('UPDATE Products SET Stock = Stock + 10 WHERE ID = ?');
  $val->execute(array($add));
  unset($_POST);
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
	<form action="home.php">
	  <input type="submit" value="view no admin" style="margin-top: 126.5px; margin-left: 87%; position: absolute">
	</form>
	<img src="etna.png" style="height: auto; width: 110px; margin-top: 126.5px">
	
      </div>
      <div id="body">
	<?php
	     if (isset($_SESSION['Role']) && $_SESSION['Role'] == 1){
	   echo "Bienvenue :" . $_SESSION['Mail'];
	     ?>
	<?php
	   $req = $bdd->prepare('SELECT Product, ID FROM Products');
	$req->execute();
	$results = $req->fetchALL();
	?>
	  <div style="width: 500px; height: 450px; overflow-y: hidden; background-color: rgba(150, 0, 0, 0.5); margin-top: 175px; margin-left:2%; position: absolute">
	    <form action="food.php" method="POST">
	      <center><table>
		<br><br><br><br><tr>
	  <input type="text" name="recipe" placeholder="name of recipe" required>
	  </tr><br><br><tr>
	  <select name="first">
	    <?php
	       foreach ($results as $key) {
	       ?>
	    <option value=<?php echo $key['ID']; ?>><?php echo $key['Product'];?></option>
	    <?php
	       }
	       ?>
	  </select>
		</tr><br><br><tr>
	  <select name="second">
	    <?php
	       foreach ($results as $key) {
	       ?>
	    <option value=<?php echo $key['ID']; ?>><?php echo $key['Product'];?></option>
	    <?php
	       }
	       ?>
	  </select>
		</tr><br><br><tr>
	  <select name="third">
	    <?php
	       foreach ($results as $key) {
	       ?>
	    <option value=<?php echo $key['ID']; ?>><?php echo $key['Product'];?></option>
	    <?php
	       }
	       ?>
	  </select>
	  </tr><br><br><tr>
	  <input type="text" name="desc" placeholder="Une petite description" required>
	  </tr><br><br><tr>
	  <input type="url" name="image" placeholder="URL of the image" required>
	  </tr><br><br><tr>
		  <input type="submit" name="addfood" value="New Recipe">
		<br><br></tr>
		</table></center>
	    </form>
	</div>
	  <?php
	     }
	     else
	     {
	     header("Location: index.php");
	     }
	     ?>
	  <div style="width: 500px; height: 450px; overflow-y: scroll; background-color: rgba(150, 0, 0, 0.5); margin-top: 175px; margin-left:35%; position: absolute">
	    <center>
	      <table border="1">
		<?php
		   $req2 = $bdd->prepare('SELECT * FROM Food');
		$req2->execute();
		$results2 = $req2->fetchALL();
		$l = 0;
		foreach ($results2 as $key2) {
		$l++;
		if ($l == 1)
		{
		?>
		<tr>
		  <td><p style="font-size: 20px"> Produit </p></td>
		  <td><p style="font-size: 20px"> Labelle </p></td>
		</tr>
		<?php
		   }
		   ?>
		<tr>
		  <td><img src=<?php echo $key2['Image'];?> style="height: 110px; width: auto"></td>
		  <td><?php echo $key2['Food']; ?></td>
		  <td>
		    <form name="food" method="post" action="food.php">
		      <button>Voir les ingredients<input type="hidden" name="food" value=<?php echo $key2['ID'] ?>></button>
		    </form>
		  </td>
		</tr>
		<?php
		   }
		   ?>
	      </table>
	    </center>
	  </div>
	  
	  <div style="width: 500px; height: 450px; overflow-y: scroll; background-color: rgba(150, 0, 0, 0.5); margin-top: 175px; margin-left:65%; position: absolute">
	    <center><table border="1"  style="width: 300px"><br><br>
		<?php
	       $req3 = $bdd->prepare('SELECT Products.Product, Products.Stock FROM Products');
		$req3->execute();
		$results3 = $req3->fetchALL();
		foreach ($results3 as $key3){
		?>
		<tr>
		  <td><p><?php echo $key3['Product'];?></p></td><br>
		  <td><p><?php echo $key3['Stock'];?></p></td>
		  
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
