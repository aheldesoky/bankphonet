<label style="width: 150px"><?=l('Title')?>:</label>
<span><?=$user_info['title']?></span>
<label style="width: 150px"><?=l('First Name')?>:</label>
<span><?=$user_info['firstname']?></span>
<label style="width: 150px"><?=l('Last Name')?>:</label>
<span><?=$user_info['lastname']?></span>
<label style="width: 150px"><?=l('Email')?>:</label>
<span><?=$user_info['email']?></span>
<label style="width: 150px"><?=l('Mobile')?>:</label>
<span><?=$user_info['mobile']?></span>
<label style="width: 150px"><?=l('Country')?>:</label>
<span><?=$user_info['country_code']?></span>
<label style="width: 150px"><?=l('PIN Code')?>:</label>
<span><?=$_POST['pin']?></span>
<input type="submit" id="btnverify" name="btnverify" value="<?=l('VERIFY')?>" class="btnsubmit"/>	
