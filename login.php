<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

   <head>
   <title>AirOwl web</title>
   <meta name="author" content="Silvia Manca" >
   <meta name="keywords" content="voli">
   <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
   <link rel="start" href="home.php">
   <link rel="next" href="voli.php">
   <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    
   <body>
  <div id="header"> <h1>AirOwl Web</h1> </div>
  <?php     
    require("menu.php");
      ?>
<div id="content">
<?php

if(session_status()!==PHP_SESSION_ACTIVE)
 session_start();

  if(($_REQUEST['username']=="") ||($_REQUEST['password']==""))
    {echo "Errore! Username e/o password mancanti!";}
    
    else if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){

  $username= trim($_REQUEST['username']);
  $password= trim($_REQUEST['password']);

  $con = mysqli_connect("localhost", "id801734_unormalfly", "pass1", "id801734_flying");

     if (!mysqli_connect_errno()){

       $query = "SELECT * FROM usr WHERE uname='$username' AND upwd='$password'";
       $result = mysqli_query($con, $query);

        if(!$result)
        echo "<p class='err'>Error - failed query: ".mysqli_error($con)."</p>";

        else if($row = mysqli_fetch_assoc($result)) {
            mysqli_free_result($result);

          $credito=$row["umoney"];
          $privilegi=$row["utype"];
          if($privilegi=="A")
          {$_SESSION['privilegi']="SI";}



           setcookie("username", $username);
           

           $_SESSION['username']=$username;
           $_SESSION['password']=$password;
           $_SESSION['credito']=$credito;


      echo "<p> Hello ".$_SESSION['username']." now you can find and buy your tickets!</p>";

            }
            else
            {echo "Error! Username and/or password is incorrect!"; }


            mysqli_close($con);}
            else    
            {echo "<p class='err'>Errore! Connection DBMS: ".mysqli_connect_error()."</p>\n";}
            }

            ?>
            

      </div>
      <?php
            require("utente.php");
       ?>
       

 <div id="footer">

<ul><li> Page:
 <?php echo basename($_SERVER['PHP_SELF'])?> </li>
 <li>Author: silvia(ma)   </li> </ul>

</div>



 </body>
 </html>