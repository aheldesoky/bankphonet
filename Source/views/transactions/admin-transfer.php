
<?php include 'views/admin/top.php'; ?>





<div class="transfer">
    <form action="?con=admin&page=admin-transfer" method="post" class="bvalidator">
    <label for="transfertype" style="width: 150px">Type of Transfer:</label>
	<select id="transfertype" name="transfertype" data-bvalidator="required" class="txtbox">
		<option value="credit" selected>Credit</option>
		<option value="score">Score</option>
	</select>
	<label for="accountnumber">From Account Mobile number or Email:</label>
	<input type="text" id="accountnumber" name="mobilefrom" value="<?=$_POST['mobilefrom']?>" class="txtbox" data-bvalidator="required" />
	
    <label for="accountnumber">To Account Mobile number or Email:</label>
	<input type="text" id="accountnumber" name="mobileto" value="<?=$_POST['mobileto']?>" class="txtbox" data-bvalidator="required" />

	<label for="amount">Amount to be transfered:</label>
	<input type="text" id="amount" name="amount" value="" class="txtbox" data-bvalidator="required,number" />

	<div class="clear"></div>

	<input type="submit" value="<?=l('TRANSFER NOW')?>" class="btnsubmit"/>
    </form>




</div>