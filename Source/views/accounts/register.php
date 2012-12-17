<div class="pageheader rad5">
	<h1><?=l('SIGN UP FOR A NEW ACCOUNT')?>:</h1>
</div>

<div class="transfer rad5">


					<form action="?page=register" method="post" class="bvalidator">
                                             <label for="title"><?=l('TITLE')?>:</label>
                                        <select id="title" name="title" data-bvalidator="required" class="txtbox">
                                            <option value="mr"><?=l('Mr')?></option>
                                            <option value="mrs"><?=l('Mrs')?></option>
                                        </select>
                                             
                                        <label for="firstname"><?=l('FIRST NAME')?>:</label>
					<input type="text" id="firstname" name="firstname" value="<?=$_POST['firstname']?>" class="txtbox" data-bvalidator="required" />


					<label for="lastname"><?=l('LAST NAME')?>:</label>
					<input type="text" id="lastname" name="lastname" value="<?=$_POST['lastname']?>" class="txtbox" data-bvalidator="required" />

                                        <label for="country"><?=l('Country')?></label>
                                        <select id="country_code" class="txtbox" data-bvalidator="required" name="country_code">
                                            <option value=""><?=l('please chose country')?></option>
                                            <?=generate_select_options($countries,'title','code')?>
                                        </select>
                                        
					<label for="emailreg"><?=l('EMAIL')?>:</label>
                                        
                                        <div id="mailcontainer">
					<input type="text" id="emailreg" name="email" value="<?=$_POST['email']?>" class="txtbox" data-bvalidator="required,email" />
                                        </div>
                                        
					<label for="mobile"><?=l('MOBILE')?>:</label>
					<input type="text" id="mobile" name="mobile" value="<?=$_POST['mobile']?>" class="txtbox" data-bvalidator="required,number" />


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

<script type="text/javascript">
$(document).ready(function(){
    $('#mailcontainer').html('<input type="text" id="emailreg" name="email" value="" class="txtbox" data-bvalidator="required,email" />');
});
</script>