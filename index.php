<!DOCTYPE html>
<html>

  <?php
     session_start();

     $bdd = new PDO('mysql:host=localhost;dbname=Fast_Quick', 'root', '3jePi8ZD');

     if(isset($_SESSION['Role'])){
     if ($_SESSION['Role'] == 1)
     header("Location: admin.php?ID=".$_SESSION['ID']);
     if ($_SESSION['Role'] == 0)
     header("Location: home.php?ID=".$_SESSION['ID']);
              }
     
     if(isset($_POST['formregister']))
     {
     $l_name = ($_POST['l_name']);
     $f_name = ($_POST['f_name']);
     $mail = htmlspecialchars($_POST['mail']);
     $mail2 = htmlspecialchars($_POST['mail2']);
     $password = hash('sha256', $_POST['password']);
     $password2 = hash('sha256', $_POST['password2']);
     $role = 0;
     if(!empty($_POST['l_name']) && !empty($_POST['f_name']) && !empty($_POST['mail']) && !empty($_POST['mail2']) && !empty($_POST['password']) && !empty($_POST['password2']))
     {
     if ($mail == $mail2)
     {
     if (filter_var($mail, FILTER_VALIDATE_EMAIL))
     {
     $requser = $bdd->prepare("SELECT * FROM Users WHERE Mail = ?");
  $requser->execute(array($mail));
  $nb = $requser->rowCount();
  if ($nb == 0)
  {
  if ($password == $password2)
  {
  $insertuser = $bdd->prepare("INSERT INTO Users (Last_Name, First_Name, Mail, Passwd, Role) VALUES ( ?, ?, ?, ?, ?)");
  $insertuser->execute(array($l_name, $f_name, $mail, $password, $role));
  $msg = 'Votre compte a bien ete ajoute';
  }
  else
  $msg = 'Les mots de passe de sont pas similaires';
  }
  else
  $msg = 'Cette adresse email est deja utilise';
  }
  else
  $msg = 'Veuillez rentrer une adresse mail valide';
  }
  else
  $msg = 'Les adresses mail ne sont pas semblables';
  }
  else
  $msg = "Tous les champs doivent etre completes";
  }

  if (isset($_POST['Connexion']))
  {
  $log_mail = htmlspecialchars($_POST['email']);
  $log_passwd = hash('sha256', $_POST['passwd']);
  $requser = $bdd->prepare("SELECT * FROM Users WHERE Mail = ? AND Passwd = ?");
  $requser->execute(array($log_mail, $log_passwd));
  $count = $requser->rowCount();
  if($count == 1)
  {
  $userinfo = $requser->fetch();
  $_SESSION['ID'] = $userinfo['ID'];
  $_SESSION['Mail'] = $userinfo['Mail'];
  echo 'ok';
  }

  else
  echo "Verifiez vos informations";
  }
  
     
     if (isset($_POST['Connection']))
     {
     $log_mail = htmlspecialchars($_POST['email']);
     $log_passwd = hash('sha256', $_POST['passwd']);
     $requser = $bdd->prepare("SELECT * FROM Users WHERE Mail = ? AND Passwd = ?");
  $requser->execute(array($log_mail, $log_passwd));
  $count = $requser->rowCount();
  if($count == 1)
  {
  $userinfo = $requser->fetch();
  $_SESSION['ID'] = $userinfo['ID'];
  $_SESSION['Mail'] = $userinfo['Mail'];
  $_SESSION['Role'] = $userinfo['Role'];
  header("Location: index.php?ID=".$_SESSION['ID']);
  }
  else
  {
  echo "Verifiez vos informations";
  }
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
	<img src="etna.png" style="height: auto; width: 110px; margin-top: 126.5px">
      </div>
      <div id="body">
	<div class="connection">
	  <img src="groot.jpg">
	  <form action="" method="POST">
	    <div class="form-input">
	      <input type="email" name="email" placeholder="Mail" required>
	    </div>
	    <div class="form-input">
	      <input type="password" name="passwd" placeholder="Password" required>
	    </div>
	    <input type="Submit" name="Connection" value="LOGIN" class="btn-login">
	    <br>
	    </form>
	    <p href="" id="open" class="regis"><u>Create Account</u></p>
	</div>
      </div>

      <div id="reg" class="register">


	<div class="register-content">
	  <span class="close">&times;</span>
	  <center>
	  <form action="" method="POST" style="margin-top: 20px">
	    <table style="align-content: center;">
	      <tr>
		<td><input type="text" placeholder="Nom" name="l_name" required></td>
	      </tr>
	      <tr>
		<td><input type="text" placeholder="Prenom" name="f_name" required></td>
	      </tr>
	      <tr>
		<td><input type="email" placeholder="Adresse mail" name="mail" required></td>
	      </tr>
	      <tr>
		<td><input type="email" placeholder="Confirmation adresse mail" name="mail2" required></td>
	      </tr>
	      <tr>
		<td><input type="password" placeholder="Mot de passe" name="password" required></td>
	      </tr>
	      <tr>
		<td><input type="password" placeholder="Confirmation mot de passe" name="password2" required></td>
	      </tr>
	      <td>
		<center>
		  <input type="Submit" name="formregister" value="S'inscrire" class="btn-login" style="margin-top: -10px">
		</center>
	      </td>
	    </table>
	  </form>
	  </center>
	  
	</div>
	<script type="text/javascript" src="java.js"></script>
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
