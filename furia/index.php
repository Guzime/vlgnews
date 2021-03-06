<?php 
    require_once "source/bd.php"; 
    require_once "source/functions.php"; 
    require_once "outputhandle.php"; 
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
                    <br/><h3>Здравствуйте, <?php echo $_SESSION['user'];?></h3>
                    <form name = "myform" action = "source/authorization.php" method = "post">				 
                 
                             <input type = "submit" name = "submit_close" value = "Выйти" />
                                <?php if(($_SESSION['is_admin'])) { ?>
                                    <input type = "submit" name = "create_news" value = "Добаить новость" />
                                <?php } ?>
                    </form>    
                         
                </div>  
                
                
			    	 
         <?php } else { ?>
                <div id="avt_form">
                    <form class="avt_form" name = "myform" action = "source/authorization.php" method = "post">			 
                         <label>Логин:</label>
                         <input type = "text"  name = "login" placeholder = "Введите логин" /><br/>
                         <label>Пароль:</label>
                         <input type = "password" name = "pass" placeholder = "Введите пароль" /><br />
                         <input type = "submit" name = "submit" value = "Войти" />
                    </form>
                </div>	
          
        <?php } ?>	
</div>   
<?php  
    $start = 0;
    $step = 4;
    $number_page = 1;

    if(isset($_GET['page']))
    {
        $number_page = htmlspecialchars($_GET['page']);
        $start = $step * ( $number_page - 1);
    }
    if(isset($_GET['tag']))
    {
        $tag = htmlspecialchars($_GET['tag']);
        output_news_with_tag($tag, $dbh);
     
    }
    else
    {        
        if(isset($_GET['section']))
            {
                $section = htmlspecialchars($_GET['section']);
                output_news_with_section($section, $dbh, $start, $step, $number_page);
            }
        else
            {
                output_all_news( $dbh, $start, $step, $number_page);
            }
    }
   
 ?>   
</body>
</html>
