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
  { echo "<p>SESSIONS DISABLED, impossible to continue.</p>\n";   }
   else
 {
 ?>
  <div id="header"> <h1>AirOwl Web</h1> </div>
  <?php
    require("menu.php");        ?>
    <div id="content">
 <h3> Flight Routes</h3>

      <?php
      $con = mysqli_connect("localhost", "id801734_unormalfly", "pass1", "id801734_flying");
      if (mysqli_connect_errno())
	echo "<p>Errore connessione al DBMS: ".mysqli_connect_error()."</p>";
      	else
       {
  if(!isset($_SESSION['username']))
{echo "Login to see and buy the flyghts for this route!";}


         $query = "SELECT * FROM `fly` GROUP BY `fsrc`,`fdst`";
         $result = mysqli_query($con, $query);
            if(!$result)
          echo "<tr><td colspan='4'>Error – failed query: ".mysqli_error($con)."</td></tr>";
                else
            {   echo "<form name=\"elenco_tratte\" action=\"volo.php\" method=\"POST\">";
              echo "<table><tr> <th>Airport of departure</th><th>Airport of arrival</th> </tr>";

         while($row = mysqli_fetch_assoc($result))
          {   if(isset($_SESSION['username']))
                {
                echo "<tr><td>$row[fsrc]</td><td>$row[fdst]</td>";
                echo "<td><input type=\"submit\" value=\"Seleziona\" name='$row[fid]'></td></tr>";
                }
                 if(!isset($_SESSION['username']))
                {echo "<tr><td>$row[fsrc]</td><td>$row[fdst]</td></tr>";  }

                }

                 mysqli_free_result($result);
                 }

                mysqli_close($con);
	}        echo "</table></form>";
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
<?php          	}
        ?>
      </body>
      </html>