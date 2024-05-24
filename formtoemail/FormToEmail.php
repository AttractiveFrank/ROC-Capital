<?php

/*
Thank you for purchasing FormToEmail-Pro by FormToEmail.com
Version 2.8 September 26th 2008
COPYRIGHT FormToEmail.com 2006 - 2008 - All rights reserved.
You may not sell (or otherwise distribute) this script. YOU ARE NOT PERMITTED TO POST THIS CODE IN A PUBLIC PLACE, such as a forum for example. A single license entitles you to use this script on one website only. A multiple license entitles you to use this script on any number of sites owned or maintained by you.
For support, please visit: http://formtoemail.com/support/
DESCRIPTION
-----------
FormToEmail-Pro is a form processing script written in PHP. It allows you to place a form on your website which your visitors can fill out and send to you. The contents of the form are sent to the email address (or addresses) which you specify below. The form (code supplied below) allows your visitors to enter their name, email address and comments. You can add additional fields to the form or use the script to process any other form, see below.
The script is very secure. Your visitors (and spambots) cannot see your email address. The script cannot be hijacked by spammers for using as a relay to send spam from. It has a number of features to combat contact-form spam.
You can add additional fields to your form, which this script will also process without making any additional changes to the script. You can also use it to process your own forms, if doing so, make sure your form action is correct, like so: <form action="formtoemailpro.php" etc>. The script will handle the "POST" or "GET" methods. It will also handle multiple select inputs and multiple check box inputs. If using these, you must name the field as an array using square brackets, like so: <select name="fruit[]" multiple>. The same goes for check boxes if you are using more than one with the same name, like so: <input type="checkbox" name="fruit[]" value="apple">Apple<input type="checkbox" name="fruit[]" value="orange">Orange<input type="checkbox" name="fruit[]" value="banana">Banana
** PLEASE NOTE ** If you are using the script to process your own forms (or older FormToEmail forms) you must ensure that the email field is named correctly in your form, thus: <input type="text" name="email" etc>. Note the lower case "email". If you don't do this, you won't be able to see who the email is from and the script won't be able to check the validity of the email. If you are using the form code below, you don't need to check for this.
The script will handle file uploads of any file type and send them as attachments to the email that is sent to you or upload them to your server. There is no limit to the number of files you can upload. To allow your form to uploaded files, you must put this enctype="multipart/form-data" in the form action and use the "post" method, like so: <form action="formtoemailpro.php" method="post" enctype="multipart/form-data">. You must also use a file input <input type="file" name="whatever"> on your form, one for each file you wish the visitor to upload. Give each one a different name. You do not need to make any configuration changes to the script to allow file uploads, they will be detected automatically. If you wish to save the uploaded files to your server instead of sending them as attachments then you must enable this in the configuration options below.
This is a PHP script. In order for it to run, you must have PHP (version 4.1.0 or later) on your webhosting account, and have the PHP mail() function enabled and working. If you are not sure about this, please ask your webhost about it.
SETUP INSTRUCTIONS
------------------
Step 1: Put the form on your webpage
Step 2: Enter your email address
Step 3: Configure the script (optional)
Step 4: Upload the files to your webspace
Step 1:
-------
Put the form on your webpage (if not using your own form). If using your own form, remember to change the action to: <form action="formtoemailpro.php" method="post">
Copy the appropriate form code below and paste it into your webpage. You have two code options here:
1. Code for the standard form
2. Code for the standard form with the reCAPTCHA system enabled
1. Code for the standard form
Copy the code below as it is, and paste it into your webpage:
<form action="formtoemailpro.php" method="post">
<table border="0" bgcolor="#ececec" cellspacing="5">
<tr><td>Name</td><td><input type="text" size="30" name="name"></td></tr>
<tr><td>Email</td><td><input type="text" size="30" name="email"></td></tr>
<tr><td valign="top">Comments</td><td><textarea name="comments" rows="6" cols="30"></textarea></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" value="Send"></td></tr>
</table>
</form>
2. Code for the standard form with the reCAPTCHA system enabled
Copy the code below as it is, and paste it into your webpage (you will need to enter your reCAPTCHA public key where indicated (more information below). You will also need to enable and configure the reCAPTCHA system in the configuration options below):
<form action="formtoemailpro.php" method="post">
<table border="0" bgcolor="#ececec" cellspacing="5">
<tr><td>Name</td><td><input type="text" size="30" name="name"></td></tr>
<tr><td>Email</td><td><input type="text" size="30" name="email"></td></tr>
<tr><td valign="top">Comments</td><td><textarea name="comments" rows="6" cols="30"></textarea></td></tr>
<tr><td>&nbsp;</td><td>
<?php
require_once('recaptchalib.php');
$publickey = "enter your reCAPTCHA public key in here between the quotes";
echo recaptcha_get_html($publickey);
?>
</td></tr>
<tr><td>&nbsp;</td><td><input type="submit" value="Send"></td></tr>
</table>
</form>
Step 2:
-------
Enter your email address.
Enter the email address below to send the contents of the form to. Like this for example: $my_email = "webmaster@example.com"; If desired, you can enter more than one email address separated by commas, like so: $my_email = "bob@example.com,sales@example.co.uk,jane@example.com";
*/
$my_email = "ronan@ronanocoigligh.com";
/*

The script will now work. Everything below this line is optional. If you wish, you can now proceed to Step 4 (Upload the files to your webspace).
Step 3:
-------
Configure the script (optional).
You can edit these options at any time. If you do so, remember to save the file and upload it to your webspace.
Bcc email addresses. The script can send a Blind Carbon Copy (BCC) of the email to the address(es) specified below. Enter the address(es) between the quotes below, like this for example: $bcc = "support@example.com,mail@example.com";
*/
$bcc = "";
/*
Subject line. The default subject line for the email that is sent to you, is shown below. To change this, enter your own subject between the quotes. Make sure that you use a subject that will get past any spam filters you might use.
*/
$subject = "Website Submission";
/*
Continue link. You have the option of presenting your visitor with a standard "thank you" message or automatically redirecting them to a "thank you" page (or any page of your choosing) after they have submitted the form. The default is the standard "thank you" message. If you are using the standard "thank you" message, they will be provided with a "continue" link to your homepage (or any page of your choosing) after submitting the form, which they can click on to continue. Enter the continue link to offer the user. If you do not change this, your visitor will be given a continue link to your homepage. If you are using the automatic redirect option below, the $continue value is ignored.
If you do change it, remove the "/" symbol below and replace it with the address of the page to link to, eg: "mypage.htm" or "http://www.elsewhere.com/page.htm"
*/
$continue = "http://ronanocoigligh.com/thankyou.html";
/*
Automatic redirect. If you would like the visitor to be automatically redirected to another page (or site) when they submit the form (as opposed to getting the standard "thank you" message) change the value below to 1, like so: $auto_redirect = 1;
*/
$auto_redirect = 0;
/*
Enter the web address of the page that you would like the visitor to be automatically redirected to (between the quotes below). You only need to do this if you have enabled the auto redirect above. You can redirect them to any page on any site, it doesn't have to be a page on your own site. It is advisable to write the full URL like so: $redirect_url = "http://example.com/thankyou.htm";
*/
$redirect_url = "/";
/*
You can compare two email address inputs to confirm the visitor's email address. The visitor must correctly enter their email address in the two inputs, otherwise they will get an error and the email will not be sent. If using this option, you must have two email inputs on your form named "email" and "email2", like this: <input type="text" name="email"> <input type="text" name="email2">. By default, this is not enabled. Default value: $confirm_email_address = 0; To enable it, change the 0 below to 1 like so: $confirm_email_address = 1;
*/
$confirm_email_address = 0;
/*
Required fields. You can choose to require specific fields on your form. If these are empty when the form is submitted the user will be issued with a message to go back and enter a value. The form will not be sent until the required fields are filled out. If you do not enable required fields, the script will still issue an error if all fields are blank, and will not send an email. To enable checking for required fields, change the value below to 1, like so: $required_fields_check = 1;
*/
$required_fields_check = 0;
/*
Specify which fields to require. You only need to do this if you have enabled the checking for required fields above. Enter the name of the field in quotes. If you wish to require more than one field, separate them with commas. Like this for example: $required_fields = array('name','comments'); The field name must be exactly as it appears on the form. For example if you have this on your form: <input type="text" name="Zip_Code"> and you want to require the name and zip code you would do this: $required_fields = array('name','Zip_Code'); Please note, if you are using an array for an input name (e.g name="product[]") and you wish to make this a required field, enter the name below without the square brackets like so ('product'). The standard form has the three fields shown below. If you have not enabled checking for required fields you can leave the line below as it is, as it will be ignored.
*/
/*$required_fields = array('name','email','phone','company','Title','message');*/
$required_fields = array('name','email');
/*
IP address display. If you enable this, the email sent to you will have the sender's IP address shown at the bottom. To enable it, change the value to 1, like so: $show_ip = 1;
*/
$show_ip = 1;
/*
Check for banned IPs. You can ban specific IP addresses or IP address classes from using your form. To enable checking for these, change the value below to 1, like so: $banned_ips_check = 1;
*/
$banned_ips_check = 0;
/*
Banned IPs. Make a list of the IP addresses (or classes) you would like to ban. You must enable checking for banned IPs above, for this to work. Enter the IP address in quotes. For more than one address, separate them with commas as in this example: $banned_ips = array('44.22.233.21','82.24.56.1','224.130.87.113');
To ban an IP address class, enter the class like so (remembering to put a period at the end): $banned_ips = array('44.','82.24.','224.130.87.'); So looking at the last class in this example, any IP address in the range 224.130.87.0 to 224.130.87.255 will be banned. In other words, any IP address beginning with 224.130.87. will be banned.
Here's an example of individual IP addresses and an IP class (they all go in the same array): $banned_ips = array('44.22.233.21','224.130.87.113','82.24.');
Please note, the IP addresses and classes shown in the above examples are fictitious. There is virtually no limit to the number of IP addresses you can list here but the more you have the slower the script will run (as with any script) but you would need to have quite a large list to notice any difference.
*/
$banned_ips = array();
/*
Banned IP message. If the form is submitted from a banned IP address, the (contents of the form) email will not be sent to you. The script will issue an error to the user. You can edit the error message by changing the message between the quotes below. If you don't want to reveal that the IP address is banned, you could have a message like "An error has occurred. The form was not sent.".
*/
$banned_ip_message = "Your IP address is banned. The form was not sent.";
/*
Cookie requirement. If you enable this the script will first check for the existence of a cookie. If the cookie does not exist, the script will exit, an error message will be issued and the email will not be sent. This is a very useful feature as it will block some spam bots. If this is enabled, the user (your website visitor) must have cookies enabled on their browser. To use this feature you must set a cookie on the page that the form is on. If it is on an HTML page you can set the cookie by putting this line in the <head></head> section: <meta http-equiv="Set-Cookie" content="formtoemailpro=1">
If the form is on a PHP page, you can set the cookie by entering this code on the page (before any output - usually near the top): setcookie('formtoemailpro',1);
To require a cookie, change the value to 1, like so: $require_cookie = 1;
*/
$require_cookie = 0;
/*
Referrer check. By default the script will check for a referrer (referer) header to establish that the form is being submitted from your site. To disable this, change the value to 0, like so: $check_referrer = 0;
*/
$check_referrer = 1;
/*
Word block. You can block any word (rude or otherwise) character, string or phrase from being submitted. If such an instance is detected the script will issue an error and the email will not be sent. The script performs this check by default and checks all fields for these words. To disable it, change the value below to 0, like so: $word_block = 0;
*/
$word_block = 1;
/*
Blocked words. This is a list of words or characters that will be checked for if word block is enabled above. You can add or remove words from the array below. You can enter a single character or a string of characters or words (it is not case-sensitive). Place each word (or phrase) in quotes and separate them with commas. By default the script will not allow web addresses (URLs beginning with http:// or https://) to be posted. If someone is trying to spam you, you can be fairly certain that they will include a web address in the comments or elsewhere. If you expect your visitors to enter web addresses, then you should remove 'http://','https://' from the array (or disable word block above). The line below is only used if word block is enabled, otherwise it is ignored.
*/
$blocked_words = array();
/*
Gibberish check. Frequently, contact form spam may consist of gibberish "words" like "YwfZCvLdDQYDTzGAH" or "MldMtrPAgZq" for example. The gibberish check identifies such "words", blocks them and issues an error. If an error is issued, the script will not send the email. It looks for a series of consecutive consonants or consecutive vowels. These "words" very often have a long series of consecutive consonants or consecutive vowels that you would not find in a normal word. You can set a threshold (below) which will allow consecutive vowels or consecutive consonants up to the threshold limit. This check only works for English alphabet vowels and consonants. By default it is enabled. The default value is $gibberish_check = 1; To disable it, change the 1 below to a 0, like so: $gibberish_check = 0;
*/
$gibberish_check = 0;
/*
Gibberish threshold. The gibberish threshold is used in conjunction with the gibberish check above. It defines a threshold for the number of consecutive consonants or consecutive vowels you will allow in submitted words. The default setting is $gibberish_threshold = 6; This means that if any 6 (or more) consecutive vowels or any 6 (or more) consecutive consonants are present in a word, then it will be blocked. Change the value to suit. 6 appears to be a good setting as there are not many (or any?) English words that have six or more consecutive vowels or consonants. This setting has no effect if the gibberish check is disabled above.
*/
$gibberish_threshold = 6;
/*
Gobbledegook check. You sometimes get spam consisting entirely of gobbledegook characters (Å ð ç etc). They are in fact "exotic" or non-English language characters. This check will prevent any messages getting through if gobbledegook is found. By default this check is not done. To enable it, change the value to 1, like so: $gobbledegook_check = 1;
*/
$gobbledegook_check = 1;
/*
reCAPTCHA system. This is a third-party CAPTCHA system (more information here: http://recaptcha.net/). reCAPTCHA is a claimed Trademark. If you enable this option, the script will check the user input from the CAPTCHA. To use this system, you first need to register with recaptcha.net and get a public and private key which you enter on your form and in this script (the public key goes in your form page, the private key gets entered in this script below). The keys are only valid for the domain they were registered to (see recaptcha.net for more information). There is form code above for use with this system. If using your own form, then you need to paste in this code between the <form></form> tags:
<?php
require_once('recaptchalib.php');
$publickey = "enter your reCAPTCHA public key in here between the quotes";
echo recaptcha_get_html($publickey);
?>
Note that you have to enter your reCAPTCHA public key in the above code (same too if using the sample form code above). Your form page MUST be a PHP page for the reCAPTCHA code to work. i.e. your page must have a .php extension like "contact.php" for example. You will also need to download the PHP zip file from recaptcha.net and put the file "recaptchalib.php" in the same directory/folder as the form page and script. The zip file from recaptcha.net has several files in it but "recaptchalib.php" is the only one you need. You can get it here: http://code.google.com/p/recaptcha/downloads/list?q=label:phplib-Latest
All the code you need is included in the script. You do not need to get any code from recaptcha.net. The only thing you need from them is your public and private keys and the zip file containing recaptchalib.php.
By default this option is not enabled ($reCAPTCHA = 0;). To enable it, change the 0 below to 1, like so: $reCAPTCHA = 1;
*/
$reCAPTCHA = 0;
/*
Private key for the reCAPTCHA system. Enter your reCAPTCHA private key between the quotes below. You get this from recaptcha.net when you register with them, see above. The key is only valid for the domain it was registered to. This is only used if you have enabled the reCAPTCHA system above. Default is: $privatekey = "";
*/
$privatekey = "";
/*
HTML formatting. By default the script will send you an email in plain text but you can choose to have the output sent to you in HTML format. This presents the output in a table with different colors and bold fonts which makes it very neat and easy to read. You can customize it below. Enabling this option also means that the autoresponder email (if enabled) will also be in HTML format. To enable HTML formatting change the value below to 1, like so: $html_format = 1;
*/
$html_format = 1;
/*
HTML output customizing. Change the values below, as required, to customize the HTML output. These values are only used if HTML formatting is enabled above, otherwise they are ignored. You can use words (red, green) hexidecimal or RGB values for the colors. The table outputs two columns. The left one contains the keys (variables from your form fields) and the right one contains the values entered by your visitor. Try it with the default settings first so you can see what it looks like. The HTML format uses "old-fashioned" HTML (bgcolor, <font>) because some email readers have difficulty with CSS.
You can also change the font settings for the autoresponder message below (if enabled).
*/
$table_cellpadding = "5";
$table_cellspacing = "1";
$table_background_color = "#000000";
$table_left_column_color = "#ececec";
$table_left_column_font = "arial";
$table_left_column_font_size = "2";
$table_left_column_font_color = "#000000";
$table_right_column_color = "#ffffff";
$table_right_column_font = "arial";
$table_right_column_font_size = "2";
$table_right_column_font_color = "#000000";
$autoresponder_font = "arial";
$autoresponder_font_size = "2";
$autoresponder_font_color = "#000000";
/*
Character set. Specify a character set (encoding) to be used in the output email and the built-in "thank you" message. Only change this if you need to and you know the correct one to use. Enter the desired value between the quotes. Default: $character_set = "iso-8859-1"; Please also state the character set in the <head> of your form page. So for example if you are using utf-8, the line in your form page would be: <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> and the variable below would be: $character_set = "utf-8";
*/
$character_set = "iso-8859-1";
/*
Encode From: name and subject line. Apply encoding to the email From: name and the email subject line. Only do this if you need to. You will normally only need to do this if you are using exotic characters that are getting garbled in the From: name or subject line. It uses the $character_set variable value above. The default setting is disabled, thus: $encode_name_subject = 0; To enable it, change the 0 to 1, like so: $encode_name_subject = 1;
*/
$encode_name_subject = 0;
/*
CSV attachment. You can choose to have the form data included in a CSV (Comma Separated Value) file that is sent as an attachment to the email the script sends (you still get the form data in the email). The file contains the field names as the header row and the form data as the second row. The file only contains data from the submitted form and does not accumulate data from all form submissions (see below if you want a CSV file containing all form submissions). The CSV file can be opened in Excel, for example. You do not need to make any changes to your form. To enable this, change the value below to 1, like so: $csv_attachment = 1;
*/
$csv_attachment = 0;
/*
CSV file on server. If you enable this, all data from submitted forms will be accumulated in a CSV file on your server. You can then download the file and open it in Excel (for example) and search/sort/manipulate/print the data to suit. By default the CSV file is kept in the same directory/folder as the script and is named "form_data.csv". You can change the location of the file below. The first line of the file is a header row made up of the field names from your form. The subsequent rows show the data submitted from your form, one line of data for each form submitted.
*** IMPORTANT ***
For this to work, PHP must have permission to write to the directory where the CSV file will be created and kept (the script creates the file automatically if it does not already exist). For Unix/Linux type operating systems, set the permissions for the directory to CHMOD 770. This allows you (the owner) and PHP to write to the directory but does not allow the rest of the world to do so. You do not need to change permissions for the CSV file itself.
To enable this option, change the value below to 1, like so: $csv_file_on_server = 1;
*/
$csv_file_on_server = 0;
/*
Path to CSV file on server. This is the path to the location on your server where the CSV file will be kept. By default it is in the same directory/folder as the script. The default setting is: $path_to_csv_file = dirname(__FILE__) . "/"; You can change the location by entering the full server path below. Like this for example: $path_to_csv_file = "/home/users/bob/files/"; Note that you must have a trailing slash at the end. Note also that you do not include the file name in the path.
*/
$path_to_csv_file = dirname(__FILE__) . "/";
/*
CSV filename. Enter a filename below for the CSV file or keep the default name as it is. This name is used for the file that is sent as an attachment and/or the file that is kept on your server. If you enter a name, put it in quotes like this: $csv_filename = "sales_enquiry.csv";
*/
$csv_filename = "form_data.csv";
/*
Autoresponder. You can configure the script to send an automated email response to the enquirer. The message will contain a subject line, a header message, the data from the form submitted and a footer message (signature). You can also attach a file to it, see below. Configure the various options in the lines below.
If HTML output is enabled above, then the autoresponse email will also be in HTML format. It is advisable not to enable HTML output as it can be unpredictable at times with different email applications/readers, and your visitor might not have their system configured to display HTML emails.
By default the script will not issue an autoresponse. To enable the autoresponder, change the value below to 1, like so: $autoresponder = 1;
*/
$autoresponder = 0;
/*
By default the From: address shown in the autoresponse email will be the email address that is used to send the contents of the form to, and is configured in the $my_email variable above. You can enter a different From: email address below. Like this for example: $autoresponder_from = "support@example.com";
*/
$autoresponder_from = "ronan@ronanocoigligh.com";
/*
Enter a subject line for the autoresponse email below. Keep it between the quotes.
*/
$autoresponder_subject = "[ronanocoigligh.com] New Submission";
/*
Enter a message below, between the quotes, that will be shown at the top of the autoresponse email.
*/
$autoresponder_header_message = "This enquiry was generated using the enquiry form on the website.";
/*
Enter a message (or signature) below, between the quotes, that will be shown at the bottom of the autoresponse email.
*/
$autoresponder_footer_message = "ronanocoigligh Enquiry";
/*
Send an attachment with the autoresponder. You can attach a file to the autoresponse message. To do so, you need to enable it then enter the information about the file, its name, its location and the filetype in the configuration options below. To enable a file to be attached to the autoresponse email, change the 0 to 1 below, like this: $autoresponder_attachment = 1;
*/
$autoresponder_attachment = 0;
/*
Autoresponder attachment file name. Between the quotes below, enter the name of the file you are attaching, like this for example: $autoresponder_attachment_file = "brochure.doc";
*/
$autoresponder_attachment_file = "";
/*
Autoresponder attachment location. In the quotes below, enter the location (path) of the file you would like to attach. It must be the full server path to the file and must have a trailing slash, like this for example: $autoresponder_attachment_path = "/home/username/files/"; Do not enter the file name here, that is done above.
*/
$autoresponder_attachment_path = "";
/*
Autoresponder attachment content (MIME) type. Between the quotes below, enter the file content type. PHP cannot tell what the content type is, so you must enter it yourself. These examples are for common content types:
$autoresponder_attachment_content_type = "application/msword"; (Word document .doc)
$autoresponder_attachment_content_type = "application/ms-excel"; (Excel spreadsheet .xls)
$autoresponder_attachment_content_type = "application/pdf"; (Adobe PDF document .pdf)
$autoresponder_attachment_content_type = "image/jpeg"; (JPEG image .jpg .jpeg)
You can get a list of MIME content types here: http://www.utoronto.ca/webdocs/HTMLdocs/Book/Book-3ed/appb/mimetype.html
*/
$autoresponder_attachment_content_type = "";
/*
Ignoring fields. You might have fields/inputs on your form that you want to ignore, i.e you do not want them sent in the email you receive from the script. Typically this might be a "submit" input. If you wish to ignore certain fields, you must enable this option. To enable it, change the 0 below to 1, like so: $ignore_fields = 1;
*/
$ignore_fields = 0;
/*
In the array below, list the field names that you want to be ignored. Enter the names EXACTLY as they appear on your form. An example is shown below. You can edit it as required but remember to put the values in quotes and separate them with commas. The array below is ignored if you have not enabled $ignore_fields above.
*/
$fields_to_ignore = array('Submit','submit','recaptcha_challenge_field','recaptcha_response_field');
/*
Sort fields. You can specify the order that your form fields are displayed in the email sent from the script. To use this option you must enable it then enter the form fields order in the next section below. To enable it, change the 0 below to 1, like so: $sort_fields = 1;
*/
$sort_fields = 0;
/*
Form fields order. In the array below ($field_order_keys) you can set the order of your form fields so that they will show in the email in the order that they appear in the array. You must enable $sort_fields above for this to take effect, otherwise it is ignored. The array shown below is an example. Enter your form field names in the array. Put them in quotes and separate them with commas as in the example below. You must name the fields EXACTLY as they are named in your form. ONLY the fields in the array will be shown in the email sent from the script and in the order entered in the array. If you have an array input field on your form, like fruit[], then enter the name without the square brackets, like so: 'fruit'.
*/
$field_order_keys = array('signup-contact','signup-email','signup-telephone','signup-event', 'signup-venue', 'Date Start', 'Time Start', 'Time End', 'genre','signup-comments');
/*
Line spacing. If you receive your email in plain text, the form data will be shown on separate lines with a space in between them. This is to make it easy to read. This is default. You can change the output so that the data is shown on new lines but without spaces. To do so, change the value below to 0, like so: $line_spacing = 0;
*/
$line_spacing = 1;
/*
Show blank fields. By default the script will only return form fields where a value has been entered. If you would like the script to return all form fields including blanks, then enable $show_blank_fields below. To enable it, change the 0 to 1 like so: $show_blank_fields = 1;
*/
$show_blank_fields = 1;
/*
Block file types. If you are uploading files from your form, you can block certain file types. To do so, enable this feature then enter the blocked file types in the next option. To enable this feature, change the 0 below to 1, like so: $block_file_types = 1; Alternatively you can specifically state which file types you will allow, see below. Blocking file types will allow ALL file types to be uploaded EXCEPT those that you choose to block.
*/
$block_file_types = 0;
/*
File types to block. List in the array below, the file extensions that you want to block. If the script detects a file with one of these extensions, it will issue an error and stop processing the form. Enter file types in lower case, in quotes and separated by commas, like this default setting: $file_types_to_block = array('.com','.bat','.exe'); Note that you must include the dot (period). You can add or remove file extensions to suit. This array is ignored if you have not enabled $block_file_types above so it is safe to leave it as it is. Enter the file type extensions in lower case, ".exe" will block "file.EXE" and "file.exe" for example.
*/
$file_types_to_block = array('.com','.bat','.exe');
/*
Allow file types. If you are uploading files from your form, as an alternative to blocking certain file types (above) you can choose to only ALLOW certain file types. To do so, enable this feature then enter the allowed file types in the next option. To enable this feature, change the 0 below to 1, like so: $allow_file_types = 1; Stating file types to allow will only allow those that you state below to be uploaded, ALL others will not be allowed. By default, ALL file types are allowed.
*/
$allow_file_types = 0;
/*
File types to allow. List in the array below, the file extensions that you want to allow. If the script detects a file type that is not allowed, it will issue an error and stop processing the form. Enter file types in lower case, in quotes and separated by commas, like this default setting: $file_types_to_allow = array('.doc','.pdf','.jpg'); Note that you must include the dot (period). You can add or remove file extensions to suit. This array is ignored if you have not enabled $allow_file_types above so it is safe to leave it as it is.
*/
$file_types_to_allow = array('.doc','.pdf','.jpg');
/*
Set a maximum file upload size. You can check the size of uploaded files and reject those that exceed a maximum file size set below. This feature is Independent of $block_file_types above. It only requires a value to be set for it to be enabled, otherwise the check is not carried out. By default the value is empty and the check is not carried out, this is the default setting: $max_file_size = ""; To enable this feature, enter a value between the quotes. The value is the maximum permitted file size in bytes. 1 Megabyte (MB) = 1048576 Bytes. Do not enter punctuation in the value. Here is an example: $max_file_size = "1048576"; This check is independent of the check that PHP makes on your server for the size of uploaded files (in php.ini). Please note. If an uploaded file exceeds the limit set in php.ini then PHP will reject the file and it will not get passed to the script. This means that the script will not issue an error because it knows nothing about the file. If you want the script to issue an error in this case, increase the limit in php.ini to a value that is greater than the value you set here.
*/
$max_file_size = "";
/*
Upload files to the server. By default, any files uploaded from your form will be sent as attachments to the email the script sends you. Alternatively you can upload these files to your server. Uploaded files will overwrite any existing files of the same name in the same location. See the section in the description at the top of this script for information about handling file uploads. To enable uploads to your server, change the 0 to 1 in the line below, like so: $upload_files_to_server = 1;
*/
$upload_files_to_server = 0;
/*
Upload files directory. By default the uploaded files will go in the same directory/folder that the script is in. You can instead name a directory on your server where you would like the files to go. PHP must have permission to write to the directory. Permissions are down to your server setup but CHMOD 777 will work in every case. If the directory is above the web root, you will get the file-names-only shown in the email from the script. If the directory is web-accessable you will get a link to the uploaded file(s) in the email from the script which you can click on to download them. If using the latter option it is better to enable the HTML output option in the script as it makes displaying the links more predictable (it handles spaces in the file names better). If you specify a directory below, put it in quotes and include a trailing slash (you must use the full server path), as in this example: $path_to_uploaded_file = "/home/username/uploads/";
*/
$path_to_uploaded_file = dirname(__FILE__) . "/";
/*
Prefix for uploaded file names. You can specify a prefix for the uploaded files, this is optional. This will only be applied to files uploaded to your server, not to files sent as attachments. You can hard-code a prefix or you can use a value from your form. To hard-code a prefix, put it in quotes like so: $uploaded_file_prefix = "user_file_"; This prefix name will be applied to EVERY file uploaded. You might find it useful to prefix the file name with the user's name. You can do so like this: $uploaded_file_prefix = $_REQUEST['name']; This assumes that the name input on your form is "name", otherwise change it to suit. You can prefix it with any value from your form, just change 'name' in this example with the name of the field from your form. To make the file name more readable, you can put an underscore after the prefix like so: $uploaded_file_prefix = $_REQUEST['name'] . "_"; You can use more than one form value and separate them with underscores like so: $uploaded_file_prefix = $_REQUEST['firstname'] . "_" . $_REQUEST['lastname']; (The example assumes you have the inputs "firstname" and "lastname" on your form).
*/
$uploaded_file_prefix = "";
/*
Show attachments in the email body. If files are uploaded from your form and sent as an attachment to the email from the script, you can choose to show the file names in the body (message) of the email. This is independent of the way the file names are displayed when uploading them to your server (information on that above). This setting only applies to files uploaded and sent as attachments. If enabled it will show the name of the file input from your form and the corresponding file name that was uploaded. Same goes for one or multiple file inputs. By default it is enabled. Default setting: $show_attachments_in_email_body = 1; To disable it, change the 1 to 0 below, like so: $show_attachments_in_email_body = 0;
*/
$show_attachments_in_email_body = 1;
/*
End of configuration options.
Step 4:
-------
Upload the files to your webspace.
Save this file (formtoemailpro.php) and upload it together with your webpage (containing the form) to your webspace. If you are using your own form, remember to change the form action to formtoemailpro.php - <form action="formtoemailpro.php" etc>. Put the files in the same directory (folder). You do not need to set permissions for the script.
THAT'S IT, FINISHED!
You do not need to make any changes below this line.
*/
$errors = array();
$attachment_array = array();
// Remove $_COOKIE elements from $_REQUEST.
if(count($_COOKIE)){foreach(array_keys($_COOKIE) as $value){unset($_REQUEST[$value]);}}
// Check reCAPTCHA
if($reCAPTCHA)
{
require_once('recaptchalib.php');
$resp = recaptcha_check_answer($privatekey,$_SERVER["REMOTE_ADDR"],$_REQUEST["recaptcha_challenge_field"],$_REQUEST["recaptcha_response_field"]);
if(!$resp->is_valid)
{
$errors[] = "The reCAPTCHA wasn't entered correctly. Go back and try it again (reCAPTCHA said: " . $resp->error . ")";
}
}
// Remove ignored fields from $_REQUEST.
if($ignore_fields)
{
foreach($fields_to_ignore as $value){if(isset($_REQUEST[$value])){unset($_REQUEST[$value]);}}
}
// Confirm email address.
if($confirm_email_address)
{
if(isset($_REQUEST['email']) || isset($_REQUEST['email2']))
{
if($_REQUEST['email'] != $_REQUEST['email2']){$errors[] = "Please correctly confirm your email address";}else{unset($_REQUEST['email2']);}
}
}
// Validate email field.
//$blackList = array("gmail.com","yahoo.com","live.com","me.com", "mail.com", "test.com", "hotmail.com", "hotmail.it", "hotmail.co.uk","verizon.net", "gmx.net", "gmx.com","googlemail.com")
$blackList = array("");

