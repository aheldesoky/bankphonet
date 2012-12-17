<div class="pageholder">
	
    <?php if($page){ ?>
        <h1><?=$page['title']?></h1>



		<?php  if ($page['name'] == 'online-banking'){ ?>

		<div class="actionmenu">
			<a href="?page=transactions"><?=l('MY TRANSACTIONS')?></a>
			<a href="?page=transfer"><?=l('NEW TRANSFER')?></a>
			<a href="?page=request-withdraw"><?=l('REQUEST WITHDRAW')?></a>
		</div>

		<?php }elseif($page['name'] == 'partner-solutions'){?>

		<div class="actionmenu">
			<a href="?page=partner-solutions"><?= l('DEVELOPERS')?></a>
		</div>

		<?php } ?>

	<div class="bodytext">
            <?=$page['description']?>
        </div>

	<div class="images">
		<div class="imageholder">
			<img src="uploads/cms/<?=$page['image1']?>" width="175" height="175" alt="cms1"/>
		</div>
		<div class="imageholder">
			<img src="uploads/cms/<?=$page['image2']?>" width="175" height="175" alt="cms1"/>
		</div>
	</div>
        
        <?php }else{ ?>
        <div class="nocontentfound"><?= l('Sorry There are an error'); ?></div>
        <?php } ?>

</div>