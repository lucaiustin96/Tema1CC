<?php
    function AzureFaceRecognition($img)
    {
        define( 'API_BASE_URL',     'https://westeurope.api.cognitive.microsoft.com/face/v1.0/detect?' );
        define( 'API_PRIMARY_KEY',      '026c3a80f37b4b4cb40ccd03c0701823' );
        //$img = 'https://politichieactuala.files.wordpress.com/2012/07/traian-basescu.jpg';

        $post_string = '{"url":"' . $img . '"}';

        $query_params = array(
            'analyzesFaceLandmarks'     => 'true',
            'analyzesAge'                       => 'true',
            'analyzesGender'                    => 'true',
            'analyzesHeadPose'              => 'true',
            'returnFaceAttributes' => 'age,gender,headPose,smile,facialHair,glasses,' .
                'emotion,hair,makeup,occlusion,accessories,blur,exposure,noise'
        );

        $params = '';
        foreach( $query_params as $key => $value ) {
            $params .= $key . '=' . $value . '&';
        }
        $params .= 'subscription-key=' . API_PRIMARY_KEY;

        $post_url = API_BASE_URL . $params;

        $ch = curl_init();
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array(                                                                          
                'Content-Type: application/json',                                                                                
                'Content-Length: ' . strlen($post_string))
            );    

            curl_setopt( $ch, CURLOPT_URL, $post_url );
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_string );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $response = curl_exec( $ch );
        curl_close( $ch );

        return $response;       
    }
?>    
