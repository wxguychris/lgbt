<%  set mailer = server.createobject("SMTPsvg.Mailer")  Mailer.FromName = "lgbtcenterofraleigh.com"  Mailer.FromAddress = "root@lgbtcenterofraleigh.com"  Mailer.RemoteHost = "mail.lgbtcenterofraleigh.com"  Mailer.AddRecipient "LGBT Center", "info@lgbtcenterofraleigh.com"  Mailer.Subject = "Gift Donation - lgbtcenterofraleigh.com"  For each Item in Request.Form ' Loop through each Form item     strMsgInfo = "Your Name: " & request.Form("Your Name") & vbCrLf	 strMsgInfo = strMsgInfo & "Phone Number: " & request.Form("Phone Number") & vbCrLf	 strMsgInfo = strMsgInfo & "Email Address: " & request.Form("Email Address") & vbCrLf	 strMsgInfo = strMsgInfo & "Physical Address: " & request.Form("Physical Address") & vbCrLf	 strMsgInfo = strMsgInfo & "Gift Type: " & request.Form("Gift Type") & vbCrLf	 strMsgInfo = strMsgInfo & "Gift Recipient Name: " & request.Form("Gift Recipient Name") & vbCrLf	 strMsgInfo = strMsgInfo & "Acknowledgment Email Address: " & request.Form("Acknowledgment Email Address") & vbCrLf	 strMsgInfo = strMsgInfo & "Submit: " & request.Form("Submit") & vbCrLf	   next  strMsgHeader = "Form information follows" & vbCrLf & "*************"  strMsgFooter = vbCrLf & "*************"  Mailer.BodyText = strMsgHeader & strMsgInfo & strMsgFooter  if Mailer.SendMail then     ' Message sent Ok, redirect to a confirmation page     Response.Redirect ("http://lgbtcenterofraleigh.com/confirm.html")  else     ' Message send failure     Response.Write ("An error has occurred.<BR>")     ' Send error message     Response.Write ("The error was " & Mailer.Response)  end if%>