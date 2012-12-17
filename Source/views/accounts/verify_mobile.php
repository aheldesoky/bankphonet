<div class="formcontainter">
				<h1><?=l('Verify Mobile')?></h1>

                                        <form action="?page=verify" method="post" class="bvalidator">
					<label for="emailreg"><?=l('CODE')?>:</label>
					<input type="text" id="emailreg" name="code" value="" class="txtbox" data-bvalidator ="required" />

					
					<div class="clear"></div>


					<input type="submit" value="<?=l('VERIFY')?>" class="registerbtn"/>

                                        </form>
			</div>