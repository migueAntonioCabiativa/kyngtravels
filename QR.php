
<style media="screen">

  body {
    background-color: #fff;
    font-family: 'Poppins', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    margin: 0;
  }
  button {
    background-color: #47a386;
    border: 0;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    color: #fff;
    font-size: 14px;
    padding: 10px 25px;
  }
  .QR{
    width: 100px;
    height: 100px;
  }
  .modal-container {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    pointer-events: none;
    opacity: 0;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100vw;
    transition: opacity 0.3s ease;
  }

  .modal-container a{
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 100, 135, 0.4);
      backdrop-filter: blur(10px);
      -o-backdrop-filter: blur(10px);
      -ms-backdrop-filter: blur(10px);
      -moz-backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      -webkit-transition: all .7s;
      transition: all .7s;
      cursor: default;
      z-index: 10;
  }


  .show {
    pointer-events: auto;
    opacity: 1;
  }

  .modal {
    background-color: #006487;
    max-width: 100%;
    padding: 30px 50px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    text-align: center;
    z-index: 200;
  }


  @media (orientation: landscape){
    .modal{
      width: 100vh;
    }
    .scanning{
      height: 75vh;
      margin-bottom: 3vh;
    }
    .scanning video {
      height: 100%;
    }
  }
  @media (orientation: portrait){
    .scanning{
      width: 80vw;
      margin-bottom: 3vh;
    }
  }



</style>

<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title>QR</title>
   <script src="/layouts/html5-qrcode/html5-qrcode.min.js" type="text/javascript"></script>
 </head>
 <body>
   <button onclick="StarScanner();" class="QR">
        <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc.--><path d="M48 32C21.5 32 0 53.5 0 80v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H48zm80 64v64H64V96h64zM48 288c-26.5 0-48 21.5-48 48v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48H48zm80 64v64H64V352h64zM256 80v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H304c-26.5 0-48 21.5-48 48zm64 16h64v64H320V96zm32 352v32h32V448H352zm96 0H416v32h32V448zM416 288v32H352V288H256v96 96h64V384h32v32h96V352 320 288H416z"/></svg>
    </button>

    <div id="modal_container" class="modal-container">
      <a onclick="StopScanner();"></a>
      <div class="modal">
        <div id="reader" class="scanning" ></div>
        <button onclick="StopScanner();">Cerrar</button>
      </div>
    </div>
 </body>
</html>

<script type="text/javascript">

  const html5QrCode = new Html5Qrcode("reader");
  const qrCodeSuccessCallback = (decodedText, decodedResult) => {
      StopScanner();
      console.log(decodedResult.decodedText);
      console.log(decodedResult.result.format.formatName);
      alert(decodedResult.result.format.formatName + ' - ' + decodedText);
  };
  const config = { fps: 20, qrbox: { width: 500, height: 500 } };
  var p=true;

  function StarScanner() {
    p=false
    modal_container.classList.add('show');
    html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback).catch((err) => {
      modal_container.classList.remove('show');
      console.log("Unable to start scanning, Camera can be in use");
    }).then(() => {
      p=true;
      console.log("asigned");});
  }

  function StopScanner() {
    if (p) {
      modal_container.classList.remove('show');
      html5QrCode.stop().then(ignore => {
        // QR Code scanning is stopped.
        console.log("QR Code scanning stopped.");
      }).catch(err => {
        // Stop failed, handle it.
        console.log("Unable to stop scanning.");
      });
    }else {
      console.log("Esperar");
    }
  }

</script>
