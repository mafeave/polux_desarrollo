$("#contenido").validationEngine({ promptPosition : "centerRight",
scroll: false, autoHidePrompt: true, autoHideDelay: 2000 });

$("#tablaReporte").dataTable({ "class": "dataTable display",
"sPaginationType": "full_numbers" });


$('#<?php echo $this->campoSeguro('programa')?>').width(150);
$('#<?php echo $this->campoSeguro('programa')?>').select2();
