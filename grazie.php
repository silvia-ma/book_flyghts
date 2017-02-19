<?php
    $session = true;
if( session_status() === PHP_SESSION_DISABLED  )
    $session = false;
elseif( session_status() !== PHP_SESSION_ACTIVE )
{     session_start();      }
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
	echo "<p>Errore connection DBMS: ".mysqli_connect_error()."</p>\n";
      	else
       {
       if (isset($_REQUEST['costo_t'])&& (isset($_REQUEST['posti'])))
     {

    $costo = $_REQUEST['costo_t'];

    
   foreach ($_REQUEST['posti'] as $fid => $posti)
   {
   $query1 = "SELECT fseat FROM `fly` WHERE fid = '$fid'";
  $query2 =  "SELECT `umoney` FROM usr WHERE uname = '$username'";
  $result1 = mysqli_query($con, $query1);
  $result2 = mysqli_query($con, $query2);
  if((!$result1) || (!$result2))
    echo "<tr><td colspan='4'>Error – failed query1: ".mysqli_error($con)."</td></tr>";
  
   else
  { while($row1 = mysqli_fetch_assoc($result1))
    {$seat="$row1[fseat]";
    $posti_rim= $seat - $posti;
     }
   while($row2 = mysqli_fetch_assoc($result2))
    {$money= "$row2[umoney]";
    $saldo= $credito - $costo; }


    if (($posti_rim>=0)&&($saldo>=0))
  {
   $query3 = "UPDATE `fly` SET `fseat`  = '$posti_rim'   WHERE fid = '$fid'";
    $query4 =  "UPDATE `usr` SET `umoney`  = '$saldo'   WHERE uname = '$username'";
       $result3 = mysqli_query($con, $query3);
       $result4 = mysqli_query($con, $query4);

       if((!$result3) || (!$result4))
          echo "<tr><td colspan='4'>Error – failed query2: ".mysqli_error($con)."</td></tr>";
          else
          {echo "<p>Purchase completed!</p>";
          $_SESSION['credito']=$saldo; 


          foreach ($_COOKIE['carrello'] as $id => $posti)
 {  unset($posti);
    $scadenza = time() - 3600*24;

  setcookie("carrello[$id]", '', $scadenza );  }

      }
          }
    else
    echo "<p>You don't have enough credit to complete this purchase or there are no seats on the selected flight.</p>";

    }      }
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
