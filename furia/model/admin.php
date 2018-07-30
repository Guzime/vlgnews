<?php session_start();?>
<?php
        require_once "bd.php";
        if(isset($_POST['delete']))
        {
            $id = htmlspecialchars($_GET['id']);
            $sth = $dbh->prepare("DELETE FROM news WHERE news.id = ? ");
            $sth->execute(array($id));
            if (file_exists("fornews/".$id.".jpg"))
                unlink("fornews/".$id.".jpg");
            header ('location: /', true, 301);
        }
 ?>
<!DOCTYPE >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>VLGNEWS</title>
<script src="js/jquery-3.3.1.min.js"></script>
<link href="/css/stylesheet.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="top_bar_black">
    <div id="logo_container"> <a href=/ > <div id="logo_image"> </div></a>  
        <div id="nav_block">
          <a href=/index.php?section=politic>
            <div class="nav_button"> Политика </div>
          </a>
          <a href=/index.php?section=sport>
            <div class="nav_button"> Спорт </div>
          </a>
          <a href=/index.php?section=science>
            <div class="nav_button"> Наука </div>
          </a>
          <a href=/index.php?section=economic>
            <div class="nav_button"> Экономика </div>
          </a>
        </div>
    </div> 
 </div>   
</div>

<?php  

    $id = htmlspecialchars($_GET['id']);
     
        if((isset($_POST['edit']) || $_SESSION['root'] == 10) && isset($_GET[id]))
        {
                  
                   $sth = $dbh->prepare("SELECT * FROM news WHERE news.id = ? ");
                   $sth->execute(array($id));
                   foreach($sth as $row)
                   {
                        echo "<div id=edit_form>
                                    <form class=edit_form name=edit_form action=admhandle.php?id=".$id." enctype=multipart/form-data method=post>
                                        <br/><label>Заголовок:</label><br/>
                                        <input type=text name=head id=head value='".$row['head']."' /> <br/>
                                        <label>Ключевые слова (через запятую):</label><br/>
                                        <input type=text name=keywords id=keywords value='".$row['keywords']."'/> <br/>
                                        <label>Текст новости:</label><br/>
                                        <textarea name=text id=text> ".$row['text']." </textarea> <br/>
                                        <label>Раздел:</label><br/>
                                        <select name=section size=4>
                                            <option selected value=politic>Политика</option>
                                            <option value=sport>Спорт</option>
                                            <option value=science>Наука</option>
                                            <option value=economic>Экономика</option>
                                       </select><br/>
                                        <div id=file_upload>
                                            <input type=file name=file><br/>
                                        </div>
                                         <br/>
                                       <input type=submit name=submit value=Принять />
                                    </form>
                              </div>
                        ";
                   }
        }
   
        
         if ((isset($_POST['create_news']) || $_SESSION['root'] == 10) && !isset($_GET['id']))
        {
            ?>
                <div id=edit_form>
                    <form class=edit_form name=edit_form action=crthandle.php enctype=multipart/form-data method=post>
                            <br/><label>Заголовок:</label><br/>
                            <input type=text name=head id=head /> <br/>
                            <label>Ключевые слова (через запятую):</label><br/>
                            <input type=text name=keywords id=keywords /> <br/>
                            <label>Текст новости:</label><br/>
                            <textarea name=text id=text>  </textarea> <br/>
                            <label>Раздел:</label><br/>
                            <select name=section id=section size=4 >
                                <option selected value=politic>Политика</option>
                                <option value=sport>Спорт</option>
                                <option value=science>Наука</option>
                                <option value=economic>Экономика</option>
                           </select><br/>
                            <div id=file_upload>
                                <input type=file name=file><br/>
                            </div>
                             <br/>
                           <input type=submit name=create value=Принять />
                    </form>
              </div>
           <?php
        }
    ?>
               <script type="text/javascript">
                $(document).ready(function() {
                    $(".edit_form").submit(function()
                    { 
                        if($.trim($("#head").val())== "" || $.trim($("#keywords").val())== "" || $.trim($("#text").val())== "" ) 
                        {
                                alert("Не все заполнены поля");
                                return false;
                     
                        }
                
                    });
                    
                    return true;
                    
                 });
                </script>
    
  
</body>
</html>