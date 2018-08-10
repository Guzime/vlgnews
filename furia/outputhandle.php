<?php
 
function output_news_with_tag($tag, $dbh)
{
    $sth = $dbh->prepare('SELECT LEFT(text, 200), head, publication_date, keywords, id FROM news ORDER BY publication_date DESC ');
    $sth->execute();
    $counter = 0;
    foreach($sth as $row)
    {
        $str_tags = mb_strtolower($row['keywords'], 'UTF-8');
        $array_tags = preg_split("/[\s,]+/", $str_tags);
        foreach($array_tags as $word)
        {
            if ($word == $tag)
            {
                output_news($row, false);
                $counter++;
            }
        }
    }
    if(!$counter)
    {
        show_error("http://furia/", "таких новостей не существует!");
    }
}
 
function output_navigation_of_str($number_page, $url, $max_page)
{
    echo "<div id=navigation>";
    if($number_page > 1)
    {
        echo"<a href=".$url."page=".($number_page - 1)." >  <<предыдущая страница </a> ";
    }
    if($number_page < $max_page)
    {
        echo  "<a href=".$url."page=".($number_page + 1)."> следующая страница>> </a></div>"; 
    } 
}
 
 
function output_news_with_section($section, $dbh, $start, $step, $number_page)
{
    $sth = $dbh->prepare('SELECT LEFT(text, 200), head, publication_date, id FROM news  WHERE section = ? ORDER BY publication_date DESC LIMIT ?, ?');
    $sth->bindValue(1, $section, PDO::PARAM_STR);
    $sth->bindValue(2, $start, PDO::PARAM_INT);
    $sth->bindValue(3, $step, PDO::PARAM_INT);
    $sth->execute();
    if(!$sth->rowCount())
    {
        show_error("http://furia/", "таких новостей не существует!");
    }
    
    $count = $dbh->prepare('SELECT COUNT(*) FROM news WHERE section = ?');
    $count->execute(array($section));
    $max_page = ceil($count->fetchColumn()/$step);
    echo $max_page;
    
    foreach($sth as $row)
    {
        output_news($row, false);
    }
    
    output_navigation_of_str($number_page, "/?section=".$section."&", $max_page);
   
}

function output_all_news( $dbh, $start, $step, $number_page)
{
    $sth = $dbh->prepare('SELECT LEFT(text, 200), head, publication_date, id FROM news ORDER BY publication_date DESC LIMIT ?, ?');
    $sth->bindValue(1, $start, PDO::PARAM_INT);
    $sth->bindValue(2, $step, PDO::PARAM_INT);
    $sth->execute();
    if(!$sth->rowCount())
    {
        show_error("http://furia/", "таких новостей не существует!");
    }
    
    $count = $dbh->query("SELECT COUNT(*) FROM news")->fetchColumn();
    $max_page = ceil($count/$step);
    
     foreach($sth as $row)
    {
        output_news($row, false);
    }
 
    output_navigation_of_str($number_page, "/?".$section, $max_page);
  
}
?>