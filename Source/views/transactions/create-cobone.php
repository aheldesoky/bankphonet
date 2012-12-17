<div class="pageheader rad5">
	<h1><?=l('CREATE COUPON:')?></h1>
</div>


<div class="transfer">
    <form action="" method="post" class="bvalidator">

	<label for="amount"><?=l('Amount to create coupon with:')?></label>
	<input type="text" id="amount" name="amount" value="<?=$_POST['amount']?>" class="txtbox" data-bvalidator="required,number" />

	<div class="clear"></div>

	<input type="submit" value="<?=l('CREATE NOW')?>" class="btnsubmit"/>
    </form>




</div>