
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
					<option value="miss"><?=l('Miss')?></option>
				</select>

				<label for="firstname"><?=l('FIRST NAME')?>:</label>
				<input type="text" id="firstname" name="firstname" value="" class="txtbox" data-bvalidator="required" />


				<label for="lastname"><?=l('LAST NAME')?>:</label>
				<input type="text" id="lastname" name="lastname" value="" class="txtbox" data-bvalidator="required" />


				<label for="country"><?=l('COUNTRY')?>:</label>
				<select id="country_code" class="txtbox" data-bvalidator="required" name="country_code">
					<option value=""><?= l('please choose country') ?></option>
<?= generate_select_options($countries, 'title', 'code') ?>
			</select>
			<label for="emailreg"><?=l('EMAIL')?>:</label>
                        <div id="mailcontainer">
                        </div>
			<label for="mobile"><?=l('MOBILE')?>:</label>
			<input type="text" id="mobile" name="mobile" value="<?= l('Ex: 20111')?>" class="txtbox clearonfocus" data-bvalidator="required,number,mobile" title="<?= l('Ex: 20111')?>"/>


			<label for="password"><?=l('PASSWORD')?>:</label>
			<input type="password" id="password" name="password" value="" class="txtbox" data-bvalidator="required,minlength[6]" />

			<label for="repassword"><?=l('RE-PASSWORD')?>:</label>
			<input type="password" id="repassword" name="repassword" value="" class="txtbox" data-bvalidator="required,minlength[6]" />



			<div class="clear"></div>
			<div style="text-align: center">
			<a href="http://bankphonet.com/?con=cms&node=legal" style="font-size: 10px; color: #555555;">By clicking sign up you read & agree with our legal agreement.</a>
			</div>
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
						<?= l('recharge by depositing  at our bank account or by coupons or accept transfers with no fees.')?>
			<br />
						<?= l('transfer to any member or withdraw at yor bank/ home for 0% ')?>
			<br />
						<?= l('buy online with your credit')?>
		
		</p>

		<a href="?con=cms&node=online-banking" class="moreinfo" title="more info">
			<img src="views/assets/images/<?= l('more-info.png')?>" width="85" height="22" alt="more info"/>
		</a>
	</div>


	<div class="block">

		<h2><?= l('Online payment')?></h2>
		<p>
						<?= l('Buy credits and recharge online')?>
		</p>

		<a href="?con=cms&node=online-payment" class="moreinfo" title="more info" target="_blank">
			<img src="views/assets/images/<?= l('more-info.png')?>" width="85" height="22" alt="more info"/>
		</a>
	</div>


	<div class="block">

		<h2><?= l('Tickets')?></h2>
		<p>
						<?= l('book your flight tickets cheapest fastest to any where in the world ')?>
		</p>

		<a href="http://tickets.bankphonet.com" class="moreinfo" title="more info" target="_blank">
			<img src="views/assets/images/<?= l('more-info.png')?>" width="85" height="22" alt="more info"/>
		</a>
	</div>


	<div class="block">

		<h2><?= l('Partner solution')?></h2>
		<p>
						<?= l('Integrate your website with our gateway and receive payments online instantly.')?>
			<br />
						<?= l('Consume our API to confirm transactions.')?>
			<br />
						<?= l('Accept payments online')?>
			<br />
		</p>
		<a href="#" class="moreinfo" title="more info">
			<img src="views/assets/images/<?= l('more-info.png')?>" width="85" height="22" alt="more info"/>
		</a>

	</div>


</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#mailcontainer').html('<input type="text" id="emailreg" name="email" value="" class="txtbox" data-bvalidator="required,email" />');
});
</script>