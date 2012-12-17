<html>
    <head>
        <title>Verify Transaction</title>
    </head>
    
    <body>

		<h2>New order:</h2>
		<div style="width:600px;margin:0 auto;background: #eeeeee;padding: 5px;">
			Your total order is 100 EGP. click the below check out link to proceed to payment.
			<a href="http://localhost/bankphonet/Source/?page=order&pk=tXuZ0cgdU/znb4EtoGaQfA==&am=250.50&gb=http://www.mywebsite.com/ordercomplete.html" > CHECK OUT </a>
		</div>

		<h2>Verify transaction:</h2>
        <div style="width:600px;margin:0 auto;background: #eeeeee;padding: 5px;">
            <form action="" method="post">
            <table>
                <tr><td colspan="2">Please Enter Your information to verify</td></tr>
                <tr><td>Private Key: </td><td><input type="text" name="p_key" id="" /></td></tr>
                <tr><td>Transaction id: </td><td><input type="text" name="t_id" id="" /></td></tr>
                <tr><td>Amount : </td><td><input type="text" name="amount" id="" /></td></tr>
                <tr><td> </td><td><input type="submit" name="" id=""  value="verify" /></td></tr>
            </table>
            </form>
     

<?php
include 'Zend/Soap/Client.php';

if($_POST){
    $client = new Zend_Soap_Client("http://localhost/bankphonet/Source/api/?wsdl",
    array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_DEFLATE));

    if($client->confirm($_POST['p_key'],$_POST['t_id'],$_POST['amount']) == true){
        echo 'Transaction done';
    }else{
        echo " There are no transaction with this data";
    }
}
?>

            
               </div>
    </body>
</html>