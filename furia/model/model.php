<?php session_start();
     require_once "bd.php";//подкл БД 
     header('Content-Type: text/html; charset= utf-8');
 
     if(isset($_POST['submit'])) {
		 if(!$_POST['login'] == "" && !$_POST['pass'] == "") 
         {			 
		     $login = $_POST['login'];
		     $login = htmlspecialchars($login);
		     $login = trim($login);
		     $login = stripslashes($login);
				 
		     $pass = $_POST['pass'];
		     $pass = htmlspecialchars($pass);
		     $pass = trim($pass);
		     $pass = stripslashes($pass);
             $pass = md5($pass);
				 
			 $sth = $dbh->query("SELECT `root` FROM `reg_user` WHERE login = '$login' && pass = '$pass'");
		     if($sth->rowCount() > 0) {				
			  $_SESSION['user'] = $login; 
              $root = $sth->fetchColumn();
              $_SESSION['root'] = $root;
				     echo "
                            <html>
                              <head>
                               <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
                              </head>
                            </html>";				 
		     }			
		     else {
			    echo "
                            <html>
                              <head>
                               <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
                              </head>
                              <script> alert('Вы ввели неправильные данные'); </script>
                            </html>";		
		     }			
		 }
		 else {
			     echo "
                            <html>
                              <head>
                               <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
                              </head>
                              <script> alert('Вы заполнили не все поля'); </script>
                            </html>";		
		 }
     }
     else {
	     if($_POST['submit_close']) { 
	         unset($_SESSION['user']);
             unset($_SESSION['root']);
	        echo "
                            <html>
                              <head>
                               <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
                              </head>
                            </html>";
	     }

     }
     
     if ($_POST['create_news'] )
     {
        require_once "admin.php"; 
     }
     
     
?>