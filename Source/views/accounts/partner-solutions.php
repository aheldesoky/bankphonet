<div class="pageheader rad5">
	<h1><?=l('Developers & API keys')?>:</h1>
</div>


<div class="profileviewholder rad5" style="margin-top: 20px;">


	<div class="profile-item">
		<span><?=l('Public key')?>:</span> <?=$oUser->generate_public_key($oUser->id);?>
	</div>


	<div class="profile-item">
		<span><?=l('Private key')?>:</span> <?=$oUser->generate_private_key($oUser->id)?>
		<div class="clear"></div>
		<span class="warning" style="width: 300px; margin: 10px;"><?=l('Do not share this key with anyone')?>.</span>
	</div>

	<div class="profile-item">


		<p>

		Information and manual for developers will go here
		</p>


	</div>

</div>
<div class="clear"></div>
<br /><br /><br /><br />