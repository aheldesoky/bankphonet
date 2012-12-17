
<?php include 'views/admin/top.php'; ?>


<div class="filtergrid">
    <form action="?con=admin&page=withdraw-requests" method="post">
	<label for="emailphone">EMAIL/MOBILE:</label>
	<input type="text" id="emailphone" name="email" value="<?=$_SESSION['withdraw_filter']?>" class="txtbox"/>
	<input type="submit" name="set" value="FILTER" />
	<input type="submit" name="clear" value="CLEAR FILTER" />
    </form>
</div>

<?php if($withdraw_requests){ ?>
<table cellpadding="0" cellspacing="0">

	<tr>
		<th><a href="?con=admin&action=set-order-withdraw&order=id"># <?=($_SESSION['withdraw_dir'] == 'up' && $_SESSION['withdraw_order'] == 'id') ? '&uArr;' : (($_SESSION['withdraw_order'] == 'id') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-withdraw&order=firstname">FULL NAME <?=($_SESSION['withdraw_dir'] == 'up' && $_SESSION['withdraw_order'] == 'firstname') ? '&uArr;' : (($_SESSION['withdraw_order'] == 'firstname') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-withdraw&order=email">EMAIL<?=($_SESSION['withdraw_dir'] == 'up' && $_SESSION['withdraw_order'] == 'email') ? '&uArr;' : (($_SESSION['withdraw_order'] == 'email') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-withdraw&order=mobile">MOBILE <?=($_SESSION['withdraw_dir'] == 'up' && $_SESSION['withdraw_order'] == 'mobile') ? '&uArr;' : (($_SESSION['withdraw_order'] == 'mobile') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-withdraw&order=balance">BALANCE <?=($_SESSION['withdraw_dir'] == 'up' && $_SESSION['withdraw_order'] == 'balance') ? '&uArr;' : (($_SESSION['withdraw_order'] == 'balance') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-withdraw&order=method">METHOD <?=($_SESSION['withdraw_dir'] == 'up' && $_SESSION['withdraw_order'] == 'method') ? '&uArr;' : (($_SESSION['withdraw_order'] == 'method') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-withdraw&order=amount">AMOUNT<?=($_SESSION['withdraw_dir'] == 'up' && $_SESSION['withdraw_order'] == 'amount') ? '&uArr;' : (($_SESSION['withdraw_order'] == 'amount') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order-withdraw&order=datetime1">REQUEST DATE<?=($_SESSION['withdraw_dir'] == 'up' && $_SESSION['withdraw_order'] == 'datetime1') ? '&uArr;' : (($_SESSION['withdraw_order'] == 'datetime1') ? '&dArr;' : '') ?></a></th>
		<th>DETAILS</th>
		<th>ACTION</th>

    </tr>

	<tbody>
            
            <?php foreach($withdraw_requests as $withdraw){ ?>
		<tr>
			<td><?=$withdraw['id']?></td>
			<td><?=$withdraw['firstname'].' ' .$withdraw['lastname']?></td>
			<td><?=$withdraw['email']?></td>
			<td><?=$withdraw['mobile']?></td>
			<td><?=$withdraw['balance']?> EGP</td>
			<td><?=$withdraw['method']?></td>
			
			<td><?=$withdraw['amount']?></td>
			<td><?=$withdraw['datetime1']?></td>
                        <td><a href="?con=admin&page=withdrawl-request-details&id=<?=$withdraw['id']?>">Details</a></td>
                        <td>
                         <?php if($withdraw['accepted'] == 0){ ?>
                        <a href="?con=admin&action=accept-withdraw&id=<?=$withdraw['id']?>">ACCEPT</a>
                        <?php }else{ ?>
                        - -
                        <?php } ?>
			</td>
		</tr>

                <?php  } ?>


		


	</tbody>


</table>
            		<?= mypaging ($pages_count, $page_no, 'href="?con=admin&page=withdraw-requests&page-no={page}" class="{active}"') ?>

<?php }else{  ?>

There are no requests
<?php } ?>