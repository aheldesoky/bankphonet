<div class="pageheader rad5">
    <h1><?= l('Request money withdraw:') ?></h1>
</div>
<div class="transfer rad5">
    <form action="?page=request-withdraw" method="post" class="bvalidator">


        <label for="method"><?= l('Choose the way you wish to receive your money:') ?></label>
        <select name="method" id="blocked" class="txtbox" data-bvalidator="required" onchange="showMethod($(this).val());">
            <option value="bank"><?= l('Bank') ?></option>
            <option value="western_union"><?= l('Western union') ?></option>
            <option value="post_office"><?= l('Post office') ?></option>
            <option value="check"><?= l('Cheque') ?></option>
        </select>

        <div id="bank_controls">
            <label for="country"><?= l('Country') ?></label>
            <select id="country_code" class="txtbox" data-bvalidator="required" name="country_code" onchange="ShowSwift($(this).val ())">
                <option value=""><?= l('please choose country') ?></option>
                <?= generate_select_options($countries, 'title', 'code') ?>
            </select>


            <div id="bank_info">
                <label for="bankname"><?= l('Bank') ?>:</label>
                <select id="bankname" name="bank_id" id="blocked" class="txtbox" data-bvalidator="required" onchange="showOther ($(this).val ())">
                    <option value=""><?= l('please choose bank') ?></option>

                </select>
            </div>

            <div id="bank_name" style="display: none;">
                <label for="bank_title"><?= l('Bank Name:') ?></label>
                <input type="text" name="bank_title" id="bank_title" value="" class="txtbox"/>
            </div>



            <label for="accountownername"><?= l('Bank account owner name') ?>:</label>
            <input type="text" id="accountownername" name="account_ownername" value="<?= $_POST['bank_account'] ?>" class="txtbox" data-bvalidator="required" />


            <label for="accountnumber"><?= l('Bank account number') ?>:</label>
            <input type="text" id="accountnumber" name="bank_account" value="<?= $_POST['bank_account'] ?>" class="txtbox" data-bvalidator="required" />

            <div id="swiftcode" style="display: none;">
                <label for="accountnumber"><?= l('Swift code') ?>:</label>
                <input type="text" id="swiftcode" name="swift_code" value="<?= $_POST['swift_code'] ?>" class="txtbox" data-bvalidator="required" />
            </div>
        </div>



       

        <div id ="wn_post_controls" style="display: none;">
            <label for="name"><?= l('Name') ?>:</label>
            <input type="text" id="name" name="name" value="<?= $_POST['name'] ?>" class="txtbox" data-bvalidator="required" />


            <label for="address"><?= l('Address') ?>:</label>
            <input type="text" id="address" name="address" value="<?= $_POST['address'] ?>" class="txtbox" data-bvalidator="required" />
        </div>

        <div id="wn_controls" style="display: none;">
            <label for="mobile"><?= l('Mobile') ?>:</label>
            <input type="text" id="mobile" name="mobile" value="<?= $_POST['mobile'] ?>" class="txtbox" data-bvalidator="required,mobile,number" />

        </div>

        
         <div id="check" style="display:none">
           
             <label for="po_box"><?= l('Po.Box') ?>:</label>
            <input type="text" id="mobile" name="po_box" value="<?= $_POST['po_box'] ?>" class="txtbox" data-bvalidator="required" />

        </div>
        
        <div id="post_controls" style="display: none;">
            <label for="postoffice"><?= l('Selected Post office') ?>:</label>
            <input type="text" id="address" name="postoffice" value="<?= $_POST['postoffice'] ?>" class="txtbox" data-bvalidator="required" />

        </div>


        <label for="amount"><?= l('Amount to be transfered') ?>:</label>
        <input type="text" id="amount" name="amount" value="<?= $_POST['amount'] ?>" class="txtbox" data-bvalidator="required,number" />

        <div class="clear"></div>

        <input type="submit" value="<?= l('REQUEST NOW') ?>" class="btnsubmit"/>
    </form>




</div>
<script type="text/javascript">


    function showOther (id){
        if(!id){
            $('#bank_name').show ();
            $('#bank_info').fadeOut('slow');
        }
    }
    
    function ShowSwift(id){
        if(id != 'EG')
            $('#swiftcode').show ();
        else
            $('#swiftcode').hide ();
         
        //Put ajax request For banks here
        $.ajax({
            url:'?ajax=get_banks',
            type:'GET',
            data : "cn="+id,
            success:function(html){
                
                if(jQuery.trim(html) != ''){
                     
                    $('#bankname').html(html);
                    $('#bank_info').show ();
                    $('#bank_name').hide ();
                }
                else{
                    $('#bank_name').show ();
                    $('#bank_info').fadeOut('slow');
                }
            }
             
        });

    }
    function showMethod (id)
    {
  
        switch (id){
       
            case 'bank' :
                $('#wn_post_controls,#wn_controls,#post_controls,#check').hide('fast');
                $('#bank_controls').fadeIn('slaw');
                break;
       
            case 'check':
                $('#post_controls,#bank_controls').hide('fast');
                $('#wn_post_controls,#wn_controls,#check').fadeIn('slaw');
                break;
            
            case 'western_union':
                $('#bank_controls,#post_controls,#check').hide('fast');
                $('#wn_controls,#wn_post_controls').fadeIn('slow');
                break;
           
            case 'post_office':
                $('#bank_controls,#wn_controls,#check').hide('fast');
                $('#post_controls,#wn_post_controls').fadeIn('slow');
                break;
        }
    }
</script>