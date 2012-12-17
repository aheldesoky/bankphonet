<?php



//View CMS
if($page == 'default')
{
    $page_name = $_GET['node'];
    
    if($page_name)
        $page = $oCms->getPage($page_name);
    
    $inner_page = 'views/cms/page.php';
    include $master_page;
}


?>
