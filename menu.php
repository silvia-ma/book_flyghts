<div id="menu">
<h2>Men&ugrave;</h2>
             <ul>
     <li><a href="home.php">Home</a></li>
     <li><a href="voli.php">Flights</a></li>
     <li><a href="carrello.php">Basket</a></li>
    <?php
          if(session_status()!==PHP_SESSION_ACTIVE){
             session_start();  }
        
         if(isset($_SESSION['privilegi'])) {
          echo "<li><a href=\"gestione.php\">Manage flights</a></li>";        }
    ?>

      	      </ul>
</div>