<div class="pageheader rad5">
	<h1><?=l('EDIT MY PROFILE')?></h1>
</div>

<div class="transfer rad5">


					<form action="?page=editprofile&id=<?=$id?>" method="post" class="bvalidator">
                                             <label for="title"><?=l('TITLE')?>:</label>
                                        <select id="title" name="title" data-bvalidator="required" class="txtbox">
                                            <option value="mr" <?=($profile['title'] == 'mr') ? 'SELECTED' : '' ?> ><?=l('Mr')?></option>
                                            <option value="mrs" <?=($profile['title'] == 'mrs') ? 'SELECTED' : '' ?> ><?=l('Mrs')?></option>
                                        </select>
                                             
                                        <label for="firstname"><?=l('FIRST NAME')?>:</label>
					<input type="text" id="firstname" name="firstname" value="<?=$profile['firstname']?>" class="txtbox" data-bvalidator="required" />


					<label for="lastname"><?=l('LAST NAME')?>:</label>
					<input type="text" id="lastname" name="lastname" value="<?=$profile['lastname']?>" class="txtbox" data-bvalidator="required" />

                                        <label for="country"><?=l('Country')?></label>
                                        <select id="country_code" class="txtbox" data-bvalidator="required" name="country_code">
                                            <option value=""><?=l('please chose country')?></option>
                                            <?=generate_select_options($countries,'title','code',$profile['country_code'])?>
                                        </select>
                                        
					<label for="emailreg"><?=l('EMAIL')?>:</label>
					<input type="text" id="emailreg" name="email" value="<?=$profile['email']?>" class="txtbox" data-bvalidator="required,email" />

					<label for="mobile"><?=l('MOBILE')?>:</label>
					<input type="text" id="mobile" name="mobile" value="<?=$profile['mobile']?>" class="txtbox" data-bvalidator="required,number" />

                                        <?php if($oUser->admin == 1 && $oUser->id != $profile['id'] ){ ?>
                                        <label for="blocked">BLOCKED:</label>
                                        <select name="blocked" id="blocked" class="txtbox">
                                            <option <?=($profile['blocked'] == 0) ? 'SELECTED' : '' ?> value="0">No</option>
                                            <option <?=($profile['blocked'] == 1) ? 'SELECTED' : '' ?> value="1">Yes</option>
                                        </select>
                                        <?php } ?>

					<div class="clear"></div>


					<input type="submit" value="<?=l('SAVE')?>" class="registerbtn"/>
                                        </form>


			</div>

