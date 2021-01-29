<?php
    include 'config.inc.php';

    function generateToken() {
        $curl = curl_init();

        $options = array(   CURLOPT_URL => 'https://apitestenv.vnforapps.com/api.security/v1/security',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_HTTPHEADER => array(
                            "Accept: */*",
                            'Authorization: '.'Basic '.base64_encode('integraciones.visanet@necomplus.com'.":".'d5e7nk$M')
                        ));


        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function generateSesion($amount, $token) {

        $email = $_SESSION["envEmail"];
        if (is_null($email)) {
            $email = "soporte@calperu.org.pe";
        }

        $tipodoc = $_SESSION["envTipDoc"];
        $nrodoc = $_SESSION["envNroDoc"];


        $session = array(
            'amount' => $amount,
            'antifraud' => array(
                'clientIp' => $_SERVER['REMOTE_ADDR'],
                'merchantDefineData' => array(
                    'MDD4' => $email,
                    'MDD33' => $tipodoc,
                    'MDD34' => $nrodoc
                ),
            ),
            'channel' => 'web',
        );
        $json = json_encode($session);
        $response = json_decode(postRequest('https://apitestenv.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/341198214', $json, $token));
        return $response->sessionKey;
    }

    function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token) {
        $data = array(
            'antifraud' => null,
            'captureType' => 'manual',
            'channel' => 'web',
            'countable' => true,
            'order' => array(
                'amount' => $amount,
                'currency' => 'PEN',
                'purchaseNumber' => $purchaseNumber,
                'tokenId' => $transactionToken
            ),
            'recurrence' => null,
            'sponsored' => null
        );
        $json = json_encode($data);
        $session = json_decode(postRequest('https://apitestenv.vnforapps.com/api.authorization/v3/authorization/ecommerce/341198214', $json, $token));
        return $session;
    }

    function postRequest($url, $postData, $token) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$token,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => $postData
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function generatePurchaseNumber(){
        // $archivo = "assets/purchaseNumber.txt";
        $archivo = "C:\\xampp\\htdocs\\pagoenlinea\\config\\assets\\purchaseNumber.txt";
        $purchaseNumber = 222;
        $fp = fopen($archivo,"r");
        $purchaseNumber = fgets($fp, 100);
        fclose($fp);
        ++$purchaseNumber;
        $fp = fopen($archivo,"w+");
        fwrite($fp, $purchaseNumber, 100);
        fclose($fp);
        return $purchaseNumber;
    }
