<?php 
/**
 *  this page processes the submitted information from the ticket 
 *  purchase form and redirects the user to the payment processor's site
 * 
 */

/**
 * Global settings
 * 
 */

/* Variables to be passed via hidden field to payment processor */
require_once('internal/pmt_gateway_settings.php');
// URL to bounce to in the event they click cancel or there is an error
$payment['xxxCancelURL']='http://www.lgbtcenterofraleigh.com/buy_tickets.php?error';

/* Internal application variables */

/**
 * Function settings
 */

function error_redirect() {
    header("Location: {$payment['xxxCancelURL']}");
}

/** Start application logic **/
if (isset($_POST['tickets'])) {
    //tickets variable is set, somebody selected to purchase a ticket
    // TODO: make this dynamic with a database table
    $eventId = preg_replace("/[^0-9A-Z]/i", "", $_POST['tickets']); //get the event id submitted
    $quantity = preg_replace("/[^0-9]/","",$_POST['quantity']); // get the quantity submitted
    if ($quantity <= 0) {
        error_redirect();
    }
    switch($eventId) {
        case "hightea":
            $item['title']="High Tea at the Umstead - July 11, 2010 2-4:30pm";
            $item['unit_price']=50.00;
            $item['qty']=$quantity;

            break;
        case "comingout":
            break;
        default:
            //no event selected, or something unexpected was entered
            header("Location: {$payment['xxxCancelURL']}");
    }
    /* create the product string */
    $payment['Products'] .= "|{$item['unit_price']}::{$item['qty']}::tickets::{$item['title']}::";

        ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>LGBT Center of Raleigh - Contact Us</title>
<style type="text/css">
<!--
body {
	background-color: #990000;
	background-image: url(images/bg_red.jpg);
	background-repeat: no-repeat;
}
-->
</style>
<link href="main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.style3 {color: #993399}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body onload="MM_preloadImages('images/nav_calendar_over.gif','images/nav_community_over.gif','images/nav_photos_over.gif','images/nav_ack_over.gif','images/nav_contact_over.gif','images/join_email_list_over.gif','images/nav_vol_over.gif','images/nav_espanol_over.gif','images/nav_sponsors_over.gif','images/facebook_over.jpg','images/nav_contribute_over.gif','images/nav_founders_over.gif','Library/images/nav_contribute_over.gif','images/nav_partners_over.gif','images/facebook_over.gif');javascript:document.forms['form'].submit();">
<table width="820" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10" height="10" background="images/shad_tl.jpg"><img src="images/shim.gif" width="10" height="10" /></td>
    <td height="10" background="images/shad_t.jpg"><img src="images/shim.gif" width="10" height="10" /></td>
    <td width="10" height="10" background="images/shad_tr.jpg"><img src="images/shim.gif" width="10" height="10" /></td>
  </tr>
  <tr>
    <td width="10" background="images/shad_sl.jpg"><img src="images/shim.gif" width="10" height="10" /></td>
    <td bgcolor="#FFFFFF"><table width="800" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="5"><img src="images/bar_red.gif" width="200" height="5" /></td>
            <td height="5"><img src="images/bar_yellow.gif" width="200" height="5" /></td>
            <td height="5"><img src="images/bar_green.gif" width="200" height="5" /></td>
            <td height="5"><img src="images/bar_violet.gif" width="200" height="5" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr valign="top">
            <td width="200" class="nav"><!-- #BeginLibraryItem "/Library/navigation.lbi" -->
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<body onLoad="MM_preloadImages('../images/join_email_list_over.gif','../images/facebook_over.jpg')"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><a href="index.html"><img src="images/lgbt_logo.gif" width="200" height="109" border="0" /></a></td>
              </tr>
              <tr>
                <td height="10"><span class="style2"><img src="images/shim.gif" width="50" height="10" /></span></td>
              </tr>
              <tr>
                <td><img src="images/nav_about.gif" width="200" height="9" /></td>
              </tr>
              <tr>
                <td class="nav"><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="style2"><img src="images/shim.gif" width="50" height="10" /></td>
                    <td class="style2"><p class="nav"><a href="about_mission.html" class="nav">Our Mission<br />
                    </a><a href="about_vision.html" class="nav">Our Vision<br />
                    </a><a href="about_board.html" class="nav">Board Members<br />
                    </a><a href="about_news.html" class="nav">News</a></p>                      </td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                  <tr>
                    <td height="1" background="images/dot_horiz.gif"><span class="style2"><img src="images/shim.gif" width="150" height="1" /></span></td>
                  </tr>
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>

                <td><a href="contribute.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image47','','images/nav_contribute_over.gif',1)"><img src="images/nav_contribute.gif" alt="Contribute" name="Image47" id="Image47" border="0" width="200" height="9"></a></td>
              </tr>
              <tr>
                <td><table align="center" border="0" cellpadding="0" cellspacing="0" width="150">
                    <tbody><tr>
                      <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8"></span></td>
                    </tr>
                    <tr>

                      <td background="images/dot_horiz.gif" height="1"><span class="style2"><img src="images/shim.gif" width="150" height="1"></span></td>
                    </tr>
                    <tr>
                      <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8"></span></td>
                    </tr>
                </tbody></table></td>
              </tr>

              <!--<tr>
                <td><img src="../images/nav_contribute.gif" width="200" height="9" /></td>
              </tr>
              <tr>
                <td><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="style2"><img src="../images/shim.gif" width="50" height="10" /></td>
                    <td class="style2"><p class="nav"><a href="../cont_corp.html" class="nav">Corporate Sponsors<br />
                    </a><a href="../cont_ind.html" class="nav">Individual Sponsors<br />
                    </a><a href="../cont_vol.html" class="nav"></a><a href="../cont_don.html" class="nav">Donations</a></p>                        </td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="8"><span class="style2"><img src="../images/shim.gif" width="50" height="8" /></span></td>
                    </tr>
                    <tr>
                      <td height="1" background="../images/dot_horiz.gif"><span class="style2"><img src="../images/shim.gif" width="150" height="1" /></span></td>
                    </tr>
                    <tr>
                      <td height="8"><span class="style2"><img src="../images/shim.gif" width="50" height="8" /></span></td>
                    </tr>
                </table></td>
              </tr>-->
              <tr>
                <td><a href="volunteer.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image84','','images/nav_vol_over.gif',1)"><img src="images/nav_vol.gif" alt="Volunteer Opportunities" name="Image84" width="200" height="9" border="0" id="Image84" /></a></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                  <tr>
                    <td height="1" background="images/dot_horiz.gif"><span class="style2"><img src="images/shim.gif" width="150" height="1" /></span></td>
                  </tr>
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><a href="calendar.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image36','','images/nav_calendar_over.gif',1)"><img src="images/nav_calendar.gif" alt="Events Calendar" name="Image36" width="200" height="9" border="0" id="Image36" /></a></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                  <tr>
                    <td height="1" background="images/dot_horiz.gif"><span class="style2"><img src="images/shim.gif" width="150" height="1" /></span></td>
                  </tr>
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><a href="resources.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image37','','images/nav_community_over.gif',1)"><img src="images/nav_community.gif" alt="Community Resources" name="Image37" width="200" height="9" border="0" id="Image37" /></a></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                  <tr>
                    <td height="1" background="images/dot_horiz.gif"><span class="style2"><img src="images/shim.gif" width="150" height="1" /></span></td>
                  </tr>
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><a href="photos.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image41','','images/nav_photos_over.gif',1)"><img src="images/nav_photos.gif" alt="Event Photos" name="Image41" width="200" height="9" border="0" id="Image41" /></a></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                  <tr>
                    <td height="1" background="images/dot_horiz.gif"><span class="style2"><img src="images/shim.gif" width="150" height="1" /></span></td>
                  </tr>
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><a href="founders.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image421','','images/nav_founders_over.gif',1)"><img src="images/nav_founders.gif" alt="Founders" name="Image421" width="200" height="9" border="0" id="Image421" /></a></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                  <tr>
                    <td height="1" background="images/dot_horiz.gif"><span class="style2"><img src="images/shim.gif" width="150" height="1" /></span></td>
                  </tr>
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><a href="sponsors.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image45','','images/nav_sponsors_over.gif',1)"><img src="images/nav_sponsors.gif" alt="Sponsors" name="Image45" width="200" height="9" border="0" id="Image45" /></a></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                  <tr>
                    <td height="1" background="images/dot_horiz.gif"><span class="style2"><img src="images/shim.gif" width="150" height="1" /></span></td>
                  </tr>
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><a href="partners.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image42','','images/nav_partners_over.gif',1)"><img src="images/nav_partners.gif" alt="Partners" name="Image42" width="200" height="9" border="0" id="Image42" /></a></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                  <tr>
                    <td height="1" background="images/dot_horiz.gif"><span class="style2"><img src="images/shim.gif" width="150" height="1" /></span></td>
                  </tr>
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                </table></td>
              </tr>
              <!--<tr>
                <td><a href="../founders.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image49','','../images/nav_founders_over.gif',1)"><img src="../images/nav_founders.gif" alt="Founders" name="Image49.1" width="200" height="9" border="0" id="Image49.1" /></a></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="8"><span class="style2"><img src="../images/shim.gif" width="50" height="8" /></span></td>
                    </tr>
                    <tr>
                      <td height="1" background="../images/dot_horiz.gif"><span class="style2"><img src="../images/shim.gif" width="150" height="1" /></span></td>
                    </tr>
                    <tr>
                      <td height="8"><span class="style2"><img src="../images/shim.gif" width="50" height="8" /></span></td>
                    </tr>
                </table></td>
              </tr>-->
              <tr>
                <td><a href="contact.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image49','','images/nav_contact_over.gif',1)"><img src="images/nav_contact.gif" alt="Contact Us" name="Image49" width="200" height="9" border="0" id="Image49" /></a></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                    </tr>
                    <tr>
                      <td height="1" background="images/dot_horiz.gif"><span class="style2"><img src="images/shim.gif" width="150" height="1" /></span></td>
                    </tr>
                    <tr>
                      <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                    </tr>
                </table></td>
              </tr>

              <tr>
                <td><a href="spanish/index.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image85','','images/nav_espanol_over.gif',1)"><img src="images/nav_espanol.gif" alt="View Spanish version of this site." name="Image85" width="200" height="12" border="0" id="Image85" /></a></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                    </tr>
                    <tr>
                      <td height="1" background="images/dot_horiz.gif"><span class="style2"><img src="images/shim.gif" width="150" height="1" /></span></td>
                    </tr>
                    <tr>
                      <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><a href="mailto:info@lgbtcenterofraleigh.com?subject=LGBT Center Email List" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image541','','images/join_email_list_over.gif',1)"><img src="images/join_email_list.gif" alt="Join Our Email List" name="Image541" width="200" height="12" border="0" id="Image541" /></a></td>
              </tr>
              <tr>
                <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                  <tr>
                    <td height="1" background="images/dot_horiz.gif"><span class="style2"><img src="images/shim.gif" width="150" height="1" /></span></td>
                  </tr>
                  <tr>
                    <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><a href="http://www.facebook.com/pages/lgbt-Center-of-Raleigh/34335003862?ref=search&sid=1382332332.3158455808..1" target="_blank" onMouseOver="MM_swapImage('Image46','','images/facebook_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="images/facebook.gif" alt="Join Us On Facebook" name="Image46" width="200" height="20" border="0"></a></td>
              </tr>
              <tr>
                <td height="10"><span class="style2"><img src="images/shim.gif" width="50" height="10" /></span></td>
              </tr>
            </table>
<!-- #EndLibraryItem --></td>
            <td width="1" background="images/dot_vert.gif"><img src="images/shim.gif" width="1" height="1" /></td>
            <td width="599"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="30" height="30"><img src="images/shim.gif" width="30" height="30" /></td>
                <td height="30"><img src="images/shim.gif" width="30" height="30" /></td>
                <td width="60" height="30"><img src="images/shim.gif" width="60" height="30" /></td>
              </tr>
              <tr>
                <td width="30"><img src="images/shim.gif" width="30" height="30" /></td>
                <td><p class="bluebold">Please wait to complete your purchase.</p>
                  <p class="body">
                    <form action="https://secure.internetsecure.com/process.cgi" method="POST" id="form" name="form">
                    <?php
                    // put your code here
                    foreach ($payment as $name=>$value) {
                        //loop through values and write out fields
                        echo "<input type=\"hidden\" name=\"$name\" value=\"$value\" />\n";

                    }
                    ?>
                        <span class="body">If you are not automatically redirected within 10 seconds, click the <strong>Submit</strong> button below to complete your donation.</span>
                        <br/><br/><input type="submit" value="Submit" class="bodysmall"/></form></p>
                </td>

                <td width="60"><img src="images/shim.gif" width="30" height="30" /></td>
              </tr>
              <tr>
                <td width="30" height="30"><img src="images/shim.gif" width="30" height="30" /></td>
                <td height="30"><img src="images/shim.gif" width="30" height="30" /></td>
                <td width="60" height="30"><img src="images/shim.gif" width="30" height="30" /></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="5"><img src="images/bar_blue.gif" width="200" height="5" /></td>
            <td height="5"><img src="images/bar_violet.gif" width="200" height="5" /></td>
            <td height="5"><img src="images/bar_yellow.gif" width="200" height="5" /></td>
            <td height="5"><img src="images/bar_green.gif" width="200" height="5" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center"><!-- #BeginLibraryItem "/Library/footer.lbi" --><table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
          </tr>
          <tr>
            <td class="address">316 W. Cabarrus St. | Raleigh, NC 27601 | <a href="mailto:info@lgbtcenterofraleigh.com">info@lgbtcenterofraleigh.com</a> | &copy; 2010 All Rights Reserved </td>
  </tr>
          <tr>
            <td height="8"><span class="style2"><img src="images/shim.gif" width="50" height="8" /></span></td>
          </tr>
        </table><!-- #EndLibraryItem --></td>
      </tr>
    </table></td>
    <td width="10" background="images/shad_sr.jpg"><img src="images/shim.gif" width="10" height="10" /></td>
  </tr>
  <tr>
    <td width="10" height="10" background="images/shad_bl.jpg"><img src="images/shim.gif" width="10" height="10" /></td>
    <td height="10" background="images/shad_b.jpg"><img src="images/shim.gif" width="10" height="10" /></td>
    <td width="10" height="10" background="images/shad_br.jpg"><img src="images/shim.gif" width="10" height="10" /></td>
  </tr>
</table>
</body>
</html>