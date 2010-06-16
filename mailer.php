<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//require_once('common_mail.php');

// check to see if any information is POSTed
// or if the submission is empty
// or if there aren't enough fields there
$data = array_diff($_POST, array(''));

if (empty($_POST) or !isset($_POST) or count($data)<=2) {
   //nothing POSTed, redirect
   header("Location: http://www.lgbtcenterofraleigh.com/");
   exit;
}

//get the type of donation
$type=addslashes($_POST['type']);

//setup common variables
$mailvar=array('from'=>'LGBT Center of Raleigh <root@lgbtcenterofraleigh.com>',
                'to'=>'LGBT Center <lgbtcenterofraleigh@gmail.com>',
                'confirm_page'=>"http://lgbtcenterofraleigh.com/confirm.html",
                'type'=>$type);

/*$mailvar=array('from'=>'LGBT Center of Raleigh <root@lgbtcenterofraleigh.com>',
                'to'=>'LGBT Center <info@lgbtcenterofraleigh.com>',
                'confirm_page'=>"http://lgbtcenterofraleigh.com/confirm.html");*/

// start app logic
if (stripos($type,"Donation")!==false) {
    // type of notification is donation
    $mailvar['subject']="Donation - lgbtcenterofraleigh.com";
} elseif (stripos($type,"Volunteer")!==false) {
    //volunteer notification
    $mailvar['subject']="Volunteer Information - lgbtcenterofraleigh.com";
} elseif (stripos($type,"Space Request")!==false) {
    //space request
    $mailvar['subject']="Space Reservation Request - lgbtcenterofraleigh.com";
} else {
    //some other kind of notification
    $mailvar['subject']="Website contact ($type) - lgbtcenterofraleigh.com";
}

//start creating mailtext
$mailtext="";
//$mailtext=count($_POST);

//loop through posted fields and add to mailtext
foreach ($_POST as $name=>$value){
    if (empty($value)) {
        //nothing in the field,
        continue;
    } else {
        $mailtext.="$name: ". addslashes($value) . "\n";
    }
}

//check to see if anything is listed in the mailtext
if (empty($mailtext)) {
    //no text, bounce user to main page
    header("Location: http://www.lgbtcenterofraleigh.com/");
    exit;
}

//add form submission time
$mailtext.="\nForm submitted: " . date("Y-m-d H:i",time());

//set up mail object and send message
mail($mailvar['to'],$mailvar['subject'],$mailtext,"From: {$mailvar['from']}\r\nReply-To: {$mailvar['from']}");

//redirect user to confirmation page
header("Location: {$mailvar['confirm_page']}");

?>

