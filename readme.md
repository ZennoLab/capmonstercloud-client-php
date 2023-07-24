# Php client library for Zennolab.CapMonster api

#### Usage
```php
    namespace ZennoLab\CapMonster; 

    require __DIR__.'/vendor/autoload.php'   
    $client = new Client(iget_env("your_client_key"));

    //solve image captcha
    $body = "base64_captcha_image";
    $imageRequest = new captcha\ImageToTextRequest($body);
    $imageResult = $client->solve($imageRequest);
    
    //solve Recaptcha 2 (without proxy)
    $websiteURL = "https://lessons.zennolab.com/captchas/recaptcha/v2_simple.php?level=high";
    $websiteKey = "6Lcg7CMUAAAAANphynKgn9YAgA4tQ2KI_iqRyTwd";
    $recaptchaV2Request = new captcha\RecaptchaV2Request($websiteURL, $websiteKey);
    $recaptchaV2Result = $client->solve($recaptchaV2Request);
    
    // solve HCaptcha (without proxy)
    $websiteUrl = "https://lessons.zennolab.com/captchas/hcaptcha/?level=easy";
    $websiteKey = "472fc7af-86a4-4382-9a49-ca9090474471";
    $hcatpchaRequest = new captcha\HCaptchaRequest($websiteURL, $websiteKey);
    $hcaptchaResult = $client->solve($hcatpchaRequest);
```

#### Response format
 The result of the solve method always contains two fields: bool result, a request success indicator, and a mixed message field containing a text description of the error or an object of a successful response from the server.

#### Supported captchas

- FunCaptchaTask
- FunCaptchaTaskProxyless
- GeeTestTask
- GeeTestTaskProxyless
- HCaptchaTask
- HCaptchaTaskProxyless
- ImageToTextTask
- RecaptchaV2Task
- RecaptchaV2TaskProxyless
- RecaptchaV3TaskProxyless
- RecaptchaV2EnterpriseTask
- RecaptchaV2EnterpriseTaskProxyless
- TurnstileTask
- TurnstileTaskProxyless
- ComplexImageRecaptcha
- ComplexImageHCaptcha
- ComplexImageFuncaptcha
