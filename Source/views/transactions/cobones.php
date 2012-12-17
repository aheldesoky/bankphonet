<div class="pageheader rad5">
	<h1><?=l('MY COUPONS:')?></h1>
</div>

<div class="transactionsactions">
	<a href="?page=create-cobone" class="button"><?=l('CREATE NEW COUPONE')?></a>
</div>

<?php if ($cobones){ ?>
<table cellpadding="0" cellspacing="0">

	<tr>
		<th><a href="?page=cobones&order=cobone_time&dir=<?=($dir == 'up') ? 'down' : 'up' ?>"><?=l('DATE')?> <?= ($order == 'cobone_time' && $dir == 'up') ? '&uArr;' : (($order == 'cobone_time') ? '&dArr;' : '')  ?></a></th>
		<th><a href="?page=cobones&order=code&dir=<?=($dir == 'up') ? 'down' : 'up' ?>"><?=l('COUPONE CODE')?> <?= ($order == 'code' && $dir == 'up') ? '&uArr;' : (($order == 'code') ? '&dArr;' : '')  ?></a></th>
		<th><a href="?page=cobones&order=amount&dir=<?=($dir == 'up') ? 'down' : 'up' ?>"><?=l('AMOUNT')?><?= ($order == 'amount' && $dir == 'up') ? '&uArr;' : (($order == 'amount') ? '&dArr;' : '')  ?></a></th>
		<th><a href="?page=cobones&order=charger_id&dir=<?=($dir == 'up') ? 'down' : 'up' ?>"><?=l('STATUS')?><?= ($order == 'charger_id' && $dir == 'up') ? '&uArr;' : (($order == 'charger_id') ? '&dArr;' : '')  ?></a></th>
		<th><?=l('ACTIONS')?></th>
	</tr>

	<tbody>
            <?php foreach($cobones as $cobone){ ?>
		<tr>
			<td><?=date('Y-m-d',$cobone['cobone_time'])?></td>
			<td><?=$cobone['code']?></td>
			<td><?=$cobone['amount']?> EGP</td>
			<td><?=($cobone['charger_id']) ?  l('REDEEMED') : l('ACTIVE') ?></td>
			<td>
                            <?php if(!$cobone['charger_id']){ ?>
                            <a href="?action=delcopone&id=<?=$cobone['id']?>" class="taction"><?= l('Delete')?></a>
                            <?php }else{ ?>
                             -- 
                            <?php } ?>
                        </td>
		</tr>
                
		<?php } ?>	

		






	</tbody>


</table>
<?=		mypaging ($pages_count, $page_no, 'href="?page=cobones&page-no={page}" class="{active}"'); ?>

<?php }else{ ?>

		<div class="nocontentfound">
			You didn't create any cobones yet
		</div>


<?php } ?>