<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//require_once('common_mail.php');

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

//loop through posted fields and add to mailtext
foreach ($_POST as $name=>$value){
    $mailtext.="$name: ". addslashes($value) . "\n";
}

//add form submission time
$mailtext.="\nForm submitted: " . date("Y-m-d H:i",time());

//set up mail object and send message
mail($mailvar['to'],$mailvar['subject'],$mailtext,"From: {$mailvar['from']}\r\nReply-To: {$mailvar['from']}");

//redirect user to confirmation page
header("Location: {$mailvar['confirm_page']}");

?>

