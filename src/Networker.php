<?php
namespace ZennoLab\CapMonster; 

class Networker {

    protected function postRequest(string $url, array $payload, string $userAgent, array $ignoredHttpCodes = []) : string {
        $jsonPayload = json_encode($payload);
        print_r($payload);
        $ch = curl_init($url);

        curl_setopt_array($ch, array(
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_HTTPHEADER => array("Content-Type:application/json"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 21,
            CURLOPT_USERAGENT => $userAgent
        ));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($curlErrorNumber = curl_errno($ch)) {
            curl_close($ch);
            throw new \Exception(curl_strerror($curlErrorNumber));
        }
        curl_close($ch);

        if($this->isErrorCode($httpCode) && !in_array($httpCode, $ignoredHttpCodes)) { 
            throw new \Exception($response);
        }

        return $response;
    }

    protected function postRequestIgnore503(string $url, array $payload, string $userAgent) : string {
        return $this->postRequest($url, $payload, $userAgent, [503]);
    }

    private function isErrorCode(int $code) : bool {
        $firstDigit = substr((string)$code, 0, 1);
        return $firstDigit == '4' || $firstDigit == '5';
    }

}
