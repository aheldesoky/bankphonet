
<?php include 'views/admin/top.php'; ?>


<div class="filtergrid">
    <form action="?con=admin" method="get">
        <input type="hidden" name="con" value="admin" />
        <input type="hidden" name="page" value="mobile-charge" />
        
	<label for="emailphone">EMAIL/MOBILE:</label>
	<input type="text" id="emailphone" name="keyword" value="<?=$_GET['keyword']?>" class="txtbox"/>
	<input type="submit"  value="FILTER" />
    </form>
</div>

<?php if($requests){ ?>
<table cellpadding="0" cellspacing="0">

	<tr>
		<th># </th>
		<th>FULL NAME </th>
		<th>EMAIL</th>
		<th>MOBILE </th>
		<th>CARD NUMBER </th>
		<th>BALANCE </th>
		
		<th>AMOUNT</th>
		<th>REQUEST DATE</th>
		
		<th>ACTION</th>

    </tr>

	<tbody>
            
            <?php foreach($requests as $request){ ?>
		<tr>
			<td><?=$request['id']?></td>
			<td><?=$request['firstname'].' ' .$request['lastname']?></td>
			<td><?=$request['email']?></td>
			<td><?=$request['mobile']?></td>
			<td><?=$request['card_number']?></td>
			<td><?=$request['balance']?> EGP</td>
			
			
			<td><?=$request['amount']?></td>
			<td><?=$request['datetime1']?></td>
                       
                        <td>
                         <?php if($request['accepted'] == 0){ ?>
                        <a href="?con=admin&action=accept-mobile&id=<?=$request['id']?>">ACCEPT</a> - 
                        <a href="?con=admin&action=accept-mobile&id=<?=$request['id']?>&reject=1">REJECT</a>
                        <?php }elseif($request['accepted'] == 1){ ?>
                        - -
                        <?php }else{ ?>
                        Rejected
                        <?php } ?>
			</td>
		</tr>

                <?php  } ?>


		


	</tbody>


</table>
            		<?= mypaging ($pages_count, $page_no, 'href=?'.extractUrl($_GET).'&page-no={page} class="{active}"') ?>

<?php }else{  ?>

There are no requests
<?php } ?>