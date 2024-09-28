<?php



//Import PHPMailer classes into the global namespace

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\SMTP;

use PHPMailer\PHPMailer\OAuth;



// Alias the League Google OAuth2 provider class

use League\OAuth2\Client\Provider\Google;



//SMTP needs accurate times, and the PHP time zone MUST be set

//This should be done in your php.ini, but this is how to do it if you don't have access to that

date_default_timezone_set('Etc/UTC');

// Load Composer's autoloader

require '../composer/vendor/autoload.php';






	$con=mysqli_connect("SERVER","USER","PASSWORD","DB");



$day=date("d");

$month=date("m");



$query="SELECT * FROM table WHERE date='$day-$month' AND suscription=1";



$result= mysqli_query($con,$query);

while ($row = @mysqli_fetch_assoc($result)){

	unset($id);

	unset($nombre);

	unset($mail1);

	unset($mail2);

	unset($mail3);

	

	$id=$row['id'];

	$nombre=$row['nombre'];

	$mail1=$row['mail1'];

	$mail2=$row['mail2'];

	$mail3=$row['mail3'];

	

if (($mail1!="")||($mail2!="")||($mail3!="")){

	

	

	

$mail = new PHPMailer;

$mail->isSMTP();



$mail->AuthType = 'XOAUTH2';

$mail->Host = 'smtp.gmail.com';

$mail->Port = 587;

$mail->SMTPSecure = "tls";

$mail->SMTPAuth = true;



$email="***@gmail.com";

	// Get this data from googleapis
	
$clientId = 'CLIENTID';

$clientSecret = 'CLIENTSECRET';

$refreshToken = 'REFRESHTOKEN';



//Create a new OAuth2 provider instance

$provider = new Google(

    [

        'clientId' => $clientId,

        'clientSecret' => $clientSecret,

    ]

);



//Pass the OAuth provider instance to PHPMailer

$mail->setOAuth(

    new OAuth(

        [

            'provider' => $provider,

            'clientId' => $clientId,

            'clientSecret' => $clientSecret,

            'refreshToken' => $refreshToken,

            'userName' => $email,

        ]

    )

);





$mail->setFrom($email, 'DISPLAY NAME');

$mail->addReplyTo('...@gmail.com', 'DISPLAY NAME');

if ($mail1!=""){

$mail->addAddress($mail1, $nombre);

}

if ($mail2!=""){

$mail->addAddress($mail2, $nombre);

}

if ($mail3!=""){

$mail->addAddress($mail3, $nombre);

}

$mail->AddEmbeddedImage('img/1.jpg', 'parte_top');

$mail->AddEmbeddedImage('img/2.jpg', 'parte_izq');

$mail->AddEmbeddedImage('img/3.jpg', 'parte_der');

$mail->AddEmbeddedImage('img/4.jpg', 'parte_bottom');

$mail->IsHTML(true);

$mail->CharSet = 'UTF-8';

$mail->Subject = 'SUBJECT';

$content="

 <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=3Dhttp://www.w3.org/1999/xhtml>

 <head>

 <meta http-equiv=3DContent-Type content=3D\"text/html; charset=3Dutf-8\"><meta name=3Dviewport content=3D\"width=3Ddevice-width,initial-scale=3D1,minimum-scale=3D1,maximum-scale=3D1\"><meta name=3Dformat-detection content=3D\"telephone=3Dno\"><title>TITLE</title>

 <meta name='color-scheme' content='light dark'>

<meta name='supported-color-schemes' content='light dark'>

     <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->

	

	 <style type='text/css'>



	:root {

    color-scheme: light dark;

    supported-color-schemes: light dark;

  }

				@media (prefers-color-scheme: dark) {

		/* Your dark mode styles: */



		.textoo {

			background: #FFF !important;

			color: #000 !important;

		}

}

	

		.textoo {

			background: #FFF !important;

			color: #000 !important;

		}

	

			</style>

	

	 <!--[if mso]>

	 <style type='text/css'>

	 	@media (prefers-color-scheme:  light) {

		html {

			background: #FFFFFF !important;

			font-color: #000001 !important;

			}

			}

			

			

	}

			</style>

		<![endif]-->

	 

    <!--[if mso]>

    <style>

        * {

            font-family: Georgia !important;

        }

    </style>

    <![endif]-->



    <!--[if !mso]><!-->

    <link href='https://WEBURL/poorrichard.css' rel='stylesheet'>

    <!--<![endif]-->

    </head>

	<body>

	<table border='0' cellspacing='0' cellpadding='0' style='max-width: 700px; width: 50%; height: 50%; border: none;   border-collapse: collapse;  padding: 0;  margin: 0; text-align: center;' align='center'>

    	<tr ><td colspan='3' ><img style='display: block;' src='cid:parte_top' /></td></tr>

    	<tr ><td><img src='cid:parte_izq'  style='display: block;' /></td><td  class='textoo' style=\"font-family: 'poor_richardregular', Georgia, serif;  display: block; 

			font-size: 60px; font-weight:bold; color: #000; letter-spacing: 4px; text-align: center;\">_____!</td><td style='text-align: right;'><img style='display: block; float: right' src='cid:parte_der' /></td></tr>

    		<tr ><td colspan='3'><img  style='display: block;' src='cid:parte_bottom' /></td></tr>


		<tr><td colspan='3'>   <div style='margin:auto;text-align: center;'>Si deseas desuscribirte hace click <a href='UNSUSCRIBEURL'>ac&aacute;</a></div>   </td></tr>

    </table>

	

	</body>

	</html>

";





//Read an HTML message body from an external file, convert referenced images to embedded,

//convert HTML into a basic plain-text alternative body

$mail->msgHTML($content);

$mail->IsHTML(true);

//Replace the plain text body with one created manually

$mail->AltBody = 'ALTBODY';





//send the message, check for errors

if (!$mail->send()) {

    echo 'Mailer Error: '. $mail->ErrorInfo;

} else {

    echo 'Message sent!';

   }





	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

}

	

	

	

	

	

	

	

}















?>



