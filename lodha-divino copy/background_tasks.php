<?php
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get the input file from the command line
if ($argc < 2) {
    exit("No input file provided.\n");
}
$inputFile = $argv[1];
if (!file_exists($inputFile)) {
    exit("Input file does not exist.\n");
}

// Read data
$data = json_decode(file_get_contents($inputFile), true);
if (!$data) {
    exit("Invalid input data.\n");
}

// Extract variables
extract($data);

// Task 1: Send Email
try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'enquiry.rp@riogapremium.com'; // Your email address
    $mail->Password = 'koet dmwa mlfg mnbh'; // Your email password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('enquiry.rp@riogapremium.com', $ProjectName);

    // Email to user
    $mail->addAddress($email, $namenew);
    $mail->Subject = 'Thank you for enquiry - ' . $ProjectName;
    $mail->isHTML(true);
    $mail->Body = "
        Dear $namenew,<br><br>
        Thank you for expressing your interest in <strong>$ProjectName</strong>. We have received your request, and one of our sales experts will contact you shortly.<br><br>
        Click here to connect on WhatsApp: <a href='$link'>$link</a><br><br>
        Best regards,<br>
        Rioga Premium
    ";
    $mail->send();

    // Email to sales team
    $mail->clearAddresses();
    $recipients = [
        'yashs@riogapremium.com' => 'Yash Suryawanshi',
        'info@riogapremium.com' => 'Rioga Premium',
    ];
    foreach ($recipients as $emailAddress => $name) {
        $mail->addAddress($emailAddress, $name);
    }
    $mail->Subject = 'Lead Alert - ' . $ProjectName;
    $mail->Body = "
        Hi Team,<br><br>
        New lead received:<br><br>
        <ul>
            <li><strong>Name:</strong> $namenew</li>
            <li><strong>Country:</strong> $country</li>
            <li><strong>Phone:</strong> $newphone</li>
            <li><strong>Email:</strong> $email</li>
        </ul>
    ";
    $mail->send();
} catch (Exception $e) {
    error_log("Mailer Error: {$mail->ErrorInfo}");
}

// Task 2: Send SMS
$smsPayloads = [
    [
        'template_id' => '670cdedfd6fc05311a306bc2',
        'recipients' => [
            [
                'mobiles' => "91$newphone",
                'name' => $ProjectName,
                'number' => '+91 8291947281',
                'link' => $link,
            ],
        ],
    ],
];
foreach ($smsPayloads as $payload) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authkey: 431698AxW1T03gVCR6704f714P1",
            "content-type: application/json",
        ],
    ]);
    curl_exec($curl);
    curl_close($curl);
}

// Task 3: Salesforce Integration
$params = [
    "last_name" => $namenew,
    "email" => $email,
    "00N2w00000HwGv0" => $CountryCode,
    "mobile" => $newphone,
    "oid" => "00D2w00000EMwCv",
];
$postData = http_build_query($params);
$opts = [
    'http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postData,
    ],
];
$context = stream_context_create($opts);
file_get_contents("https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8", false, $context);

// Clean up temporary file
unlink($inputFile);
?>
