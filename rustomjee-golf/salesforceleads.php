<?php

// Replace with your credentials
$consumerKey = '3MVG9Kr5_mB04D17Lpo6oLF.52a7Hc.WwjI9EmfVIvAomNPk7gXcfBAmjbj1ssAnHyAl7PWdMInwl1vZJKrJx';
$consumerSecret = 'E46A38A487FF16CF6212ED3EDD97BCCFC4BC7E7FA795C920F7A4C537ABDA6EC7';
$username = 'enquiry.rp-w4mw@force.com';
$password = 'EnquiryRiogaP2025'.'sNQ08eJRjNtJHcrM18YjiRK5';



// Authentication URL
$url = "https://login.salesforce.com/services/oauth2/token";

// Prepare data for OAuth2 authentication
$data = [
    'grant_type' => 'password',
    'client_id' => $consumerKey,
    'client_secret' => $consumerSecret,
    'username' => $username,
    'password' => $password,
];

// cURL request for authentication
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute cURL
$response = curl_exec($curl);
curl_close($curl);

// Decode response
$responseData = json_decode($response, true);

// Check for access token
if (isset($responseData['access_token'])) {
    $accessToken = $responseData['access_token'];
    $instanceUrl = $responseData['instance_url'];

    // Prepare lead data
    $leadData = [
        'FirstName' => 'Vicky',
        'LastName' => 'Walmiki',
        'Company' => 'L&T',
        'Email' => 'vickyw@riogapremium.com',
        'Phone' => '9594146765',
    ];

    // Create Lead endpoint
    $url = $instanceUrl . "/services/data/v56.0/sobjects/Lead/";

    // cURL request to create a lead
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($leadData)); // Send lead data as JSON
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json', // Set content type to JSON
    ]);

    // Execute cURL for lead creation
    $response = curl_exec($curl);
    curl_close($curl);

    // Decode lead creation response
    $responseData = json_decode($response, true);

    // Check if lead was created successfully
    if (isset($responseData['id'])) {
        echo "Lead created successfully! Lead ID: " . $responseData['id'];
    } else {
        echo "Lead creation failed. Response: " . json_encode($responseData);
    }
} else {
    echo "Authentication failed. Response: " . json_encode($responseData);
}





?>