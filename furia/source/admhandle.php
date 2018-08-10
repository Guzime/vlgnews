<?php
    require_once "functions.php"; 
    require_once "bd.php"; 
    header('Content-Type: text/html; charset= utf-8');

    $id = $_GET['id'];
        
        if(isset($_POST['submit']))
        {
            $text = ($_POST['text']);
            $head = ($_POST['head']);
            $section = ($_POST['section']);
            $keywords = ($_POST['keywords']);
            
            $sth = $dbh->prepare("UPDATE news SET head = ?, text = ?, section = ?, keywords = ?  WHERE news.id = ? ");
            $sth->execute(array($head, $text, $section, $keywords, $id));
        }
      
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
            
            // если расширение не входит в список допустимых - return
            if(!in_array($extension, $correct_extension))
            {
                show_error($_SERVER['HTTP_REFERER'], "Недопустимы формат файла (должен быть jpg, png либо jpeg )");
            }
         
            // загружаем изображение на сервер
            $file = $_FILES['file'];
            copy($file['tmp_name'], 'fornews/' . "$id".".jpg");
            redirect("http://furia/");
        }
        else
        {
            redirect("http://furia/");
        }
     
 
?>