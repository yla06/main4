<?php

class NovaPoshta
{

  private function sendRequest( $xml )
  {
    $ch       = curl_init();
    curl_setopt( $ch, CURLOPT_URL, 'https://api.novaposhta.ua/v2.0/json/' );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_HEADER, 0 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $xml );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
    $response = curl_exec( $ch );
    curl_close( $ch );

    return $response;
  }

  public function getOfficess()
  {
    return $this -> sendRequest( '{
      "apiKey": "9b847be7277c0bc0a0acd4a3568eb730",
      "modelName": "Address",
      "calledMethod": "getCities",
      "methodProperties":{}
      }' );
  }

  public function getOfficesByCity( $city )
  {
    return $this -> sendRequest( '{
      "apiKey": "9b847be7277c0bc0a0acd4a3568eb730",
      "modelName": "Address",
      "calledMethod": "getWarehouses",
      "methodProperties": {
          "CityRef": "' . $city . '"
      }
    }' );
  }
}

$np = new NovaPoshta;
echo '<pre>';
print_r( json_decode( $np -> getOfficess() ) );
echo '</pre>';

//echo '<pre>';
//print_r( json_decode( $np -> getOfficesByCity( 'db5c893b-391c-11dd-90d9-001a92567626' ) ) );
//echo '</pre>';