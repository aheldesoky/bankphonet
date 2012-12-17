<div class="pageheader rad5">
	<h1><?=l('CHANGE PASSWORD')?></h1>
</div>


<div class="transfer rad5">

                                        <form action="?page=change-password" method="post" class="bvalidator">
					<label for="emailreg"><?=l('Old Password')?>:</label>
					<input type="text" id="emailreg" name="oldpassword" value="" class="txtbox" data-bvalidator ="required,minlength[6]" />

					<label for="password"><?=l('New PASSWORD')?>:</label>
					<input type="password" id="password" name="password" value="" class="txtbox" data-bvalidator ="required,minlength[6]"/>

                                        <label for="password"><?=l('RE-PASSWORD')?>:</label>
					<input type="password" id="password" name="repassword" value="" class="txtbox" data-bvalidator ="required,minlength[6]"/>
                                        
					<div class="clear"></div>


					<input type="submit" value="<?=l('CHANGE PASSWORD')?>" class="registerbtn"/>

                                        </form>
	<div class="clear"></div>
			</div>