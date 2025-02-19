<?php
ob_start(); // Start output buffering

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json'); // Set content type to JSON

$full_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($url);
parse_str($parts['query'], $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    // echo $query['email'];

    $ProjectName = "Oberoi Garden City, Thane";
    $link = "bit.ly/OGC-Thne";
    $namenew = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $country = htmlspecialchars($_POST['country'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $type = htmlspecialchars($_POST['type'] ?? '');
    $config = htmlspecialchars($_POST['config'] ?? '');
    $date = htmlspecialchars($_POST['date'] ?? '');
    $source = htmlspecialchars($_POST['utm_source'] ?? '');
    $medium = htmlspecialchars($_POST['utm_medium'] ?? '');
    $campaign = htmlspecialchars($_POST['utm_campaign'] ?? '');
    $term = htmlspecialchars($_POST['utm_term'] ?? '');

    $newphone = str_replace(' ', '', $phone);
    $CountryCode = trim(explode("+", $country)[1]);
    
    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'enquiry.rp@riogapremium.com'; // Your SMTP username
        $mail->Password   = 'koet dmwa mlfg mnbh'; // Your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; // TCP port to connect to
        $mail->SMTPDebug = 0; // Set to 0 for production
        
        $mail->setFrom('enquiry.rp@riogapremium.com', 'Oberoi Garden City, Thane');
        
        // First email to user
        $mail->addAddress($email, $name);
        $mail->Subject = 'Thank you for enquiry - Oberoi Garden City, Thane';
        $mail->isHTML(true);
        $mail->Body = "
            Dear $namenew!,<br>
            <br>
            Warm greetings!<br>
            <br>
            Thank you for expressing your interest in Oberoi Garden City, Thane. We have received your request and one of our dedicated sales experts will reach out to you within the next 30 minutes to provide detailed information about the project.<br>
            <br>
            Should you wish to speak to us directly in the meantime, feel free to call us at +919867160002 or<br>
            <a href='https://wa.me/+919867160002?text=I’m+interested+in+the+Oberoi+Garden+City+project.+Please+send+brochure+and+price+details.'>Click Here to instantly Connect on WhatsApp</a><br>
            <br>
            We look forward to assisting you!<br>
            <br>
            Note: This this is automated Email Please do not reply.<br>
        ";
        $mail->send();

        // Clear all addresses for the next email
        $mail->clearAddresses();

        // Email 2: To another recipient (e.g., your team)
        $recipients = [
            'yashs@riogapremium.com' => 'Yash Suryawanshi',
            'info@riogapremium.com' => 'Rioga Premium',
            'aasims@riogapremium.com' => 'Aasim S',
            // 'riteshk@riogapremium.com' => 'Ritesh K',
            // 'faisalg@riogapremium.com' => 'Mohit A',
            // 'sunilu@riogapremium.com' => 'Sunil U',
            // 'vishalp@riogapremium.com' => 'Vishal P',
        ];

        foreach ($recipients as $emailAddress => $name) {
            $mail->addAddress($emailAddress, $name); // Add each recipient
        }
        
        $mail->Subject = 'Lead Alert - Oberoi Garden City, Thane';
        $mail->Body = "
            Hi,<br>
            <br>
            Here are the Lead details of Oberoi Garden City, Thane<br>
            <br><br>
            Full Name: $namenew<br><br>
            Country: $country<br><br>
            Phone Number: $phone<br><br>
            Email : $email<br><br>
            Enquired About: $type<br><br>
            Configuration: $config<br><br>
            Site Visit Date: $date<br><br>
            UTM Medium: $medium<br><br>
            UTM Term: $term<br><br>
            UTM Source: $source<br><br>
            UTM Campaign: $campaign<br><br>
        ";
        $mail->send();

        echo json_encode(['status' => 'success', 'message' => 'Messages have been sent']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }


    // smscodeStarts

    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n  \"template_id\": \"670cdedfd6fc05311a306bc2\",\n  
    \"short_url\": \"1\",\n  
    \"realTimeResponse\": \"1\", \n  
    \"recipients\": [\n    {\n      
    \"mobiles\": \"91".$newphone."\",\n      
    \"name\": \"".$ProjectName."\",\n      
    \"number\": \"%2B91 9867160002\",\n      
    \"link\": \"".$link."\"\n    }\n  ]\n}",
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authkey: 431698AxW1T03gVCR6704f714P1",
        "content-type: application/json"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
    echo $response;
    }



    // Send SMS to Sales Team


    

    $curl = curl_init();
    
    curl_setopt_array($curl, [
    CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n  \"template_id\": \"67063c42d6fc055d97488112\",\n  
    \"short_url\": \"1\",\n  
    \"realTimeResponse\": \"1\", \n  
    \"recipients\": [\n    {\n      
    \"mobiles\": \"919867160002, 919765277792\",\n      
    \"projname\": \"".$ProjectName."\",\n      
    \"name\": \"".$namenew."\",\n     
    \"email\": \"".$email."\",\n      
    \"mobile\": \"%2B".$CountryCode." ".$newphone."\"\n    }\n  ]\n}",
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authkey: 431698AxW1T03gVCR6704f714P1",
        "content-type: application/json"
        ],
      ]);
      
      $response = curl_exec($curl);
      $err = curl_error($curl);
      
      curl_close($curl);
      
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        echo $response;
      }


// smscodeEnds
}

ob_end_flush(); // Flush the output buffer

?>
