<?php
        require_once "bd.php";
        require_once "functions.php"; 
        if(isset($_POST['delete']))
        {
            $id = $_GET['id'];
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

    $id = $_GET['id'];
     
        if((isset($_POST['edit']) || $_SESSION['is_admin'] == true) && isset($_GET[id]))
        {
                  
                   $sth = $dbh->prepare("SELECT * FROM news WHERE news.id = ? ");
                   $sth->execute(array($id));
                   foreach($sth as $row)
                   {
                       $action = "admhandle.php?id=".$id;
                       output_admin_form($row, $action);
                   }
        }
   
        if ((isset($_POST['create_news']) || $_SESSION['is_admin'] == true) && !isset($_GET['id']))
        {
            $row = array("head" => "" , "keywords" => "", "text" => "");
            $action = "crthandle.php";
            output_admin_form($row, $action);
            
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