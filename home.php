<!DOCTYPE html>
<html>

  <?php

     session_start();

     $bdd = new PDO('mysql:host=localhost;dbname=Fast_Quick', 'root', '3jePi8ZD');

     if (empty($_SESSION['ID']))
     header("Location: index.php");
?>  
  <head>
    <meta charset="UTF-8">
    <title>Etna Food</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
    
  </head>
  
  <body>
    <?php
       $req = $bdd->prepare('SELECT Food.ID, Products.ID, Products.Product, Products.Stock, Food.Food, Food.Desc, Food.Image FROM Products INNER JOIN Food ON (Food.First_Product = Products.ID OR Food.Second_Product = Products.ID OR Food.Third_Product = Products.ID)');
    $req->execute();
    $j = 0;
    $results = $req->fetchALL();
    foreach ($results as $key => $value){
    $i = $value[0];
    $array[$i][$j] = $value[3];
    $j++;
    if ($j == 3){
    $array[$i][3] = $value[4];
    $array[$i][4] = $value[5];
    $array[$i][5] = $value[6];
    $j = 0;
    }
    }
    ?>
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
	<div style="width: 500px; height: 450px; overflow-y: scroll; background-color: rgba(125, 0, 0, 0.4); position: absolute ; top: 55%; left: 50%; transform: translateX(-50%) translateY(-50%);">
	    <table style="color: black" border="1">
	      <?php
		 $k = 1;
		 $l = 0;
		 while ($k <= $i) {
			      if ($array[$k][0] != 0 && $array[$k][1] != 0 && $array[$k][2] != 0){
			      $l++;
			      if ($l == 1) {
			      ?>
		 <tr>
		   <td style="width: calc(500px / 3)"><p style="font-size: 20px"> Produit </p></td>
		   <td style="width: calc(500px / 3)"><p style="font-size: 20px"> Libelle </p></td>
		   <td style="width: calc(500px / 3)"><p style="font-size: 20px"> Description </p></td>
		 </tr>
		 <?php
		    }
		    ?>
		 
	      <tr>
		<td style="width: calc(500px / 3)"><img src=<?php echo $array[$k][5];?> style="width: calc(500px / 3); height: auto"></td>
		<td style="width: calc(500px / 3)"><?php echo $array[$k][3]?></td>
		<td style="width: calc(500px / 3)"><?php echo $array[$k][4]?></td>
	      </tr>
	      <?php
		 }
		 $k++;
		 }
		 if ($l == 0)
		 echo "Nous ne pouvons faire aucune recette pour le moment";
		 ?>
	    </table>
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
