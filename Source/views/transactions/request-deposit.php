<div class="pageheader rad5">
    <h1><?= l('Request deposit:') ?></h1>
</div>
<div class="transfer rad5">
    <form action="?page=request-deposit" method="post" class="bvalidator" enctype="multipart/form-data">

        <label for="accountownername"><?= l('Depositor name') ?>:</label>
        <input type="text" id="accountownername" name="depositor_name" value="<?= $_POST['depositor_name'] ?>" class="txtbox" data-bvalidator="required" />


        <label for="amount"><?= l('Amount') ?>:</label>
        <input type="text" id="amount" name="amount" value="<?= $_POST['amount'] ?>" class="txtbox" data-bvalidator="required" />
       
        <label for="bank"><?= l('Bank/Branch') ?>:</label>
        <input type="text" id="bank" name="bank" value="<?= $_POST['bank'] ?>" class="txtbox" data-bvalidator="required" />


        <label for="date"><?= l('Date') ?>:</label>
        <input type="text" id="date" name="deposit_date" value="<?= $_POST['deposit_date'] ?>" class="txtbox" data-bvalidator="required" />



        <label for="tel"><?= l('Telephone ') ?>:</label>
        <input type="text" id="address" name="tel" value="<?= $_POST['tel'] ?>" class="txtbox" data-bvalidator="required" />




        <label for="file"><?= l('Image of deposit slip ') ?>:</label>
        <input type="file" name="file" class="txtbox"  data-bvalidator="required" />
        <div class="clear"></div>

        <input type="submit" value="<?= l('REQUEST NOW') ?>" class="btnsubmit"/>
    </form>




</div>