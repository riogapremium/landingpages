<?php
ob_start(); // Start output buffering
echo "hi";

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json'); // Set content type to JSON



    $ProjectName = "Lodha Divino";
    $link = "bit.ly/L-Mtnga";
    $namenew = "Yash Test";
    $email = "yashs@riogapremium.com";
    $country = "India +91";
    $phone = "7400493119";
    $newphone = str_replace(' ', '', $phone);
    $type = "Enquire Now";
    $config = "";
    $date = "";
    $source = "";
    $medium = "";
    $campaign = "";
    $term = "";
    $salesnumber = "918291947281";

    $CountryCode = trim(explode("+", $country)[1]);
    
    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit;
    }




// send email to user

    // Initialize cURL session
    $curl = curl_init();
    
    // Set up the cURL options in a more readable way
    curl_setopt_array($curl, [
        // API endpoint to send the email
        CURLOPT_URL => "https://control.msg91.com/api/v5/email/send",
        
        // To return the response as a string instead of outputting it directly
        CURLOPT_RETURNTRANSFER => true,
        
        // Set HTTP version, max redirects, timeout, etc.
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
    
        // Define request type and body (we're sending a POST request)
        CURLOPT_CUSTOMREQUEST => "POST",
        
        // JSON payload containing email data
        CURLOPT_POSTFIELDS => json_encode([
            "recipients" => [
                [
                    "to" => [
                        [
                            "name" => $namenew,
                            "email" => $email
                        ]
                    ],
                    "variables" => [
                        "projname" => $ProjectName,
                        "username" => $namenew,
                        "salesnumber" => $salesnumber,
                        "link" => $link
                    ]
                ],
             
            ],
            
            // "from" details (sender of the email)
            "from" => [
                "name" => $ProjectName,
                "email" => "enquiry.rp@riogapremium.com"
            ],
    
            // Domain for DKIM (DomainKeys Identified Mail) signing
            "domain" => "riogapremium.com",
            
          
    
            // Email template ID to be used
            "template_id" => "thank_you_email_2"
        ]),
        
        // Set HTTP headers
        CURLOPT_HTTPHEADER => [
            "accept: application/json", // Accept JSON response
            "authkey: 431698AxW1T03gVCR6704f714P1", // Your unique API key from Msg91
            "content-type: application/JSON" // Sending JSON data
        ],
    ]);
    
    // Execute the cURL request and capture the response or error
    $response = curl_exec($curl);
    
    // Check for any cURL error
    $err = curl_error($curl);
    
    // Close the cURL session
    curl_close($curl);
    
    // If there's an error, display it, otherwise print the response
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
    
    
    
// Email to sales team


    $curl = curl_init();
    
    // Set up the cURL options in a more readable way
    curl_setopt_array($curl, [
        // API endpoint to send the email
        CURLOPT_URL => "https://control.msg91.com/api/v5/email/send",
        
        // To return the response as a string instead of outputting it directly
        CURLOPT_RETURNTRANSFER => true,
        
        // Set HTTP version, max redirects, timeout, etc.
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
    
        // Define request type and body (we're sending a POST request)
        CURLOPT_CUSTOMREQUEST => "POST",
        
        // JSON payload containing email data
        CURLOPT_POSTFIELDS => json_encode([
            "recipients" => [
                [
                    "to" => [
                        [
                            "name" => "Default",
                            "email" => "yashsuryawanshi619@gmail.com"
                        ],
                        [
                            "name" => "Yash S",
                            "email" => "yashs@riogapremium.com"
                        ],
                        // [
                        //     "name" => "Yash S",
                        //     "email" => "yashs@riogapremium.com"
                        // ]
                    ],
                    "variables" => [
                        "projname" => $ProjectName, 
                        "username" => $namenew,
                        "country" => $country,
                        "newphone" => $newphone,
                        "email" =>  $email,
                        "type" => $type,
                        "config" => $config,
                        "date" => $date,
                        "medium" => $medium,
                        "term" => $term,
                        "source" => $source,
                        "campaign" => $campaign
                    ]
                ],
               
          
            ],
            
            // "from" details (sender of the email)
            "from" => [
                "name" => $ProjectName,
                "email" => "enquiry.rp@riogapremium.com"
            ],
    
            // Domain for DKIM (DomainKeys Identified Mail) signing
            "domain" => "riogapremium.com",
            
          
    
            // Email template ID to be used
            "template_id" => "lead_email_template"
        ]),
        
        // Set HTTP headers
        CURLOPT_HTTPHEADER => [
            "accept: application/json", // Accept JSON response
            "authkey: 431698AxW1T03gVCR6704f714P1", // Your unique API key from Msg91
            "content-type: application/JSON" // Sending JSON data
        ],
    ]);
    
    // Execute the cURL request and capture the response or error
    $response = curl_exec($curl);
    
    // Check for any cURL error
    $err = curl_error($curl);
    
    // Close the cURL session
    curl_close($curl);
    
    // If there's an error, display it, otherwise print the response
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
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
        \"number\": \"%2B91 8291947281\",\n      
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
        \"mobiles\": \"".$salesnumber.", 917400493119\",\n      
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


// Salesforce Integration

function salesforce_integration($flat_type, $ProjectName, $fullname, $email_id, $country_code, $mobile, $form_type, $site_date, $campaign, $utm_source, $utm_medium, $utm_campaign, $location, $received_on) {
    

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


salesforce_integration($config, $ProjectName, $namenew, $email, $CountryCode, $newphone, $type, $date, $campaign, $source, $medium, $campaign, $location, $received_on);


    



// }

ob_end_flush(); // Flush the output buffer

?>
