<?php 
    require_once "source/bd.php"; 
    require_once "source/functions.php"; 
?>
<!DOCTYPE >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>VLGNEWS</title>
<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
</head>


<body>
<div id="top_bar_black">
 
    <div id="logo_container"> <a href=./ > <div id="logo_image"> </div></a>  
        <div id="nav_block">
          <a href=index.php?section=politic>
            <div class="nav_button"> Политика </div>
          </a>
          <a href=index.php?section=sport>
            <div class="nav_button"> Спорт </div>
          </a>
          <a href=index.php?section=science>
            <div class="nav_button"> Наука </div>
          </a>
          <a href=index.php?section=economic>
            <div class="nav_button"> Экономика </div>
          </a>
        </div>
    </div> 
          <?php if(isset($_SESSION['user'])) { ?>
                <div id="greeting_form">
                    <br/><h3>Здравствуйте, <?php echo $_SESSION['user']; ?> </h3>
                    <form name = "myform" action = "source/authorization.php" method = "post">				 
                 
                             <input type = "submit" name = "submit_close" value = "Выйти" />
                                <?php if(($_SESSION['is_admin'])) { ?>
                                    <input type = "submit" name = "create_news" value = "Добаить новость" />
                                <?php } ?>
                    </form>    
                         
                </div>  
			    	 
         <?php } else { ?>
               <div id="avt_form">
                    <form name = "myform" action = "source/authorization.php" method = "post">			 
                         <label>Логин:</label>
                         <input type = "text" name = "login" placeholder = "Введите логин" /><br/>
                         <label>Пароль:</label>
                         <input type = "password" name = "pass" placeholder = "Введите пароль" /><br />
                         <input type = "submit" name = "submit" value = "Войти" />
                    </form>
             </div>	
        <?php } ?>		        
 </div>   
</div>

<?php  

    $id = htmlspecialchars($_GET['id']);
    $sth = $dbh->prepare("SELECT * FROM news WHERE news.id = ? ");
    $sth->execute(array($id));
    if($sth->rowCount())
    {    
        foreach($sth as $row)
        {
            output_news($row, true);             
        }
    }
    else
    {
        show_error("http://furia/", "Новости с id: ".$id." не существует!");
    }
 ?>   
     
      
</body>
</html>
