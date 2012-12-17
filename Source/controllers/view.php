<?php




if($page == 'myprofile')
{
    $profile = $oUser->get_user_profile ($oUser->id);
    $inner_page = 'views/accounts/myprofile.php';
    include $master_page;
}





if($page == 'admin')
{
    $inner_page = 'views/admin/home.php';
    include $master_page;
}




if($page == 'admin-accounts')
{
    $inner_page = 'views/admin/accounts.php';
    include $master_page;
}




if($page == 'admin-transactions')
{
    $inner_page = 'views/admin/transactions.php';
    include $master_page;
}




if($page == 'admin-withdraw')
{
    $inner_page = 'views/admin/accounts.php';
    include $master_page;
}





if($page == 'admin-deposit')
{
    $inner_page = 'views/admin/accounts.php';
    include $master_page;
}



if($page == 'admin-transfer')
{
    $inner_page = 'views/admin/accounts.php';
    include $master_page;
}



if($page == 'admin-newaccount')
{
    $inner_page = 'views/admin/accounts.php';
    include $master_page;
}




if($page == 'cms')
{
    $inner_page = 'views/cms/page.php';
    include $master_page;
}




