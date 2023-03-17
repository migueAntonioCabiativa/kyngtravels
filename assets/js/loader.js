window.addEventListener('load',()=>{
  var t = document.getElementsByTagName('title')[0];
  const contenedor_loader = document.getElementById('splinner');
    if (t.text.includes('Paguina principal')) {
      setTimeout(() => {    
        contenedor_loader.style.opacity=0;
        contenedor_loader.style.visibility='hidden';
      }, 2000);
  }else {
    contenedor_loader.style.opacity=0;
    contenedor_loader.style.visibility='hidden';
  }

});
