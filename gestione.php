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

<script type="text/javascript">

  function checkFormat(data,ora_p,ora_a,posti)        {
  var regex_data = /^\d{2}.\d{2}.\d{4}$/;
  var regex_ora =  /^\d{2}:\d{2}$/; 
  var regex_posti = /^\d{1,3}$/;
  if (!regex_data.test(data))
   {  alert ("Errore - Inserire una data nel formato GG.MM.AAAA!" );
   return false;                        }
   if (!regex_ora.test(ora_p)||!regex_ora.test(ora_a))                        
   {alert ("Errore - Inserire un orario nel formato HH:MM!" );
    return false;                         }
  if (!regex_posti.test(posti)||posti>299)
   {alert ("Errore - La capienza massima di un aereo è di 299 posti!" );
   return false;                         }
   return true;                  }
                
  function checkFormato(part,arr,data,ora_p,ora_a,posti,costo)        {
  var regex_par = /^[A-Z]{3}\/[a-zA-Z]{1,} ?[a-zA-Z]{1,}?$/;
  var regex_data = /^\d{2}.\d{2}.\d{4}$/;
  var regex_ora =  /^\d{2}:\d{2}$/; 
  var regex_posti = /^\d{1,3}$/;
  var regex_costo = /^\d(\,?\d{1,3})*$/
  
  if ((!regex_par.test(part))||(!regex_par.test(arr)))
  {  alert ("Error - Insert the name of the airport with the format \"code IATA of 3 letters/airport name\"!" );
  return false;                        }
  if (!regex_data.test(data))
 {  alert ("Error - Insert the date with the format DD.MM.YYYY!" );
 return false;                        }
if (!regex_ora.test(ora_p)||!regex_ora.test(ora_a))                        
 {alert ("Error - Insert the time with the format HH:MM!" );
 return false;                         }
 if (!regex_posti.test(posti)||posti>299)
  {alert ("Error - The maximum capacity of the airplan is 299 seats!" );
 return false;                         }
 if (!regex_costo.test(costo))
  {alert ("Error - Insert a valid price!" );
 return false;                         }
    
  return true;                  }            
</script>
    </head>

   <body>
   <?php
   if(!$session)
    {  echo "<p>SESSIONS DISABLED, impossible to continue.</p>\n";             }
     else
      {
        ?>
  <div id="header"> <h1>AirOwl Web</h1> </div>
  <?php
    require("menu.php");
      ?>
    <div id="content">
      <?php
      
      if(!isset($_SESSION['privilegi']))
      {echo "<p>ACCESS DENIED! You don't have the right permissions to access at this page!</p>";}

      else
      {

      $con = mysqli_connect("localhost", "id801734_unormalfly", "pass1", "id801734_flying");
      if (mysqli_connect_errno())
	echo "<p>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
      	else    
       {

         $query = "SELECT * FROM `fly` ORDER BY `fid`";
         $result = mysqli_query($con, $query);
            if(!$result)
          echo "<tr><td colspan='4'>Error – failed query: ".mysqli_error($con)."</td></tr>";
                else
            {echo"<h2>Manage the flights</h2>";
         echo"<table><tr><th>Identification</th><th>Airport of departure</th>
                            <th>Airport of arrival</th>
                            <th>Date - Time of Departure - Time of Arrival - Available Seats</th></tr>";




                 while($row = mysqli_fetch_assoc($result))
            {     $fid="$row[fid]";
                  $fdst="$row[fdst]";
                  $fsrc="$row[fsrc]";
                  $date="$row[fday]";
                  $orap="$row[ftsrc]";
                  $oraa="$row[ftdst]";
                  $fseat="$row[fseat]";

  $fday = strtotime($date);
  $ftsrc = strtotime($orap);
  $ftdst = strtotime($oraa);

                echo "<tr><td>".$fid."</td><td>".$fsrc."</td><td>".$fdst."</td>";
                echo"<td><form name='aggiornaForm' method='POST' action='aggiorna.php'><p>";
                echo "<input type=text size=10 name='data' value=".date('d.m.Y',$fday).">";
                 echo"<input type=text size=10 name='ora_p' value=".date('H:i',$ftsrc).">";
                 echo"<input type=text size=10 name='ora_a' value=".date('H:i',$ftdst).">";
                echo "<input type=text size=10 name='posti' value=".$fseat.">";
                echo "<input type=\"hidden\" name=\"volo\" value=\"$row[fid]\">";
                echo "<input type=\"submit\" name='action' value=\"Aggiorna\" onclick='return checkFormat(data.value,ora_p.value,ora_a.value,posti.value)'>";
                echo "<input type=\"submit\" name='action' value=\"Cancella\"></p></form></td></tr>";
              }
       echo" </table>";
      mysqli_free_result($result);  
      }

             mysqli_close($con);
             ?>


             <h2>Add a flight</h2>
          <table>

                        <tr><th>Identification</th>
                            <th>Airport of departure</th>
                            <th>Airport of arrival</th>
                            <th>Date</th>
                            <th>Time of Departure</th>
                            <th>Time of Arrival</th>
                            <th>Available Seats</th>
                            <th>Price</th>
                            </tr>
  <?php
          echo"  <form name='aggiungiForm' method='POST' action='aggiorna.php'> ";
           echo "<tr><td>Automatically generated</td>";
            echo "<td><textarea rows='1'cols='15' name='part'></textarea></td>";
            echo"<td><textarea rows='1' cols='15' name='arr'></textarea></td>";
            echo "<td><textarea rows='1' cols='15' name='data'></textarea></td>";
            echo"<td><textarea rows='1' cols='10' name='ora_p'></textarea></td>";
            echo"<td><textarea rows='1' cols='10' name='ora_a'></textarea></td>";
            echo "<td><textarea rows='1' cols='5' name='posti'></textarea></td>";
            echo "<td><textarea rows='1' cols='5' name='costo'></textarea></td>";
                
            echo "<td><input type=\"submit\" name='action' value=\"Aggiungi\" onclick='return checkFormato(part.value, arr.value,data.value,ora_p.value,ora_a.value,posti.value, costo.value)'></td></tr></form>";
  ?>      
       
          </table>
       
        <?php
      }   }
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
