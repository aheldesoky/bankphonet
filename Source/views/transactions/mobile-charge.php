<div class="pageheader rad5">
	<h1><?=l('CHARGE VIA MOBILE:')?></h1>
</div>


<div class="transfer">
    <form action="" method="post" class="bvalidator">

	<label for="amount"><?=l('Amount to charge with:')?></label>
	<input type="text" id="amount" name="amount" value="<?=$_POST['amount']?>" class="txtbox" data-bvalidator="required,number" />
	
        
        <label for="card_number"><?=l('Card number:')?></label>
	<input type="text" id="card_number" name="card_number" value="<?=$_POST['card_number']?>" class="txtbox" data-bvalidator="required,number" />

        
        <label for="service_provider"><?=l('Service provider');?></label>
        <select id="service_provider" name="service_provider" class="txtbox" data-bvalidator="required">
            <option value=""><?= l('Choose provider')?></option>
            <?=getProvider ($_POST['operator']);?>
        </select>
        
        
        
	<div class="clear"></div>

	<input type="submit" value="<?=l('CREATE NOW')?>" class="btnsubmit"/>
    </form>




</div>