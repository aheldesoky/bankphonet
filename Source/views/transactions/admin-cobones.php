<div class="pageheader rad5">
    <h1><?= l('MY COUPONS:') ?></h1>
</div>

<div class="transactionsactions">
    <a href="?page=create-cobone" class="button"><?= l('CREATE NEW COUPON') ?></a>
</div>


<div class="filtergrid tfilter">
    <form action ="?con=admin&page=cobones" method="post">
	<label for="from">COUPON CODE:</label>
	<input type="text" id="from" name="code" value="<?=$_SESSION['code']?>" class="txtbox"/>
	<div class="clear"></div>
	
        <input type="submit" name="set" value="FILTER" />
	<input type="submit" name="reset" value="CLEAR FILTER" />
    </form>
</div>



<?php if ($cobones) { ?>
    <table cellpadding="0" cellspacing="0">

        <tr>
            <th><a href="?con=admin&page=cobones&order=cobone_time&dir=<?= ($dir == 'up') ? 'down' : 'up' ?>"><?= l('DATE') ?> <?= ($order == 'cobone_time' && $dir == 'up') ? '&uArr;' : (($order == 'cobone_time') ? '&dArr;' : '') ?></a></th>
            <th><a href="?con=admin&page=cobones&order=code&dir=<?= ($dir == 'up') ? 'down' : 'up' ?>"><?= l('COUPON CODE') ?> <?= ($order == 'code' && $dir == 'up') ? '&uArr;' : (($order == 'code') ? '&dArr;' : '') ?></a></th>
            <th><a href="?con=admin&page=cobones&order=from_mobile&dir=<?= ($dir == 'up') ? 'down' : 'up' ?>"><?= l('FROM MOBILE') ?><?= ($order == 'from_mobile' && $dir == 'up') ? '&uArr;' : (($order == 'from_mobile') ? '&dArr;' : '') ?></a></th>
            <th><a href="?con=admin&page=cobones&order=to_mobile&dir=<?= ($dir == 'up') ? 'down' : 'up' ?>"><?= l('TO MOBILE') ?><?= ($order == 'to_mobile' && $dir == 'up') ? '&uArr;' : (($order == 'to_mobile') ? '&dArr;' : '') ?></a></th>
            <th><a href="?con=admin&page=cobones&order=amount&dir=<?= ($dir == 'up') ? 'down' : 'up' ?>"><?= l('AMOUNT') ?><?= ($order == 'amount' && $dir == 'up') ? '&uArr;' : (($order == 'amount') ? '&dArr;' : '') ?></a></th>
            <th><a href="?con=admin&page=cobones&order=charger_id&dir=<?= ($dir == 'up') ? 'down' : 'up' ?>"><?= l('STATUS') ?><?= ($order == 'charger_id' && $dir == 'up') ? '&uArr;' : (($order == 'charger_id') ? '&dArr;' : '') ?></a></th>
            <th><?= l('ACTIONS') ?></th>
        </tr>

        <tbody>
            <?php foreach ($cobones as $cobone) { ?>
                <tr>
                    <td><?= date('Y-m-d', $cobone['cobone_time']) ?></td>
                    <td><?= $cobone['code'] ?></td>
                    <td><?= $cobone['from_mobile'] ?> </td>
                    <td><?= ($cobone['to_mobile']) ? $cobone['to_mobile'] : l('Not Charged') ?> </td>
                    <td><?= $cobone['amount'] ?> EGP</td>
                    <td><?= ($cobone['charger_id']) ? l('REDEEMED') : l('ACTIVE') ?></td>
                    <td>
                        <?php if (!$cobone['charger_id']) { ?>
                            <a href="?con=admin&action=delcopone&id=<?= $cobone['id'] ?>&user=<?=$cobone['owner_id']?>" class="taction">Delete</a>
                        <?php } else { ?>
                            -- 
                        <?php } ?>
                    </td>
                </tr>

            <?php } ?>	








        </tbody>


    </table>
    <?= mypaging($pages_count, $page_no, 'href="?con=admin&page=cobones&page-no={page}" class="{active}"') ?>
<?php } else { ?>

    <div class="nocontentfound">
        No coupons found
    </div>
<?php } ?>