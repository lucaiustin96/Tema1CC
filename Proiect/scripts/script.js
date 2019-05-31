  var phraseDiv;
  var startRecognizeOnceAsyncButton;

  // subscription key and region for speech services.
  var subscriptionKey, serviceRegion;
  var authorizationToken;
  var SpeechSDK;
  var recognizer;

  document.addEventListener("DOMContentLoaded", function () {
    startRecognizeOnceAsyncButton = document.getElementById("startRecognizeOnceAsyncButton");
    subscriptionKey = "fe95569ea57849aeb5d854719a60d519";
    serviceRegion = "westeurope";
    phraseDiv = document.getElementById("phraseDiv");

    startRecognizeOnceAsyncButton.addEventListener("click", function () {
      startRecognizeOnceAsyncButton.disabled = true;
      phraseDiv.value = "";

      // if we got an authorization token, use the token. Otherwise use the provided subscription key
      var speechConfig;
      if (authorizationToken) {
        speechConfig = SpeechSDK.SpeechConfig.fromAuthorizationToken(authorizationToken, serviceRegion.value);
      } else {
        if (subscriptionKey.value === "" || subscriptionKey.value === "subscription") {
          alert("Please enter your Microsoft Cognitive Services Speech subscription key!");
          return;
        }
        speechConfig = SpeechSDK.SpeechConfig.fromSubscription(subscriptionKey, serviceRegion);
      }

      speechConfig.speechRecognitionLanguage = "en-US";
      var audioConfig  = SpeechSDK.AudioConfig.fromDefaultMicrophoneInput();
      recognizer = new SpeechSDK.SpeechRecognizer(speechConfig, audioConfig);

      recognizer.recognizeOnceAsync(
        function (result) {
          startRecognizeOnceAsyncButton.disabled = false;
          phraseDiv.value += result.text;
          window.console.log(result);

          // document.getElementById("myForm").submit();
          // window.location.replace("bing-search-image.php");
          recognizer.close();
          recognizer = undefined;


        },
        function (err) {
          startRecognizeOnceAsyncButton.disabled = false;
          phraseDiv.value += err;
          window.console.log(err);

          recognizer.close();
          recognizer = undefined;
        });
    });

    if (!!window.SpeechSDK) {
      SpeechSDK = window.SpeechSDK;
      startRecognizeOnceAsyncButton.disabled = false;

     
      if (typeof RequestAuthorizationToken === "function") {
          RequestAuthorizationToken();
      }
    }
  });