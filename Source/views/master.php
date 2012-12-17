<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html dir="<?= ($local == 'ar') ? 'rtl' : 'ltr'; ?>">
    <head>
        <title><?= l ('BANKPHONET.COM | First egyptian online bank free register recharge pay transfer withdraw 0% fees') ?></title>
        <meta name="description" content="BANKPHONET.COM online payment gateway in Egypt" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="views/assets/js/jquery-1-6-4.js"></script>
        <script type="text/javascript" src="views/assets/js/common.js"></script>
        <script type="text/javascript" src="views/assets/js/jquery.bvalidator.js"></script>

        <?php if ($local == 'ar') { ?>
            <link type="text/css" rel="stylesheet" href="views/assets/css/style-ar.css" />
        <?php } else { ?>
            <link type="text/css" rel="stylesheet" href="views/assets/css/style.css" />
        <?php } ?>

        <link type="text/css" rel="stylesheet" href="views/assets/css/bvalidator.css" />
        <link type="text/css" rel="stylesheet" href="views/assets/css/shCore.css" />
        <link type="text/css" rel="stylesheet" href="views/assets/css/shCoreDefault.css" />


        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-5205741-10']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>
    <body>


        <div class="main-holder">


            <div class="header">

                <div class="logo">
                    <a href=".">
                        <img src="views/assets/images/logo.png" width="147" height="33" alt="bankphonet.com"/>
                    </a>
                </div><!-- logo -->



                <div class="links">

                    <?php if (!$oUser -> id) { ?>
                        <div class="login-form">

                            <form action="?page=login" method="post" class="bvalidator" autocomplete="off">
                                <input type="text" id="email" name="email" value="<?= l ('Email / Phone no.') ?>"  class="txtbox txtlogin clearonfocus" data-bvalidator ="required" title="<?= l ('Email / Phone no.') ?>"/>

                                <input type="password" id="password" name="password" value="<?= l ('password') ?>" class="txtbox txtlogin clearonfocus" data-bvalidator ="required,minlength[6]" title="<?= l ('password') ?>"/>

                                <input type="submit" value="<?= l ('LOGIN') ?>" class="login"/>
                                <span style="font-size: 11px; color: #FF8300;margin-left: 13px;"><?= l ('bankphonet.com OR phonetmall.com accounts') ?></span>
                            </form>
                        </div>
                    <?php } else { ?>
                        <div class="login-form">
                            <?php if ($local == 'ar') { ?>
                                <a href="?lang=en&ref=<?= getURL () ?>" class="item">English</a>
                            <?php } else { ?>
                                <a href="?lang=ar&ref=<?= getURL () ?>" class="item">عربي </a>
                            <?php } ?>
                            <a href="?action=logout" class="item last"><?= l ('Logout') ?></a>
                            <a href="?page=myprofile" class="item"><?= $oUser -> firstname . ' ' . $oUser -> lastname ?></a>
                            <?php if ($oUser -> admin != 1) { ?>
                            	<a href="?page=transactions-score" class="item balance"><b><?= l ('Score:') ?></b> <?= $oUser -> points ?> <?= l ('Points') ?></a>
                                <a href="?page=transactions" class="item balance"><b><?= l ('Balance:') ?></b> <?= $oUser -> balance ?> <?= l ('EGP') ?></a>
                            <?php } else { ?>
                                <a href="?con=admin" class="item balance"><b>Admin area</b> </a>

                            <?php } ?>


                        </div>
                    <?php } ?>




                </div><!-- links -->
                <?php if (!$oUser -> id) { ?>
                    <?php if ($local == 'ar') { ?>
                        <a href="?lang=en&ref=<?= getURL () ?>" class="item lang">English</a>
                    <?php } else { ?>
                        <a href="?lang=ar&ref=<?= getURL () ?>" class="item lang">عربي </a>
                    <?php } ?>
                <?php } ?>

                <div class="clear"></div>

                <div class="menu">
                    <a href="." class="first <?= ($page == 'default') ? 'current' : ''; ?>"><?= l ('Home') ?></a>
                    <a href="?con=cms&node=online-banking" class="<?= ($_GET['node'] == 'online-banking' || $page == 'transactions' || $page == 'transfer' || $page == 'request-withdraw') ? 'current' : ''; ?>"><?= l ('Online Banking') ?></a>
                    <a href="http://phonetmall.com/?con=stores&page=store&id=57" target="_blank" class="<?= ($_GET['node'] == 'online-payment') ? 'current' : ''; ?>"><?= l ('Online Payment') ?></a>
                    <a href="http://tickets.bankphonet.com" target="_blank" class="<?= ($_GET['node'] == 'tickets') ? 'current' : ''; ?>"><?= l ('Tickets') ?></a>
                    <a href="?con=cms&node=partner-solutions" class="<?= ($_GET['node'] == 'partner-solutions') ? 'current' : ''; ?>" ><?= l ('Partner Solutions') ?></a>
                    <a href="?page=contact-us" class="last <?= ($page == 'contact-us') ? 'current' : ''; ?>" ><?= l ('Contact us') ?></a>
                    <a href="?con=cms&node=how-bankphonet-works" class="<?= ($_GET['node'] == 'how-bankphonet-works' ) ? 'current' : ''; ?>"><?= l ('How it works?') ?></a>

                </div>


            </div><!-- header -->



            <?php
            if ($notify_msg)
                echo '<div class="notifmessage successmessage rad5">' . $notify_msg . '</div>';
            if ($error_msg)
                echo '<div class="notifmessage errormessage rad5">' . $error_msg . '</div>';
            ?>
            <!-- show notification messages to the user -->

            <div class="clear"></div>

            <div class="maincontentholder">
                <?php
                if ($inner_page)
                    include $inner_page;
                ?>
            </div>


            <div class="footer">

                <div class="ssl">
                    <div style="width: 720px; height: 90px; background: url(https://www.bankphonet.com/views/assets/images/admazika2day.png); margin: 0 auto;">
                        <a href="https://www.bankphonet.com" style="float:left; width: 360px; height: 90px;display:block;" target="_blank"></a>
                        <a href="http://www.phonetmall.com" style="float:left; width: 360px; height: 90px;display:block;" target="_blank"></a>
                    </div>

                    <div class="certif">
                        <script type="text/javascript" src="https://seal.thawte.com/getthawteseal?host_name=www.bankphonet.com&amp;size=S&amp;lang=en"></script>
                    </div>

                </div>
                <div class="clear"></div>


                <div class="links">
                    <a href="."><?= l ('HOME') ?></a>
                    <a href="http://phonetmall.com/?con=stores&page=store&id=49"><?= l ('ABOUT US') ?></a>
                    <a href="?con=cms&node=online-banking"><?= l ('ONLINE BANKING') ?></a>
                    <a href="http://phonetmall.com/?con=stores&page=store&id=57" class="<?= ($_GET['node'] == 'online-payment') ? 'current' : ''; ?>"><?= l ('ONLINE PAYMENT') ?></a>
                    <a href="http://tickets.bankphonet.com"><?= l ('TICKETS') ?></a>
                    <a href="?con=cms&node=partner-solutions"><?= l ('PARTNER SOLUTIONS') ?></a>
                    <a href="?page=contact-us"><?= l ('CONTACT US') ?></a>
                    <a href="https://twitter.com/bankphonet" target="_blank"><img src="views/assets/images/twitter.png" width="28" height="28" alt="twitter" /></a>
                    <a href="https://www.facebook.com/Bankphonet" target="_blank"><img src="views/assets/images/facebook.png" width="28" height="28" alt="facebook"/></a>
                </div>

                <div class="privacy">
                    copyright © <?= date ('Y') ?> bankphonet.com
                </div>




                <div class="sociallinks">




                </div><!-- sociallinks -->
            </div><!-- footer -->


            <div class="clear"></div>
        </div> <!-- main-holder -->

        <div class="certif">
            <script type="text/javascript" src="https://seal.thawte.com/getthawteseal?host_name=www.bankphonet.com&amp;size=S&amp;lang=en"></script>
        </div>

    </body>
    <script type="text/javascript">

        $('.clearonfocus').focus(function() {
            if (this.value == this.title) {
                $(this).val("");
            }
        }).blur(function() {
            if (this.value == "") {
                $(this).val(this.title);
            }
        });

    </script>
</html>
