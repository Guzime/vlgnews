<?php
    session_start();
    require_once "bd.php"; 
    
    header('Content-Type: text/html; charset= utf-8');

    $id = $_GET['id'];
        
        if(isset($_POST['submit']))
        {
            $text = htmlspecialchars($_POST['text']);
            $head = htmlspecialchars($_POST['head']);
            $section = htmlspecialchars($_POST['section']);
            $keywords = htmlspecialchars($_POST['keywords']);
            
            $sth = $dbh->prepare("UPDATE news SET head = ?, text = ?, section = ?, keywords = ?  WHERE news.id = ? ");
            $sth->execute(array($head, $text, $section, $keywords, $id));
               
        }
      
       if(is_uploaded_file($_FILES['file']['tmp_name'])) 
        {
           if($_FILES['file']['size'] == 0)
                echo "
                    <html>
                      <head>
                       <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
                      </head>
                      <script> alert('Файл слишком большой'); </script>
                    </html>";
            
            $getMime = explode('.', $_FILES['file']['name']);
            $mime = strtolower(end($getMime));
            // массив допустимых расширений
            $types = array('jpg', 'png', 'jpeg');
            
            // если расширение не входит в список допустимых - return
            if(!in_array($mime, $types))
            {
                echo "
                    <html>
                      <head>
                       <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
                      </head>
                     <script> alert('Недопустимы формат файла (должен быть jpg, png либо jpeg )'); </script> 
                    </html>";
                exit();    
            }
         
            // загружаем изображение на сервер
            $file = $_FILES['file'];
            copy($file['tmp_name'], 'fornews/' . "$id".".jpg");
            header ('location: /', true, 301);
                 }
        else
        {
            header ('location: /', true, 301);
        }
     
 
?>