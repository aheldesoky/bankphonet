
<h1 class="inh1">TRANSFER TO ACCOUNT:</h1>


<div class="transfer">
    <form action="?page=order" method="post" class="bvalidator">
	<label for="accountnumber">
        Are you sure that you want transfer 
        <?=$amount?> EGP <br/>
        To <?=$to_data['firstname'].' '.$to_data['lastname']?>
        
        </label>
	
	<div class="clear"></div>
        <a href="." class="btnsubmit">CANCEL </a>
        <input type="hidden" name="doprocess" />
	<input type="submit" value="TRANSFER NOW" class="btnsubmit"/>
    </form>




</div>