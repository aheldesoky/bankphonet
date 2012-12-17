
<?php include 'views/admin/top.php'; ?>




<div class="transfer">
    <form action="?con=admin&page=deposit" method="post" class="bvalidator">
	<label for="accountnumber">Account Mobile number or Email:</label>
	<input type="text" id="accountnumber" name="mobile" value="<?=$_POST['mobile']?>" class="txtbox" data-bvalidator="required" />

	<label for="amount">Amount to be added to account:</label>
	<input type="text" id="amount" name="amount" value="" class="txtbox" data-bvalidator="required,number" />

	<div class="clear"></div>

	<input type="submit" value="WITHDRAW NOW" class="btnsubmit"/>
    </form>




</div>