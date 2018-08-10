<?php
session_start();
    
function output_news($row, $is_full)
{
    if($is_full)
    {
        $array_tags = preg_split("/[\s,]+/", $row['keywords']);
        echo "<div id=content_container_list>
                    <div id=header>
                  <div class=header_content_mainline>".htmlspecialchars($row['head'])."</div>
                </div>
                    <div id=header_lower>";
                        if (file_exists("source/fornews/".htmlspecialchars($row['id']).".jpg"))
                            echo "<img src = source/fornews/".$row['id'].".jpg >";
                        
                          echo"  <div id=header_content_boxcontent>".htmlspecialchars($row['text'])."</div>
                         <div id=publication_date> Опубликовано: ".htmlspecialchars($row['publication_date'])." </div>
                            <div id=tags> <span> Для поиску по тегу нажмите на него: </span>";
                             foreach($array_tags as $tag_name)
                                 {
                                     echo "<a href=index.php?tag=".mb_strtolower($tag_name, 'UTF-8')."> #".mb_strtolower($tag_name, 'UTF-8')."</a>";

                                 }
                    echo "  </div>
                    </div>";
    }
    else 
    {
      echo "<a href = news.php?id=".$row['id'].">
            <div id=content_container>
                    <div id=header>
                        <div class=header_content_mainline>".htmlspecialchars($row['head'])."</div>
                    </div>
                <div id=header_lower>";
                    if (file_exists("source/fornews/".$row['id'].".jpg"))
                        echo "<img src = source/fornews/".$row['id'].".jpg >";
                                                
                     echo "<div id=header_content_boxcontent>".htmlspecialchars($row['LEFT(text, 200)']). "..."."</div>
                           <div id=publication_date> Опубликовано: ".htmlspecialchars($row['publication_date'])." </div>
                </div>
        </a>";
    }
    if(($_SESSION['is_admin'])) 
    {
        echo  " <div id=admin_buttons> 
                        <form name = adm_form action = source/admin.php?id=".$row['id']." method=post>
                            <input type=submit name=delete value=Удалить />
                            <input type=submit name=edit value=Редактировать />
                        </form>
                </div>";
    }
    echo "</div>";
    
}
    
function output_admin_form($row, $action)
{
           
     echo "<div id=edit_form>
                <form class=edit_form name=edit_form action=".$action." enctype=multipart/form-data method=post>
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
          </div>";
}

function show_error($url, $error)
{
    echo "<html>
              <head>
                    <meta http-equiv='Refresh' content='0; URL=".$url."'>
              </head>
                    <script> alert('".$error."'); </script>
         </html>";	
    exit();     
}

function redirect($url)
{
        echo "<html>
                  <head>
                        <meta http-equiv='Refresh' content='0; URL=".$url."'>
                  </head>
             </html>";	
        exit();             
    }
 ?>