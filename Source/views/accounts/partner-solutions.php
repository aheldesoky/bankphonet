<div class="pageheader rad5">
	<h1><?=l('Developers & API keys')?>:</h1>
</div>

<script type="text/javascript" src="views/assets/js/shCore.js"></script>
<script type="text/javascript" src="views/assets/js/shBrushPhp.js"></script>
<script type="text/javascript" src="views/assets/js/shBrushXml.js"></script>
<script>
    

  </script>
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

		
                    
                    
                <h2>BANKPHONET.COM PAYMENT GATEWAY API</h2>
<br/>

If you've an online store and want to accept payments using our payment gateway then you need to follow the following steps:<br/>

Create an account and verify it on BANKPHONET.COM<br/>

After creating and verifying your account on BANKPHONET.COM website, You'll get:<br/>
                    <ul style="margin-left:30px;">
                    <li>Private key</li>
                    <li>Public key</li></ul>
You can find these keys at the bottom of 'MY PROFILE' page. <br/>

<br/><br/>
In order to initiate a payment transaction from your website to our website you'll send the user to our<br/>
BANKPHONET.COM with three values.<br/>
YOUR_PUBLIC_KEY (the public key in 'MY PROFILE' page) - Mandatory<br/>
AMOUNT (the amount you want your customer to pay) - Mandatory<br/>
SUCCESS_GO_BACK_LINK (The link you want BANKPHONET.COM to redirect the user to it after the payment succeeded) - Optional<br/>

<br/><br/>
The User who will pay for your account should have a verified account on BANKPHONET.COM and should have the <br/>
requested payment amount in his balance. otherwise payment action will be discarded. <br/><br/>

<pre class="brush: xml">
&lt;!-- EXAMPLE LINK --&gt;
&lt!-- 
    The following example assumes that your 
    public key = 6U4bex0KIyZjW2Gsituldw==
    Amount = 100
    Success go link = http://www.mywebsite.com/ordercomplete.html   --&gt;



 &lt;a href="<?=BASE_URL?>?page=order&pk=6U4bex0KIyZjW2Gsituldw==&am=100&gb=http://www.mywebsite.com/ordercomplete.html"&gt;  CHECK OUT &lt;/a&gt;


</pre>
<br/>
<h2>TRANSACTION PROCESSING</h2><br/><br/>

There are two possibilities for the transaction:<br/><br/>
Success:<br/>
    In this case we will redirect your client back to the provided go_back link.<br/>
Failure:<br/>
    Transaction might fail due to reason or another and an error message displayed to the user.<br/>


<br/><br/>
<h2>TRANSACTION CONFIRMATION</h2><br/><br/>

After a successful payment transaction the client will be redirected to your go_back_url with a parameter in the url "tid"<br/>
<br/>

<pre class="brush: xml">

<h2>EXAMPLE OF A SUCCESSFUL TRANSACTION</h2>
In case you provided a go_back_link
Client will be redirected to it
YOUR Go Back Link is : http://www.mywebsite.com/ordercomplete.html
Client will be redirected to :
http://www.mywebsite.com/ordercomplete.html?tid=8777

Where 'tid' is the transaction id 

</pre>


<h2>TRANSACTION CONFIRMATION & API CONSUMING</h2><br/><br/>

Then, we've a client who paid on BANKPHONET.COM to my account the amount 100.<br/>
Sure you need to confirm this transaction. <br/>
<br/>
For this specific purpose we've created a web service that could be consumed by a BANKPHONET.COM user<br/>
<br/><br/>

<h2>HOW TO CONSUME OUR WEB SERVICE</h2><br/>
You need to be a verified BANKPHONET.COM user.<br/>
You need to have a private key (could be found on BANKPHONET.COM website in "MY PROFILE" page)<br/><br/>

Our web service provides only one method to call. <br/><br/>

<pre class="brush: php">
/**
  * This function will be used by online merchants to verify and confirm
  * Transactions done by their users through bankphonet.com payment gateway.
  * @param string $private_key
  * @param integer $transaction_id
  * @param decimal $amount
  *
  * @return bolean
**/
public function confirm($private_key, $transaction_id, $amount)

// This function will validate your account and confirm the transaction.
// and will return true on success and false on failure.

</pre>

<h2>EXAMPLES CONSUMING API</h2><br/>

CONSUMING API FROM PHP USING ZEND FRAME WORK<br/>

Using the ZEND SOAP component<br/>

the WSDL URI is:
<pre class="brush: xml">
<?=BASE_URL?>api/?wsdl</pre>


<br/>
<pre class="brush: php">
// Initialize a Zend_Soap_Client

$client = new Zend_Soap_Client("<?=BASE_URL?>api/?wsdl",array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_DEFLATE));

// We provide the confirm function described above three params
$private_key =  "6U4bex0KIyZjW2Gsituldw==";
$transaction_id = 944;
$amount = '100';


//confirm if transaction is completed with the mentioned amount
 $transaction_check = $client->confirm($private_key, $transaction_id, $amount)

if ($transaction_check) {
    //on transaction success do something ...
}else{
    //do something else on transaction doesn't exist or amount doesn't match or any possible error.
}
</pre>


                    
                    
                    
		</p>


	</div>

</div>
<div class="clear"></div>
<br /><br /><br /><br />



<script type="text/javascript">
     SyntaxHighlighter.all()
</script>