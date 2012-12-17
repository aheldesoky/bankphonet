<div class="pageheader rad5">
	<h1><?=l('TRANSFER TO ACCOUNT:')?></h1>
</div>


<div class="transfer">
    <form action="?page=transfer" method="post" class="bvalidator">
    <label for="transfertype" style="width: 150px"><?=l('Type of Transfer')?>:</label>
	<select id="transfertype" name="transfertype" data-bvalidator="required" class="txtbox">
		<option value="credit" selected><?=l('Credit')?></option>
		<option value="points"><?=l('Points')?></option>
	</select>
	<label for="accountnumber"><?=l('Account Mobile number or Email')?>:</label>
	<input type="text" id="accountnumber" name="mobile" value="<?=$_POST['mobile']?>" class="txtbox" data-bvalidator="required" />

	<label for="amount"><?=l('Amount to be transfered')?>:</label>
	<input type="text" id="amount" name="amount" value="" class="txtbox" data-bvalidator="required,number" />

	<div class="clear"></div>

	<input type="submit" value="<?=l('TRANSFER NOW')?>" class="btnsubmit"/>
    </form>




</div>