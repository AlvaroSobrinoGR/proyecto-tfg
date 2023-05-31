let archivo_actual = window.location.pathname;
if(!archivo_actual.includes("/index.html")){
    window.location.pathname = archivo_actual+"index.html";
}