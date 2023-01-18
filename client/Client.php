<?php

include_once './client/src/Networker.php';
include_once './client/src/CaptchaRequest.php';
include_once './client/src/Result.php';
include_once './client/src/Timeouts.php';

class Client extends Networker {

    private $clientKey;

    private $startTime;
    private $endTime;
    private $totalTimeToTask;

    private $apiEndpoint = "https://api.capmonster.cloud/";
    private $userAgent = "Zennolab.CapMonsterCloud.Client.PHP/1.2";

    private function startTask() : void {
        $this->startTime = date_create()->format('Uv');
        $this->endTime = $this->startTime + $this->totalTimeToTask;
    }

    private function isTimeExpired() {
        $currentTime = date_create()->format('Uv');
        return $currentTime >= $this->endTime;
    }

    private function tryParseGetBalanceError(string $rawError) : string {
        $parsed = json_decode($rawError, true);
        
        if(json_last_error() === JSON_ERROR_NONE) {
            return $parsed['errorCode'];
        } else {
            return  'Curl: ' . $rawError;
        }
    }

    public function __construct(string $clientKey) {
        $this->clientKey = $clientKey;
    }

    public function solve(CaptchaRequest $request) : Result {
        if(!$request->isValid()) {
            return $request->getTrouble();
        }

        $this->totalTimeToTask = $request->getTotalTime();

        $request->setClientKey($this->clientKey);

        try {
            $request->createTask();
        } catch (Exception $e) {
            return new Result(false, $e->getMessage());
        }

        $this->startTask();
        usleep($request->getFirstDelay());
        
        while(!$this->isTimeExpired()) {
            try {
                $request->getTaskResult();  //помним, что 503 ошибка игнорируется
            } catch (Exception $e) {
                return new Result(false, $e->getMessage());
            }

            if($request->isReady) {
                return new Result(true, $request->solution);
            }

            //если интервал до следующего запроса больше времени, оставшегося на выполнение
            if($request->getInterval() > $this->endTime - date_create()->format('Uv')) {
                return new Result(false, 'Timeout');
            }

            usleep($request->getInterval());
        }

        return new Result(false, 'Timeout');
    }

    public function getBalance() : Result {
        $url = $this->apiEndpoint . 'getBalance';

        $response = null;
        try {
            $response = $this->postRequest($url, ["clientKey" => $this->clientKey], $this->userAgent); 
        } catch (Exception $e) {
            $message = $this->tryParseGetBalanceError($e->getMessage());
            return new Result(false, $message);
        }

        $jsonResponse = json_decode($response, true);
        
        if($jsonResponse['errorId'] == 1) {
            $message = $jsonResponse['errorDescription'];
            return new Result(false, $message);
        }

        return new Result(true, $jsonResponse['balance']);
    }

}