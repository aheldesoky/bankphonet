<div class="pageheader rad5">
	<h1><?=l('LOGIN')?></h1>
</div>
<br /><br />
<img src="views/assets/images/login-both.png" width="900" height="120" alt="login bankphonet.com & phonetmall.com"/>
<br /><br />


<div class="transfer rad5">

                                        <form action="?page=login&ref=<?=$_GET['ref']?>&esc=<?=$esc?>" method="post" class="bvalidator" autocomplete="off">
					<label for="emailreg"><?=l('EMAIL / PHONE')?>:</label>
					<input type="text" id="emailreg" name="email" value="<?=$_POST['email']?>" class="txtbox" data-bvalidator ="required" />

					<label for="password"><?=l('PASSWORD')?>:</label>
					<input type="password" id="password" name="password" value="" class="txtbox" data-bvalidator ="required,minlength[6]"/>


					<div class="clear"></div>


					<input type="submit" value="<?=l('LOGIN')?>" class="registerbtn"/>

                                        </form>
	<div class="clear"></div>
	<br /><br />
	<a href="?page=forget-password" style="color: #0782C1; font-size: 13px;"><?= l('FORGET YOUR PASSWORD')?></a><br/>
	<a href="?page=register" style="color: #0782C1; font-size: 13px;"><?= l('SIGN UP FOR A NEW ACCOUNT')?></a>
			</div>