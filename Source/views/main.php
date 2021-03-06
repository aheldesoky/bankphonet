
<div class="homepage-splash">

	<?php if (!$oUser->id) {
 ?>
		<div class="signup">

			<div class="signup-header">
							<?=l('SIGN UP FOR A FREE ACCOUNT')?>
			</div>
			<form action="?page=register" method="post" class="bvalidator">

				<label for="title"><?=l('TITLE')?>:</label>
				<select id="title" name="title" data-bvalidator="required" class="txtbox">
					<option value="mr"><?=l('Mr')?></option>
					<option value="mrs"><?=l('Mrs')?></option>
				</select>

				<label for="firstname"><?=l('FIRST NAME')?>:</label>
				<input type="text" id="firstname" name="firstname" value="" class="txtbox" data-bvalidator="required" />


				<label for="lastname"><?=l('LAST NAME')?>:</label>
				<input type="text" id="lastname" name="lastname" value="" class="txtbox" data-bvalidator="required" />


				<label for="country"><?=l('COUNTRY')?>:</label>
				<select id="country_code" class="txtbox" data-bvalidator="required" name="country_code">
					<option value=""><?= l('please chose country') ?></option>
<?= generate_select_options($countries, 'title', 'code') ?>
			</select>
			<label for="emailreg"><?=l('EMAIL')?>:</label>
			<input type="text" id="emailreg" name="email" value="" class="txtbox" data-bvalidator="required,email" />

			<label for="mobile"><?=l('MOBILE')?>:</label>
			<input type="text" id="mobile" name="mobile" value="<?= l('Ex: 20111')?>" class="txtbox clearonfocus" data-bvalidator="required,number" title="<?= l('Ex: 20111')?>"/>


			<label for="password"><?=l('PASSWORD')?>:</label>
			<input type="password" id="password" name="password" value="" class="txtbox" data-bvalidator="required,minlength[6]" />

			<label for="repassword"><?=l('RE-PASSWORD')?>:</label>
			<input type="password" id="repassword" name="repassword" value="" class="txtbox" data-bvalidator="required,minlength[6]" />



			<div class="clear"></div>


			<input type="submit" value="<?=l('SIGN UP')?>" class="registerbtn"/>

		</form>


	</div>
<?php } else { ?>

		<div class="signup">

		</div>
<?php } ?>

	<div class="slider">


		<img src="views/assets/images/<?= l('splash.png')?>" width="629" height="433" alt="first buyable credit online in egypt."/>


	</div>


</div> <!-- homepage-splash -->





<div class="homepage-textblocks">


	<div class="block">

		<h2><?= l('Online banking')?></h2>
		<p>
						<?= l('Deposit from ATM or online or by coupons. Deposit 100 get 100, Buy 100 for 100.')?>
			<br />
						<?= l('Transfer credit for cash or vice versa.')?>
			<br />
						<?= l('Withdraw at your loacl bank account in 72 hours. Withdraw 100 for 99.')?>
			<br />
						<?= l('Transfer to any one all free.')?>
			<br />
						<?= l('Generate coupons including any amount you choose freely.')?>
		</p>

		<a href="#" class="moreinfo" title="more info">
			<img src="views/assets/images/<?= l('more-info.png')?>" width="85" height="22" alt="more info"/>
		</a>
	</div>


	<div class="block">

		<h2><?= l('Online payment')?></h2>
		<p>
						<?= l('Recharge your phone online, pay all your bills online.')?>
			<br />
						<?= l('Subscribe to internet online add your advertising to papers,tv, websites online.')?>
		</p>

		<a href="#" class="moreinfo" title="more info">
			<img src="views/assets/images/<?= l('more-info.png')?>" width="85" height="22" alt="more info"/>
		</a>
	</div>


	<div class="block">

		<h2><?= l('Tickets')?></h2>
		<p>
						<?= l('Your flight tickets, your hotel tickets, your cinema tickets, your limo etc...')?>
		</p>

		<a href="#" class="moreinfo" title="more info">
			<img src="views/assets/images/<?= l('more-info.png')?>" width="85" height="22" alt="more info"/>
		</a>
	</div>


	<div class="block">

		<h2><?= l('Partner solution')?></h2>
		<p>
						<?= l('Integrate your website with our gateway and receive payments online instantly.')?>
			<br />
						<?= l('Consumer our API to confirm transactions.')?>
			<br />
						<?= l('Accept payments online')?>
			<br />
		</p>
		<a href="#" class="moreinfo" title="more info">
			<img src="views/assets/images/<?= l('more-info.png')?>" width="85" height="22" alt="more info"/>
		</a>

	</div>


</div>
