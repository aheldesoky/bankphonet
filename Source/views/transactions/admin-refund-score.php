
<h1 class="inh1"><a href="?con=admin">ADMIN HOME </a> >> REFUND SCORE TRANSACTION</h1>


<div class="transfer">
    <form action="?con=admin&page=admin-refund-score&id=<?=$id?>" method="post">
        <label>
            Are you sure that you want to refund this transaction to <?=$transaction['from_firstname'].' ' .$transaction['from_lastname']?> 
            <br/> with amount <?=$transaction['amount']?> Points ,This operation can't be un-done
        </label>

	<div class="clear"></div>
          <input type="hidden" name="id" value="<?=$id?>" />
          <a href="?con=admin&page=admin-transactions-score" class="btnsubmit" style="margin-right:10px;">CANCEL</a>
	<input type="submit" value="REFUND" class="btnsubmit"/>
      
    </form>




</div>