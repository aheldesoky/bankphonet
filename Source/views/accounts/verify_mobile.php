<div class="formcontainter">
				<h1><?=l('Verify Mobile')?></h1>

                                        <form action="?page=verify" method="post" class="bvalidator">
					<label for="emailreg"><?=l('CODE')?>:</label>
					<input type="text" id="emailreg" name="code" value="" class="txtbox" data-bvalidator ="required" />

					
					<div class="clear"></div>

                                        <a href="?action=resendverification" style="margin-left: 155px;color: #0782C1; font-size: 13px;"><?= l('RESEND VERIFICATION CODE')?></a><br/>
                                       
					<input type="submit" value="<?=l('VERIFY')?>" class="registerbtn"/>

                                        </form>
			</div>