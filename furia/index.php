<?php session_start();?>
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
                    <br/><h3>Здравствуйте, <?php echo $_SESSION['user'].", ваш уровень прав: ".$_SESSION['root'];?> </h3>
                    <form name = "myform" action = "model/model.php" method = "post">				 
                 
                             <input type = "submit" name = "submit_close" value = "Выйти" />
                                <?php if(($_SESSION['root']) == 10) { ?>
                                    <input type = "submit" name = "create_news" value = "Добаить новость" />
                                <?php } ?>
                    </form>    
                         
                </div>  
                
                
			    	 
         <?php } else { ?>
                <div id="avt_form">
                    <form class="avt_form" name = "myform" action = "model/model.php" method = "post">			 
                         <label>Логин:</label>
                         <input type = "text"  name = "login" placeholder = "Введите логин" /><br/>
                         <label>Пароль:</label>
                         <input type = "password" name = "pass" placeholder = "Введите пароль" /><br />
                         <input type = "submit" name = "submit" value = "Войти" />
                    </form>
                </div>	
          
        <?php } ?>	

        
 </div>   
 
             
                


<?php  require_once "model/bd.php"; 
    if(isset($_GET['tag']))
    {
        $tag = htmlspecialchars($_GET['tag']);
        $sth = $dbh->query('SELECT LEFT(text, 200), head, publication_date, keywords, id FROM news ORDER BY publication_date DESC LIMIT 10');
         foreach($sth as $row)
            {
                $str = mb_strtolower($row['keywords'], 'UTF-8');
                $tags = preg_split("/[\s,]+/", $str);
                foreach($tags as $word)
                {
                    if ($word == $tag)
                    {
                        echo "<a href = list.php?id=".$row['id'].">
                                <div id=content_container>
                                        <div id=header>
                                            <div class=header_content_mainline>".$row['head']."</div>
                                        </div>
                                    <div id=header_lower>";
                                        if (file_exists("model/fornews/".$row['id'].".jpg"))
                                            echo "<img src = model/fornews/".$row['id'].".jpg >";
                                                                    
                                         echo "<div id=header_content_boxcontent>".$row['LEFT(text, 200)']. "..."."</div>
                                               <div id=publication_date> Опубликовано: ".$row['publication_date']." </div>
                                    </div>
                            </a>";
                                if(($_SESSION['root']) == 10) 
                    {
                        echo  " <div id=admin_buttons> 
                                        <form name = adm_form action = model/admin.php?id=".$row['id']." method=post>
                                            <input type=submit name=delete value=Удалить />
                                            <input type=submit name=edit value=Редактировать />
                                        </form>
                                </div>";
                    }
                            echo "</div>";
                    }
                }
            }
    }
    else
    {        
        if(isset($_GET['section']))
            {
                $section = htmlspecialchars($_GET['section']);
                $sth = $dbh->prepare('SELECT LEFT(text, 200), head, publication_date, id FROM news  WHERE section = ? ORDER BY publication_date DESC LIMIT 10');
                $sth->execute(array($section));
            }
        else
            {
                $sth = $dbh->query('SELECT LEFT(text, 200), head, publication_date, id FROM news ORDER BY publication_date DESC LIMIT 10');
            }
            foreach($sth as $row)
            {
                
                echo "<a href = list.php?id=".$row['id'].">
                        <div id=content_container>
                            <div id=header>
                                <div class=header_content_mainline>".$row['head']."</div>
                            </div>
                                <div id=header_lower>";
                                    if (file_exists("model/fornews/".$row['id'].".jpg"))
                                        echo "<img src = model/fornews/".$row['id'].".jpg >";
                                                                
                                     echo "<div id=header_content_boxcontent>".$row['LEFT(text, 200)']. "..."."</div>
                                <div id=publication_date> Опубликовано: ".$row['publication_date']." </div>
                        </div>
                    </a>";
                                if(($_SESSION['root']) == 10) 
                            {
                                echo  " <div id=admin_buttons> 
                                                <form name = adm_form action = model/admin.php?id=".$row['id']." method=post>
                                                    <input type=submit name=delete value=Удалить />
                                                    <input type=submit name=edit value=Редактировать />
                                                </form>
                                        </div>";
                            }
                    echo "</div>";
            }
    }
 ?>   
     
        
</body>
</html>
