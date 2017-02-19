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
            {  echo "<p>SESSIONI DISABILITATE, impossibile proseguire</p>\n";  }
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
	echo "<p>Error connection DBMS: ".mysqli_connect_error()."</p>\n";
      	else
       {
     if ((isset($_REQUEST['data']))&& (isset($_REQUEST['ora_p']))&&(isset($_REQUEST['ora_a']))&&(isset($_REQUEST['posti'])))
     {
      $data = date('Y-m-d',strtotime($_REQUEST['data']));
      $ora_p = date('H:i:s',strtotime($_REQUEST['ora_p']));
      $ora_a = date('H:i:s',strtotime($_REQUEST['ora_a']));
      $posti = $_REQUEST['posti'];

     
      if (($_REQUEST['action'])=="Aggiorna")
      { $fid = $_REQUEST['volo'];
        $query = "UPDATE `fly` SET fday = '$data', ftsrc = '$ora_p', ftdst = '$ora_a' , fseat  = '$posti'   WHERE fid = '$fid'";
       $result = mysqli_query($con, $query);
         if (!$result)
        { echo "<tr><td colspan='4'>Errore – query fallita: ".mysqli_error($con)."</td></tr>"; }
             else
            { echo "<p>Update successful!</p>";  } }


         if (($_REQUEST['action'])=="Cancella")
         { $fid = $_REQUEST['volo'] ; 
           $query = "DELETE FROM `fly` WHERE fid = '$fid'";
         $result = mysqli_query($con, $query);
         if (!$result)
         { echo "<tr><td colspan='4'>Errore – query fallita: ".mysqli_error($con)."</td></tr>"; }
             else
            {echo "<p>Delete successful!</p>";  }    }

         if ((($_REQUEST['action'])=="Aggiungi")&&(isset($_REQUEST['part']))&& (isset($_REQUEST['arr']))&&(isset($_REQUEST['costo'])) )
         {
           $query1 = "SELECT fid FROM `fly` ORDER BY fid";
           $result = mysqli_query($con, $query1);
           if(!$result)
          echo "<tr><td colspan='4'>Error – failed query: ".mysqli_error($con)."</td></tr>";
                else
            {    $j=1;
                 $flag=false;
                 $nrow = mysqli_num_rows($result);
                 while($row = mysqli_fetch_assoc($result))
                 { foreach ( $row as $key => $value )
                   { if ($value!=$j)
                     {$fid=$j;
                     $flag=true;}
                     else
                     $j++;  }              }
                     if($flag==false)
                     $fid=$row++;

            mysqli_free_result($result);

           $part = $_REQUEST['part'];
           $arr = $_REQUEST['arr'];
           $costo = $_REQUEST['costo'];
           $query = "INSERT INTO `fly` (`fid`, `fsrc`, `fdst`, `fday`, `ftsrc`, `ftdst`, `fseat`, `fprice`) VALUES
           ('$fid','$part','$arr','$data','$ora_p','$ora_a','$posti','$costo')";
         $result = mysqli_query($con, $query);
         if (!$result)
         { echo "<tr><td colspan='4'>Errore – query fallita: ".mysqli_error($con)."</td></tr>"; }
             else
            {echo "<p>Volo aggiunto con successo!</p>"; } }
            }

     echo "<p>Torna alla <a href=\"gestione.php\">pagina di gestione</a></p>";
        }

         mysqli_close($con);
         }} ?>
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
