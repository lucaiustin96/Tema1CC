
<html>
    <head>
        <title>Proiect</title>
        <script src="scripts/script.js"></script>
        <script src="microsoft.cognitiveservices.speech.sdk.bundle.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <?php include("header.php");?>
        <?php include("database.php");?>
        <div class = "container">
            <div class = "start-microphone" id="startRecognizeOnceAsyncButton">
                Start recognition
            </div>    
            <div id="content">
                <form id = "myForm" action="bing-search.php" method="post">
                  <input type="text" id="phraseDiv" name="search-text">
                  <input class = "submit" type="submit" value="Cauta">
                </form> 
            </div>
            <div class = "tot">
                <div class = "info">
                    Top cautari:
                </div>
                <?php SelectFromDatabase(); ?>
                <div class="reclama-right">RECLAMA TA AICI</div>
            </div>
        </div>
    </body>
</html>