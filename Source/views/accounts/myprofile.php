<div class="pageheader rad5">
	<h1><?=l('My profile')?>:</h1>
</div>
<div class="transactionsactions">
	<a href="?page=editprofile" class="button"><?=l('EDIT MY PROFILE')?></a>
	<a href="?page=change-password" class="button"><?=l('CHANGE PASSWORD')?></a>
</div>



<div class="profileviewholder rad5">


	<div class="profile-item">
            <span><?=l('Title')?>:</span> <?=  ucfirst($profile['title'])?>.
	</div>

	<div class="profile-item">
		<span><?=l('First name')?>:</span> <?=  ucfirst($profile['firstname'])?>
	</div>

	<div class="profile-item">
		<span><?=l('Last name')?>:</span> <?=  ucfirst($profile['lastname'])?>
	</div>

	<div class="profile-item">
		<span><?=l('Country')?>:</span> <?= ucfirst($profile['country_title'])?>
	</div>

	<div class="profile-item">
		<span><?=l('EMAIL')?>:</span><?=($profile['email'])?>
	</div>

	<div class="profile-item">
		<span><?=l('Mobile')?>:</span> <?= ($profile['mobile'])?>
	</div>




</div>
<div class="clear"></div>


<br /><br /><br /><br />