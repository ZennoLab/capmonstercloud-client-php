<?php

    include_once "./client/Client.php";
    include_once "./client/src/captcha/RecaptchaV2.php";
    include_once "./client/src/captcha/HCaptcha.php";
    include_once "./client/src/captcha/RecaptchaV3.php";
    include_once "./client/src/captcha/ImageToText.php";
    include_once "./client/src/captcha/GeeTest.php";

    require_once __DIR__ . '/../../vendor/autoload.php';

    use PHPUnit\Framework\TestCase;

    $clientKey = getenv('CLIENT_KEY');

    class Test extends TestCase {

        public function testRecaptchaSolve() {
            global $clientKey;

            $client = new Client($clientKey);
            
            $captchaOptions = [
                "websiteURL" => "https://lessons.zennolab.com/captchas/recaptcha/v2_simple.php?level=high",
		        "websiteKey" => "6Lcg7CMUAAAAANphynKgn9YAgA4tQ2KI_iqRyTwd"
            ];
            $request = new RecaptchaV2Request($captchaOptions["websiteURL"], $captchaOptions["websiteKey"]);

            $solution = $client->solve($request);
            if(gettype($solution->message) == 'array') {
                $solution->setMessage(json_encode($solution->message));
            }
            $this->assertTrue($solution->result, $solution->message);
        }

        public function testHcaptchaSolve() {
            global $clientKey;

            $client = new Client($clientKey);
            
            $captchaOptions = [
                "websiteURL" => "https://lessons.zennolab.com/captchas/hcaptcha/?level=easy",
		        "websiteKey" => "472fc7af-86a4-4382-9a49-ca9090474471"
            ];
            $request = new HCaptchaRequest($captchaOptions["websiteURL"], $captchaOptions["websiteKey"]);

            $solution = $client->solve($request);
            if(gettype($solution->message) == 'array') {
                $solution->setMessage(json_encode($solution->message));
            }
            $this->assertTrue($solution->result, $solution->message);
        }

        public function testIncorrectWebsite() {
            global $clientKey;

            $client = new Client($clientKey);
            
            $captchaOptions = [
                "websiteURL" => "incorrect website",
		        "websiteKey" => "6Lcg7CMUAAAAANphynKgn9YAgA4tQ2KI_iqRyTwd"
            ];
            $request = new HCaptchaRequest($captchaOptions["websiteURL"], $captchaOptions["websiteKey"]);

            $solution = $client->solve($request);
            if(gettype($solution->message) == 'array') {
                $solution->setMessage(json_encode($solution->message));
            }
            $this->assertFalse($solution->result, $solution->message);
        }

        public function testIncorrectMinScore() {
            global $clientKey;

            $client = new Client($clientKey);
            
            $captchaOptions = [
                "websiteURL" => "https://lessons.zennolab.com/captchas/recaptcha/v2_simple.php?level=high",
		        "websiteKey" => "6Lcg7CMUAAAAANphynKgn9YAgA4tQ2KI_iqRyTwd",
                "minScore" => 1.1
            ];
            $request = new RecaptchaV3Request($captchaOptions["websiteURL"], $captchaOptions["websiteKey"], $captchaOptions["minScore"]);

            $solution = $client->solve($request);
            if(gettype($solution->message) == 'array') {
                $solution->setMessage(json_encode($solution->message));
            }
            $this->assertTrue($solution->result, $solution->message);
        }

        public function testIncorrectRecognizingThreshold() {
            global $clientKey;

            $client = new Client($clientKey);
            
            $captchaOptions = [
                "body" => "body",
                "recognizingThreshold" => 101
            ];
            $request = new ImageToTextRequest($captchaOptions['body'], null, $captchaOptions["recognizingThreshold"]);

            $solution = $client->solve($request);
            if(gettype($solution->message) == 'array') {
                $solution->setMessage(json_encode($solution->message));
            }
            $this->assertFalse($solution->result, $solution->message);
        }

        public function testIncorrectWebsiteKey() {
            global $clientKey;

            $client = new Client($clientKey);
            
            $captchaOptions = [
                "websiteURL" => "https://lessons.zennolab.com/captchas/recaptcha/v2_simple.php?level=high",
		        "websiteKey" => ""
            ];
            $request = new RecaptchaV2Request($captchaOptions["websiteURL"], $captchaOptions["websiteKey"]);

            $solution = $client->solve($request);
            if(gettype($solution->message) == 'array') {
                $solution->setMessage(json_encode($solution->message));
            }
            $this->assertFalse($solution->result, $solution->message);
        }

        public function testIncorrectGt() {
            global $clientKey;
            
            $client = new Client($clientKey);
            
            $captchaOptions = [
                "websiteURL" => "https://lessons.zennolab.com/captchas/recaptcha/v2_simple.php?level=high",
		        "gt" => "",
                "challenge" => ""
            ];
            $request = new GeeTestRequest($captchaOptions["websiteURL"], $captchaOptions["gt"], $captchaOptions["challenge"]);

            $solution = $client->solve($request);
            if(gettype($solution->message) == 'array') {
                $solution->setMessage(json_encode($solution->message));
            }
            $this->assertFalse($solution->result, $solution->message);
        }

    }
