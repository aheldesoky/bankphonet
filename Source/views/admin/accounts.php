<?php include 'views/admin/top.php'; ?>

<div class="filtergrid">
    <form action="?con=admin&page=admin-accounts" method="post">
	<label for="emailphone">EMAIL/MOBILE:</label>
	<input type="text" id="emailphone" name="email" value="<?=$_SESSION['account_filter']?>" class="txtbox"/>
	<input type="submit" name="set" value="FILTER" />
	<input type="submit" name="clear" value="CLEAR FILTER" />
    </form>
</div>

<?php if($accounts){ ?>
<table cellpadding="0" cellspacing="0">

	<tr>
		<th><a href="?con=admin&action=set-order&order=id"># <?=($_SESSION['account_dir'] == 'up' && $_SESSION['account_order'] == 'id') ? '&uArr;' : (($_SESSION['account_order'] == 'id') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order&order=firstname">FULL NAME <?=($_SESSION['account_dir'] == 'up' && $_SESSION['account_order'] == 'firstname') ? '&uArr;' : (($_SESSION['account_order'] == 'firstname') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order&order=email">EMAIL<?=($_SESSION['account_dir'] == 'up' && $_SESSION['account_order'] == 'email') ? '&uArr;' : (($_SESSION['account_order'] == 'email') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order&order=mobile">MOBILE <?=($_SESSION['account_dir'] == 'up' && $_SESSION['account_order'] == 'mobile') ? '&uArr;' : (($_SESSION['account_order'] == 'mobile') ? '&dArr;' : '') ?></a></th>
		<th><a href="?con=admin&action=set-order&order=balance">CREDIT <?=($_SESSION['account_dir'] == 'up' && $_SESSION['account_order'] == 'balance') ? '&uArr;' : (($_SESSION['account_order'] == 'balance') ? '&dArr;' : '') ?></a></th>
		<th>EDIT</th>
	</tr>

	<tbody>
            
            <?php foreach($accounts as $account){ ?>
		<tr>
			<td><?=$account['id']?></td>
			<td><?=$account['firstname'].' ' .$account['lastname']?></td>
			<td><?=$account['email']?></td>
			<td><?=$account['mobile']?></td>
			<td><?=$account['balance']?> EGP</td>
			<td>
			<a href="?page=editprofile&id=<?=$account['id']?>" class="taction">EDIT</a>
			</td>
		</tr>

                <?php  } ?>


		


	</tbody>


</table>
            		<?= mypaging ($pages_count, $page_no, 'href="?con=admin&page=admin-accounts&page-no={page}" class="{active}"') ?>

<?php }else{  ?>

There are no accounts
<?php } ?>