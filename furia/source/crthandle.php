<?php
    require_once "functions.php"; 
    require_once "bd.php"; 
    header('Content-Type: text/html; charset= utf-8');

 if (isset($_POST['submit']))
 {
     $text = ($_POST['text']);
     $head = ($_POST['head']);
     $section = ($_POST['section']);
     $keywords = ($_POST['keywords']);
     $publication_date = date("Y-m-d H:i:s");
     
     if(is_uploaded_file($_FILES['file']['tmp_name'])) 
        {
           if($_FILES['file']['size'] == 0)
            {
                show_error($_SERVER['HTTP_REFERER'], "Файл слишком большой");
            }
                
            $buffer = explode('.', $_FILES['file']['name']);
            $extension = strtolower(end($buffer));
            // массив допустимых расширений
            $correct_extension = array('jpg', 'png', 'jpeg');
            
            // если расширение не входит в список допустимых 
            if(!in_array($extension, $correct_extension))
            {
               show_error("http://furia/source/admin.php", "Недопустимы формат файла (должен быть jpg, png либо jpeg )");
            }
            
            $sth = $dbh->prepare("INSERT INTO news(text, head, section, publication_date, keywords) VALUES(?, ?, ?, ?, ? )");
            $sth->execute(array($text, $head, $section, $publication_date, $keywords));
             
            $sth = $dbh->query("SELECT id FROM news ORDER BY id DESC LIMIT 1");
            $id = $sth->fetchColumn();
            // загружаем изображение на сервер
            $file = $_FILES['file'];
            copy($file['tmp_name'], 'fornews/' . "$id".".jpg");
            redirect("http://furia/");
        }
   
        else
        {
            $sth = $dbh->prepare("INSERT INTO news(text, head, section, publication_date, keywords) VALUES(?, ?, ?, ?, ? )");
            $sth->execute(array($text, $head, $section, $publication_date, $keywords));
            redirect("http://furia/");
        }
    
 }        
?>