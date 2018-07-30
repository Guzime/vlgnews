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
                    <form name = "myform" action = "model/model.php" method = "post">			 
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

<?php  require_once "model/bd.php"; 


    
    $id = htmlspecialchars($_GET['id']);
    $sth = $dbh->prepare("SELECT * FROM news WHERE news.id = ? ");
    $sth->execute(array($id));
        foreach($sth as $row)
        {
            $tags = preg_split("/[\s,]+/", $row['keywords']);
            echo "<div id=content_container_list>
                        <div id=header>
                      <div class=header_content_mainline>".$row['head']."</div>
                    </div>
                        <div id=header_lower>";
                            if (file_exists("model/fornews/".$row['id'].".jpg"))
                                echo "<img src = model/fornews/".$row['id'].".jpg >";
                            
                              echo"  <div id=header_content_boxcontent>".$row['text']."</div>
                             <div id=publication_date> Опубликовано: ".$row['publication_date']." </div>
                                <div id=tags> <span> Теги для поиска: </span>";
                                 foreach($tags as $tag_name)
                                     {
                                         echo "<a href=index.php?tag=".mb_strtolower($tag_name, 'UTF-8')."> #".mb_strtolower($tag_name, 'UTF-8')."</a>";

                                     }
                        echo "  </div>
                        </div>";
                        
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
 ?>   
     
      
</body>
</html>
