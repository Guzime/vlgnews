<?php  require_once "bd.php"; 
header('Content-Type: text/html; charset= utf-8');

 if (isset($_POST['create']))
 {
     $text = htmlspecialchars($_POST['text']);
     $head = htmlspecialchars($_POST['head']);
     $section = htmlspecialchars($_POST['section']);
     $keywords = htmlspecialchars($_POST['keywords']);
     $publication_date = date("Y-m-d H:i:s");
     
     if(is_uploaded_file($_FILES['file']['tmp_name'])) 
        {
           if($_FILES['file']['size'] == 0)
           {
               echo "
                    <html>
                      <head>
                       <meta http-equiv='refresh' content='0;http://furia/model/admin.php'>
                      </head>
                      <script> alert('Файл слишком большой'); </script>
                    </html>";
                    exit();
           }
            $getMime = explode('.', $_FILES['file']['name']);
            $mime = strtolower(end($getMime));
            // массив допустимых расширений
            $types = array('jpg', 'png', 'jpeg');
            
            // если расширение не входит в список допустимых 
            if(!in_array($mime, $types))
             {
               echo "
                    <html>
                      <head>
                       <meta http-equiv='refresh' content='0;http://furia/model/admin.php'>
                      </head>
                      <script> alert('Недопустимы формат файла (должен быть jpg, png либо jpeg )'); </script>
                    </html>";
                    exit();
           }
            
             $sth = $dbh->prepare("INSERT INTO news(text, head, section, publication_date, keywords) VALUES(?, ?, ?, ?, ? )");
             $sth->execute(array($text, $head, $section, $publication_date, $keywords));
             
             $sth = $dbh->query("SELECT id FROM news ORDER BY id DESC LIMIT 1");
             $id = $sth->fetchColumn();
            // загружаем изображение на сервер
            $file = $_FILES['file'];
            copy($file['tmp_name'], 'fornews/' . "$id".".jpg");
            header ('location: /', true, 301);
            
        }
   
        else
        {
            $sth = $dbh->prepare("INSERT INTO news(text, head, section, publication_date, keywords) VALUES(?, ?, ?, ?, ? )");
             $sth->execute(array($text, $head, $section, $publication_date, $keywords));
            
            header ('location: /', true, 301);
        }
    
 }        
?>