<?php
     require_once "functions.php"; 
     require_once "bd.php";
     header('Content-Type: text/html; charset= utf-8');
 
     if(isset($_POST['submit'])) {
		 if(!$_POST['login'] == "" && !$_POST['pass'] == "") 
         {			 
		     $login = $_POST['login'];
		     $pass = $_POST['pass'];
		     $pass = md5($pass);
			 $sth = $dbh->prepare("SELECT is_admin FROM reg_user WHERE login = ? && pass = ?");
             $sth->execute(array($login, $pass));
		     if($sth->rowCount())
             {				
                $_SESSION['user'] = $login; 
                $is_admin = $sth->fetchColumn();
                $_SESSION['is_admin'] = $is_admin;
                redirect($_SERVER['HTTP_REFERER']);	 
		     }			
		     else 
             {
                show_error($_SERVER['HTTP_REFERER'], "Вы ввели неправильные данные");
			 }			
		 }
		 else 
         {
            show_error($_SERVER['HTTP_REFERER'], "Вы заполнили не все поля");
		 }
     }
     else
     {
	     if($_POST['submit_close']) { 
	         unset($_SESSION['user']);
             unset($_SESSION['is_admin']);
             redirect($_SERVER['HTTP_REFERER']);	 
	     }
     }
     
     if ($_POST['create_news'] )
     {
        require_once "admin.php"; 
     }
     
     
?>