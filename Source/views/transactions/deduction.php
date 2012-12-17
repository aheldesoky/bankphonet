<div class="pageheader rad5">
	<h1><?=l('DEDUCT FROM ACCOUNT:')?></h1>
</div>


<div class="transfer">
	<div class="deduction-form">
	    <form action="?page=transfer" method="post" class="bvalidator">
	    <label for="deductiontype" style="width: 150px"><?=l('Type of Deduction')?>:</label>
		<select id="deductiontype" name="deductiontype" data-bvalidator="required" class="txtbox">
			<option value="credit" selected><?=l('Credit')?></option>
			<option value="points"><?=l('Points')?></option>
		</select>
		<label for="accountnumber"><?=l('Account Mobile number or Email')?>:</label>
		<input type="text" id="accountnumber" name="mobile" value="<?=$_POST['mobile']?>" class="txtbox" data-bvalidator="required" />
	
		<label for="amount"><?=l('Amount to be transfered')?>:</label>
		<input type="text" id="amount" name="amount" value="" class="txtbox" data-bvalidator="required,number" />
		
		<label for="pin"><?=l('PIN Code')?>:</label>
		<input type="text" id="pin" name="pin" value="" class="txtbox" data-bvalidator="required,number" />
	
		<div class="clear"></div>
		
		<input type="button" id="btndeduct" name="btndeduct" value="<?=l('DEDUCT NOW')?>" class="btnsubmit"/>
		
	    </form>
	</div>
	<div class="verification-info"></div>

</div>