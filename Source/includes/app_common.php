<?php


function strToHex($string)
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}


function sendSMS ($sms,$number){
    $user = "bankph";
    $pass = "12345";
    $sender="BankPhonet";
    //$sms = strToHex($sms);
    $url="http://api2.infobip.com/api/sendsms/plain?user=$user&password=$pass&sender=$sender&SMSText=$sms&GSM=$number";
    $result = file_get_contents ($url);
    return $result;
}


function sendEmail($to, $subject, $message) {
    require_once "includes/Mail/class.phpmailer.php";
    $mail = new PHPMailer ();
    $mail->IsSMTP();

    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "email-smtp.us-east-1.amazonaws.com";
    $mail->Port = "465";
    $mail->Username = "AKIAJH73XSSOQJU7LSNA";
    $mail->Password = "Al9qx8ly6JVP92Oxl95pos2JFI1b7Rgbv0Nr44kP288i";

    $mail->SetFrom('info@bankphonet.com', 'Bankphonet');
    $mail->AddReplyTo('info@bankphonet.com', 'Bankphonet');

    $mail->Subject = $subject;


    $mail->MsgHTML($message);
    $mail->AddAddress($to);



    if (!$mail->Send()) {
        echo $mail->ErrorInfo;
        return false;
    } else {
        return true;
    }
}

function AmazonEmail ($to, $subject, $message){
    
    require_once('includes/Amazon/AmazonSESMailer.php');
    
    // Create a mailer class with your Amazon ID/Secret in the constructor
    $mailer = new AmazonSESMailer('AKIAJNWHMPZPBOIMNSFA', '/A9J2hcctciKellmlVvCLjhfsLdoppDYXfynEsmr');
    
    // Then use this object like you would use PHPMailer normally!
    $mailer->AddAddress($to);
    $mailer->SetFrom('info@bankphonet.com');
    $mailer->Subject = $subject;
    $mailer->MsgHtml($message);
    $send = $mailer->Send();
    if(!$send){
        return false;
    }
    
    return true;
}


 function getProvider ($selected = false){
    
    $html = '<option value="etisalat" '.(($selected == 'etisalat') ? 'SELECTED' : '' ).'>'.l('Etisalat').'</option>
            <option value="vodafone" '.(($selected == 'vodafone') ? 'SELECTED' : '' ).'>'.l('Vodafone').'</option>
            <option value="mobinil" '.(($selected == 'mobinil') ? 'SELECTED' : '' ).'>'.l('Mobinil').'</option>';
    
    return $html;
}


?>
