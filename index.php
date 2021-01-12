<?php
  include "post_ship_engine.php";

  // pass an array in ship engine format
  $data_array =  array(
    "shipment" => [
      "service_code" => "fedex_home_delivery",
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

  // Call the API with passing the array of shipping data
  $make_call = callAPI('POST', 'https://api.shipengine.com/v1/labels/', json_encode($data_array));
  $response = json_decode($make_call, true);
  $errors   = $response['response']['errors'];
  $data     = $response;

  // Return response to page
  echo json_encode($data);

  // return the pdf url to the label created
  $print_data = $data["label_download"]["pdf"];
  echo $print_data;

  $newfile = 'C:/H-Block/temp/file.pdf';
  copy($print_data, $newfile);
  // using cups command for unix based systems to print to default printer
  // exec('lp -d Zebra_Technologies_ZTC_ZP_500__ZPL_ -o raw temp/file.zpl');
  shell_exec('Java C:/H-Block/PrintGIF.java')

?>
