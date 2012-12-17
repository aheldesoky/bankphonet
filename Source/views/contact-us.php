
				<div class="pageheader rad5">
	<h1><?=l('CONTACT US')?> :</h1>
</div>
<div class="formcontainter">



					<form action="?page=contact-us" method="post" class="bvalidator">
                                        <label for="title"><?=l('Full name:')?></label>
                                        <input type="text" id="firstname" name="contact_name" value="" class="txtbox" data-bvalidator="required" />

                                        <label for="title"><?=l('Email')?></label>
                                        <input type="text" id="firstname" name="contact_email" value="" class="txtbox"  data-bvalidator="required,email" />

                                        <label for="title"><?=l('Company')?></label>
                                        <input type="text" id="firstname" name="contact_company" value="" class="txtbox"  />

                                        <label for="title"><?=l('Phone')?></label>
                                        <input type="text" id="firstname" name="contact_phone" value="" class="txtbox"  data-bvalidator="required,numbers" />

                                        <label for="title"><?=l('Message')?></label>
                                        <textarea name="contact_message" class="txtarea" data-bvalidator="required" style="width: 330px;height: 200px; border: 1px solid #817e75;"></textarea>

                                      
                                             
                                        
					<div class="clear"></div>


					<input type="submit" value="<?=l('SEND')?>" class="registerbtn"/>
                                        </form>


			</div>

