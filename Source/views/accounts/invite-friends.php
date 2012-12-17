<div class="pageheader rad5">
	<h1><?=l('INVITE YOUR FRIENDS')?></h1>
</div>

<div class="formcontainter">


					<form action="?page=invite-friends" method="post" class="bvalidator">
                                        <label for="title"><?=l('Mobile')?> 1:</label>
                                        <input type="text" id="mobile" name="friend[]" value="<?= l('Ex: 20111')?>" class="txtbox clearonfocus" data-bvalidator="required,number,mobile" title="<?= l('Ex: 20111')?>"/>

                                        <label for="title"><?=l('Mobile')?> 2:</label>
                                        <input type="text" id="mobile" name="friend[]" value="" class="txtbox clearonfocus" data-bvalidator="number,mobile" title=""/>

                                        <label for="title"><?=l('Mobile')?> 3:</label>
                                        <input type="text" id="mobile" name="friend[]" value="" class="txtbox clearonfocus" data-bvalidator="number,mobile" title=""/>

                                        <label for="title"><?=l('Mobile')?> 4:</label>
                                        <input type="text" id="mobile" name="friend[]" value="" class="txtbox clearonfocus" data-bvalidator="number,mobile" title=""/>

                                        <label for="title"><?=l('Mobile')?> 5:</label>
                                        <input type="text" id="mobile" name="friend[]" value="" class="txtbox clearonfocus" data-bvalidator="number,mobile" title=""/>

                                        <label for="title"><?=l('Mobile')?> 6:</label>
                                        <input type="text" id="mobile" name="friend[]" value="" class="txtbox clearonfocus" data-bvalidator="number,mobile" title=""/>

                                             
                                        
					<div class="clear"></div>


					<input type="submit" value="<?=l('INVITE FRIENDS')?>" class="registerbtn"/>
                                        </form>


			</div>

