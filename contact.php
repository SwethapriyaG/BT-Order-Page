<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
    mail("sheikh@smartsensordevices.com", $_POST["emailsubjuect"], $_POST["message"]);
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LfP2t4ZAAAAAKemSFc9buOb2i3L0_xKymSqtDxk';
    $recaptcha_response = $_POST['recaptcha_response'];
    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);
    if ($recaptcha->score >= 0.5) {
        
        if($_POST["emailsubjuect"]=='Support'){            
            $toEmail = "support@smartsensordevices.com";
            $sub= "BleuIO - Support request";
        }else {
            $toEmail = "sales@bleuio.com";
            $sub= "BleuIO - General inquiry";
        }
    
    //$toEmail = "sheikh@smartsensordevices.com";
    $headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: ".$sub." <". $_POST["email"] .">\r\n";
    $message = "Name : ".$_POST["name"].'<br/>';
    $message .="Email : ".$_POST["email"].'<br/>';
    if (isset($_POST["phone"])) {
    	$message .="Phone : ".$_POST["phone"].'<br/>';

    }
    $message .="Message : ".$_POST["message"].'<br/>';
        if(mail($toEmail, $sub, $message, $headers)) {
            echo '<script>window.location.replace("index.php?message=success");</script>';
        } else {
            echo '<script>window.location.replace("index.php?message=failed");</script>';
        }
    } 
    else {
        echo '<script>window.location.replace("index.php?message=failed");</script>';
    }
}
?>