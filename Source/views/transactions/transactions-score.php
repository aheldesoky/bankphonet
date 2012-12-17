<div class="pageheader rad5">
	<h1><?=l('MY TRANSACTIONS:')?></h1>
</div>

<div class="transactionsactions">
	<a href="?page=transfer" class="button"><?=l('NEW TRANSFER')?></a>
</div>
<div class="filtergrid tfilter">
	<label for="transactiontype" style="width: 150px">TYPE OF TRANSACTION:</label>
	<select id="transactiontype" name="transactiontype" data-bvalidator="required" class="txtbox">
		<option value="credit">Credit</option>
		<option value="points" selected>Points</option>
	</select>
</div>
<?php if ($transactions){ ?>
<table cellpadding="0" cellspacing="0">

	<tr>
		<th><a href="?page=transactions&order=datetime1&dir=<?=($dir == 'up') ? 'down' : 'up' ?>"><?=l('DATE')?> <?= ($order == 'datetime1' && $dir == 'up') ? '&uArr;' : (($order == 'datetime1') ? '&dArr;' : '')  ?></a></th>
		<th><a href="?page=transactions&order=id&dir=<?=($dir == 'up') ? 'down' : 'up' ?>"><?=l('TRANSACTION')?>  <?= ($order == 'id' && $dir == 'up') ? '&uArr;' : (($order == 'id') ? '&dArr;' : '')  ?></a></th>
		<th><a href="?page=transactions&order=from_firstname&dir=<?=($dir == 'up') ? 'down' : 'up' ?>"><?=l('FROM/TO')?> <?= ($order == 'from_firstname' && $dir == 'up') ? '&uArr;' : (($order == 'from_firstname') ? '&dArr;' : '')  ?></a></th>
		<th><a href="?page=transactions&order=amount&dir=<?=($dir == 'up') ? 'down' : 'up' ?>"><?=l('AMOUNT')?> <?= ($order == 'amount' && $dir == 'up') ? '&uArr;' : (($order == 'amount') ? '&dArr;' : '')  ?></a></th>
		<th><a href="?page=transactions&order=type&dir=<?=($dir == 'up') ? 'down' : 'up' ?>"><?=l('TYPE')?> <?= ($order == 'type' && $dir == 'up') ? '&uArr;' : (($order == 'type') ? '&dArr;' : '')  ?></a></th>
		<th><a href=""><?=l('ACTIONS')?></a></th>
	</tr>

	<tbody>

                <?php  foreach($transactions as $rec){ ?>
		<tr>
			<td><?=$rec['datetime1']?></td>
			<td><?=$rec['id']?></td>
			<td><?=($oUser->id == $rec['from_id']) ? $rec['to_firstname'].' '.$rec['to_lastname'] : $rec['from_firstname'].' '.$rec['from_lastname'] ?></td>
			<td><?=$rec['amount']?> <?=l('Points')?></td>
			<td><?=l($rec['type'])?></td>
			<td>
			<?php 
                            if($rec['type'] == 'in') {
                                if($rec['total_shipping'] == 0){?>
                                    
                            <a href="?page=refund&id=<?=$rec['id']?>" class="taction"><?=l('REFUND')?></a>
                            
                            
                            <?php }else{ echo l('Frozen');}}else{ ?>
                            --
                            <?php } ?>
                        </td>
		</tr>
                <?php } ?>
                
		<tr>
			







	</tbody>


</table>
            		<?= mypaging ($pages_count, $page_no, 'href="?page=transactions&page-no={page}" class="{active}"') ?>
<?php } else { ?>

		<div class="nocontentfound">
			There are no transaction done yet from or to your account
		</div>
<?php } ?>
