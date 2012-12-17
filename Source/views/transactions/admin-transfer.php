
<?php include 'views/admin/top.php'; ?>





<div class="transfer">
    <form action="?con=admin&page=admin-transfer" method="post" class="bvalidator">
	<label for="accountnumber">From Account Mobile number or Email:</label>
	<input type="text" id="accountnumber" name="mobilefrom" value="<?=$_POST['mobilefrom']?>" class="txtbox" data-bvalidator="required" />
	
        <label for="accountnumber">To Account Mobile number or Email:</label>
	<input type="text" id="accountnumber" name="mobileto" value="<?=$_POST['mobileto']?>" class="txtbox" data-bvalidator="required" />

	<label for="amount">Amount to be transfered:</label>
	<input type="text" id="amount" name="amount" value="" class="txtbox" data-bvalidator="required,number" />

	<div class="clear"></div>

	<input type="submit" value="WITHDRAW NOW" class="btnsubmit"/>
    </form>




</div>