////////////////////////////////////VARIABLES GLOBALES////////////////////////////////////
var idMensajeSeleccionado = "";
//////////////////////////////////////MASCARAS//////////////////////////////////////

//#region turnos

//#endregion

//////////////////////////////////////FIN MASCARAS//////////////////////////////////////

//////////////////////////////////NOTIFICACIONES////////////////////////////////////

//#region notificaciones

//cargar notificaciones
$(document).on("click", "#notificaciones", function () {
	$.ajax({
		url: "../php/principal/notificaciones.php",
		success: function (data) {
			$("#contenedorCategoriaPrincipal").html(data);
		},
		error: function () {
			$("#contenedorCategoriaPrincipal").html(errorMsg);
		},
	});
});

//refrescar notificaciones
$(document).on("click", "#refrescarMensajes", function () {
	$("#notificaciones").click();
});

//nuevo mensaje
$(document).on("click", "#botonNuevoMensaje", function () {
	$("#modalNuevoMensaje select, #modalNuevoMensaje textarea").each(function () {
		$(this).val("");
	});
	$("#modalNuevoMensajeDestino").val("2");
	$("#modalNuevoMensajePrioridad").val("0");
	$("#modalNuevoMensaje").modal("show");
});

//eliminar mensaje (MODAL)
$(document).on("click", "#eliminarMensaje", function () {
	idMensajeSeleccionado = $(this).attr("data-id");
	$("#modalEliminarMensajeConfirmacion").val("0");
	$("#modalEliminarMensajeBoton").attr("disabled", true);
	$("#modalEliminarMensaje").modal("show");
});

//editar mensajes (MODAL)
$(document).on("click", "#editarMensaje", function () {
	idMensajeSeleccionado = $(this).attr("data-id");
	$.ajax({
		url: "../php/principal/cargarMensaje.php",
		type: "post",
		data: {
			id: idMensajeSeleccionado,
		},
		success: function (data) {
			detalles = data.split("|");
			$("#modalEditarMensajeDestino option").each(function () {
				if ($(this).val() == detalles[0]) {
					$(this).attr("selected", true);
				} else {
					$(this).removeAttr("selected");
				}
			});
			$("#modalEditarMensajeAsunto").val(detalles[1]);
			$("#modalEditarMensajeMensaje").val(detalles[2]);
			$("#modalEditarMensajePrioridad option").each(function () {
				if ($(this).val() == detalles[3]) {
					$(this).attr("selected", true);
				} else {
					$(this).removeAttr("selected");
				}
			});
			$("#modalEditarMensajeEstado option").each(function () {
				if ($(this).val() == detalles[4]) {
					$(this).attr("selected", true);
				} else {
					$(this).removeAttr("selected");
				}
			});
			$("#modalEditarMensaje").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaPrincipal").html(errorMsg);
		},
	});
});

//editar mensaje
$(document).on("click", "#modalEditarMensajeBoton", function () {
	$.ajax({
		url: "../php/principal/actualizarMensaje.php",
		type: "post",
		data: {
			destino: $("#modalEditarMensajeDestino").val(),
			asunto: $("#modalEditarMensajeAsunto").val(),
			mensaje: $("#modalEditarMensajeMensaje").val(),
			prioridad: $("#modalEditarMensajePrioridad").val(),
			estado: $("#modalEditarMensajeEstado").val(),
			id: idMensajeSeleccionado,
		},
		success: function (data) {
			$("#modalEditarMensaje").modal("hide");
			if (data == "1") {
				$("#refrescarMensajes").click();
				ohSnap("Mensaje actualizado", {
					duration: "3500",
					color: "green",
				});
			} else {
				ohSnap("Problemas al actualizar el mensaje", {
					duration: "3500",
					color: "red",
				});
			}
		},
	});
});

