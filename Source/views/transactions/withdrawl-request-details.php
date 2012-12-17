<h1 class="inh1">USER DATA:</h1>






<div class="profileviewholder">


    <div class="profile-item">
        <span>Title:</span> <?= ucfirst($withdraw['title']) ?>.
    </div>

    <div class="profile-item">
        <span>First name:</span> <?= ucfirst($withdraw['firstname']) ?>
    </div>

    <div class="profile-item">
        <span>Last name:</span> <?= ucfirst($withdraw['lastname']) ?>
    </div>

    <div class="profile-item">
        <span>Country:</span> <?= ucfirst($withdraw['profile_country']) ?>
    </div>

    <div class="profile-item">
        <span>EMAIL:</span><?= ($withdraw['email']) ?>
    </div>

    <div class="profile-item">
        <span>Mobile:</span> <?= ($withdraw['acc_mobile']) ?>
    </div>




</div>
<div class="clear"></div>

<h1 class="inh1">REQUEST DATA:</h1>
<div class="profileviewholder">


    <div class="profile-item">
        <span>METHOD</span> <?= $withdraw['method'] ?>
    </div>

    
    <?php if($withdraw['method'] == 'check'){ ?>
     <div class="profile-item">
        <span>NAME:</span> <?= $withdraw['name'] ?>
    </div>

    <div class="profile-item">
        <span>ADDRESS:</span> <?= $withdraw['address'] ?>
    </div>
    
    <div class="profile-item">
        <span>MOBILE:</span> <?= $withdraw['mobile'] ?>
    </div>
    
    <div class="profile-item">
        <span>PO.Box:</span> <?= $withdraw['po_box'] ?>
    </div>
    
    <?php } ?>
    
    
    <?php if($withdraw['method'] == 'bank'){ ?>
    <div class="profile-item">
        <span>BANK NAME:</span> <?= $withdraw['bank_title'] ?>
    </div>

    <div class="profile-item">
        <span>COUNTRY:</span> <?= $withdraw['request_country'] ?>
    </div>

    <div class="profile-item">
        <span>ACCOUNT NUMBER:</span> <?= $withdraw['bank_account'] ?>
    </div>

    <div class="profile-item">
        <span>ACCOUNT OWNER:</span> <?= $withdraw['account_ownername'] ?>
    </div>
    
    <div class="profile-item">
        <span>SWIFT CODE:</span> <?= $withdraw['swift_code'] ?>
    </div>
    <?php } ?>
    <?php if($withdraw['method'] == 'post_office' || $withdraw['method'] == 'western_union'){ ?>
    <div class="profile-item">
        <span>NAME:</span> <?= $withdraw['name'] ?>
    </div>

    <div class="profile-item">
        <span>ADDRESS:</span> <?= $withdraw['address'] ?>
    </div>
    <?php } ?>
    <?php if($withdraw['method'] == 'western_union'){ ?>
    <div class="profile-item">
        <span>MOBILE:</span> <?= $withdraw['mobile'] ?>
    </div>
    <?php } ?>
    
    
    <?php if($withdraw['method'] == 'post_office'){ ?>
    <div class="profile-item">
        <span>POST OFFICE:</span> <?= $withdraw['postoffice'] ?>
    </div>
    <?php } ?>
    
    
    <div class="profile-item">
        <span>AMOUNT :</span> <?= $withdraw['amount'] ?>
    </div>
    
    <div class="profile-item">
        <span>DATE:</span> <?= $withdraw['datetime1'] ?>
    </div>
    
    <?php if($withdraw['accepted'] == 0){ ?>
    <div>
        <a href="?con=admin&page=admin-refund&id=<?=$withdraw['transaction_id']?>" class="btnsubmit" style="margin-right:10px;">REFUND</a>
    </div>
    <?php } ?>
</div>
<div class="clear"></div>
<br /><br /><br /><br />