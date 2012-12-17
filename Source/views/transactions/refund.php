
<h1 class="inh1"><?=l('REFUND TRANSACTION')?></h1>


<div class="transfer">
    <form action="?page=refund&id=<?=$id?>" method="post">
        <label>
            <?=l('Are you sure that you want to refund this transaction from')?> <?=$transaction['from_firstname'].' ' .$transaction['from_lastname']?> 
            <br/> <?=l('with amount')?> <?=$transaction['amount']?> <?=l('EGP ,This operation can not be un-done')?>
        </label>

	<div class="clear"></div>
           <input type="hidden" name="id" value="<?=$id?>" />
          <a href="?page=transactions" class="btnsubmit" style="margin-right:10px;"><?=l('CANCEL')?></a>
	<input type="submit" value="<?=l('REFUND')?>" class="btnsubmit"/>
      
    </form>




</div>