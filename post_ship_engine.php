<?php

function callAPI($method, $url, $data){
   $curl = curl_init();
   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }
   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'API-Key: Enter API Key1',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}

$data_array =  array(
  "shipment" => [
    "service_code" => "ups_ground",
    "ship_to" => [
      "name" => "Jane Doe",
      "address_line1" => "525 S Winchester Blvd",
      "city_locality" => "San Jose",
      "state_province" => "CA",
      "postal_code" => "95128",
      "country_code" => "US",
      "address_residential_indicator" => "yes"
    ],
    "ship_from" => [
      "name" => "John Doe",
      "company_name" => "Example Corp",
      "phone" => "555-555-5555",
      "address_line1" => "4009 Marathon Blvd",
      "city_locality" => "Austin",
      "state_province" => "TX",
      "postal_code" => "78756",
      "country_code" => "US",
      "address_residential_indicator" => "no"
    ],
    "packages" => [
      [
        "weight" => [
          "value" => 20,
          "unit" => "ounce"
        ],
        "dimensions" => [
          "height" => 6,
          "width" => 12,
          "length" => 24,
          "unit" => "inch"
        ]
      ]
    ]
  ]
);

$make_call = callAPI('POST', 'https://api.shipengine.com/v1/labels/', json_encode($data_array));
$response = json_decode($make_call, true);
$errors   = $response['response']['errors'];
$data     = $response;

?>