$emailAddress = $_POST['email']; // Don't use REQUEST if you don't have to; use $_GET or $_POST (Whichever is correct)

$domainArray = explode("@",$emailAddress);

$emailDomain = $domainArray[1];

if(in_array($emailDomain,$blackList))
{
    exit("We do not accept free domain email addresses, please go back and enter your work email address.");
}
   else{$exploded_email = explode("@",$_REQUEST['email']);
if(empty($exploded_email[0]) || strlen($exploded_email[0]) > 64 || 
empty($exploded_email[1])){$errors[] = "Email address is invalid";}
else{if(substr_count($exploded_email[1],".") == 0){$errors[] = "Email address is invalid";}
else{$exploded_domain = explode(".",$exploded_email[1]);
if(in_array("",$exploded_domain)){$errors[] = "Email address is invalid";}

else{foreach($exploded_domain as $value){if(strlen($value) > 63 || !preg_match('/^[a-z0-9-]+$/i',$value)){$errors[] = "Email address is invalid"; break;}}}}}}
 

// Test for cookie.
if($require_cookie)
{
if(!isset($_COOKIE['formtoemailpro'])){$errors[] = "You must enable cookies to use the form";}
}
// Check referrer.
if($check_referrer)
{
if(!(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && stristr($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST']))){$errors[] = "You must enable referrer logging to use the form";}
}
// Check for required fields. If none, don't allow blank form to be sent.
if($required_fields_check)
{
foreach($required_fields as $value){if((!isset($_REQUEST[$value]) || empty($_REQUEST[$value])) && (!isset($_FILES[$value]['name']) || empty($_FILES[$value]['name']))){$errors[] = "Please go back and complete the $value field";}}
}else{
// Check for a blank form.
function recursive_array_check_blank($element_value)
{
global $set;
if(!is_array($element_value)){if(!empty($element_value)){$set = 1;}}
else
{
foreach($element_value as $value){if($set){break;} recursive_array_check_blank($value);}
}
}
recursive_array_check_blank($_REQUEST);
if(!$set){$errors[] = "You cannot send a blank form";}
unset($set);
}
// Check for banned IPs.
if($banned_ips_check)
{
foreach($banned_ips as $value)
{
if($value == substr($_SERVER[REMOTE_ADDR], 0, strlen($value))){$errors[] = $banned_ip_message; break;}
}
}
// Check for gibberish.
if($gibberish_check)
{
$vowels = array('a','e','i','o','u');
$consonants = array('b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','v','w','x','y','z');
function recursive_array_gibberish_check($element_value)
{
global $set;
global $vowels;
global $consonants;
global $return_value;
global $gibberish_threshold;
$consecutive_consonant_count = 0;
$consecutive_vowel_count = 0;
if(!is_array($element_value))
{
$exploded_value = explode(" ",$element_value);
foreach($exploded_value as $word_to_check)
{
if((strlen($word_to_check) >= $gibberish_threshold) && (!is_numeric($word_to_check)))
{
// in_array() is case sensitive. Convert input to lower case.
$word_to_check = strtolower($word_to_check);
for($i = 0; $i < strlen($word_to_check); $i++)
{
if(in_array($word_to_check[$i],$vowels)){$consecutive_consonant_count = 0; $consecutive_vowel_count++; if($consecutive_vowel_count == $gibberish_threshold){$set = 1; $return_value = $word_to_check; break;}}elseif(in_array($word_to_check[$i],$consonants)){$consecutive_vowel_count = 0; $consecutive_consonant_count++; if($consecutive_consonant_count == $gibberish_threshold){$set = 1; $return_value = $word_to_check; break;}}else{if($word_to_check[$i] == "@" || $word_to_check[$i] == "-"){$consecutive_consonant_count = 0; $consecutive_vowel_count = 0;}}
}
}
if($set){break;}
}
}
else
{
foreach($element_value as $value){if($set){break;} recursive_array_gibberish_check($value);}
}
}
recursive_array_gibberish_check($_REQUEST);
if($set){$errors[] = "You have submitted a gibberish word: \"{$return_value}\"";}
unset($set);
unset($return_value);
}
// Check all fields for gobbledegook.
if($gobbledegook_check)
{
$gobbledegook_alphabet = array('¡','¢','¤','¦','§','¨','ª','«','¬','®','¯','°','±','²','³','µ','¶','·','¸','¹','º','»','¼','½','¾','¿','À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','×','Ø','Ù','Ú','Û','Ü','Ý','Þ','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ð','ñ','ó','õ','ö','÷','ø','ú','û','ü','ý','þ');
function recursive_array_check_gobbledegook($element_value,$inkey = "")
{
global $set;
global $gobbledegook_alphabet;
global $return_value;
global $return_key;
if(!is_array($element_value))
{
foreach($gobbledegook_alphabet as $value){if(stristr($element_value,$value)){$set = 1; $return_value = $value; $return_key = $inkey; break;}}
}else{
foreach($element_value as $key => $value){if($set){break;} recursive_array_check_gobbledegook($value,$key);}
}
}
recursive_array_check_gobbledegook($_REQUEST);
if($set){if(is_numeric($return_key)){$errors[] = "You have entered an invalid character ($return_value)";}else{$errors[] = "You have entered an invalid character ($return_value) in the \"$return_key\" field";}}
unset($set);
unset($return_value);
unset($return_key);
}
// Check for blocked words/web addresses.
if($word_block)
{
function recursive_array_check_word_block($element_value,$inkey = "")
{
global $set;
global $blocked_words;
global $return_value;
global $return_key;
if(!is_array($element_value))
{
foreach($blocked_words as $value){if(stristr($element_value,$value)){$set = 1; $return_value = $value; $return_key = $inkey; break;}}
}else{
foreach($element_value as $key => $value){if($set){break;} recursive_array_check_word_block($value,$key);}
}
}
recursive_array_check_word_block($_REQUEST);
if($set){if(is_numeric($return_key)){$errors[] = "You have entered an invalid string ($return_value)";}else{$errors[] = "You have entered an invalid string ($return_value) in the \"$return_key\" field";}}
unset($set);
unset($return_value);
unset($return_key);
}
// Check for blocked/allowed file types and check file size.
if(count($_FILES))
{
if($block_file_types)
{
foreach(array_keys($_FILES) as $value)
{
if(!empty($_FILES[$value]['name']))
{
if(in_array(strtolower(strrchr($_FILES[$value]['name'],".")),$file_types_to_block))
{
$disallowed_filetype = strrchr($_FILES[$value]['name'],"."); $errors[] = "{$disallowed_filetype} file types are not permitted. The file \"{$_FILES[$value]['name']}\" cannot be uploaded.";
}
}
}
}
if($allow_file_types)
{
foreach(array_keys($_FILES) as $value)
{
if(!empty($_FILES[$value]['name']))
{
if(!in_array(strtolower(strrchr($_FILES[$value]['name'],".")),$file_types_to_allow))
{
$disallowed_filetype = strrchr($_FILES[$value]['name'],"."); $errors[] = "{$disallowed_filetype} file types are not permitted. The file \"{$_FILES[$value]['name']}\" cannot be uploaded.";
}
}
}
}
if($max_file_size)
{
foreach(array_keys($_FILES) as $value)
{
if(!empty($_FILES[$value]['size'])){if($_FILES[$value]['size'] > $max_file_size){$errors[] = "File \"{$_FILES[$value]['name']}\" exceeds the maximum file size of {$max_file_size} bytes.";}}
}
}
}
// Display any errors and exit if errors exist.
if(count($errors)){foreach($errors as $value){print "$value<br>";} exit;}
if(!defined("PHP_EOL")){define("PHP_EOL", strtoupper(substr(PHP_OS,0,3) == "WIN") ? "\r\n" : "\n");}
if($line_spacing){$line_space = PHP_EOL.PHP_EOL;}else{$line_space = PHP_EOL;}
// HTML format the output.
if($html_format)
{
// Allow posted HTML code to be displayed (and not executed). Convenient time to do nl2br.
function recursive_array_check_HTML(&$element_value)
{
if(!is_array($element_value)){$element_value = nl2br(htmlspecialchars($element_value));}
else
{
foreach($element_value as $key => $value){$element_value[$key] = recursive_array_check_HTML($value);}
}
return $element_value;
}
recursive_array_check_HTML($_REQUEST);
$html_open = "<html><head><title>$subject</title></head><body><table cellpadding=\"".$table_cellpadding."\" cellspacing=\"".$table_cellspacing."\" bgcolor=\"".$table_background_color."\">";
 $html_close = "</table><!--Add the following script at the bottom of the web page (before </body></html>)-->
<script type='text/javascript' async defer data-cfasync='false' src='https://mylivechat.com/chatwidget.aspx?hccid=85846151'></script>

  </body>
</html>"; $content_type = "html";}else{$html_open = ""; $colon_sep = ": "; $html_close = ""; $content_type = "plain";}
function build_message($request_input)
{
global $colon_sep;
global $html_format;
global $table_left_column_color;
global $table_left_column_font;
global $table_left_column_font_size;
global $table_left_column_font_color;
global $table_right_column_color;
global $table_right_column_font;
global $table_right_column_font_size;
global $table_right_column_font_color;
global $line_space;
global $show_blank_fields;
if(!isset($message_output)){$message_output = "";}if(!is_array($request_input)){$message_output = $request_input;}else{foreach($request_input as $key => $value){if(!empty($value) || $show_blank_fields){if($html_format){if(!is_numeric($key)){$message_output .= "<tr><td valign=\"top\" bgcolor=\"".$table_left_column_color."\" nowrap><font face=\"".$table_left_column_font."\" size=\"".$table_left_column_font_size."\" color=\"".$table_left_column_font_color."\"><b>".str_replace("_"," ",ucfirst($key))."</b></font></td><td bgcolor=\"".$table_right_column_color."\"><font face=\"".$table_right_column_font."\" size=\"".$table_right_column_font_size."\" color=\"".$table_right_column_font_color."\">".build_message($value)."</font></td></tr>".PHP_EOL;}else{$message_output .= "<table><tr><td><font face=\"".$table_right_column_font."\" size=\"".$table_right_column_font_size."\" color=\"".$table_right_column_font_color."\">".build_message($value)."</font></td></tr></table>";}}else{if(!is_numeric($key)){$message_output .= str_replace("_"," ",ucfirst($key)).$colon_sep.build_message($value).$line_space;}else{$message_output .= build_message($value).", ";}}}}}return rtrim($message_output,", ");
}
if($sort_fields)
{
$ordered_request = array();
foreach($field_order_keys as $value){$ordered_request[$value] = $_REQUEST[$value];}
$_REQUEST = $ordered_request;
}
// Show ATTACHMENTS in body of email.
if($show_attachments_in_email_body && count($_FILES) && !$upload_files_to_server)
{
foreach(array_keys($_FILES) as $value){if(!empty($_FILES[$value]['tmp_name'])){$_REQUEST[$value] = $_FILES[$value]['name'];}}
}
// Show FILE UPLOADS in body of email.
if(count($_FILES) && $upload_files_to_server)
{
if(substr_count($path_to_uploaded_file,$_SERVER['DOCUMENT_ROOT']))
{
$web_location = str_replace($_SERVER['DOCUMENT_ROOT'],"",$path_to_uploaded_file);
if($html_format)
{
foreach(array_keys($_FILES) as $value){if(!empty($_FILES[$value]['tmp_name'])){$_REQUEST[$value] = "<a href=\"http://".$_SERVER['HTTP_HOST'].$web_location.$uploaded_file_prefix.$_FILES[$value]['name']."\">{$uploaded_file_prefix}{$_FILES[$value]['name']}</a>";}}
}
else
{
foreach(array_keys($_FILES) as $value){if(!empty($_FILES[$value]['tmp_name'])){$_REQUEST[$value] = "http://".$_SERVER['HTTP_HOST'].$web_location.$uploaded_file_prefix.$_FILES[$value]['name'];}}
}
}
else
{
foreach(array_keys($_FILES) as $value){if(!empty($_FILES[$value]['tmp_name'])){$_REQUEST[$value] = $uploaded_file_prefix.$_FILES[$value]['name'];}}
}
}
// Show sender's IP address.
if($show_ip){$_REQUEST["Sender's IP address"] = $_SERVER[REMOTE_ADDR];}
$message = $html_open;
$message .= build_message($_REQUEST);
$message .= $html_close;
// Strip slashes.
$message = stripslashes($message);
$from_name = "";
if(isset($_REQUEST['name']) && !empty($_REQUEST['name'])){$from_name = stripslashes($_REQUEST['name']); if($encode_name_subject){$from_name = "=?{$character_set}?B?".base64_encode($_REQUEST['name'])."?=";}}
$headers = "From: {$from_name} <{$_REQUEST['email']}>";
$headers .= PHP_EOL;
$headers .= "MIME-Version: 1.0";
if($csv_attachment || $csv_file_on_server)
{
function build_file_data($data_input)
{
if(!isset($file_data)){$file_data = "";}if(!is_array($data_input)){if(stristr($data_input,'"')){$data_input = str_replace('"','""',$data_input);} if(stristr($data_input,'"') || stristr($data_input,",") || stristr($data_input,"\n") || stristr($data_input,"\r\n")){$file_data = "\"$data_input\"";}else{$file_data = $data_input;}}else{foreach($data_input as $key => $value){if(!is_numeric($key)){$file_data .= build_file_data($value).",";}else{$file_data .= build_file_data($value)." :: ";}}}return rtrim(rtrim($file_data,",")," :: ");
}
}
if(count($_FILES) || $csv_attachment)
{
if(count($_FILES))
{
if($upload_files_to_server)
{
foreach(array_keys($_FILES) as $value){if(!empty($_FILES[$value]['tmp_name'])){move_uploaded_file($_FILES[$value]['tmp_name'], $path_to_uploaded_file.$uploaded_file_prefix.$_FILES[$value]['name']);}}
}
else
{
foreach(array_keys($_FILES) as $value)
{
if(is_uploaded_file($_FILES[$value]['tmp_name']))
{
$file = fopen($_FILES[$value]['tmp_name'],'rb');
$data = fread($file,filesize($_FILES[$value]['tmp_name']));
fclose($file);
$data = chunk_split(base64_encode($data));
$attachment_array[] = "--boundary_sdfsfsdfs345345sfsgs".PHP_EOL."Content-Type: ".$_FILES[$value]['type'].";".PHP_EOL." name=\"".$_FILES[$value]['name']."\"".PHP_EOL."Content-Disposition: attachment;".PHP_EOL." filename=\"".$_FILES[$value]['name']."\"".PHP_EOL."Content-Transfer-Encoding: base64".PHP_EOL.PHP_EOL.$data.PHP_EOL.PHP_EOL;
}
}
}
}
if(count($attachment_array) || $csv_attachment)
{
$headers .= PHP_EOL;
$headers .= "Content-Type: multipart/mixed;".PHP_EOL;
$headers .= " boundary=\"boundary_sdfsfsdfs345345sfsgs\"";
$body = "";
$body .= "--boundary_sdfsfsdfs345345sfsgs".PHP_EOL;
$body .= "Content-Type: text/".$content_type."; charset=\"{$character_set}\"".PHP_EOL.PHP_EOL;
$body .= $message.PHP_EOL.PHP_EOL;
if(count($attachment_array)){foreach($attachment_array as $value){$body .= $value;}}
if($csv_attachment)
{
// Comma separate the keys (doesn't need to be recursive).
$data = "";
foreach(array_keys($_REQUEST) as $value){$data .= "$value,";}
// Remove trailing comma.
$data = rtrim($data,",");
$data .= PHP_EOL;
$data .= stripslashes(build_file_data($_REQUEST));
$body .= "--boundary_sdfsfsdfs345345sfsgs".PHP_EOL."Content-Type: text/plain; charset=\"{$character_set}\"".PHP_EOL." name=\"$csv_filename\"".PHP_EOL."Content-Disposition: attachment;".PHP_EOL." filename=\"$csv_filename\"".PHP_EOL.PHP_EOL.$data.PHP_EOL.PHP_EOL;
}
$body .= "--boundary_sdfsfsdfs345345sfsgs--";
$message = $body;
}
}
if(!count($attachment_array) && !$csv_attachment)
{
$headers .= PHP_EOL;
$headers .= "Content-Type: text/{$content_type}; charset=\"{$character_set}\"";
}
if($bcc)
{
$headers .= PHP_EOL;
$headers .= "Bcc: " . $bcc;
}
$subject = stripslashes($subject);
if($encode_name_subject){$subject = "=?{$character_set}?B?".base64_encode($subject)."?=";}
// Send email.
mail($my_email,$subject,$message,$headers);
// Send autoresponse.
if($autoresponder && isset($_REQUEST['email']) && !empty($_REQUEST['email']))
{
// Remove visitor's IP address if present.
if(isset($_REQUEST["Sender's IP address"])){unset($_REQUEST["Sender's IP address"]);}
if($autoresponder_from){$my_email = $autoresponder_from;}
$headers = "From: " . $my_email;
$headers .= PHP_EOL;
$headers .= "MIME-Version: 1.0".PHP_EOL;
$headers .= "Content-Type: text/{$content_type}; charset=\"{$character_set}\"";
if($html_format)
{
$html_open = "<html><head><title>$autoresponder_subject</title></head><body><p><font face=\"".$autoresponder_font."\" size=\"".$autoresponder_font_size."\" color=\"".$autoresponder_font_color."\">$autoresponder_header_message</font></p><table cellpadding=\"".$table_cellpadding."\" cellspacing=\"".$table_cellspacing."\" bgcolor=\"".$table_background_color."\">";
 $html_close = "</table><p><font face=\"".$autoresponder_font."\" size=\"".$autoresponder_font_size."\" color=\"".$autoresponder_font_color."\">$autoresponder_footer_message</font></p><!--Add the following script at the bottom of the web page (before </body></html>)-->
<script type='text/javascript' async defer data-cfasync='false' src='https://mylivechat.com/chatwidget.aspx?hccid=85846151'></script>
</body>
</html>";
$message = $html_open;
$message .= build_message($_REQUEST);
$message .= $html_close;
}else{$message = $autoresponder_header_message . PHP_EOL.PHP_EOL . build_message($_REQUEST) . $autoresponder_footer_message;}
$message = stripslashes($message);
if($autoresponder_attachment)
{
$file = fopen($autoresponder_attachment_path.$autoresponder_attachment_file,'rb');
$data = fread($file,filesize($autoresponder_attachment_path.$autoresponder_attachment_file));
fclose($file);
$data = chunk_split(base64_encode($data));
$headers = "From: " . $my_email;
$headers .= PHP_EOL;
$headers .= "MIME-Version: 1.0".PHP_EOL;
$headers .= "Content-Type: multipart/mixed;".PHP_EOL;
$headers .= " boundary=\"boundary_sdfsfsdfs345345sfsgs\"";
$body = "";
$body .= "--boundary_sdfsfsdfs345345sfsgs".PHP_EOL;
$body .= "Content-Type: text/".$content_type."; charset=\"{$character_set}\"".PHP_EOL.PHP_EOL;
$body .= $message.PHP_EOL.PHP_EOL;
$body .= "--boundary_sdfsfsdfs345345sfsgs".PHP_EOL."Content-Type: ".$autoresponder_attachment_content_type.";".PHP_EOL." name=\"".$autoresponder_attachment_file."\"".PHP_EOL."Content-Disposition: attachment;".PHP_EOL." filename=\"".$autoresponder_attachment_file."\"".PHP_EOL."Content-Transfer-Encoding: base64".PHP_EOL.PHP_EOL.$data.PHP_EOL.PHP_EOL;
$body .= "--boundary_sdfsfsdfs345345sfsgs--";
$message = $body;
}
// Use the fifth parameter for those services that need it, like AOL for example. Only allow one email address in the fifth parameter. Check for commas and explode on them if they exist.
if(substr_count($my_email,",") > 0){$my_email = explode(",",$my_email); $my_email = $my_email[0];}
$autoresponder_subject = stripslashes($autoresponder_subject);
mail($_REQUEST['email'],$autoresponder_subject,$message,$headers,"-f{$my_email}");
}
// Write to CSV file.
if($csv_file_on_server)
{
// If file does not exist, create it and write header row.
if(!file_exists($path_to_csv_file.$csv_filename))
{
$data = "";
foreach(array_keys($_REQUEST) as $value){$data .= "$value,";}
// Remove trailing comma.
$data = rtrim($data,",");
$data .= "\r\n";
$handle = fopen($path_to_csv_file.$csv_filename, "a");
fwrite($handle,$data);
fclose($handle);
}
// Write data row.
$data = "";
$data .= stripslashes(build_file_data($_REQUEST));
$data .= "\r\n";
$handle = fopen($path_to_csv_file.$csv_filename, "a");
fwrite($handle,$data);
fclose($handle);
}
// Redirect or display "thank you" message.
if($auto_redirect){header("location: $redirect_url"); exit;}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">



<html>
    <head>
    <link rel="shortcut icon" href="../img/logo/favicon.ico" type="image/x-icon" />                 
    <link rel="icon" href="img/logo/favicon.ico" type="image/x-icon">
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <!--styles-->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600|Damion&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link href="../css/styletwo.css" rel="stylesheet" type="text/css" />
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!--scripts-->
        <script src="../js/html5shiv.js"></script>
        <script src="../js/jquery.js" type="text/javascript"></script>
        <script src="../js/modernizer.js" type="text/javascript"></script>
        <script src="../js/functions.js" type="text/javascript"></script>
        <script src="../js/bootstrap.min.js" type="text/javascript"></script><script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54448404-1', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>
      </head>
    <body>

        <div class="container-fluid">
            <div id="header" class="row header">
                <div class="header-inner">
                    <!--header-->
                    <div id="logo-container">
                        <center><img src="../img/logo/Locatiblemark-WHITE.png" alt="logo"width="199" height="95" id="logo"></center>
                    </div>
                    <!--headline-->
                    <div id="headline" class="headline">Thank You</div>
                    <div id="subheadline" class="subheadline">Thank you for emailing through. We will keep you updated.<br >
                    Please check you spam box, and add us to allowed (white box) preventing our emails to go into your inbox.
              
                    </div>
                </div>
            </div>
            <!--social-->
            
            <!--hosts-->
            <div id="hosts" class="row hosts">
                <div id="host01" class="row host">
                    <img id="host-image01" src="../img/ronan.png" alt="" class="col-xs-6 col-md-4">
                    <div id="host-quote01" class="col-xs-12 col-md-8 quote-text">-See you soon!</div>
                </div>
                
            </div>
            <!--footer-->
            <div id="footer" class="row footer">
                <a id="tw-link" href="https://twitter.com/locatible"><img src="../img/tw-icon.png" alt="" class="tw-icon"></a>
                 <a id="fb-link" href="https://www.facebook.com/locatible?_rdr"><img src="../img/fb-icon.png" alt="" class="fb-icon"></a>
                <div id="copyright" class="copyright-text">Copyright &copy; 2019 lindacrean.com&trade;</div>
                <div id="host-quote01" class="col-xs-12 col-md-8 quote-text">-You will be automatically re-directed.<a href="http://www.locatible.com/">If not click here</a></div>
            </div>
        </div>
       

<script type="text/javascript">
var timer = 6; //seconds
 website = "http://www.lindacrean.com"
function delayer() {
 window.location = website;
}
setTimeout('delayer()', 1000 * timer); 
</script>




    
  </body>
</html>