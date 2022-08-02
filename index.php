<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kyngtravels</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="assets/icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/styles/style.css?version=1" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/logos/SIMBOLO_1.png">
</head>
<body>
    <main class="d-flex align-items-center d-flex flex-column align-items-center">
        <h1>
          <img src="assets/logos/LOGO_HORIZONTAL_BLANCO_1.png" alt="">
        </h1>
        <br>
        <div class="container">
                <div class="countdown"></div>
        </div>
        <div class="subscribe m-4">
        <div class="social-links text-center m-3">
          <a href="https://www.instagram.com/kyngtravels/" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="https://wa.me/message/Y24MG7Y4WEWCM1" class="whatsapp"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>
    </main>

    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger chat-icon="https://mhconcepts.ml/assets/images/logo_xianCX.png"
      intent="WELCOME"
      chat-title="MoodieCX CHAT"
      agent-id="70ffe625-393c-4523-b63e-281f3537004e"
      language-code="es"
      session-id="indexKyngtravels"
      user-id="<?php echo "indexKyngtravels,data_kyngtravels";?>"
    ></df-messenger>
    <style media="screen">df-messenger {--df-messenger-bot-message: #000000;--df-messenger-user-message: #000000;--df-messenger-button-titlebar-color: #000000;--df-messenger-font-color: #fff;--df-messenger-send-icon: #fff;}</style>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script src="assets/js/count.js?version=1"></script>
</html>
