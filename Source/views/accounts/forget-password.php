<div class="pageheader rad5">
	<h1><?=l('FORGET PASSWORD')?></h1>
</div>


<div class="transfer rad5">

                                        <form action="?page=forget-password" method="post" class="bvalidator">
					<label for="emailreg"><?=l('EMAIL / PHONE')?>:</label>
					<input type="text" id="emailreg" name="email" value="<?=$_POST['email']?>" class="txtbox" data-bvalidator ="required" />

					

					<div class="clear"></div>


					<input type="submit" value="<?=l('RETRIVE PASSWORD')?>" class="registerbtn"/>

                                        </form>
	<div class="clear"></div>
	<br /><br />
	<a href="?page=register" style="color: #0782C1; font-size: 13px;"><?= l('SIGN UP FOR A NEW ACCOUNT:')?></a>
			</div>