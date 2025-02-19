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

    $ProjectName = "";
    $link = "";
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
    $subprojname = htmlspecialchars($_POST['projname'] ?? '');
    $term = htmlspecialchars($_POST['utm_term'] ?? '');

    $combineproj = $ProjectName.' '.$subprojname;

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
        
        $mail->setFrom('enquiry.rp@riogapremium.com', $combineproj);
        
        // First email to user
        $mail->addAddress($email, $name);
        $mail->Subject = 'Thank you for enquiry - '.$combineproj;
        $mail->isHTML(true);
        $mail->Body = "
            Dear $namenew!,<br>
            <br>
            Warm greetings!<br>
            <br>
            Thank you for expressing your interest in $combineproj. We have received your request and one of our dedicated sales experts will reach out to you within the next 30 minutes to provide detailed information about the project.<br>
            <br>
            Should you wish to speak to us directly in the meantime, feel free to call us at +917738055388 or<br>
            <a href='https://wa.me/+917738055388?text=I’m+interested+to+know+about+projects+in+dadar-wadala.+Please+send+brochure+and+price+details.'>Click Here to instantly Connect on WhatsApp</a><br>
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
            // 'amitr@riogapremium.com' => 'Amit Rajpal',
            'info@riogapremium.com' => 'Rioga Premium',
            'kokilat@riogapremium.com' => 'Kokila T',
            // 'minakshiv@riogapremium.com' => 'Hitesh J',
            // 'riteshk@riogapremium.com' => 'Ritesh K',
            // 'faisalg@riogapremium.com' => 'Mohit A',
            // 'sunilu@riogapremium.com' => 'Sunil U',
            // 'vishalp@riogapremium.com' => 'Vishal P',
        ];

        foreach ($recipients as $emailAddress => $name) {
            $mail->addAddress($emailAddress, $name); // Add each recipient
        }
        
        $mail->Subject = 'Lead Alert - '.$combineproj;
        $mail->Body = "
            Hi,<br>
            <br>
            Here are the Lead details of $combineproj<br>
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
    \"name\": \"".$combineproj."\",\n      
    \"number\": \"%2B91 7738055388\",\n      
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
    \"mobiles\": \"917738055388, 919765277792\",\n      
    \"projname\": \"".$combineproj."\",\n      
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




// Salesforce Integration

function salesforce_integration($flat_type, $ProjectName, $fullname, $email_id, $country_code, $mobile, $form_type, $site_date, $campaign, $utm_source, $utm_medium, $utm_campaign, $location, $received_on) {
    // $thank_you_url = "https://riogapremium.co/horizon/"; // Set your thank you URL

    // Prepare data for Salesforce
    $params = array(
        "last_name" => $fullname,
        "email" => $email_id,
        "00N2w00000HwGv0" => $country_code, // Country Code
        "mobile" => $mobile,
        "oid" => "00D2w00000EMwCv", // Salesforce Org ID
        // "retURL" => $thank_you_url, // Redirect URL after submission
        "00N2w00000HwGv5" => $flat_type, // Flat Type
        "00N2w00000HwGvA" => $form_type, // Form Type
        "00N2w00000HwGvF" => $site_date, // Site Visit Date
        "00N2w00000HwGvK" => $ProjectName, // Project Name
        "lead_source" => $utm_source, // UTM Source
        "00N2w00000HwGvP" => $utm_campaign, // UTM Campaign
        "00N2w00000HwGvU" => "", // UTM Content
        "00N2w00000HwGvZ" => $utm_medium // UTM Medium
    );

    // Make the HTTP POST request to Salesforce
    httpPost("https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8", $params);
}

/**
 * HTTP POST function to send data to Salesforce
 */
function httpPost($url, $params) {
    $postData = http_build_query($params);

    $opts = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postData
        )
    );

    $context  = stream_context_create($opts);
    $result = file_get_contents($url, false, $context);

    // Log the Salesforce response for debugging
    file_put_contents(__DIR__ . '/console.log', "Salesforce Response: " . $result . "\n", FILE_APPEND);

    return $result;
}


salesforce_integration($config, $combineproj, $namenew, $email, $CountryCode, $newphone, $type, $date, $campaign, $source, $medium, $campaign, $location, $received_on);

}

ob_end_flush(); // Flush the output buffer

?>
