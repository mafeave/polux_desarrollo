// Asociar el widget de validación al formulario
$("#login").validationEngine({
	promptPosition : "centerRight",
	scroll : false
});

$('#usuario').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});

$('#clave').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});

$(function() {
	$(document).tooltip({
		position : {
			my : "left+15 center",
			at : "right center"
		}
	}, {
		hide : {
			duration : 800
		}
	});
});

$(document).ready(function() {
	var table = $('#tablaReporte').DataTable();
	var cod=0;
	
	$('#tablaReporte tbody').on('click', 'tr', function() {
		$fila = table.row(this).data()
		cod = $fila[0];
//		alert(cod);
		$("#<?php echo $this->campoSeguro('informe')?>").val(cod);
//		alert($("#<?php echo $this->campoSeguro('ante')?>").val());
		if ($(this).hasClass('selected')) {
			// $(this).removeClass('selected');
		} else {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
		}
		
	});

});

$('#tablaReporte').DataTable();



$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});


