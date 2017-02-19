<?php
    $session = true;
if( session_status() === PHP_SESSION_DISABLED  )
    $session = false;
elseif( session_status() !== PHP_SESSION_ACTIVE )
{ session_start();      }
?>

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
   <?php
            if(!$session)
            {  echo "<p>SESSIONS DISABLED, impossible to continue.</p>\n";  }
            else
            {
        ?>
  <div id="header"> <h1>AirOwl Web</h1> </div>
  <?php
    require("menu.php");
      ?>
    <div id="content">
      <?php
   if(!isset($_SESSION['username']))
          { echo "Page available only for logged user. Login to see and buy the flyghts!.";  }
    else {
     $username= $_SESSION['username'];
     $credito = $_SESSION['credito'];
     $con = mysqli_connect("localhost", "id801734_unormalfly", "pass1", "id801734_flying");
      if (mysqli_connect_errno())
	echo "<p>Error connection DBMS: ".mysqli_connect_error()."</p>\n";
      	else
       {
       if (isset($_REQUEST['posti']))
     {

   foreach ($_REQUEST['posti'] as $fid => $posti)
   {  $scadenza = time() + 3600*24;

  setcookie("carrello[$fid]", $posti, $scadenza );
     }
     
  echo "Your flights will be saved for 24 hours in the basket!";
   mysqli_close($con);

                   }
    }
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
  <?php
       }
        ?>


 </body>
 </html>
