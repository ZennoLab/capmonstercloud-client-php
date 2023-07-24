<?php
namespace ZennoLab\CapMonster; 

class CaptchaRequest extends Networker {

    protected $validate;
    protected $type;
    protected $options;
    protected $timeouts;
    protected $taskId;

    public $isReady = false;
    public $solution;

    private $apiEndpoint = "https://api.capmonster.cloud/";
    private $userAgent = "Zennolab.CapMonsterCloud.Client.PHP/1.1";

    protected function detectProxy(array $options, string $proxyType, string $proxylessType) : string {
        if(array_key_exists('proxyType', $options)) {
            return $proxyType;
        } else {
            return $proxylessType;
        }
    }

    private function tryParseCreateTaskError(string $rawError) : string {
        $parsed = json_decode($rawError, true);
        
        if(json_last_error() === JSON_ERROR_NONE) {
            return $parsed['errorDescription'];
        } else {
            return  'Curl: ' . $rawError;
        }
    }

    private function tryParseGetResultError(string $rawError) : string {
        $parsed = json_decode($rawError, true);
        
        if(json_last_error() === JSON_ERROR_NONE) {
            return $parsed['errorCode'];
        } else {
            return  'Curl: ' . $rawError;
        }
    }

    protected function clearInput(array $options) : array {
        $callback = function($item) {
            return $item != null;
        };
        return array_filter($options, $callback);
    }

    public function __construct(string $type, array $options) {
        $this->type = $type;

        $this->validate = Validator::validate($type, $options);

        $options = $this->clearInput($options);

        $options["type"] = $type;
        $this->options = [
            "task" => $options,
            "softId" => 57
        ];

        $this->timeouts = Timeouts::detectTimeouts($type);
    }

    public function getFirstDelay() : int {
        return $this->timeouts['firstRequestDelay'];
    }

    public function getInterval() : int {
        return $this->timeouts['requestInterval'];
    }

    public function getTotalTime() : int {
        return $this->timeouts['timeout'];
    }

    public function isValid() : bool {
        return $this->validate->result;
    }

    public function getTrouble() : Result {
        return $this->validate;
    }

    public function setClientKey(string $clientKey) : void {
        $this->options["clientKey"] = $clientKey;
    }

    public function createTask() : void {
        $url = $this->apiEndpoint . 'createTask';

        $response = null;

        try {
            //postRequest выбрасывает исключение при ошибках curl (timeout reached например), а также при ошибках api благодаря http кодам
            $response = $this->postRequest($url, $this->options, $this->userAgent); 
        } catch (Exception $e) {
            $message = $this->tryParseCreateTaskError($e->getMessage());
            throw new \Exception($message);
        }

        $jsonResponse = json_decode($response, true);
        
        if($jsonResponse['errorId'] == 1) {
            $message = $jsonResponse['errorDescription'];
            throw new \Exception($message);
        }

        $this->taskId = $jsonResponse['taskId'];        
    }

    public function getTaskResult() : void {
        $url = $this->apiEndpoint . 'getTaskResult';

        $response = null;
        $payload = [
            "clientKey" => $this->options['clientKey'],
            "taskId" => $this->taskId
        ];

        try {
            //postRequest выбрасывает исключение при ошибках curl (timeout reached например), а также при ошибках api благодаря http кодам
            $response = $this->postRequestIgnore503($url, $payload, $this->userAgent); 
        } catch (Exception $e) {
            $message = $this->tryParseGetResultError($e->getMessage());
            throw new \Exception($message);
        }

        $jsonResponse = json_decode($response, true);

        if(json_last_error() != JSON_ERROR_NONE) { //произошла 503 ошибка, и в $response лежит обычная строчка => json_decode выполнится с ошибкой
            return;
        }
        
        if($jsonResponse['errorId'] == 1) {
            $message = $jsonResponse['errorCode'];
            throw new \Exception($message);
        }

        if($jsonResponse['status'] == 'ready') {
            $this->isReady = true;
            $this->solution = $jsonResponse['solution'];
        }
    }

}