//validar seleccion eliminar mensaje
$(document).on("change", "#modalEliminarMensajeConfirmacion", function () {
	if ($("#modalEliminarMensajeConfirmacion").val() == "1") {
		$("#modalEliminarMensajeBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarMensajeBoton").attr("disabled", true);
	}
});

//funcion eliminar mensaje
$(document).on("click", "#modalEliminarMensajeBoton", function () {
	$.ajax({
		url: "../php/principal/eliminarMensaje.php",
		type: "post",
		data: {
			id: idMensajeSeleccionado,
		},
		success: function (data) {
			$("#modalEliminarMensaje").modal("hide");
			if (data == "1") {
				$("#refrescarMensajes").click();
				$("#notificaciones").click();
				ohSnap("Mensaje eliminado", {
					duration: "3500",
					color: "green",
				});
			} else {
				ohSnap("No se pudo eliminar el mensaje", {
					duration: "3500",
					color: "red",
				});
			}
		},
		error: function () {
			$("#contenedorCategoriaPrincipal").html(errorMsg);
		},
	});
});

//guardar mensaje
$(document).on("click", "#modalNuevoMensajeBoton", function () {
	if ($("#modalNuevoMensajeAsunto").val() == "" || $("#modalNuevoMensajeMensaje").val() == "") {
		if ($("#modalNuevoMensajeAsunto").val() == "") {
			console.log("Falta asunto");
			$("#modalNuevoMensajeAsunto").addClass("is-invalid");
			$("#modalNuevoMensajeBoton").attr("disabled", true);
			setTimeout(function () {
				$("#modalNuevoMensajeAsunto").removeClass("is-invalid");
				$("#modalNuevoMensajeBoton").removeAttr("disabled", true);
			}, 1500);
		}
		if ($("#modalNuevoMensajeMensaje").val() == "") {
			$("#modalNuevoMensajeMensaje").addClass("is-invalid");
			$("#modalNuevoMensajeBoton").attr("disabled", true);
			setTimeout(function () {
				$("#modalNuevoMensajeMensaje").removeClass("is-invalid");
				$("#modalNuevoMensajeBoton").removeAttr("disabled", true);
			}, 1500);
		}
	} else {
		$.ajax({
			url: "../php/principal/nuevoMensaje.php",
			type: "post",
			data: {
				asunto: $("#modalNuevoMensajeAsunto").val(),
				mensaje: $("#modalNuevoMensajeMensaje").val(),
				destino: $("#modalNuevoMensajeDestino").val(),
				prioridad: $("#modalNuevoMensajePrioridad").val(),
			},
			success: function (data) {
				console.log(data);
				if (data == "1") {
					$("#notificaciones").click();
					ohSnap("Mensaje guardado", {
						duration: "3500",
						color: "green",
					});
					$("#modalNuevoMensaje").modal("hide");
				} else {
					ohSnap("Problemas al guardar el mensaje", {
						duration: "3500",
						color: "red",
					});
				}
			},
			error: function () {
				$("#contenedorCategoriaPrincipal").html(errorMsg);
			},
		});
	}
});

//#endregion

//////////////////////////////////FIN NOTIFICACIONES////////////////////////////////////

//////////////////////////////////COBERTURAS MEDICAS////////////////////////////////////
//#region coberturas medicas
//cargar coberturas
// $(document).on("click", "#coberturas", function () {
// 	$.ajax({
// 		url: "../php/principal/coberturas.php",
// 		success: function (data) {
// 			$("#contenedorCategoriaPrincipal").html(data);
// 		},
// 		error: function () {
// 			$("#contenedorCategoriaPrincipal").html(errorMsg);
// 		},
// 	});
// });

// //cargar nuevas localidades en pacientes
// $(document).on("change", "#modalAgregarCoberturaSocialProvincia", function () {
// 	cargarLocalidades($(this).val()), "Cobertura";
// });

//#endregion
//////////////////////////////////FIN COBERTURAS MEDICAS////////////////////////////////////
