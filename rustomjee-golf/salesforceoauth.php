<?php
function salesforce_integration($flat_type, $fullname, $email_id, $country_code, $mobile, $campaign, $utm_source, $utm_medium, $utm_campaign, $location, $received_on) {
    $thank_you_url = "https://riogapremium.co/horizon/"; // Set your thank you URL
    $project_name = "Godrej Horizon New";

    // Prepare data for Salesforce
    $params = array(
        "last_name" => $fullname,
        "email" => $email_id,
        "00N2w00000HwGv0" => $country_code, // Country Code
        "mobile" => $mobile,
        "oid" => "00D2w00000EMwCv", // Salesforce Org ID
        "retURL" => $thank_you_url, // Redirect URL after submission
        "00N2w00000HwGv5" => $flat_type, // Flat Type
        "00N2w00000HwGvA" => "Download Brochure", // Form Type
        "00N2w00000HwGvF" => "", // Site Visit Date
        "00N2w00000HwGvK" => $project_name, // Project Name
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


salesforce_integration("2BHK", "Yash Suryawanshi", "yashs@riogapremium.com", "91", "7400493119", "", "Google", "CPC", "L", "", "");


?>