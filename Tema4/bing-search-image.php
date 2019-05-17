<html>
    <head>
        <title>Tema4</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class = "content-full">
            <?php include("search-image-api.php"); ?>
            <?php include("database.php"); ?>
            <?php include("face-recognition.php"); ?>
            <?php include("search-box.php"); ?>

            <?php 
                $search_string = $_POST["search-text"];
                $image_string = BingWebSearch($endpoint, $accessKey, $search_string); 

                //$image_string = "https://politichieactuala.files.wordpress.com/2012/07/traian-basescu.jpg";
                echo '<img class = "image-returned" src = "'.$image_string.'">';
            ?>
             <div class = "image-info">
                <?php
                    $json = json_decode(AzureFaceRecognition($image_string));

                    $Name = $search_string;
                    $Gender = $json[0]->faceAttributes->gender;
                    $Age = $json[0]->faceAttributes->age;
                    $anger = $json[0]->faceAttributes->emotion->anger;
                    $contempt = $json[0]->faceAttributes->emotion->contempt;
                    $disgust = $json[0]->faceAttributes->emotion->disgust;
                    $fear = $json[0]->faceAttributes->emotion->fear;
                    $happiness = $json[0]->faceAttributes->emotion->happiness;
                    $neutral = $json[0]->faceAttributes->emotion->neutral;
                    $sadness = $json[0]->faceAttributes->emotion->sadness;
                    $surprise = $json[0]->faceAttributes->emotion->surprise;
                    InsertIntoDatabase($Name, $Gender, $Age, $anger, $contempt, $disgust, $fear, $happiness, $neutral, $sadness, $surprise);
                    echo '<div class = "person-info">'. $json[0]->faceAttributes->gender .'</div>';
                    echo '<div class = "person-info">'. $json[0]->faceAttributes->age .'</div>';
                    foreach($json[0]->faceAttributes->emotion as $key => $value) {
                        $width = 200 + ($value*300);
                        echo '<div class = "emotions" style="width:'.$width.'">' . $key . ' : ' . $value . '</div>';
                    }
                ?>
            </div>

            <?php 
                echo "Da";
                SelectFromDatabase();
            ?>
        </div>
    </body>
</html>