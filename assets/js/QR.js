  const modal_container = document.getElementById('modal_container');
  const html5QrCode = new Html5Qrcode("reader");
  const qrCodeSuccessCallback = (decodedText, decodedResult) => {
      StopScanner();
      console.log(decodedResult.decodedText);
      console.log(decodedResult.result.format.formatName);
      persons(decodedResult);
      //alert(decodedResult.result.format.formatName + ' - ' + decodedText);
  };
  const config = { fps: 20, qrbox: { width: 500, height: 500 } };
  var p=true;

  function StarScanner() {
    p=false;
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

  function persons(resultQR){
    if (resultQR && resultQR.result.format.formatName=="QR_CODE" && resultQR.decodedText.includes('https://kyngtravels.com/Persona')) {
      window.location.replace(resultQR.decodedText);
    }
  }
