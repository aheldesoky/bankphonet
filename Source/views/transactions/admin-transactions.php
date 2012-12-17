<?php include 'views/admin/top.php'; ?>



<div class="filtergrid tfilter">
    <form action ="?con=admin&page=admin-transactions" method="post">
	<label for="from">FROM:</label>
	<input type="text" id="from" name="from" value="<?=$_SESSION['transaction_from']?>" class="txtbox"/>
	<div class="clear"></div>
	<label for="to">TO:</label>
	<input type="text" id="to" name="to" value="<?= $_SESSION['transaction_to']?>" class="txtbox"/>
	<div class="clear"></div>
	<label for="tid">TRANSACTION ID:</label>
	<input type="text" id="tid" name="tid" value="<?= $_SESSION['transaction_id']?>" class="txtbox"/>
	<div class="clear"></div> <br /> 
	<input type="submit" name="set" value="FILTER" />
	<input type="submit" name="reset" value="CLEAR FILTER" />
    </form>
</div>

<?php if($transactions){ ?>
<table cellpadding="0" cellspacing="0">

	<tr>
		
                <th><a href="?con=admin&action=set-torder&order=datetime1">DATE # <?=($_SESSION['transaction_dir'] == 'up' && $_SESSION['transaction_order'] == 'datetime1') ? '&uArr;' : (($_SESSION['transaction_order'] == 'datetime1') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-torder&order=id">TRANSACTION ID <?=($_SESSION['transaction_dir'] == 'up' && $_SESSION['transaction_order'] == 'id') ? '&uArr;' : (($_SESSION['transaction_order'] == 'id') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-torder&order=from_email">FROM<?=($_SESSION['transaction_dir'] == 'up' && $_SESSION['transaction_order'] == 'from_email') ? '&uArr;' : (($_SESSION['transaction_order'] == 'from_email') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-torder&order=to_email">TO <?=($_SESSION['transaction_dir'] == 'up' && $_SESSION['transaction_order'] == 'to_email') ? '&uArr;' : (($_SESSION['transaction_order'] == 'to_email') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-torder&order=amount">AMOUNT <?=($_SESSION['transaction_dir'] == 'up' && $_SESSION['transaction_order'] == 'amount') ? '&uArr;' : (($_SESSION['transaction_order'] == 'amount') ? '&dArr;' : '') ?></a></th>
		<th>ACTION</th>
	</tr>

	<tbody>
                <?php foreach($transactions as $transaction){ ?>
		<tr>
			<td><?=$transaction['datetime1']?></td>
			<td><?=$transaction['id']?></td>
			<td><?=$transaction['from_email']?></td>
			<td><?=$transaction['to_email']?></td>
			<td><?=$transaction['amount']?> EGP</td>
			<td>
                            <?php if($transaction['type'] == 'out') { ?>
				<a href="?con=admin&page=admin-refund&id=<?=$transaction['id']?>" class="taction">REFUND</a>
                            <?php }else{ ?>
                                <?=$transaction['type']?>
                            <?php } ?>
                        </td>
		</tr>
                <?php } ?>

		



	</tbody>


</table>
<?= mypaging ($pages_count, $page_no, 'href="?con=admin&page=admin-transactions&page-no={page}" class="{active}"') ?>
<?php }else{ ?>

There are no transactions yet

<?php } ?>
