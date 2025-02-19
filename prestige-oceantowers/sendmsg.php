<?php

$number = "9765277792";
$ProjectName = "Prestige - Test Project";
$name = "Yash Suryawanshi";
$email = "yashs@rioga.com";
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
  \"mobiles\": \"91".$number."\",\n      
  \"projname\": \"".$ProjectName."\",\n      
  \"name\": \"".$name."\",\n     
   \"email\": \"".$email."\",\n      
   \"mobile\": \"".$mobile."\"\n    }\n  ]\n}",
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

?>