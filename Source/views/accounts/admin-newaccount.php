
<?php include 'views/admin/top.php'; ?>






<div class="transfer">


					<form action="?con=admin&page=newaccount" method="post" class="bvalidator">
                                             <label for="title">TITLE:</label>
                                        <select id="title" name="title" data-bvalidator="required" class="txtbox">
                                            <option value="mr">Mr</option>
                                            <option value="mrs">Mrs</option>
                                        </select>
                                             
                                        <label for="firstname">FIRST NAME:</label>
					<input type="text" id="firstname" name="firstname" value="<?=$_POST['firstname']?>" class="txtbox" data-bvalidator="required" />


					<label for="lastname">LAST NAME:</label>
					<input type="text" id="lastname" name="lastname" value="<?=$_POST['lastname']?>" class="txtbox" data-bvalidator="required" />

                                        <label for="country">Country</label>
                                        <select id="country_code" class="txtbox" data-bvalidator="required" name="country_code">
                                            <option value=""><?=l('please chose country')?></option>
                                            <?=generate_select_options($countries,'title','code')?>
                                        </select>
                                        
					<label for="emailreg">EMAIL:</label>
					<input type="text" id="emailreg" name="email" value="<?=$_POST['email']?>" class="txtbox" data-bvalidator="required,email" />

					<label for="mobile">MOBILE:</label>
					<input type="text" id="mobile" name="mobile" value="<?=$_POST['mobile']?>" class="txtbox" data-bvalidator="required,number" />


					<label for="password">PASSWORD:</label>
					<input type="password" id="password" name="password" value="" class="txtbox" data-bvalidator="required,minlength[6]" />

					<label for="repassword">RE-PASSWORD:</label>
					<input type="password" id="repassword" name="repassword" value="" class="txtbox" data-bvalidator="required,minlength[6]" />
                                        
                                        <label for="blocked">VERIFIED:</label>
                                        <select name="mobile_verified" id="blocked" class="txtbox">
                                            <option <?=($_POST['mobile_verified'] == 0) ? 'SELECTED' : '' ?> value="0">No</option>
                                            <option <?=($_POST['mobile_verified'] == 1) ? 'SELECTED' : '' ?> value="1">Yes</option>
                                        </select>


					<div class="clear"></div>


					<input type="submit" value="CREATE ACCOUNT" style="width: 140px; height: 30px; margin: 10px 0;"/>
                                        </form>


			</div>

