<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html dir="<?= ($local == 'ar')? 'rtl':'ltr'; ?>">
    <head>
        <title>BANKPONET.COM | Home</title>
		<meta name="description" content="BANKPHONET.COM online payment gateway in Egypt" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script type="text/javascript" src="views/assets/js/jquery-1-6-4.js"></script>
		<script type="text/javascript" src="views/assets/js/common.js"></script>
		<script type="text/javascript" src="views/assets/js/jquery.bvalidator-yc.js"></script>

		<?php if($local == 'ar') { ?>
			<link type="text/css" rel="stylesheet" href="views/assets/css/style-ar.css" />
		 <?php }else{  ?>
			<link type="text/css" rel="stylesheet" href="views/assets/css/style.css" />
		 <?php } ?>
		
		<link type="text/css" rel="stylesheet" href="views/assets/css/bvalidator.css" />
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

					<?php if (!$oUser->id) {?>
						<div class="login-form">
							
							<form action="?page=login" method="post" class="bvalidator">
								<input type="text" id="email" name="email" value="<?= l('Email / Phone no.')?>"  class="txtbox txtlogin clearonfocus" data-bvalidator ="required" title="<?= l('Email / Phone no.')?>"/>

								<input type="password" id="password" name="password" value="<?= l('password')?>" class="txtbox txtlogin clearonfocus" data-bvalidator ="required,minlength[6]" title="<?= l('password')?>"/>

								<input type="submit" value="<?= l('LOGIN')?>" class="login"/>
							</form>
						</div>
					<?php } else { ?>
					<div class="login-form">
						<?php if($local == 'ar') { ?>
							<a href="?lang=en&ref=<?=getURL()?>" class="item">English</a>
						 <?php }else{  ?>
							<a href="?lang=ar&ref=<?=getURL()?>" class="item">عربي </a>
						 <?php } ?>
						<a href="?action=logout" class="item last"><?=l('Logout')?></a>
						<a href="?page=myprofile" class="item"><?=l('My Profile')?></a>
						<?php if($oUser->admin !=1){ ?>
                                                <a href="?page=transactions" class="item balance"><b><?=l('Balance:')?></b> <?=$oUser->balance?> <?=l('EGP')?></a>
						<?php }else { ?>
                                                 <a href="?con=admin" class="item balance"><b>Admin area</b> </a>

                                                <?php } ?>
                                                 
                                                 
					</div>
<?php } ?>
					





				</div><!-- links -->
				<?php if (!$oUser->id) {?>
				<?php if($local == 'ar') { ?>
							<a href="?lang=en&ref=<?=getURL()?>" class="item lang">English</a>
						 <?php }else{  ?>
							<a href="?lang=ar&ref=<?=getURL()?>" class="item lang">عربي </a>
						 <?php } ?>
						 <?php } ?>

				<div class="clear"></div>

				<div class="menu">
						<a href="." class="first <?= ($page == 'default')? 'current': ''; ?>"><?=l('Home')?></a>
						<a href="?con=cms&node=online-banking" class="<?= ($_GET['node'] == 'online-banking' || $page == 'transactions' || $page == 'transfer' || $page == 'request-withdraw')? 'current': ''; ?>"><?=l('Online Banking')?></a>
						<a href="?con=cms&node=online-payment" class="<?= ($_GET['node'] == 'online-payment')? 'current': ''; ?>"><?=l('Online Payment')?></a>
						<a href="?con=cms&node=tickets" class="<?= ($_GET['node'] == 'tickets')? 'current': ''; ?>"><?=l('Tickets')?></a>
						<a href="?con=cms&node=partner-solutions" class="<?= ($_GET['node'] == 'partner-solutions')? 'current': ''; ?>" ><?=l('Partner Solutions')?></a>
						<a href="?page=contact-us" class="last <?= ($page == 'contact-us')? 'current': ''; ?>" ><?=l('Contact us')?></a>
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
					<img src="views/assets/images/ssl.png" width="298" height="67" alt="ssl"/>
				</div>


				<div class="links">
					<a href="."><?=l('HOME')?></a>
					<a href="?con=cms&node=online-banking"><?=l('ONLINE BANKING')?></a>
					<a href="?con=cms&node=tickets"><?=l('TICKETS')?></a>
					<a href="?con=cms&node=partner-solutions"><?=l('PARTNER SOLUTIONS')?></a>
					<a href="?page=contact-us"><?=l('CONTACT US')?></a>
				</div>

			</div><!-- footer -->


			<div class="clear"></div>
		</div> <!-- main-holder -->


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