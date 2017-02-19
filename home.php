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
       <p> Il sito AirOwl ti permette di programmare e acquistare i tuoi voli.</p> <p>Effettua il LOGIN per iniziare a volare!
       </p>

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