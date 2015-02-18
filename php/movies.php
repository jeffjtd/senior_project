<?php

     function buildAuthorizationParameters($apiKey, $sharedSecret) {
         
         $paramsToEncode = $apiKey.$sharedSecret.time();
         $encodedParams = hash('sha256', $paramsToEncode);
         
         $result = sprintf('apikey=%s&sig=%s', $apiKey, $encodedParams);
         
         return $result;
     }
     
     function getResponseFromParameters($parameters) {
         
         $baseUri = 'http://api.fandango.com';
         $apiVersion = '1';
         
         // Use your account-specific values here
         $apiKey = 'your_api_key';
         $sharedSecret = 'your_shared_secret';
         
         $authorizationParameters = buildAuthorizationParameters($apiKey, $sharedSecret);
         
         $requestUri = sprintf('%s/v%s/?%s&%s', $baseUri, $apiVersion, $parameters, $authorizationParameters);
         
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $requestUri);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);
         
         return $result;
     }
     
     header('Content-type: text/xml');
     $zipCode = '90064';
     $parameters = sprintf('op=theatersbypostalcodesearch&postalcode=%s', $zipCode);
     
     echo getResponseFromParameters($parameters);
     
?>