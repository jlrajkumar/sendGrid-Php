

<?php
	// require our config file
	require_once 'config.php';

	// require composer autoload so we can use sendgrid
	require 'vendor/autoload.php';


    
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['tel'];
    $message = $_POST['message']; 

    $contactDetails .= "Name: ".$fname. "<br>" ."<br>" ; 
    $contactDetails .= "Email: ".$email. "<br>" ."<br>" ; 
    $contactDetails .= "Phone: ".$phone.  "<br>" ."<br>"; 
    $contactDetails .= "Message: ".$message;
    

	// create new sendgrid mail
	$email = new \SendGrid\Mail\Mail(); 

	// specify the email/name of where the email is coming from
	$email->setFrom("jlrkumarjaddu@gmail.com" , FROM_NAME );
    

    // set the email subject line
	$email->setSubject( "New Contact Request has received from ${fname} " );

	// specify the email/name we are sending the email to
	$email->addTo( TO_EMAIL, TO_NAME);

    $email->setReplyTo(REPLY_TO); //To be replaced with client email to contact easily

	// add our email body content
//$email->addContent( "text/plain", "Name : " . $fname . "\r\nEmail: " . $email. "\r\nMessage: " .$message );

$email->addContent( "text/plain", "Get the client details here ");

    $email->addContent(
	    "text/html", "<strong> $contactDetails</strong>"
	);
  

	// create new sendgrid
	$sendgrid = new \SendGrid( SENDGRID_API_KEY );

	try {
		// try and send the email
	    $response = $sendgrid->send( $email );

	    // print out response data
	    print $response->statusCode() . "\n";
	   // print_r( $response->headers() );
	   
	} catch ( Exception $e ) {
		// something went wrong so display the error message
	    echo 'Caught exception: '. $e->getMessage() ."\n";
	}

    header("Location:thanks.html");
