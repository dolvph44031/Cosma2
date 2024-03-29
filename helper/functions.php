<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function sendMail($to, $subject, $content)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'ndkdzvl@gmail.com';                     //SMTP username
        $mail->Password   = 'dchuzrbjuruftzrj';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('ndkdzvl@gmail.com', 'SMARTFL');
        $mail->addAddress($to);     //Add a recipient
        //Content
        $mail->isHTML(true);                             //Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $content;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        return $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}



function redirect($url='index.php'){

    header('Location: '.$url);
    exit();
}

function view($file, $folder='client', $data=[]){

    extract($data);

    require _WEB_PATH_ROOT."/views/$folder/$file.php";

}

function layout($file, $folder='client', $data=[]){
    extract($data);
    require _WEB_PATH_ROOT."/public/$folder/layouts/$file.php";

}



function setSession($key, $value=''){
    if(!empty(session_id())){
        $_SESSION[$key] = $value;
        return true;
    }
    return false;
}


function getSession($key=''){

if(!empty($key)){
 if(!empty($_SESSION[$key])){
        return $_SESSION[$key];
    }else{
        return false;
    }
}else{

    return $_SESSION;

}
    return false;
}

function removeSession($key=''){

    if(!empty($key)){
        unset($_SESSION[$key]);
        return true;
    }else{
        session_destroy();
        return true;
    }
    return false;

}

function setFlashData($key='', $value=''){
    $key = 'flash_'.$key;

    if($key){
        setSession($key, $value);
        return true;
    }

    return false;

}

function getFlashData($key=''){
    $key = 'flash_'.$key;
    $data = getSession($key);
    removeSession($key);
    return $data;
}

function spanError($msg){

    echo '<span class="text-danger">'.$msg.'</span>';

}

function alertError($msg){
    if(!empty($msg)){
    echo '<div class="alert alert-danger">'.$msg.'</div>';
    }
}


