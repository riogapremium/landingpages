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
    $link = "bit.ly/A-airica ";
    $website = "https://adani-airica-kanjurmarg.com/";
    $salesnumber = "919867160002";

    $ProjectName = htmlspecialchars($_POST['project_name'] ?? '');
    $namenew = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $country = htmlspecialchars($_POST['country'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $newphone = str_replace(' ', '', $phone);
    $type = htmlspecialchars($_POST['type'] ?? '');
    $config = htmlspecialchars($_POST['config'] ?? '');
    $date = htmlspecialchars($_POST['date'] ?? '');
    $source = htmlspecialchars($_POST['utm_source'] ?? '');
    $medium = htmlspecialchars($_POST['utm_medium'] ?? '');
    $campaign = htmlspecialchars($_POST['utm_campaign'] ?? '');
    $term = htmlspecialchars($_POST['utm_term'] ?? '');
    $logolink = $website."email/logo.png";
    $bannerlink = $website."email/banner.webp";

    $CountryCode = trim(explode("+", $country)[1]);
    
    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit;
    }

    

// Prepare the curl handles
$curlHandles = [];
$responses = [];
$errors = [];
$multiHandle = curl_multi_init();

// First email (to user)
$curl1 = curl_init();
curl_setopt_array($curl1, [
    CURLOPT_URL => "https://control.msg91.com/api/v5/email/send",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "POST",
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
                    "salesnumber" => "+" . $salesnumber,
                    "logolink" => $logolink,
                    "bannerlink" => $bannerlink,
                    "bitlylink" => $link,
                    "callinglink" => "tel:+".$salesnumber,
                    
                ]
            ]
        ],
        "from" => [
            "name" => $ProjectName,
            "email" => "enquiry.rp@riogapremium.com"
        ],
        "domain" => "riogapremium.com",
        "template_id" => "new_thank_you_email"
    ]),
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authkey: 431698AxW1T03gVCR6704f714P1",
        "content-type: application/json"
    ]
]);

// Add curl handle to multi handle
curl_multi_add_handle($multiHandle, $curl1);
$curlHandles[] = $curl1;

// Second email (to sales team)
$curl2 = curl_init();
curl_setopt_array($curl2, [
    CURLOPT_URL => "https://control.msg91.com/api/v5/email/send",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
        "recipients" => [
            [
                "to" => [
                    ["name" => "Rioga Premium", "email" => "info@riogapremium.com"],
                    ["name" => "Yash S", "email" => "yashs@riogapremium.com"],
                    ["name" => "Aasim S", "email" => "aasims@riogapremium.com"],
                    
                ],
                "variables" => [
                    "projname" => $ProjectName,
                    "username" => $namenew,
                    "country" => $country,
                    "newphone" => $newphone,
                    "email" => $email,
                    "type" => $type,
                    "config" => $config,
                    "date" => $date,
                    "medium" => $medium,
                    "term" => $term,
                    "source" => $source,
                    "campaign" => $campaign
                ]
            ]
        ],
        "from" => [
            "name" => $ProjectName,
            "email" => "enquiry.rp@riogapremium.com"
        ],
        "domain" => "riogapremium.com",
        "template_id" => "lead_email_template"
    ]),
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authkey: 431698AxW1T03gVCR6704f714P1",
        "content-type: application/json"
    ]
]);

// Add curl handle to multi handle
curl_multi_add_handle($multiHandle, $curl2);
$curlHandles[] = $curl2;

// SMS request (to user)
$curl3 = curl_init();
curl_setopt_array($curl3, [
    CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
        "template_id" => "670cdedfd6fc05311a306bc2",
        "short_url" => "1",
        "realTimeResponse" => "1",
        "recipients" => [
            [
                "mobiles" => "91" . $newphone,
                "name" => $ProjectName,
                "number" => "%2B".$salesnumber,
                "link" => $link
            ]
        ]
    ]),
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authkey: 431698AxW1T03gVCR6704f714P1",
        "content-type: application/json"
    ]
]);

// Add curl handle to multi handle
curl_multi_add_handle($multiHandle, $curl3);
$curlHandles[] = $curl3;

// SMS request (to sales team)
$curl4 = curl_init();
curl_setopt_array($curl4, [
    CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
        "template_id" => "67063c42d6fc055d97488112",
        "short_url" => "1",
        "realTimeResponse" => "1",
        "recipients" => [
                [
                    "mobiles" => $salesnumber,
                    "projname" => $ProjectName,
                    "name" => $namenew,
                    "email" => $email,
                    "mobile" => "%2B" . $CountryCode . " " . $newphone
                ],
                [
                    "mobiles" =>  "917400493119",
                    "projname" => $ProjectName,
                    "name" => $namenew,
                    "email" => $email,
                    "mobile" => "%2B" . $CountryCode . " " . $newphone
                ]
            ],
    ]),
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authkey: 431698AxW1T03gVCR6704f714P1",
        "content-type: application/json"
    ]
]);

// Add curl handle to multi handle
curl_multi_add_handle($multiHandle, $curl4);
$curlHandles[] = $curl4;

// Execute the multi handle
$active = null;
do {
    $multiReturn = curl_multi_exec($multiHandle, $active);
    curl_multi_select($multiHandle);
} while ($active);

// Retrieve responses and errors
foreach ($curlHandles as $i => $curl) {
    $responses[$i] = curl_multi_getcontent($curl);
    $errors[$i] = curl_error($curl);
    curl_multi_remove_handle($multiHandle, $curl);
}

// Close the multi handle
curl_multi_close($multiHandle);

// Output responses and errors
foreach ($responses as $response) {
    echo $response;
}
foreach ($errors as $error) {
    if ($error) {
        echo "cURL Error #: " . $error;
    }
}



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


    



}

ob_end_flush(); // Flush the output buffer

?>
