<?php

    include_once "./client/Client.php";
    include_once "./client/src/captcha/RecaptchaV2.php";
    include_once "./client/src/captcha/HCaptcha.php";
    include_once "./client/src/captcha/RecaptchaV3.php";
    include_once "./client/src/captcha/ImageToText.php";
    include_once "./client/src/captcha/GeeTest.php";
    include_once "./client/src/captcha/Turnstile.php";
    include_once "./client/src/captcha/ComplexImageHCaptcha.php";
    include_once "./client/src/captcha/ComplexImageRecaptcha.php";
    include_once "./client/src/captcha/ComplexImageFuncaptcha.php";

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

        public function testGeeTesV4() {
            global $clientKey;

            $client = new Client($clientKey);

            $captchaOptions = [
                "websiteURL" => "https://faucetpay.io/account/login",
                "gt" => "eb8b0c2b27f3365b9244d9da81638c6",
                "version" => "4",
                "initParameters" => [
                    "riskType" => "slide"
                ],
                "userAgent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36"
            ];
            $request = new GeeTestRequest(
                $captchaOptions["websiteURL"],
                $captchaOptions["gt"],
                null,
                null,
                null,
                $captchaOptions["version"],
                $captchaOptions["initParameters"],
                $captchaOptions["userAgent"]
            );

            $solution = $client->solve($request);
            if(gettype($solution->message) == 'array') {
                $solution->setMessage(json_encode($solution->message));
            }
            $this->assertTrue($solution->result, $solution->message);
        }

        public function testTurnstileSolve() {
            global $clientKey;

            $client = new Client($clientKey);
            
            $captchaOptions = [
                "websiteURL" => "https://tsinvisble.zlsupport.com",
		        "websiteKey" => "0x4AAAAAAABUY0VLtOUMAHxE"
            ];
            $request = new TurnstileRequest($captchaOptions["websiteURL"], $captchaOptions["websiteKey"]);

            $solution = $client->solve($request);
            if(gettype($solution->message) == 'array') {
                $solution->setMessage(json_encode($solution->message));
            }
            $this->assertTrue($solution->result, $solution->message);
        }

        public function testComplexImageHCaptchaSolve()
        {
            global $clientKey;

            $client = new Client($clientKey);

            $captchaOptions = [
                "imageUrls" => [
                    "https://i.postimg.cc/kg71cbRt/image-1.jpg"
                ],
                "metadata" => [
                    "Task" => "Please click each image containing a mountain"
                ],
            ];
            $request = new ComplexImageHCaptchaRequest($captchaOptions['metadata'], $captchaOptions['imageUrls']);

            $solution = $client->solve($request);
            if(gettype($solution->message) == 'array') {
                $solution->setMessage(json_encode($solution->message));
            }
            $this->assertTrue($solution->result, $solution->message);
        }

        public function textComplexImageRecaptchaSolve()
        {
            global $clientKey;

            $client = new Client($clientKey);

            $captchaOptions = [
                "imageUrls" => [
                    "https://i.postimg.cc/s2ZDrHXy/fc1.jpg"
                ],
                "metadata" => [
                    "Task" => "Pick the image that is the correct way up"
                ],
            ];
            $request = new ComplexImageFuncaptchaRequest($captchaOptions['metadata'], $captchaOptions['imageUrls']);

            $solution = $client->solve($request);
            if(gettype($solution->message) == 'array') {
                $solution->setMessage(json_encode($solution->message));
            }
            $this->assertTrue($solution->result, $solution->message);
        }

    }
