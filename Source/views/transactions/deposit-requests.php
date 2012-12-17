
<?php include 'views/admin/top.php'; ?>


<div class="filtergrid">
    <form action="?con=admin&page=deposit-requests" method="post">
	<label for="emailphone">EMAIL/MOBILE:</label>
	<input type="text" id="emailphone" name="email" value="<?=$_SESSION['deposit_filter']?>" class="txtbox"/>
	<input type="submit" name="set" value="FILTER" />
	<input type="submit" name="clear" value="CLEAR FILTER" />
    </form>
</div>

<?php if($deposit_requests){ ?>
<table cellpadding="0" cellspacing="0">

	<tr>
		<th><a href="?con=admin&action=set-order-deposit&order=id"># <?=($_SESSION['deposit_dir'] == 'up' && $_SESSION['deposit_order'] == 'id') ? '&uArr;' : (($_SESSION['deposit_order'] == 'id') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-deposit&order=depositor_name">DEPOSITOR NAME <?=($_SESSION['deposit_dir'] == 'up' && $_SESSION['deposit_order'] == 'depositor_name') ? '&uArr;' : (($_SESSION['deposit_order'] == 'depositor_name') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-deposit&order=email">EMAIL<?=($_SESSION['deposit_dir'] == 'up' && $_SESSION['deposit_order'] == 'email') ? '&uArr;' : (($_SESSION['deposit_order'] == 'email') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-deposit&order=tel">TELEPHONE <?=($_SESSION['deposit_dir'] == 'up' && $_SESSION['deposit_order'] == 'tel') ? '&uArr;' : (($_SESSION['deposit_order'] == 'tel') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-deposit&order=balance">BALANCE <?=($_SESSION['deposit_dir'] == 'up' && $_SESSION['deposit_order'] == 'balance') ? '&uArr;' : (($_SESSION['deposit_order'] == 'balance') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-deposit&order=deposit_date">DEPOSIT DATE <?=($_SESSION['deposit_dir'] == 'up' && $_SESSION['deposit_order'] == 'deposit_date') ? '&uArr;' : (($_SESSION['deposit_order'] == 'deposit_date') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-deposit&order=amount">AMOUNT<?=($_SESSION['deposit_dir'] == 'up' && $_SESSION['deposit_order'] == 'amount') ? '&uArr;' : (($_SESSION['deposit_order'] == 'amount') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-deposit&order=bank">BANK/BRANCH<?=($_SESSION['deposit_dir'] == 'up' && $_SESSION['deposit_order'] == 'bank') ? '&uArr;' : (($_SESSION['deposit_order'] == 'bank') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-deposit&order=deposit_time">REQUEST DATE<?=($_SESSION['deposit_dir'] == 'up' && $_SESSION['deposit_order'] == 'deposit_time') ? '&uArr;' : (($_SESSION['deposit_order'] == 'deposit_time') ? '&dArr;' : '') ?></a></th>
		<th>IMAGE</th>
		

    </tr>

	<tbody>
            
            <?php foreach($deposit_requests as $deposit){ ?>
		<tr>
			<td><?=$deposit['id']?></td>
			<td><?=$deposit['depositor_name']?></td>
			<td><?=$deposit['email']?></td>
			<td><?=$deposit['tel']?></td>
			<td><?=$deposit['balance']?> EGP</td>
			<td><?=$deposit['deposit_date']?></td>
			
			<td><?=$deposit['amount']?></td>
			<td><?=$deposit['bank']?></td>
			<td><?=date('Y-m-d',$deposit['deposit_time'])?></td>
                       
                        <td>
                             <?php if($deposit['image']){ ?>
                            <a href="uploads/<?=$deposit['image']?>" target="_blank">Image</a>
                            <?php }else{ ?>
                            --
                            <?php } ?>
                        </td>
                        
		</tr>

                <?php  } ?>


		


	</tbody>


</table>
            		<?= mypaging ($pages_count, $page_no, 'href="?con=admin&page=deposit-requests&page-no={page}" class="{active}"') ?>

<?php }else{  ?>

There are no requests
<?php } ?>