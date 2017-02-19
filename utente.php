<div id="utente">

   You're visiting the website as:
   <?php
   
   if(session_status()!==PHP_SESSION_ACTIVE){
     session_start();
   }
   if(!isset($_SESSION['username']))
      {
        echo "ANONYMOUS";
      ?>
        <form name="login_form" action="login.php" method="POST">
        <p>Username: <input type="text" name="username" size=15></p>
        <p>Password: <input type="text" name="password" size=15></p>
        <p><input type="submit" value="LOGIN"> </p>
    </form>
       <?php
            }

     else
       {

         echo $_SESSION['username'];
         echo "<p>Credit available:</p>";
         echo $_SESSION['credito'];
         ?> 

         <form name="logout_form" action="logout.php" method="POST" >
       <p> <input type="submit" name="logout" value="LOGOUT" ></p></form>
       <?php
        } ?>

     </div>