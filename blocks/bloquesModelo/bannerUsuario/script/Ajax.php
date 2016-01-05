<script type='text/javascript'>

function hora() {  
    var hora = fecha.getHours();
    var minutos = fecha.getMinutes();
    var segundos = fecha.getSeconds();
    
    if(hora < 10){ 
        hora = '0' + hora;
    }
    if(minutos < 10){
        minutos = '0' + minutos; 
    }
    if(segundos < 10){ 
        segundos = '0'+segundos; 
    }     
    fecha.setSeconds(fecha.getSeconds()+1);
    
    var fech = "Fecha: " + fecha.getFullYear() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getDate() + " " + hora +":"+minutos+":"+segundos + "";       
    
    $('#<?php echo ('bannerFecha') ?>').text( fech );
    setTimeout("hora()",1000);
}

fecha = new Date(); 
hora();

</script>

