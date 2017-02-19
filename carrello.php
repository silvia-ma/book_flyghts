<?php


if( session_status() === PHP_SESSION_DISABLED  )
    $session = false;
elseif( session_status() !== PHP_SESSION_ACTIVE )
{ session_start();      }
$session = true;
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

<script type="text/javascript">
   function delete_carrello()      {

   for (var i=0; i<100; i++)
  document.cookie = "carrello[i]" + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';    

  window.location='voli.php';    }

</script>


</head>
<body>
   <?php
 if(!$session)
 {  echo "<p>SESSIONS DISABLED, impossible to continue./p>\n";   }
else
 {
 ?>
  <div id="header"> <h1>AirOwl Web</h1> </div>
  <?php
    require("menu.php");
  ?>
<div id="content">
<?php
$con = mysqli_connect("localhost", "id801734_unormalfly", "pass1", "id801734_flying");
if (mysqli_connect_errno())
echo "<p>Error connection DBMS: ".mysqli_connect_error()."</p>\n";
else
{
echo "<h2>Your basket</h2>";


 if(!isset($_SESSION['username']))
{ echo "Page available only for logged user. Login to see and buy the flyghts!";       }

else {
$totale=0;

if(isset($_COOKIE['carrello']))
{echo "<form name=\"elenco_carrello\"  method=\"POST\" action=''>";
echo "<table><tr><th>Airport of departure</th><th>Airport of arrival</th> <th>Date of Departure</th><th>Time of Departure</th><th>Time of Arrival</th><th>Cost per ticket</th><th>Number of seats to buy</th><th>Cost per flight</th></tr>";

foreach ($_COOKIE['carrello'] as $id => $posti)
{$query= "SELECT * FROM fly WHERE fid= '$id'";

     $result = mysqli_query($con, $query);
          if(!$result)
          echo "<tr><td colspan='4'>Error – failed query: ".mysqli_error($con)."</td></tr>";
          else
         {
          while($row = mysqli_fetch_assoc($result))
                 {$fid="$row[fid]";
                  $fdst="$row[fdst]";
                  $fsrc="$row[fsrc]";
                  $date="$row[fday]";
                  $orap="$row[ftsrc]";
                  $oraa="$row[ftdst]";
                  $price="$row[fprice]";

   $costo=$posti*$price;
  $totale=$totale + $costo;

                echo "<tr><td>".$fsrc."</td><td>".$fdst."</td><td>".(date('d.m.Y',strtotime("$row[fday]")))."</td>
                <td>".(date('H:i',strtotime("$row[ftsrc]")))."</td><td>".(date('H:i',strtotime("$row[ftdst]")))."</td><td>".$price." &euro;</td>";

                echo "<td><input type='text' size=2 name='posti[$fid]'readonly value=\"$posti\"></td>";
                echo"<td>".$costo."&euro;</td></tr>";
         }

                   }
                   }
                if(!isset($_REQUEST['cbox']))
                {echo"<tr><td>Costo totale: &euro;<input type='text' size=5 name='costo_t' readonly value=\" $totale \"></td>";
               echo "<td><input type='submit' value='Acquista ora' onclick=\"this.form.action='grazie.php'\"/></td>";
               echo "<td><input type='submit' value='Acquista più tardi' onclick=\"this.form.action='salvati.php'\"/></td>";
               echo "<td><input type=\"button\"  value=\"Cancella\" onclick= 'return delete_carrello()'></td></tr>"; }
               echo "</table>";

                echo "</form>";

                 mysqli_free_result($result);
}




if((!isset($_REQUEST['cbox']))&&(!isset($_COOKIE['carrello'])))
{echo "<p>Select a flight and a seat. Go <a href=\"voli.php\"> back</a>.</p>";}
else if (isset($_REQUEST['cbox']))
{echo "<form name=\"elenco_tratte\"  method=\"POST\" action=''>";
echo "<table><tr><th>Airport of departure</th><th>Airport of arrival</th> <th>Date of Departure</th><th>Time of Departure</th><th>Time of Arrival</th><th>Cost per ticket</th><th>Number of seats to buy</th><th>Cost per flight</th></tr>";

foreach ($_REQUEST['cbox'] as $item)
{$query= "SELECT * FROM fly WHERE fid= '$item'";

     $result = mysqli_query($con, $query);
          if(!$result)
          echo "<tr><td colspan='4'>Error – query failed: ".mysqli_error($con)."</td></tr>";
          else
         {
          while($row = mysqli_fetch_assoc($result))
                 {$fid="$row[fid]";
                  $fdst="$row[fdst]";
                  $fsrc="$row[fsrc]";
                  $date="$row[fday]";
                  $orap="$row[ftsrc]";
                  $oraa="$row[ftdst]";
                  $price="$row[fprice]";

  foreach ($_REQUEST['box'] as $key => $value)
  if ($key==$fid)
 { $costo=$value*$price;
  $totale=$totale + $costo;

                echo "<tr><td>".$fsrc."</td><td>".$fdst."</td><td>".(date('d.m.Y',strtotime("$row[fday]")))."</td>
                <td>".(date('H:i',strtotime("$row[ftsrc]")))."</td><td>".(date('H:i',strtotime("$row[ftdst]")))."</td><td>".$price." &euro;</td>";

                echo "<td><input type='text' size=2 name='posti[$fid]'readonly value=\"$value\"></td>";
                echo"<td>".$costo."&euro;</td></tr>";
         }
                             }   }
                   }
                echo"<tr><td>Cost total: &euro;<input type='text' size=5 name='costo_t' readonly value=\" $totale \"></td>";
               echo "<td><input type='submit' value='Acquista ora' onclick=\"this.form.action='grazie.php'\"/></td>";
               echo "<td><input type='submit' value='Acquista più tardi' onclick=\"this.form.action='salvati.php'\"/></td>";
               echo "<td><input type=\"button\"  value=\"Cancella\" onclick='return delete_carrello()'></td></tr>";
               echo "</table></form>";

              mysqli_free_result($result);

         echo "<p><input type=\"button\" value=\"Indietro\" onclick=\"window.location='voli.php'\"></p>"; }
             mysqli_close($con);

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