////////////////////////////////////VARIABLES GLOBALES////////////////////////////////////
const errorMsg = '<div class="alert alert-danger">ERROR. Problemas con la conexión al servidor.</div>';
const msgTurnoCortar = `<tr>
  <td colspan="18" class="text-left"><b>Seleccione fecha para pegar el turno.</b></td>
</tr>`;
var pacienteSeleccionadoTabla = "";
var nCarnetCoberturaPrevio = "";
var nCarnetCoseguroPrevio = "";

var prestacionSeleccionadaDescripcion = "";
var prestacionSeleccionadaCodigo = "";
var prestacionSeleccionadaPrecio = "";
var prestacionSeleccionadaPlus = "";
var prestacionSeleccionadaDescuento = "";
var prestacionSeleccionadaCantidad = "";
var numeroCarnetSeleccionadoGrilla = "";
var idPacienteSeleccionadoGrilla = "";
var turnosActivo = false;
var idFechaSinAtencion = "";
var idEliminarFeriado = "";
var idPagoTurno = "";
var tipoTurnoFilaTurno = "";
//////////////////////////////////////MASCARAS//////////////////////////////////////

//#region turnos
$("#modalNuevoPacienteDNI, #ABMdniMedico, #dniMedico").mask("00000000", {placeholder: "00000000"});
$("#modalNuevoPacienteTelFijo1").mask("(0000)000000", {placeholder: "(0000)000000"});
$("#modalNuevoPacienteTelFijo2").mask("(0000)000000", {placeholder: "(0000)0000000"});
$("#ABMcelularMedico").mask("(000)0-000-000", {placeholder: "(000)0-000-000"});
$("#modalAgregarDatosPacienteHora").mask("00:00", {placeholder: "hh:mm"});
//#endregion

//////////////////////////////////////FIN MASCARAS//////////////////////////////////////

//////////////////////////////////MENSAJES////////////////////////////////////

//cargar mensajes
function cargarMensajes() {
	if ($("#numeroMensajes").text() == "0") {
		$("#numeroMensajes").hide();
	} else {
		$("#numeroMensajes").show();
	}
	$.ajax({
		url: "../php/receptionAdministration/obtenerMensajes.php",
		success: function (data) {
			$("#sobre").attr("data-content", data);
		},
		error: function () {
			ohSnap("No se pudo cargar las notificaciones", {
				duration: "3500",
				color: "red",
			});
		},
	});

	contarMensajes();

	setTimeout(function () {
		cargarMensajes();
	}, 2500);
}

//contar mensajes
function contarMensajes() {
	$.ajax({
		url: "../php/receptionAdministration/contarMensajes.php",
		success: function (data) {
			$("#numeroMensajes").html(data);
		},
	});
}

//cargar mensaje
$(document).on("click", "#listaMensajes li", function () {
	const idMenasje = $(this).attr("id")[3];
	$("#sobre").click();
	console.log(idMenasje);
	$("#modalVerMensajeContenido").html("Mensaje N°" + idMenasje);
	$("#modalVerMensaje").modal("show");
	obtenerInformacionMensaje(idMenasje);
	cargarMensajes();
});

//obtener informacion mensaje
function obtenerInformacionMensaje(idM) {
	$.ajax({
		url: "../php/receptionAdministration/cargarDetallesMensaje.php",
		type: "post",
		data: {
			id: idM,
		},
		success: function (data) {
			info = data.split("|");
			$("#fechaMensaje").html(info[0]);
			$("#remitenteMensaje").html(info[1]);
			$("#destinoMensaje").html(info[2]);
			$("#asuntoMensaje").html(info[3]);
			$("#contenidoMensaje").html(info[4]);
		},
	});
}

//////////////////////////////////FIN MENSAJES////////////////////////////////////

//////////////////////////////////ADMINISTRACION////////////////////////////////////
var idMedicoCoberturaSocialSeleccionada = "";
var idCobertura = "";
var idMedicoCambiarFoto = "";
var idMedicoAjuste = "";
//#region ABMMedicos

//mostrar ABM medicos
$("#recepcionABMMedicos").on("click", function () {
	$.ajax({
		url: "../php/receptionAdministration/ABMMedicos.php",
		success: function (data) {
			$("#contenedorCategoriaRecepcion").html(data);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//cargar datos del medico para editar
function cargarDatosMedicoEditar(str) {
	$.ajax({
		url: "../php/receptionAdministration/cargarDatosMedico.php",
		type: "post",
		data: {
			id: str,
		},
		success: function (data) {
			detalles = data.split("|");
			if (detalles[0] == "true") {
				$("#ABMestadoMedico").attr("checked", true);
			} else {
				$("#ABMestadoMedico").removeAttr("checked");
			}
			$("#ABMnumeroMatriculaMedico").val(detalles[1]);
			$("#ABMfechaMatriculaMedico").val(detalles[2]);
			$("#ABMapellidoMedico").val(detalles[3]);
			$("#ABMnombreMedico").val(detalles[4]);
			$("#ABMdniMedico").val(detalles[5]);
			$("#ABMdomicilioMedico").val(detalles[6]);
			$("#ABMtelefono_particularMedico").val(detalles[7]);
			$("#ABMtelefono_consultorioMedico").val(detalles[8]);
			$("#ABMcelularMedico").val(detalles[9]);
			$("#ABMusuarioMedico option").each(function () {
				if ($(this).val() == detalles[10]) {
					$(this).attr("selected", true);
				} else {
					$(this).removeAttr("selected");
				}
			});
			$("#ABMespecialidadMedico option").each(function () {
				if ($(this).val() == detalles[11]) {
					$(this).attr("selected", true);
				} else {
					$(this).removeAttr("selected");
				}
			});
			$("#ABManestesistaMedico option").each(function () {
				if ($(this).val() == detalles[12]) {
					$(this).attr("selected", true);
				} else {
					$(this).removeAttr("selected");
				}
			});
			$("#ABMobservacionesMedico").val(detalles[13]);
			$("#ABMImagenMedico").attr("src", "../img/users/" + detalles[14]);
			$("#ABMBotonCambiarImagenMedico").attr("data-usuario", detalles[15]);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//validar codigo de medico
$(document).on("keyup", "#codigoMedico", () => {
	if ($.isNumeric($("#codigoMedico").val())) {
		$("#codigoMedico").addClass("is-valid").removeClass("is-invalid");
		$("#estadoMedico").removeAttr("disabled");
		$("#userMedico").removeAttr("disabled");
		$("#dniMedico").removeAttr("disabled");
		$("#apellidoMedico").removeAttr("disabled");
		$("#nombreMedico").removeAttr("disabled");
		$("#domicilioMedico").removeAttr("disabled");
		$("#telParticularMedico").removeAttr("disabled");
		$("#celMedico").removeAttr("disabled");
		$("#telefonoConsultorio").removeAttr("disabled");
		$("#especialidadMedico").removeAttr("disabled");
		$("#fechaMatricula").removeAttr("disabled");
		$("#consultorio").removeAttr("disabled");
		$("#anestesista").removeAttr("disabled");
		$("#observacionMedico").removeAttr("disabled");
		$("#tiempoDeAtencionLun").removeAttr("disabled");
		$("#tiempoDeAtencionMar").removeAttr("disabled");
		$("#tiempoDeAtencionMie").removeAttr("disabled");
		$("#tiempoDeAtencionJue").removeAttr("disabled");
		$("#tiempoDeAtencionVie").removeAttr("disabled");
		$("#tiempoDeAtencionSab").removeAttr("disabled");
		$("#tiempoDeAtencionDom").removeAttr("disabled");
		$("#botonGuardarDatosMedico").removeAttr("disabled");
	} else {
		$("#codigoMedico").addClass("is-invalid").removeClass("is-valid");
		$("#estadoMedico").attr("disabled", "disabled");
		$("#userMedico").attr("disabled", "disabled");
		$("#dniMedico").attr("disabled", "disabled");
		$("#apellidoMedico").attr("disabled", "disabled");
		$("#nombreMedico").attr("disabled", "disabled");
		$("#domicilioMedico").attr("disabled", "disabled");
		$("#telParticularMedico").attr("disabled", "disabled");
		$("#celMedico").attr("disabled", "disabled");
		$("#telefonoConsultorio").attr("disabled", "disabled");
		$("#especialidadMedico").attr("disabled", "disabled");
		$("#fechaMatricula").attr("disabled", "disabled");
		$("#consultorio").attr("disabled", "disabled");
		$("#anestesista").attr("disabled", "disabled");
		$("#observacionMedico").attr("disabled", "disabled");
		$("#tiempoDeAtencionLun").attr("disabled", "disabled");
		$("#tiempoDeAtencionMar").attr("disabled", "disabled");
		$("#tiempoDeAtencionMie").attr("disabled", "disabled");
		$("#tiempoDeAtencionJue").attr("disabled", "disabled");
		$("#tiempoDeAtencionVie").attr("disabled", "disabled");
		$("#tiempoDeAtencionSab").attr("disabled", "disabled");
		$("#tiempoDeAtencionDom").attr("disabled", "disabled");
		$("#botonGuardarDatosMedico").attr("disabled", "disabled");
	}
});

//validar dni 8 numero o una letra y 7 numeros
$(document).on("keyup change", "#dniMedico", () => {
	var contador = 0;
	if (dniMedico.value.length == 8 && $.isNumeric($("#dniMedico").val())) {
		$("#dniMedico").addClass("is-valid").removeClass("is-invalid");
		$("#botonGuardarDatosMedico").removeAttr("disabled");
	} else if ($.isNumeric($("#dniMedico").val()[0]) == false) {
		for ($i = 0; $i < dniMedico.value.length; $i++) {
			if ($.isNumeric($("#dniMedico").val()[$i]) == false && $i == 0) {
				contador++;
				if ($.isNumeric($("#dniMedico").val()[$i]) && $i > 0) {
					contador++;
				}
				if (contador == 1 && dniMedico.value.length == 8) {
					$("#dniMedico").addClass("is-valid").removeClass("is-invalid");
					$("#botonGuardarDatosMedico").removeAttr("disabled");
				} else {
					$("#dniMedico").addClass("is-invalid").removeClass("is-valid");
					$("#botonGuardarDatosMedico").attr("disabled", "disabled");
				}
			}
		}
	} else {
		$("#dniMedico").addClass("is-invalid").removeClass("is-valid");
		$("#botonGuardarDatosMedico").attr("disabled", "disabled");
	}
});

//guardar doctor (MODAL)
$(document).on("click", "#crearNuevoDoctor", function () {
	$("#modalGuardarMedico .modal-body input").each(function () {
		$(this).val("");
		$(this).attr("disabled", true);
	});
	$("#codigoMedico").removeAttr("disabled");
	$("#dniMedico").removeClass("is-invalid");
	$("#especialidadMedico").val("0").attr("disabled", true);
	$("#anestesista").val("0");
	$("#userMedico").attr("disabled", true);
	$("#observacionMedico").val("");
	$("#modalGuardarMedico").modal("show");
});

//guardar doctor
$(document).on("click", "#botonGuardarDatosMedico", function () {
	var estado = "";
	$("#modalGuardarMedicoBoton").removeAttr("disabled");
	if (
		$("#codigoMedico").val() != "" &&
		$("#dniMedico").val() != "" &&
		$("#celMedico").val() != "" &&
		$("#apellidoMedico").val() != "" &&
		$("#nombreMedico").val() != "" &&
		$("#fechaMatricula").val() != ""
	) {
		if ($("#estadoMedico").prop("checked")) {
			estado = "true";
		} else {
			estado = "false";
		}
		if ($("#telParticularMedico").val() == "") {
			telParticular = "-";
		} else {
			telParticular = $("#telParticularMedico").val();
		}
		if ($("#observacionMedico").val() == "") {
			obs = "-";
		} else {
			obs = $("#observacionMedico").val();
		}
		if ($("#telefonoConsultorio").val() == "") {
			telConsultorio = "-";
		} else {
			telConsultorio = $("#telefonoConsultorio").val();
		}
		if ($("#anestesista").prop("checked")) {
			valorAnestesista = "1";
		} else {
			valorAnestesista = "0";
		}
		$.ajax({
			url: "../php/receptionAdministration/saveDoc.php",
			type: "post",
			data: {
				codigo: $("#codigoMedico").val(),
				usuario: $("#userMedico").val(),
				dni: $("#dniMedico").val(),
				apellido: $("#apellidoMedico").val(),
				nombre: $("#nombreMedico").val(),
				domicilio: $("#domicilioMedico").val(),
				telefono: telParticular,
				celular: $("#celMedico").val(),
				telefono_consultorio: telConsultorio,
				especialidad: $("#especialidadMedico").val(),
				matricula: $("#fechaMatricula").val(),
				anestesista: valorAnestesista,
				observaciones: obs,
				activo: estado,
			},
			success: function () {
				if ($("#estadoMedico").prop("cheked")) {
					$("#estadoMedico").click();
				}
				$("#codigoMedico").val("").attr("disabled", "disabled");
				$("#codigoMedico").removeClass("is-valid").attr("disabled", "disabled");
				$("#userMedico").val("").attr("disabled", "disabled");
				$("#dniMedico").val("").attr("disabled", "disabled");
				$("#dniMedico").removeClass("is-valid").attr("disabled", "disabled");
				$("#apellidoMedico").val("").attr("disabled", "disabled");
				$("#nombreMedico").val("").attr("disabled", "disabled");
				$("#domicilioMedico").val("").attr("disabled", "disabled");
				$("#telParticularMedico").val("").attr("disabled", "disabled");
				$("#celMedico").val("").attr("disabled", "disabled");
				$("#telefonoConsultorio").val("").attr("disabled", "disabled");
				$("#especialidadMedico").val("").attr("disabled", "disabled");
				$("#fechaMatricula").val("").attr("disabled", "disabled");
				$("#consultorio").val("").attr("disabled", "disabled");
				$("#observacionMedico").val("").attr("disabled", "disabled");
				$("#tiempoDeAtencionLun").val("1").attr("disabled", "disabled");
				$("#tiempoDeAtencionMar").val("1").attr("disabled", "disabled");
				$("#tiempoDeAtencionMie").val("1").attr("disabled", "disabled");
				$("#tiempoDeAtencionJue").val("1").attr("disabled", "disabled");
				$("#tiempoDeAtencionVie").val("1").attr("disabled", "disabled");
				$("#tiempoDeAtencionSab").val("1").attr("disabled", "disabled");
				$("#tiempoDeAtencionDom").val("1").attr("disabled", "disabled");
				$("#modalGuardarMedico").modal("hide");
				$("#recepcionABMMedicos").click();
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	} else {
		$("#botonGuardarDatosMedico").attr("disabled", "disabled");
		if ($("#dniMedico").val() == "") {
			$("#dniMedico").addClass("is-invalid");
		}
		if ($("#codigoMedico").val() == "") {
			$("#codigoMedico").addClass("is-invalid");
		}
		if ($("#celMedico").val() == "") {
			$("#celMedico").addClass("is-invalid");
		}
		if ($("#apellidoMedico").val() == "") {
			$("#apellidoMedico").addClass("is-invalid");
		}
		if ($("#nombreMedico").val() == "") {
			$("#nombreMedico").addClass("is-invalid");
		}
		if ($("#fechaMatricula").val() == "") {
			$("#fechaMatricula").addClass("is-invalid");
		}
		setTimeout(function () {
			$("#botonGuardarDatosMedico").removeAttr("disabled");
			$("#dniMedico, #codigoMedico, #celMedico, #apellidoMedico, #nombreMedico, #fechaMatricula").removeClass("is-invalid");
		}, 1500);
	}
});

//cargar coberturas sociales del medico y otros horarios
// $(document).on("change", "#cronogramaNombreMedico", function () {
// 	obtenerCoberturasSociales(idMedicoAjuste);
// 	//obtenerOtrosHorarios($("#cronogramaNombreMedico").val());
// });

//obtener cobrerturas sociales relacionadas
function obtenerCoberturasSociales(idMedico) {
	$.ajax({
		url: "../php/receptionAdministration/cargarCoberturasSocialesVinculadas.php",
		type: "post",
		data: {
			id: idMedico,
		},
		success: function (data) {
			$("#contenidoCoberturasSociales").html(data);
			if ($("#ABMnumeroMatriculaMedico").prop("disabled")) {
				$("#contenidoCoberturasSociales #coberturaCheck").each(function () {
					$(this).attr("disabled", true);
				});
			} else {
				$("#contenidoCoberturasSociales #coberturaCheck").each(function () {
					$(this).removeAttr("disabled", true);
				});
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//cargar tiempo de consultas
$(document).on("click", "#ajustesMedico", function () {
	setTimeout(() => {
		$("#ABMBotonCambiarImagenMedico").removeAttr("style");
	}, 200);
	idMedicoAjuste = $(this).attr("data-id");
	nombreMedico = $(this).attr("data-medicoNombre");
	$("#modalOpcionesMedicoLabel").html("Ajustes de <b>" + nombreMedico + "</b>");
	cargarDatosMedicoEditar(idMedicoAjuste);

	//detalles medicos
	$("#datosConsulta input, #datosConsulta select").each(function () {
		$(this).removeAttr("disabled");
	});
	$("#ABMobservacionesMedico").removeAttr("disabled");
	$(
		"#ABMBotonActualizarMedico, #ABMBotonCambiarImagenMedico, #actualizarOtrosHorarios, #opcionAsignarTodo, #opcionRefrescarCoberturas, #horariosSinAtencionPorMedicoBoton"
	).show();
	//cronogramas
	setTimeout(function () {
		$("#modalOpcionesMedico input, #modalOpcionesMedico select, #modalOpcionesMedico textarea").each(function () {
			$(this).removeAttr("disabled");
		});
	}, 300);
	$("#modelosFichaVerDoctor").show();
	$("#datosConsulta-tab").click();
	$("#modalOpcionesMedico").modal("show");
	$.ajax({
		url: "../php/receptionAdministration/cargarTiempoConsulta.php",
		type: "post",
		data: {
			idMedico: idMedicoAjuste,
		},
		success: function (data) {
			verHorariosSemanales(idMedicoAjuste);
			verHorariosSinAtencion(idMedicoAjuste);
			info = data.split("|");
			$("#tiempoAtencionLun").val(info[0]);
			$("#tiempoAtencionMar").val(info[1]);
			$("#tiempoAtencionMie").val(info[2]);
			$("#tiempoAtencionJue").val(info[3]);
			$("#tiempoAtencionVie").val(info[4]);
			$("#tiempoAtencionSab").val(info[5]);
			$("#tiempoAtencionDom").val(info[6]);
			const telefono = info[7].replace("(", "").replace(")", "").replace("-", "").replace("-", "");
			$("#infoTel").html('<a href="tel:' + telefono + '" target="_blank">' + telefono + "</a>");
			$("#infoWhatsapp").html('<a href="https://api.whatsapp.com/send?phone=54' + telefono + '" target="_blank">' + telefono + "</a>");
			$("#consultorioLun").val(info[8]);
			$("#consultorioMar").val(info[9]);
			$("#consultorioMie").val(info[10]);
			$("#consultorioJue").val(info[11]);
			$("#consultorioVie").val(info[12]);
			$("#consultorioSab").val(info[13]);
			$("#consultorioDom").val(info[14]);
			$("#otroTiempoLun").val(info[15]);
			$("#otroTiempoMar").val(info[16]);
			$("#otroTiempoMie").val(info[17]);
			$("#otroTiempoJue").val(info[18]);
			$("#otroTiempoVie").val(info[19]);
			$("#otroTiempoSab").val(info[20]);
			$("#otroTiempoDom").val(info[21]);
			$("#otroConsultorioLun").val(info[22]);
			$("#otroConsultorioMar").val(info[23]);
			$("#otroConsultorioMie").val(info[24]);
			$("#otroConsultorioJue").val(info[25]);
			$("#otroConsultorioVie").val(info[26]);
			$("#otroConsultorioSab").val(info[27]);
			$("#otroConsultorioDom").val(info[28]);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ver detalles del doctor
$(document).on("click", "#verDetallesDoctor", function () {
	idMedicoDetalles = $(this).attr("data-id");
	idMedicoAjuste = idMedicoDetalles;
	nombreMedico = $(this).attr("data-medicoNombre");
	$("#modalOpcionesMedicoLabel").html("Ajustes de <b>" + nombreMedico + "</b>");
	cargarDatosMedicoEditar(idMedicoDetalles);
	//detalles medicos
	$("#datosConsulta input, #datosConsulta select").each(function () {
		$(this).attr("disabled", true);
	});
	$("#ABMobservacionesMedico").attr("disabled", true);
	$(
		"#ABMBotonActualizarMedico, #ABMBotonCambiarImagenMedico, #actualizarOtrosHorarios, #opcionAsignarTodo, #opcionRefrescarCoberturas, #horariosSinAtencionPorMedicoBoton"
	).hide();
	//cronogramas
	setTimeout(function () {
		$("#modalOpcionesMedico input, #modalOpcionesMedico select, #modalOpcionesMedico textarea").each(function () {
			$(this).attr("disabled", true);
		});
	}, 300);
	$("#modelosFichaVerDoctor").hide();
	$("#datosConsulta-tab").click();
	$("#modalOpcionesMedico").modal("show");
	$.ajax({
		url: "../php/receptionAdministration/cargarTiempoConsulta.php",
		type: "post",
		data: {
			idMedico: idMedicoDetalles,
		},
		success: function (data) {
			verHorariosSemanales(idMedicoDetalles);
			verHorariosSinAtencion(idMedicoDetalles);
			info = data.split("|");
			$("#tiempoAtencionLun").val(info[0]);
			$("#tiempoAtencionMar").val(info[1]);
			$("#tiempoAtencionMie").val(info[2]);
			$("#tiempoAtencionJue").val(info[3]);
			$("#tiempoAtencionVie").val(info[4]);
			$("#tiempoAtencionSab").val(info[5]);
			$("#tiempoAtencionDom").val(info[6]);
			const telefono = info[7].replace("(", "").replace(")", "").replace("-", "").replace("-", "");
			$("#infoTel").html('<a href="tel:' + telefono + '" target="_blank">' + telefono + "</a>");
			$("#infoWhatsapp").html('<a href="https://api.whatsapp.com/send?phone=' + telefono + '" target="_blank">' + telefono + "</a>");
			$("#consultorioLun").val(info[8]);
			$("#consultorioMar").val(info[9]);
			$("#consultorioMie").val(info[10]);
			$("#consultorioJue").val(info[11]);
			$("#consultorioVie").val(info[12]);
			$("#consultorioSab").val(info[13]);
			$("#consultorioDom").val(info[14]);
			$("#otroTiempoLun").val(info[15]);
			$("#otroTiempoMar").val(info[16]);
			$("#otroTiempoMie").val(info[17]);
			$("#otroTiempoJue").val(info[18]);
			$("#otroTiempoVie").val(info[19]);
			$("#otroTiempoSab").val(info[20]);
			$("#otroTiempoDom").val(info[21]);
			$("#otroConsultorioLun").val(info[22]);
			$("#otroConsultorioMar").val(info[23]);
			$("#otroConsultorioMie").val(info[24]);
			$("#otroConsultorioJue").val(info[25]);
			$("#otroConsultorioVie").val(info[26]);
			$("#otroConsultorioSab").val(info[27]);
			$("#otroConsultorioDom").val(info[28]);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//#region actualizar consultorios
//actualizar consultorio lunes
$(document).on("change", "#consultorioLun", function () {
	$.ajax({
		url: "../php/receptionAdministration/actuaizarConsultorio.php",
		type: "post",
		data: {
			dia: "lun",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#infoL").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#infoL").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoL").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio martes
$(document).on("change", "#consultorioMar", function () {
	$.ajax({
		url: "../php/receptionAdministration/actuaizarConsultorio.php",
		type: "post",
		data: {
			dia: "mar",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#infoM").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#infoM").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoM").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio mmiercoles
$(document).on("change", "#consultorioMie", function () {
	$.ajax({
		url: "../php/receptionAdministration/actuaizarConsultorio.php",
		type: "post",
		data: {
			dia: "mie",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#infoX").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#infoX").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoX").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio jueves
$(document).on("change", "#consultorioJue", function () {
	$.ajax({
		url: "../php/receptionAdministration/actuaizarConsultorio.php",
		type: "post",
		data: {
			dia: "jue",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#infoJ").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#infoJ").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoJ").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio viernes
$(document).on("change", "#consultorioVie", function () {
	$.ajax({
		url: "../php/receptionAdministration/actuaizarConsultorio.php",
		type: "post",
		data: {
			dia: "vie",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#infoV").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#infoV").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoV").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio sabado
$(document).on("change", "#consultorioSab", function () {
	$.ajax({
		url: "../php/receptionAdministration/actuaizarConsultorio.php",
		type: "post",
		data: {
			dia: "sab",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#infoS").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#infoS").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoS").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio domingo
$(document).on("change", "#consultorioDom", function () {
	$.ajax({
		url: "../php/receptionAdministration/actuaizarConsultorio.php",
		type: "post",
		data: {
			dia: "dom",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#infoD").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#infoD").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoD").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});
//#endregion

//#region actualizar otros consultorios
//actualizar consultorio lunes
$(document).on("change", "#otroConsultorioLun", function () {
	$.ajax({
		url: "../php/receptionAdministration/actualizarOtroConsultorio.php",
		type: "post",
		data: {
			dia: "lun",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#oInfoL").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#oInfoL").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoL").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio martes
$(document).on("change", "#otroConsultorioMar", function () {
	$.ajax({
		url: "../php/receptionAdministration/actualizarOtroConsultorio.php",
		type: "post",
		data: {
			dia: "mar",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#oInfoM").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#oInfoM").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoM").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio mmiercoles
$(document).on("change", "#otroConsultorioMie", function () {
	$.ajax({
		url: "../php/receptionAdministration/actualizarOtroConsultorio.php",
		type: "post",
		data: {
			dia: "mie",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#oInfoX").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#oInfoX").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoX").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio jueves
$(document).on("change", "#otroConsultorioJue", function () {
	$.ajax({
		url: "../php/receptionAdministration/actualizarOtroConsultorio.php",
		type: "post",
		data: {
			dia: "jue",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#oInfoJ").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#oInfoJ").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoJ").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio viernes
$(document).on("change", "#otroConsultorioVie", function () {
	$.ajax({
		url: "../php/receptionAdministration/actualizarOtroConsultorio.php",
		type: "post",
		data: {
			dia: "vie",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#oInfoV").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#oInfoV").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoV").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio sabado
$(document).on("change", "#otroConsultorioSab", function () {
	$.ajax({
		url: "../php/receptionAdministration/actualizarOtroConsultorio.php",
		type: "post",
		data: {
			dia: "sab",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#oInfoS").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#oInfoS").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoS").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar consultorio domingo
$(document).on("change", "#otroConsultorioDom", function () {
	$.ajax({
		url: "../php/receptionAdministration/actualizarOtroConsultorio.php",
		type: "post",
		data: {
			dia: "dom",
			consultorio: $(this).val(),
			idMedico: idMedicoAjuste,
		},
		beforeSend: function () {
			$("#oInfoD").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function (data) {
			$("#oInfoD").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoD").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});
//#endregion

//ver horarios semanales
function verHorariosSemanales(medico) {
	$.ajax({
		url: "../php/receptionAdministration/cargarHorariosSemanales.php",
		type: "post",
		data: {
			idMedico: medico,
		},
		success: function (data) {
			$("#listaHorariosSemanales").html(data);
			setTimeout(function () {
				if ($("#tiempoAtencionDom").val() == "-") {
					$("#consultorioDom, #apSemanaDom1, #ciSemanaDom1, #apSemanaDom2, #ciSemanaDom2").attr("disabled", true);
				} else {
					$("#consultorioDom, #apSemanaDom1, #ciSemanaDom1, #apSemanaDom2, #ciSemanaDom2").removeAttr("disabled");
				}
			}, 1000);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//horarios sin atencion
function verHorariosSinAtencion(medico) {
	$.ajax({
		url: "../php/receptionAdministration/diasSinAtencionMedico.php",
		type: "post",
		data: {
			id: medico,
		},
		success: function (data) {
			if (data == "0") {
				$("#diasSinAtencion").html("<p class='text-info'><b>El médico seleccionado no tiene días sin atención.</b></p>");
			} else {
				$("#diasSinAtencion").html(data);
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//dias sin atencion medicos
// $(document).on("click", "#verDiasSinAtencionMedicos", function () {
// 	const medico = $(this).attr("data-id");
// 	console.log("dias sin atencion");
// 	$("#ABMDiasSinAtencionPorMedico").click();
// 	setTimeout(function () {
// 		$("#horarioSinAtencionDoctor option[value=" + medico + "]").attr("selected", true);
// 		$("#horarioSinAtencionDoctor").click();
// 	}, 1000);
// });

//actualizar otros horarios
$(document).on("click", "#actualizarOtrosHorarios", function () {
	$.ajax({
		url: "../php/receptionAdministration/actualizarOtrosHorarios.php",
		type: "post",
		data: {
			idMedico: idMedicoAjuste,
			desde: $("#aplicableDesdeFecha").val(),
			hasta: $("#aplicableHastaFecha").val(),
			oHApLun1: $("#otrosHorariosApLun1").val(),
			oHCiLun1: $("#otrosHorariosCiLun1").val(),
			oHApMar1: $("#otrosHorariosApMar1").val(),
			oHCiMar1: $("#otrosHorariosCiMar1").val(),
			oHApMie1: $("#otrosHorariosApMie1").val(),
			oHCiMie1: $("#otrosHorariosCiMie1").val(),
			oHApJue1: $("#otrosHorariosApJue1").val(),
			oHCiJue1: $("#otrosHorariosCiJue1").val(),
			oHApVie1: $("#otrosHorariosApVie1").val(),
			oHCiVie1: $("#otrosHorariosCiVie1").val(),
			oHApSab1: $("#otrosHorariosApSab1").val(),
			oHCiSab1: $("#otrosHorariosCiSab1").val(),
			oHApDom1: $("#otrosHorariosApDom1").val(),
			oHCiDom1: $("#otrosHorariosCiDom1").val(),
			oHApLun2: $("#otrosHorariosApLun2").val(),
			oHCiLun2: $("#otrosHorariosCiLun2").val(),
			oHApMar2: $("#otrosHorariosApMar2").val(),
			oHCiMar2: $("#otrosHorariosCiMar2").val(),
			oHApMie2: $("#otrosHorariosApMie2").val(),
			oHCiMie2: $("#otrosHorariosCiMie2").val(),
			oHApJue2: $("#otrosHorariosApJue2").val(),
			oHCiJue2: $("#otrosHorariosCiJue2").val(),
			oHApVie2: $("#otrosHorariosApVie2").val(),
			oHCiVie2: $("#otrosHorariosCiVie2").val(),
			oHApSab2: $("#otrosHorariosApSab2").val(),
			oHCiSab2: $("#otrosHorariosCiSab2").val(),
			oHApDom2: $("#otrosHorariosApDom2").val(),
			oHCiDom2: $("#otrosHorariosCiDom2").val(),
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				$("#aplicableDesdeFecha").val("");
				$("#aplicableHastaFecha").val("");
				$("#otrosHorariosApLun1").val("");
				$("#otrosHorariosCiLun1").val("");
				$("#otrosHorariosApMar1").val("");
				$("#otrosHorariosCiMar1").val("");
				$("#otrosHorariosApMie1").val("");
				$("#otrosHorariosCiMie1").val("");
				$("#otrosHorariosApJue1").val("");
				$("#otrosHorariosCiJue1").val("");
				$("#otrosHorariosApVie1").val("");
				$("#otrosHorariosCiVie1").val("");
				$("#otrosHorariosApSab1").val("");
				$("#otrosHorariosCiSab1").val("");
				$("#otrosHorariosApDom1").val("");
				$("#otrosHorariosCiDom1").val("");
				$("#otrosHorariosApLun2").val("");
				$("#otrosHorariosCiLun2").val("");
				$("#otrosHorariosApMar2").val("");
				$("#otrosHorariosCiMar2").val("");
				$("#otrosHorariosApMie2").val("");
				$("#otrosHorariosCiMie2").val("");
				$("#otrosHorariosApJue2").val("");
				$("#otrosHorariosCiJue2").val("");
				$("#otrosHorariosApVie2").val("");
				$("#otrosHorariosCiVie2").val("");
				$("#otrosHorariosApSab2").val("");
				$("#otrosHorariosCiSab2").val("");
				$("#otrosHorariosApDom2").val("");
				$("#otrosHorariosCiDom2").val("");
				$("#otrosHorarios-tab").click();
			} else {
				ohSnap("No se guardaron los cambios. Revise su conexión a internet.", {
					duration: "3500",
					color: "red",
				});
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//cargar otros horarios
$(document).on("click", "#otrosHorarios-tab", function () {
	$.ajax({
		url: "../php/receptionAdministration/cargarOtrosHorarios.php",
		type: "post",
		data: {
			id: idMedicoAjuste,
		},
		success: function (data) {
			$("#contenidoOtrosHorarios").html(data);
			$("#aplicableDesdeFecha, #aplicableHastaFecha").val("");
			$("#inputsOtrosHorarios input").each(function () {
				$(this).val("").attr("disabled", true);
			});
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//habilitar inputs para guardar horarios
$(document).on("change", "#aplicableHastaFecha", function () {
	$("#inputsOtrosHorarios input").each(function () {
		$(this).val("").removeAttr("disabled");
	});
});

//eliminar otro horario (MODAL)
$(document).on("click", "#eliminarOtroHorario", function () {
	$("#modalEliminarOtroHorarioConfirmacion").val("0");
	$("#modalEliminarOtroHorarioBoton").attr("disabled", true);
	$("#modalEliminarOtroHorario").modal("show");
});

//validar seleccion eliminar otro horario
$(document).on("click", "#modalEliminarOtroHorarioConfirmacion", function () {
	if ($("#modalEliminarOtroHorarioConfirmacion").val() == "1") {
		$("#modalEliminarOtroHorarioBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarOtroHorarioBoton").attr("disabled", true);
	}
});

//funcion eliminar otro horario
$(document).on("click", "#modalEliminarOtroHorarioBoton", function () {
	const idMedico = $(this).attr("data-id");
	$.ajax({
		url: "../php/receptionAdministration/eliminarOtroHorario.php",
		type: "post",
		data: {
			id: idMedico,
		},
		success: function (data) {
			if (data == "1") {
				$("#otrosHorarios-tab").click();
				ohSnap("Regla eliminada.", {
					duration: "3500",
					color: "green",
				});
			} else {
				ohSnap("Problemas al eliminar la regla. Revise su conexión a Internet.", {
					duration: "3500",
					color: "red",
				});
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//buscar datos de regla
$(document).on("click", "#modificarOtroHorario", function () {
	$.ajax({
		url: "../php/receptionAdministration/cargarRegla.php",
		type: "post",
		data: {
			id: idMedicoAjuste,
		},
		success: function (data) {
			$("#inputsOtrosHorarios input").each(function () {
				$(this).removeAttr("disabled");
			});
			hora = data.split("|");
			$("#aplicableDesdeFecha").val(hora[0]);
			$("#aplicableHastaFecha").val(hora[1]);
			$("#otrosHorariosApLun1").val(hora[2]);
			$("#otrosHorariosCiLun1").val(hora[3]);
			$("#otrosHorariosApMar1").val(hora[4]);
			$("#otrosHorariosCiMar1").val(hora[5]);
			$("#otrosHorariosApMie1").val(hora[6]);
			$("#otrosHorariosCiMie1").val(hora[7]);
			$("#otrosHorariosApJue1").val(hora[8]);
			$("#otrosHorariosCiJue1").val(hora[9]);
			$("#otrosHorariosApVie1").val(hora[10]);
			$("#otrosHorariosCiVie1").val(hora[11]);
			$("#otrosHorariosApSab1").val(hora[12]);
			$("#otrosHorariosCiSab1").val(hora[13]);
			$("#otrosHorariosApDom1").val(hora[14]);
			$("#otrosHorariosCiDom1").val(hora[15]);
			$("#otrosHorariosApLun2").val(hora[18]);
			$("#otrosHorariosCiLun2").val(hora[19]);
			$("#otrosHorariosApMar2").val(hora[20]);
			$("#otrosHorariosCiMar2").val(hora[21]);
			$("#otrosHorariosApMie2").val(hora[22]);
			$("#otrosHorariosCiMie2").val(hora[23]);
			$("#otrosHorariosApJue2").val(hora[24]);
			$("#otrosHorariosCiJue2").val(hora[25]);
			$("#otrosHorariosApVie2").val(hora[26]);
			$("#otrosHorariosCiVie2").val(hora[27]);
			$("#otrosHorariosApSab2").val(hora[28]);
			$("#otrosHorariosCiSab2").val(hora[29]);
			$("#otrosHorariosApDom2").val(hora[30]);
			$("#otrosHorariosCiDom2").val(hora[31]);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//#region HORARIOS

//#region horarios semanales 1er turno
//ajustar apertura dias lunes
$(document).on("change", "#apSemanaLun1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionLun").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaLun1").val(),
			idMedico: idMedicoAjuste,
			dia: "apLun",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemL").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemL").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemL").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#apSemanaLun1").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaLun1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar cierre dias lunes
$(document).on("change", "#ciSemanaLun1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionLun").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaLun1").val(),
			idMedico: idMedicoAjuste,
			dia: "ciLun",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemL").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemL").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			$("#ciSemanaLun1").addClass("text-success");
			setTimeout(function () {
				$("#infoSemL").html("");
				$("#ciSemanaLun1").removeClass("text-success");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#ciSemanaLun1").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaLun1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar apertura dias martes
$(document).on("change", "#apSemanaMar1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionMar").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaMar1").val(),
			idMedico: idMedicoAjuste,
			dia: "apMar",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemM").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemM").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemM").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#apSemanaMar1").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaMar1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar cierre dias martes
$(document).on("change", "#ciSemanaMar1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionMar").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaMar1").val(),
			idMedico: idMedicoAjuste,
			dia: "ciMar",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemM").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemM").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemM").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#ciSemanaMar1").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaMar1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar apertura dias miercoles
$(document).on("change", "#apSemanaMie1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionMie").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaMie1").val(),
			idMedico: idMedicoAjuste,
			dia: "apMie",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemX").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemX").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemX").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#apSemanaMie1").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaMie1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar cierre dias miercoles
$(document).on("change", "#ciSemanaMie1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionMie").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaMie1").val(),
			idMedico: idMedicoAjuste,
			dia: "ciMie",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemX").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemX").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemX").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#ciSemanaMie1").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaMie1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar apertura dias jueves
$(document).on("change", "#apSemanaJue1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionJue").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaJue1").val(),
			idMedico: idMedicoAjuste,
			dia: "apJue",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemJ").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemJ").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemJ").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#apSemanaJue1").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaJue1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar cierre dias jueves
$(document).on("change", "#ciSemanaJue1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionJue").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaJue1").val(),
			idMedico: idMedicoAjuste,
			dia: "ciJue",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemJ").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemJ").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemJ").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#ciSemanaJue1").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaJue1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar apertura dias viernes
$(document).on("change", "#apSemanaVie1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionVie").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaVie1").val(),
			idMedico: idMedicoAjuste,
			dia: "apVie",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemV").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemV").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemV").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#apSemanaVie1").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaVie1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar cierre dias viernes
$(document).on("change", "#ciSemanaVie1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionVie").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaVie1").val(),
			idMedico: idMedicoAjuste,
			dia: "ciVie",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemV").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemV").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemV").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#ciSemanaVie1").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaVie1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar apertura dias sabado
$(document).on("change", "#apSemanaSab1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionSab").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaSab1").val(),
			idMedico: idMedicoAjuste,
			dia: "apSab",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemS").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemS").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemS").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#apSemanaSab1").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaSab1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar cierre dias sabado
$(document).on("change", "#ciSemanaSab1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionSab").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaSab1").val(),
			idMedico: idMedicoAjuste,
			dia: "ciSab",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemS").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemS").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemS").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#ciSemanaSab1").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaSab1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar apertura dias domingo
$(document).on("change", "#apSemanaDom1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionDom").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaDom1").val(),
			idMedico: idMedicoAjuste,
			dia: "apDom",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemD").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemD").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemD").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#apSemanaDom1").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaDom1").removeClass("text-danger");
		}, 150);
	}
});

//ajustar cierre dias domingo
$(document).on("change", "#ciSemanaDom1", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionDom").val();
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaDom1").val(),
			idMedico: idMedicoAjuste,
			dia: "ciDom",
			turno: "1",
		},
		beforeSend: function () {
			$("#infoSemD").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemD").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemD").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	if (resto != 0) {
		$("#ciSemanaDom1").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaDom1").removeClass("text-danger");
		}, 150);
	}
});
//#endregion

//#region horarios semanales 2do turno
//ajustar apertura dias lunes
$(document).on("change", "#apSemanaLun2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionLun").val();
	if (resto != 0) {
		$("#apSemanaLun2").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaLun2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaLun2").val(),
			idMedico: idMedicoAjuste,
			dia: "apLun",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemL").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemL").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemL").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar cierre dias lunes
$(document).on("change", "#ciSemanaLun2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionLun").val();
	if (resto != 0) {
		$("#ciSemanaLun2").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaLun2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaLun2").val(),
			idMedico: idMedicoAjuste,
			dia: "ciLun",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemL").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemL").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemL").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar apertura dias martes
$(document).on("change", "#apSemanaMar2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionMar").val();
	if (resto != 0) {
		$("#apSemanaMar2").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaMar2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaMar2").val(),
			idMedico: idMedicoAjuste,
			dia: "apMar",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemM").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemM").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemM").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar cierre dias martes
$(document).on("change", "#ciSemanaMar2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionMar").val();
	if (resto != 0) {
		$("#ciSemanaMar2").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaMar2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaMar2").val(),
			idMedico: idMedicoAjuste,
			dia: "ciMar",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemM").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemM").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemM").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar apertura dias miercoles
$(document).on("change", "#apSemanaMie2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionMie").val();
	if (resto != 0) {
		$("#apSemanaMie2").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaMie2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaMie2").val(),
			idMedico: idMedicoAjuste,
			dia: "apMie",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemX").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemX").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemX").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar cierre dias miercoles
$(document).on("change", "#ciSemanaMie2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionMie").val();
	if (resto != 0) {
		$("#ciSemanaMie2").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaMie2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaMie2").val(),
			idMedico: idMedicoAjuste,
			dia: "ciMie",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemX").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemX").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemX").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar apertura dias jueves
$(document).on("change", "#apSemanaJue2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionJue").val();
	if (resto != 0) {
		$("#apSemanaJue2").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaJue2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaJue2").val(),
			idMedico: idMedicoAjuste,
			dia: "apJue",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemJ").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemJ").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemJ").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar cierre dias jueves
$(document).on("change", "#ciSemanaJue2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionJue").val();
	if (resto != 0) {
		$("#ciSemanaJue2").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaJue2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaJue2").val(),
			idMedico: idMedicoAjuste,
			dia: "ciJue",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemJ").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemJ").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemJ").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar apertura dias viernes
$(document).on("change", "#apSemanaVie2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionVie").val();
	if (resto != 0) {
		$("#apSemanaVie2").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaVie2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaVie2").val(),
			idMedico: idMedicoAjuste,
			dia: "apVie",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemV").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemV").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemV").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar cierre dias viernes
$(document).on("change", "#ciSemanaVie2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionVie").val();
	if (resto != 0) {
		$("#ciSemanaVie2").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaVie2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaVie2").val(),
			idMedico: idMedicoAjuste,
			dia: "ciVie",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemV").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemV").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemV").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar apertura dias sabado
$(document).on("change", "#apSemanaSab2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionSab").val();
	if (resto != 0) {
		$("#apSemanaSab2").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaSab2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaSab2").val(),
			idMedico: idMedicoAjuste,
			dia: "apSab",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemS").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemS").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemS").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar cierre dias sabado
$(document).on("change", "#ciSemanaSab2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionSab").val();
	if (resto != 0) {
		$("#ciSemanaSab2").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaSab2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaSab2").val(),
			idMedico: idMedicoAjuste,
			dia: "ciSab",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemS").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemS").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemS").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar apertura dias domingo
$(document).on("change", "#apSemanaDom2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionDom").val();
	if (resto != 0) {
		$("#apSemanaDom2").addClass("text-danger");
		setTimeout(() => {
			$("#apSemanaDom2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#apSemanaDom2").val(),
			idMedico: idMedicoAjuste,
			dia: "apDom",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemD").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemD").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemD").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//ajustar cierre dias domingo
$(document).on("change", "#ciSemanaDom2", function () {
	datos = $(this).val().split(":");
	minutos = datos[1];
	resto = minutos % $("#tiempoAtencionDom").val();
	if (resto != 0) {
		$("#ciSemanaSab2").addClass("text-danger");
		setTimeout(() => {
			$("#ciSemanaSab2").removeClass("text-danger");
		}, 150);
	}
	$.ajax({
		url: "../php/receptionAdministration/horarioDiaAtencion.php",
		type: "post",
		data: {
			tiempo: $("#ciSemanaDom2").val(),
			idMedico: idMedicoAjuste,
			dia: "ciDom",
			turno: "2",
		},
		beforeSend: function () {
			$("#infoSemD").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoSemD").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoSemD").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});
//#endregion

//#region otros minutos de atencion
//actualizar tiempo consulta dia lunes
$(document).on("change", "#otroTiempoLun", function () {
	$.ajax({
		url: "../php/receptionAdministration/otroTiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $(this).val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#oInfoL").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#oInfoL").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoL").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia martes
$(document).on("change", "#otroTiempoMar", function () {
	$.ajax({
		url: "../php/receptionAdministration/otroTiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $(this).val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#oInfoM").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#oInfoM").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoM").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia miercoles
$(document).on("change", "#otroTiempoMie", function () {
	$.ajax({
		url: "../php/receptionAdministration/otroTiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $(this).val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#oInfoX").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#oInfoX").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoX").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia jueves
$(document).on("change", "#otroTiempoJue", function () {
	$.ajax({
		url: "../php/receptionAdministration/otroTiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $(this).val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#oInfoJ").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#oInfoJ").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoJ").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia viernes
$(document).on("change", "#otroTiempoVie", function () {
	$.ajax({
		url: "../php/receptionAdministration/otroTiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $(this).val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#oInfoV").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#oInfoV").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoV").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia sabado
$(document).on("change", "#otroTiempoSab", function () {
	$.ajax({
		url: "../php/receptionAdministration/otroTiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $(this).val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#oInfoS").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#oInfoS").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoS").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia domingo
$(document).on("change", "#otroTiempoDom", function () {
	$.ajax({
		url: "../php/receptionAdministration/otroTiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $(this).val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#oInfoD").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#oInfoD").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#oInfoD").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//#endregion

//#region minutos de atencion diarios
//actualizar tiempo consulta dia lunes
$(document).on("change", "#tiempoAtencionLun", function () {
	$.ajax({
		url: "../php/receptionAdministration/tiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $("#tiempoAtencionLun").val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#infoL").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoL").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoL").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia martes
$(document).on("change", "#tiempoAtencionMar", function () {
	$.ajax({
		url: "../php/receptionAdministration/tiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $("#tiempoAtencionMar").val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#infoM").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoM").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoM").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia miercoles
$(document).on("change", "#tiempoAtencionMie", function () {
	$.ajax({
		url: "../php/receptionAdministration/tiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $("#tiempoAtencionMie").val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#infoX").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoX").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoX").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia jueves
$(document).on("change", "#tiempoAtencionJue", function () {
	$.ajax({
		url: "../php/receptionAdministration/tiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $("#tiempoAtencionJue").val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#infoJ").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoJ").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoJ").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia viernes
$(document).on("change", "#tiempoAtencionVie", function () {
	$.ajax({
		url: "../php/receptionAdministration/tiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $("#tiempoAtencionVie").val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#infoV").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoV").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoV").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia sabado
$(document).on("change", "#tiempoAtencionSab", function () {
	$.ajax({
		url: "../php/receptionAdministration/tiempoConsulta.php",
		type: "post",
		data: {
			tiempo: $("#tiempoAtencionSab").val(),
			idMedico: idMedicoAjuste,
			dia: $(this).attr("data-dia"),
		},
		beforeSend: function () {
			$("#infoS").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
		},
		success: function () {
			$("#infoS").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
			setTimeout(function () {
				$("#infoS").html("");
			}, 1500);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar tiempo consulta dia domingo
$(document).on("change", "#tiempoAtencionDom", function () {
	if ($(this).val() == "-") {
		$("#consultorioDom, #apSemanaDom1, #ciSemanaDom1, #apSemanaDom2, #ciSemanaDom2").attr("disabled", true);
		vaciarHorariosDomingo(idMedicoAjuste);
	} else {
		$("#consultorioDom, #apSemanaDom1, #ciSemanaDom1, #apSemanaDom2, #ciSemanaDom2").removeAttr("disabled");
		$.ajax({
			url: "../php/receptionAdministration/tiempoConsulta.php",
			type: "post",
			data: {
				tiempo: $("#tiempoAtencionDom").val(),
				idMedico: idMedicoAjuste,
				dia: $(this).attr("data-dia"),
			},
			beforeSend: function () {
				$("#infoD").html('<i class="fas fa-wrench ml-1 text-info rotar"></i>');
			},
			success: function () {
				$("#infoD").html('<i class="fas fa-check-circle ml-1 text-success"></i>');
				setTimeout(function () {
					$("#infoD").html("");
				}, 1500);
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	}
});

function vaciarHorariosDomingo(idMedico) {
	$.ajax({
		url: "../php/receptionAdministration/vaciarDomingo.php",
		type: "post",
		data: {
			id: idMedico,
		},
		success: function (data) {
			if (data == "1") {
				$("#consultorioDom").val("-");
				$("#apSemanaDom1, #ciSemanaDom1, #apSemanaDom2, #ciSemanaDom2").val("00:00");
			} else {
				$("#apSemanaDom1, #ciSemanaDom1, #apSemanaDom2, #ciSemanaDom2").addClass("is-invalid");
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}
//#endregion

//#endregion

//#endregion

//#region DOCTORES CARGADOS

// //ver doctor
// function verDoctor(
// 	ap,
// 	nom,
// 	activo,
// 	codigo,
// 	avatar,
// 	dni,
// 	domicilio,
// 	tel_particular,
// 	celular,
// 	tel_consultorio,
// 	especialidad,
// 	matricula,
// 	anestesista,
// 	observacion
// ) {
// 	if (observacion == "") {
// 		obs = "<b>Ninguna</b>";
// 	} else {
// 		obs = observacion;
// 	}
// 	if (anestesista == "1") {
// 		anest = "SI";
// 	} else {
// 		anest = "NO";
// 	}
// 	$("#modalVerDoctorLabel").html(ap + " " + nom + " (" + activo + ")");
// 	$("#modalVerDoctorCodigo").html(codigo);
// 	$("#modalVerDoctorAvatar").attr("src", "../img/users/" + avatar);
// 	$("#modalVerDoctorDNI").html(dni);
// 	$("#modalVerDoctorDomicilio").html(domicilio);
// 	$("#modalVerDoctorTelPart").html(tel_particular);
// 	$("#modalVerDoctorCelular").html("<a target='_blank' href='tel:" + celular + "'>" + celular + "</a>");
// 	$("#modalVerDoctorTelCons").html(tel_consultorio);
// 	$("#modalVerDoctorEspecialidad").html(especialidad);
// 	$("#modalVerDoctorMatricula").html(matricula);
// 	$("#modalVerDoctorAnestesista").html(anest);
// 	$("#modalVerDoctorObservacion").html(obs);

// 	$("#modalVerDoctor").modal("show");
// }

//confirmar la eliminacion del doctor modal
function activarModal(str) {
	$("#modalDoctoresCargadosElimnar").modal("show");
	$("#modalDoctoresCargadosElimnarBoton").attr("data-id", str);
}

//eliminar doctores
function eliminarDoctor(str) {
	$.ajax({
		url: "../php/receptionAdministration/delDocs.php",
		type: "post",
		data: {idM: str},
		success: function (data) {
			if (data == "1") {
				$("#recepcionABMMedicos").click();
				$("#modalDoctoresCargadosElimnar").modal("hide");
				ohSnap("Médico eliminado exitosamente.", {
					duration: "3500",
					color: "green",
				});
			} else {
				$("#modalDoctoresCargadosElimnar").modal("hide");
				ohSnap("El médico no puede eliminarse porque posee pacientes con turnos.", {
					duration: "3500",
					color: "red",
				});
			}
		},
		error: function () {
			$("#listaDoctores").html(errorMsg);
		},
	});
}

//atualizar doctores
function actualizarDoctor() {
	if (
		$("#ABMapellidoMedico").val() != "" ||
		$("#ABMnombreMedico").val() != "" ||
		$("#ABMnumeroMatriculaMedico").val() != "" ||
		$("#ABMcelularMedico").val() != ""
	) {
		$.ajax({
			url: "../php/receptionAdministration/updateDoc.php",
			type: "post",
			data: {
				id: idMedicoAjuste,
				codigo: $("#ABMnumeroMatriculaMedico").val(),
				matricula: $("#ABMfechaMatriculaMedico").val(),
				apellido: $("#ABMapellidoMedico").val(),
				nombre: $("#ABMnombreMedico").val(),
				dni: $("#ABMdniMedico").val(),
				domicilio: $("#ABMdomicilioMedico").val(),
				tel_particular: $("#ABMtelefono_particularMedico").val(),
				tel_consultorio: $("#ABMtelefono_consultorioMedico").val(),
				celular: $("#ABMcelularMedico").val(),
				usuario: $("#ABMusuarioMedico").val(),
				especialidad: $("#ABMespecialidadMedico").val(),
				anestesista: $("#ABManestesistaMedico").val(),
				obs: $("#ABMobservacionesMedico").val(),
				activo: $("#ABMestadoMedico").prop("checked"),
			},
			success: function (data) {
				if (data == "1") {
					$("#recepcionABMMedicos").click();
					$("#modalOpcionesMedico").modal("hide");
					ohSnap("Datos del médico actualizados", {
						duration: "3500",
						color: "green",
					});
				} else {
					ohSnap("Problemas al actualizar", {
						duration: "3500",
						color: "red",
					});
				}
			},
			error: function () {
				$("#recepcionABMMedicos").html(errorMsg);
			},
		});
	} else {
		if ($("#ABMapellidoMedico").val() == "") {
			$("#ABMapellidoMedico").addClass("is-invalid");
			setTimeout(function () {
				$("#ABMapellidoMedico").removeClass("is-invalid");
			}, 2500);
		}
		if ($("#ABMnombreMedico").val() == "") {
			$("#ABMnombreMedico").addClass("is-invalid");
			setTimeout(function () {
				$("#ABMnombreMedico").removeClass("is-invalid");
			}, 2500);
		}
		if ($("#ABMnumeroMatriculaMedico").val() == "") {
			$("#ABMnumeroMatriculaMedico").addClass("is-invalid");
			setTimeout(function () {
				$("#ABMnumeroMatriculaMedico").removeClass("is-invalid");
			}, 2500);
		}
		if ($("#ABMcelularMedico").val() == "") {
			$("#ABMcelularMedico").addClass("is-invalid");
			setTimeout(function () {
				$("#ABMcelularMedico").removeClass("is-invalid");
			}, 2500);
		}
	}
}

//editar foto
$(document).on("click", "#ABMBotonCambiarImagenMedico", function () {
	idMedicoCambiarFoto = $(this).attr("data-usuario");
	$("#modalEditarFotoFoto").val("");
	$("#modalEditarFoto").modal("show");
});

//funcion editar foto
$(document).on("click", "#modalEditarFotoBoton", function () {
	const permitidos = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
	if ($.inArray($("#modalEditarFotoFoto")[0].files[0].type, permitidos) == -1) {
		$("#modalEditarFotoFoto").val("");
		ohSnap("Archivo no permitido. Solo se permiten imagnes .jpeg, .jpg, .png o .gif", {
			duration: "3500",
			color: "red",
		});
	} else if ($("#modalEditarFotoFoto")[0].files[0].size > 2000000) {
		$("#modalEditarFotoFoto").val("");
		ohSnap("La imagen que desea subir no debe superar los 2MB.", {
			duration: "3500",
			color: "red",
		});
	} else {
		var formData = new FormData();
		formData.append("file", $("#modalEditarFotoFoto")[0].files[0]);
		formData.append("idUsuario", idMedicoCambiarFoto);
		$.ajax({
			url: "../php/receptionAdministration/subirArchivo.php",
			type: "post",
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				ohSnap("Subiendo imagen", {
					duration: "1500",
					color: "blue",
				});
			},
			success: function (data) {
				if (data == "1") {
					$("#recepcionABMMedicos").click();
					$("#modalEditarFoto").modal("hide");
					ohSnap("Imagen actualizada", {
						duration: "2500",
						color: "green",
					});
					setTimeout(function () {
						$("#ABMImagenMedico").attr("src", $(".medicosCargados .contenedorImg img").attr("src"));
					}, 500);
				} else if (data == "0") {
					$("#modalEditarFotoFoto").val("");
					ohSnap("Ocurrió un error al subir el archivo", {
						duration: "3000",
						color: "red",
					});
				} else if (data == "2") {
					$("#modalEditarFotoFoto").val("");
					ohSnap("Ya existe un archivo con este nombre", {
						duration: "3000",
						color: "red",
					});
				}
			},
			error: function () {
				ohSnap("Problemas con su conexión", {
					duration: "3000",
					color: "red",
				});
			},
		});
	}
});

//modal opciones doctores

//#endregion

//#region COBERTURAS SOCIALES

//cargar coberturas
$(document).on("click", "#coberturasMedicas-tab", function () {
	$.ajax({
		url: "../php/receptionAdministration/cargarCoberturasSocialesVinculadas.php",
		type: "post",
		data: {
			id: idMedicoAjuste,
		},
		success: function (data) {
			$("#nombreMedicoSeleccionado").html($("#cronogramaNombreMedico option:selected").text());
			$("#contenidoCoberturasSociales").html(data);
			obtenerCoberturasSociales(idMedicoAjuste);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//refrescar tabla
$(document).on("click", "#opcionRefrescarCoberturas", function () {
	$("#opcionLlamarCobertura").css("display", "none");
	$("#opcionEliminarCobertura, #opcionEditarCobertura, #opcionLlamarCobertura").hide();
	$("#coberturasMedicas-tab").click();
});

//guardar id cobertura social
$(document).on("click", "#coberturaCheck", function () {
	var contador = 0;
	var ids = [];
	var telefono = [];
	$("#coberturaCheck:checked").each(function () {
		contador++;
		ids.push($(this).attr("data-valor"));
		telefono.push($(this).attr("data-telefono"));
	});

	if (contador > 0) {
		$("#opcionEditarCobertura, #opcionEliminarCobertura").show();
	} else {
		$("#opcionEditarCobertura, #opcionEliminarCobertura").hide();
	}

	if (contador >= 2) {
		$("#opcionEditarCobertura, #opcionLlamarCobertura").hide();
	} else {
		idMedicoCoberturaSocialSeleccionada = ids[0];
		if (contador == 1) {
			$("#opcionEditarCobertura").show();
		} else {
			$("#opcionEditarCobertura").hide();
		}
		if (telefono[0] != "" && contador == 1) {
			$("#opcionLlamarCobertura").attr("href", "tel:" + telefono);
			$("#opcionLlamarCobertura").show();
		} else {
			$("#opcionLlamarCobertura").hide();
		}
	}
});

//desvincular coberturas sociales medico (MODAL)
$(document).on("click", "#opcionEliminarCobertura", function () {
	$("#modalEliminarCoberturaSocialConfirmacion").val("0");
	$("#modalEliminarCoberturaSocialBoton").attr("disabled", true);
	$("#modalEliminarCoberturaSocial").modal("show");
});

//validar seleccion del usuario para desvincular cobertura
$(document).on("change", "#modalEliminarCoberturaSocialConfirmacion", function () {
	if ($("#modalEliminarCoberturaSocialConfirmacion").val() == "1") {
		$("#modalEliminarCoberturaSocialBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarCoberturaSocialBoton").attr("disabled", true);
	}
});

//desvincular cobertura social
$(document).on("click", "#modalEliminarCoberturaSocialBoton", function () {
	var ids = [];
	$("#coberturaCheck:checked").each(function () {
		ids.push($(this).attr("data-valor"));
	});
	$.ajax({
		url: "../php/receptionAdministration/desvincularCobertura.php",
		type: "post",
		data: {
			id: ids,
		},
		success: function (data) {
			$("#opcionRefrescarCoberturas").click();
			$("#modalEliminarCoberturaSocial").modal("hide");
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//asignar todas las coberturas sociales (MODAL)
$(document).on("click", "#opcionAsignarTodo", function () {
	$("#modalConfirmarAsignarTodoBoton").attr("disabled", true);
	$("#modalConfirmarAsignarTodoSelect").val("0");
	$("#modalConfirmarAsignarTodoNombreMedico").text($("#cronogramaNombreMedico option:selected").text());
	$("#modalConfirmarAsignarTodo").modal("show");
});

//validar seleccion antes de asignar todas las coberturas
$(document).on("change", "#modalConfirmarAsignarTodoSelect", function () {
	if ($("#modalConfirmarAsignarTodoSelect").val() == "1") {
		$("#modalConfirmarAsignarTodoBoton").removeAttr("disabled");
	} else {
		$("#modalConfirmarAsignarTodoBoton").attr("disabled", true);
	}
});

//funcion asignar todo
$(document).on("click", "#modalConfirmarAsignarTodoBoton", function () {
	$.ajax({
		url: "../php/receptionAdministration/asignarTodasCoberturas.php",
		type: "post",
		data: {
			id: idMedicoAjuste,
		},
		success: function () {
			$("#opcionRefrescarCoberturas").click();
			$("#modalConfirmarAsignarTodo").modal("hide");
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//actualizar plus (MODAL)
$(document).on("click", "#opcionEditarCobertura", function () {
	$.ajax({
		url: "../php/receptionAdministration/cargarValorPlus.php",
		type: "post",
		data: {
			id: idMedicoCoberturaSocialSeleccionada,
		},
		success: function (data) {
			respuesta = data.split("|");
			idCobertura = respuesta[2];
			$("#modalEditarPlusValor").val(respuesta[0]);
			$("#modalEditarPlusDescripcion").text(respuesta[1]);
			$("#modalEditarPlusDescripcion").focus();
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
	$("#modalEditarPlus").modal("show");
});

//funcion actualizar cobertura social
$(document).on("click", "#modalEditarPlusBoton", function () {
	$.ajax({
		url: "../php/receptionAdministration/actualizarPlus.php",
		type: "post",
		data: {
			id: idCobertura,
			plus: $("#modalEditarPlusValor").val(),
			descripcion: $("#modalEditarPlusDescripcion").val(),
		},
		success: function (data) {
			if (data == "1") {
				$("#modalEditarPlus").modal("hide");
				$("#opcionRefrescarCoberturas").click();
			} else {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//#endregion

//#endregion administracion
//////////////////////////////////FIN ADMINISTRACION////////////////////////////////////

//////////////////////////////////FERIADOS////////////////////////////////////
//#region feriados

//mostrar formulario de feriados
$(document).on("click", "#ABMFeriados", function () {
	$.ajax({
		url: "../php/holiday/feriadosInstitucionales.php",
		success: function (data) {
			$("#contenedorCategoriaRecepcion").html(data);
			cargarFeriados();
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//cargarFeriados
function cargarFeriados() {
	$.ajax({
		url: "../php/holiday/listaFeriados.php",
		success: function (data) {
			$("#listaFeriados").html(data);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//funcion eliminar feriado
$(document).on("click", "#modalEliminarFeriadoBoton", function () {
	$.ajax({
		url: "../php/holiday/eliminarFeriado.php",
		type: "post",
		data: {id: idEliminarFeriado},
		success: function () {
			cargarFeriados();
			$("#modalEliminarFeriado").modal("hide");
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//validar modal eliminar feriado
$(document).on("change", "#modalEliminarFeriadoConfirmacion", function () {
	if ($("#modalEliminarFeriadoConfirmacion").val() == "1") {
		$("#modalEliminarFeriadoBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarFeriadoBoton").attr("disabled", true);
	}
});

//eliminar feriado (MODAL)
function eliminarFeriado(str) {
	idEliminarFeriado = str;
	$("#modalEliminarFeriadoBoton").attr("disabled", true);
	$("#modalEliminarFeriadoConfirmacion").val("0");
	$("#modalEliminarFeriado").modal("show");
}

//guardar feriados
$(document).on("click", "#feriadosGuardar", function () {
	if ($("#feriadoDia").val() == "") {
		$("#feriadoDia").addClass("is-invalid");
		$("#feriadosGuardar").attr("disabled", "disabled");
	}

	if ($("#feriadoObservacion").val() == "") {
		$("#feriadoObservacion").addClass("is-invalid");
		$("#feriadosGuardar").attr("disabled", "disabled");
	}

	setTimeout(function () {
		$("#feriadoObservacion, #feriadoDia").removeClass("is-invalid");
		$("#feriadosGuardar").removeAttr("disabled");
	}, 1500);

	if ($("#feriadoDia").val() != "" && $("#feriadoObservacion").val() != "") {
		$.ajax({
			url: "../php/holiday/guardarFeriado.php",
			type: "post",
			data: {
				dia: $("#feriadoDia").val(),
				observacion: $("#feriadoObservacion").val(),
			},
			success: function () {
				cargarFeriados();
				$("#feriadoDia").val("");
				$("#feriadoObservacion").val("");
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	}
});

//#endregion feriados
//////////////////////////////////FIN FERIADOS////////////////////////////////////

//////////////////////////////////TURNOS////////////////////////////////////
//#region turnos
var fecha = "";
var turnoSeleccionadoGrilla = "";
var horaNuevoTurnoPegado = "";
var infoDelDia = "";
var ultimoIdTurno = "";
var dniUltimoPacienteSeleccionado = "";
var moverFlag = true;
var flagCortar = false;
var fechaDropCompleta = "";
var IdEvento = "";
var horaPrevia = "";
var minutosPrevios = "";
var fechaPrevia = "";
var turnoDesdeGrilla = false;
var dniSeleccionadoGrilla = "";
var fechaSeleccionadaGrilla = "";
var medicoSeleccionadaGrilla = "";
var coberturaSeleccionadaGrilla = "";
var tipoCoberturaSeleccionadaGrilla = "";
var tipoTurnoSeleccionadoGrilla = "";
var coseguroSeleccionadaGrilla = "";
var pacienteSeleccionadaGrilla = "";
var nombrePacienteSeleccionadaGrilla = "";
var flagAgregarWPTEL = false;
const msgCalendarioDetalles =
	'<small class="text-danger">Seleccione un día para ver la grilla de horarios correspondientes. No se pueden seleccionar días previos al actual, ni los días marcados en el calendario con color rojo.</small>';

//cargar horarios sin atencion
$(document).on("click", "#diaSinAtencionMedico-tab", function () {
	$.ajax({
		url: "../php/receptionTurns/listaHorariosSinAtencionMedicos.php",
		type: "post",
		data: {
			id: idMedicoAjuste,
		},
		success: function (data) {
			$("#listaDiasSinAtencionMedicos").html(data);
			if ($("#ABMnumeroMatriculaMedico").prop("disabled")) {
				$("#listaDiasSinAtencionMedicos #botonEliminarFechaSinAtencion").each(function () {
					$(this).attr("disabled", true);
				});
			} else {
				$("#listaDiasSinAtencionMedicos #botonEliminarFechaSinAtencion").each(function () {
					$(this).removeAttr("disabled", true);
				});
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//activar boton guardar dia sin atencion
$(document).on("change", "#fechaSinActividad", function () {
	if ($("#fechaSinActividad").val() == "") {
		$("#horariosSinAtencionPorMedicoBoton").attr("disabled", true);
	} else {
		$("#horariosSinAtencionPorMedicoBoton").removeAttr("disabled");
	}
});

//cambiar modo de guardado
$(document).on("change", "#horarioSinAtencionModo", function () {
	switch ($(this).val()) {
		case "0":
			$("#horarioSinAtencionLabelDia").html("Día");
			$("#horarioSinAtencionUnicoDia").show();
			$("#horarioSinAtencionUltimoDia, #horarioSinAtencionUnicoDiaPorHoras").hide();
			break;
		case "1":
			$("#horarioSinAtencionLabelDia").html("Primer día del rango");
			$("#horarioSinAtencionUnicoDia, #horarioSinAtencionUltimoDia").show();
			$("#horarioSinAtencionUnicoDiaPorHoras").hide();
			break;
		case "2":
			$("#horarioSinAtencionLabelDia").html("Día");
			$("#horarioSinAtencionUnicoDiaPorHoras").show();
			$("#horarioSinAtencionUltimoDia").hide();
			break;
	}
});

//elimnar horario sin atencion (MODAL)
function eliminarFechaSinAtencion(id) {
	idFechaSinAtencion = id;
	$("#modalEliminarHorarioSinAtencionConfirmacion").val("0");
	$("#modalEliminarHorarioSinAtencionBoton").attr("disabled", true);
	$("#modalEliminarHorarioSinAtencion").modal("show");
}

//validar eliminar horarios
$(document).on("change", "#modalEliminarHorarioSinAtencionConfirmacion", function () {
	if ($($(this)).val() == "1") {
		$("#modalEliminarHorarioSinAtencionBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarHorarioSinAtencionBoton").attr("disabled", true);
	}
});

//funcion eliminar horario sin atencion
$(document).on("click", "#modalEliminarHorarioSinAtencionBoton", function () {
	$.ajax({
		url: "../php/receptionTurns/eliminarTurnosSinAtencion.php",
		type: "post",
		data: {
			id: idFechaSinAtencion,
		},
		success: function () {
			$("#diaSinAtencionMedico-tab").click();
			$("#modalEliminarHorarioSinAtencion").modal("hide");
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//guardar horario sin atencion
$(document).on("click", "#horariosSinAtencionPorMedicoBoton", function () {
	$.ajax({
		url: "../php/receptionTurns/guardarFechaSinAtencionMedico.php",
		type: "post",
		data: {
			modo: $("#horarioSinAtencionModo").val(),
			inicio: $("#fechaSinActividad").val(),
			fin: $("#fechaSinActividadFin").val(),
			desde: $("#fechaSinActividadDesde").val(),
			hasta: $("#fechaSinActividadHasta").val(),
			observacion: $("#observacionFechaSinActividad").val(),
			idMedico: idMedicoAjuste,
		},
		success: function () {
			$("#horariosSinAtencionPorMedicoBoton").attr("disabled", true);
			$("#observacionFechaSinActividad").val("");
			$("#fechaSinActividad").val("");
			$("#fechaSinActividadFin").val("");
			$("#fechaSinActividadDesde").val("");
			$("#fechaSinActividadHasta").val("");
			$("#diaSinAtencionMedico-tab").click();
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//mostrar calendario
$(document).on("click", "#asignarTurno", function () {
	$.ajax({
		url: "../php/receptionTurns/agregarTurno.php",
		success: function (data) {
			turnosActivo = true;
			$("#modalAgregarDatosPacienteDNISolicitante").focus();
			$("#nuevoTurnoMedicoNombre, #nuevoTurnoMedicoMatricula").removeClass("is-invalid");
			$("#contenedorCategoriaRecepcion").html(data);
			if ($("#nuevoTurnoMedicoNombre").val() == "0") {
				$("#modalAgregarDatosPacienteDNISolicitante").addClass("is-invalid");
				$("#nuevoTurnoMedicoNombre").addClass("is-invalid");
			} else {
				$("#modalAgregarDatosPacienteDNISolicitante").removeClass("is-invalid");
				$("#nuevoTurnoMedicoNombre, #nuevoTurnoMedicoMatricula").removeClass("is-invalid");
				generarCalendario($("#nuevoTurnoMedicoNombre").val());
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//cargar turnos del medico
$(document).on("change", "#nuevoTurnoMedicoNombre", function () {
	if ($("#nuevoTurnoMedicoNombre").val() == "0") {
		$("#calendario").html("<span class='text-danger'>Por favor seleccione un médico efector</span>");
		$("#nuevoTurnoMedicoNombre, #nuevoTurnoMedicoMatricula").addClass("is-invalid");
		$("#nuevoTurnoMedicoMatricula").val("");
	} else {
		$("#nuevoTurnoMedicoMatricula").val($("#nuevoTurnoMedicoNombre option:selected").attr("data-matricula"));
		generarCalendario($("#nuevoTurnoMedicoNombre").val());
		setTimeout(function () {
			marcarCantidades();
			$("#nuevoTurnoMedicoNombre, #nuevoTurnoMedicoMatricula").removeClass("is-invalid").addClass("is-valid");
		}, 200);
		// $.ajax({
		// 	url: "../php/receptionTurns/buscarInfoPacienteTurno.php",
		// 	type: "post",
		// 	data: {
		// 		idPaciente: $("#nuevoTurnoMedicoNombre").val(),
		// 	},
		// 	success: function (data) {
		// 		$("#detallesPacienteTurno").html(data);
		// 		$("#calendario").html("");
		// 		if ($("#modalAgregarDatosPacienteDNISolicitante").val() != "" && $("#modalAgregarDatosDelPacienteApyNom").val() != "") {
		// 			$("#agregarTurnoDiaSeleccionado").show();
		// 		} else {
		// 			$("#agregarTurnoDiaSeleccionado").hide();
		// 		}
		// 	},
		// 	error: function () {
		// 		$("#contenedorCategoriaRecepcion").html(errorMsg);
		// 	},
		// });
	}
});

//mes previo
$(document).on("click", ".fc-prev-button", function () {
	$(".fc-highlight").click();
	setTimeout(function () {
		marcarCantidades();
	}, 200);
});

//mes siguiente
$(document).on("click", ".fc-next-button", function () {
	$(".fc-highlight").click();
	setTimeout(function () {
		marcarCantidades();
	}, 200);
});

//function marcar cantidades
function marcarCantidades() {
	$(".fc-event-title").each(function () {
		if ($(this).text() > 0) {
			$(this).addClass("badge badge-pill badge-success font-weight-bold border border-white").css("font-size", "13px");
			$(this).hide();
		} else if ($(this).text() == " ") {
			$(this).parent().css("position", "relative");
			$(this).parent().css("z-index", "3");
			$(this).parent().css("margin-top", "20px");
			$(this).parent().css("margin-left", "2px");
			$(this).parent().css("font-size", "12px");
			$(this).addClass("badge badge-pill badge-danger text-white fas fa-ban");
		}
	});
}

//marcar numeros de fechas
$(document).on("click", ".fc-header-toolbar button", function () {
	$(".fc-daygrid-day-number").each(function () {
		$(this).parent().css("position", "relative");
		$(this).parent().css("z-index", "3");
	});
});

//generar calendario
function generarCalendario(str) {
	const calendarEl = document.getElementById("calendario");
	var calendar = new FullCalendar.Calendar(calendarEl, {
		headerToolbar: {
			left: "prev,next today",
			center: "title",
			right: "dayGridMonth,listMonth",
		},

		editable: true,
		locale: "es",
		businessHours: true,
		selectable: true,
		initialView: "dayGridMonth",
		events: "../php/receptionTurns/obtenerEventos.php?idM=" + str,
	});
	calendar.render();
	$(".fc-daygrid-day-number").each(function () {
		$(this).parent().css("position", "relative");
		$(this).parent().css("z-index", "3");
	});
	$("#calendarioDetalles").html(msgCalendarioDetalles);
	calendar.on("dateClick", function (info) {
		$.ajax({
			url: "../php/receptionTurns/verificarFecha.php",
			type: "post",
			data: {
				fecha: info.dateStr,
				medico: $("#nuevoTurnoMedicoNombre").val(),
			},
			success: function (data) {
				// console.log(info.dayEl);
				// info.dayEl.innerText.replace("0", "");

				$(".fa-ban").html(" ");
				if (data == "1") {
					$("#nuevoSobreTurno").hide();
					$("#calendarioDetalles").html("<span class='text-danger'>Día sin atención. No se permite agendar turnos.</span>");
					ohSnap("Posición no disponible. Por favor, seleccione otra.", {
						duration: "3500",
						color: "red",
					});
					//$("#modalErrorTurnoExistente").modal("show");
				} else {
					fecha = info.dateStr;
					nueva = fecha.split("-");
					const event = new Date(Date.UTC(nueva[0], nueva[1] - 1, nueva[2], 12, 0, 0));
					const options = {weekday: "long", year: "numeric", month: "long", day: "numeric"};
					//console.log(event.toLocaleDateString(undefined, options));

					$("#modalAgregarDatosPacienteFecha").html("Reserva para el día: " + event.toLocaleDateString(undefined, options));
					cargarTurnosDelDia(fecha, $("#nuevoTurnoMedicoNombre").val());
					moverFlag = true;
				}
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	});
}

//vaciar input matricula
$(document).on("click", "#nuevoTurnoMedicoMatricula", function () {
	$("#nuevoTurnoMedicoNombre option").removeAttr("selected");
	$("#nuevoTurnoMedicoNombre option:nth(0)").attr("selected", true);
	$("#nuevoTurnoMedicoMatricula").val("").addClass("is-invalid").removeClass("is-valid");
	$("#nuevoTurnoMedicoNombre").addClass("is-invalid").removeClass("is-valid");
	$("#calendario, #calendarioDetalles").html("");
});

//seleccionar medico escribiendo matricula
$(document).on("keyup", "#nuevoTurnoMedicoMatricula", function () {
	$("#nuevoTurnoMedicoNombre option").removeAttr("selected");
	$("#nuevoTurnoMedicoNombre option:nth(0)").removeAttr("selected", true);
	$("#nuevoTurnoMedicoNombre option").each(function () {
		const matricula = $(this).attr("data-matricula");
		//$(this).removeAttr("selected");
		if (matricula == $("#nuevoTurnoMedicoMatricula").val()) {
			$(this).attr("selected", true);
			generarCalendario($("#nuevoTurnoMedicoNombre").val());
			setTimeout(function () {
				$("#nuevoTurnoMedicoMatricula, #nuevoTurnoMedicoNombre").removeClass("is-invalid").addClass("is-valid");
				marcarCantidades();
			}, 400);
		} else {
			$("#calendario, #calendarioDetalles").html("");
			$("#nuevoTurnoMedicoMatricula, #nuevoTurnoMedicoNombre").addClass("is-invalid").removeClass("is-valid");
		}
	});
});

//mover evento
// $(document).on("click", "#modalConfirmarDropConfirmar", function () {
// 	moverEvento(IdEvento, fechaDropCompleta);
// });

//buscar paciente por apellido y nombre y obtener su DNI
$(document).on("change", "#modalAgregarDatosDelPacienteApyNom", function () {
	buscarPacienteApyNom();
});

//buscar paciente por apellido y nombre y obtener su DNI
$(document).on("keyup", "#modalAgregarDatosDelPacienteApyNom", function () {
	buscarPacienteApyNom();
});

//limpiar input busqueda paciente
$(document).on("click", "#modalAgregarDatosDelPacienteApyNom", function () {
	$("#modalAgregarDatosDelPacienteApyNom, #modalAgregarDatosPacienteDNISolicitante").val("");
	buscarPacienteApyNom();
});

//buscar pacientes por ap y nom
function buscarPacienteApyNom() {
	$.ajax({
		url: "../php/receptionTurns/buscarApNom.php",
		type: "post",
		data: {ApyNom: $("#modalAgregarDatosDelPacienteApyNom").val()},
		success: function (data) {
			$("#resultadoPacientes").html(data);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//quitar lista de pacientes buscados
$(document).on("blur", "#modalAgregarDatosDelPacienteApyNom", function () {
	setTimeout(function () {
		$("#resultadoPacientes").html("");
	}, 500);
});

//cargar nombre del paciente automaticamete si existe
$(document).on("keyup", "#modalAgregarDatosPacienteDNISolicitante", function () {
	if ($("#modalAgregarDatosPacienteDNISolicitante").val().length == 8) {
		cargarApyNomPaciente($("#modalAgregarDatosPacienteDNISolicitante").val());
	}
});

//paciente equivocado
$(document).on("click", "#modalEditarPacientePacienteEquivocado", function () {
	$("#modalEditarPaciente").modal("hide");
	$("#modalAgregarDatosPacienteDNISolicitante").val("");
	$("#modalAgregarDatosDelPacienteApyNom").val("");
});

//funcion cargar paciente
function cargarApyNomPaciente(str) {
	$.ajax({
		url: "../php/receptionTurns/buscarDNI.php",
		type: "post",
		data: {
			dni: str,
		},
		success: function (data) {
			respuesta = data.split("|");
			if (data != "0") {
				$("#modalAgregarDatosDelPacienteApyNom").val(respuesta[0]);
				//$("#modalAgregarDatosPacienteNuevo").html("");
				$("#modalAgregarDatosPacienteDNISolicitante, #modalAgregarDatosDelPacienteApyNom").removeClass("is-invalid").addClass("is-valid");
				editarPaciente(respuesta[1]);
				detallesPaciente(respuesta[1]);
			} else {
				$("#modalPacienteNoEncontrado").modal("show");
				$("#contendedorCalendario").html("");
				$("#modalAgregarDatosDelPacienteApyNom, #nuevoTurnoMedicoMatricula").val("");
				$("#nuevoTurnoMedicoNombre").val("0");
				$("#modalAgregarDatosPacienteDNISolicitante, #modalAgregarDatosDelPacienteApyNom, #nuevoTurnoMedicoMatricula, #nuevoTurnoMedicoNombre")
					.removeClass("is-valid")
					.addClass("is-invalid");
				//$("#modalAgregarDatosPacienteNuevo").html('<i role="button" id="modalAgregarDatosPacienteCrear" class="fas fa-user-plus text-success"></i>');
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//ingreasar paciente seleccionado
function ingresarPacienteSeleccionado(id, dni, apellido, nombre) {
	$("#resultadoPacientes").html("");
	$("#modalAgregarDatosDelPacienteApyNom")
		.val(apellido + " " + nombre)
		.removeClass("is-invalid")
		.addClass("is-valid");
	$("#modalAgregarDatosPacienteDNISolicitante").val(dni).removeClass("is-invalid").addClass("is-valid");
	editarPaciente(id);
	detallesPaciente(id);
}

//detalles paciente
function detallesPaciente(id) {
	$.ajax({
		url: "../php/receptionTurns/buscarInfoPacienteTurno.php",
		type: "post",
		data: {
			idPaciente: id,
		},
		success: function (data) {
			$("#detallesPacienteTurno").html(data);
		},
		error: function () {
			ohSnap("Problemas al obtener información del paciente", {duration: "3000", color: "red"});
		},
	});
}

//modal agregar paciente
$(document).on("click", "#modalPacienteNoEncontradoAgregar", function () {
	$("#modalPacienteNoEncontrado").modal("hide");
	$("#modalNuevoPacienteDNI")
		.val($("#modalAgregarDatosPacienteDNISolicitante").val())
		.removeClass("is-invalid")
		.addClass("is-valid")
		.attr("disabled", true);
	$("#modalNuevoPaciente").modal("show");
});

//validar input nuevo paciente DNI
$(document).on("keyup", "#modalAgregarDatosPacienteDNISolicitante", function () {
	if ($(this).val().length == 8) {
		$(this).removeClass("is-invalid").addClass("is-valid");
	} else {
		$(this).removeClass("is-valid").addClass("is-invalid");
	}
});

//rechazar nuevo paciente
$(document).on("click", "#modalPacienteNoEncontradoCancelar", function () {
	$("#modalPacienteNoEncontrado").modal("hide");
	$("#modalAgregarDatosPacienteDNISolicitante, #modalAgregarDatosDelPacienteApyNom").val("").addClass("is-invalid").removeClass("is-valid");
});

//funcion sobreturno
$(document).on("click", "#modalAgregarDatosSobreTurno", function () {
	if ($("#modalAgregarDatosSobreTurno").prop("checked")) {
		horaPrevia = $("#modalAgregarDatosPacienteHora").val();
		$("#modalAgregarDatosPacienteHora").removeAttr("disabled");
	} else {
		$("#modalAgregarDatosPacienteHora").val(horaPrevia).attr("disabled", "disabled");
	}
});

//verificar coseguro
$(document).on("click", "#modalNuevoPacienteEsCoseguro", function () {
	if ($("#modalNuevoPacienteEsCoseguro").prop("checked") == false) {
		$("#modalNuevoPacienteCoseguro, #modalNuevoPacienteCarnetCoseguro").removeAttr("disabled");
	} else {
		$("#modalNuevoPacienteCoseguro, #modalNuevoPacienteCarnetCoseguro").attr("disabled", true);
	}
});

//habilitar n° coseguro
$(document).on("change", "#modalNuevoPacienteCoseguro", function () {
	if ($("#modalNuevoPacienteCoseguro").val() == "0") {
		$("#modalNuevoPacienteCarnetCoseguro").val("").attr("disabled", true);
	} else {
		$("#modalNuevoPacienteCarnetCoseguro").removeAttr("disabled");
	}
});

//eliminar otro horario (MODAL)
$(document).on("click", "#botonEliminarPaciente", function () {
	$("#modalEliminarPacienteConfirmacion").val("0");
	$("#modalEliminarPacienteBoton").attr("disabled", true);
	$("#modalEliminarPaciente").modal("show");
});

//validar seleccion eliminar otro horario
$(document).on("click", "#modalEliminarPacienteConfirmacion", function () {
	if ($("#modalEliminarPacienteConfirmacion").val() == "1") {
		$("#modalEliminarPacienteBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarPacienteBoton").attr("disabled", true);
	}
});

//mostrar modal eliminar registro del dia
$(document).on("click", "#modalVerTurnosDelDiaQuitarTurno", function () {
	$("#modalEditarTurno, #modalInformacionTurno").modal("hide");
	$("#modalConfirmarQuitarTurno").modal("show");
	ultimoIdTurno = $(this).attr("data-id");
});

//confirmar la eliminacion del turno
$(document).on("change", "#modalConfirmarQuitarTurnoConfirmacion", function () {
	if ($("#modalConfirmarQuitarTurnoConfirmacion").val() == "1") {
		$("#modalConfirmarQuitarTurnoBoton").removeAttr("disabled");
	} else {
		$("#modalConfirmarQuitarTurnoBoton").attr("disabled", "disabled");
	}
});

//verificar si existe DNI y si es correcto
$(document).on("keyup", "#modalNuevoPacienteDNI", function () {
	if ($(this).val().length > 7) {
		$.ajax({
			url: "../php/receptionTurns/buscarDNI.php",
			type: "post",
			data: {
				dni: $(this).val(),
			},
			success: function (data) {
				if (data != "0") {
					$("#modalNuevoPacienteDNIExiste").show();
					$("#modalNuevoPacienteDNI").removeClass("is-valid").addClass("is-invalid");
				} else {
					$("#modalNuevoPacienteDNIExiste").hide();
					$("#modalNuevoPacienteDNI").removeClass("is-invalid").addClass("is-valid");
				}
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	} else {
		$("#modalNuevoPacienteDNI").removeClass("is-valid").addClass("is-invalid");
	}
});

//verificar apellido
$(document).on("keyup", "#modalNuevoPacienteApellido", function () {
	if ($(this).val().length > 2) {
		$(this).removeClass("is-invalid").addClass("is-valid");
	} else {
		$(this).removeClass("is-valid").addClass("is-invalid");
	}
});

//verificar nombre
$(document).on("keyup", "#modalNuevoPacienteNombre", function () {
	if ($(this).val().length > 2) {
		$(this).removeClass("is-invalid").addClass("is-valid");
	} else {
		$(this).removeClass("is-valid").addClass("is-invalid");
	}
});

//verificar fecha
$(document).on("keyup", "#modalNuevoPacienteFechaNacimiento", function () {
	if ($(this).val().length > 2) {
		$(this).removeClass("is-invalid").addClass("is-valid");
	} else {
		$(this).removeClass("is-valid").addClass("is-invalid");
	}
});

//verificar domicilio
$(document).on("keyup", "#modalNuevoPacienteDomicilio", function () {
	if ($(this).val().length > 2) {
		$(this).removeClass("is-invalid").addClass("is-valid");
	} else {
		$(this).removeClass("is-valid").addClass("is-invalid");
	}
});

//verificar telefeno fijo 1
$(document).on("keyup", "#modalNuevoPacienteTelFijo1", function () {
	if ($(this).val().length > 11) {
		$(this).removeClass("is-invalid").addClass("is-valid");
	} else {
		$(this).removeClass("is-valid").addClass("is-invalid");
	}
});

//verificar telefeno fijo 1
$(document).on("keyup", "#modalNuevoPacienteTelFijo2", function () {
	if ($(this).val().length > 11) {
		$(this).removeClass("is-invalid").addClass("is-valid");
	} else {
		$(this).removeClass("is-valid").addClass("is-invalid");
	}
});

//verificar celular
// $(document).on("keyup", "#modalNuevoPacienteCelular", function () {
// 	if ($(this).val().length > 16) {
// 		$(this).removeClass("is-invalid").addClass("is-valid");
// 	} else {
// 		$(this).removeClass("is-valid").addClass("is-invalid");
// 	}
// });

//verificar email
$(document).on("keyup", "#modalNuevoPacienteEmail, #modalProveedoresEmail, #modalProveedoresModificarEmail", function () {
	if ($(this).val().indexOf("@", 0) == -1 || $(this).val().indexOf(".", 0) == -1) {
		$(this).removeClass("is-valid").addClass("is-invalid");
		$("#modalProveedoresGuardar, #modalModificarProveedorBoton").attr("disabled", true);
	} else {
		$(this).removeClass("is-invalid").addClass("is-valid");
		$("#modalProveedoresGuardar, #modalModificarProveedorBoton").removeAttr("disabled");
	}

	if ($(this).val().length == 0) {
		$("#modalProveedoresGuardar, #modalModificarProveedorBoton").removeAttr("disabled");
		$(this).removeClass("is-invalid");
	}
});

//verificar observaciones
$(document).on("keyup", "#modalNuevoPacienteObservacion", function () {
	if ($(this).val().length > 2) {
		$(this).removeClass("is-invalid").addClass("is-valid");
	} else {
		$(this).removeClass("is-valid").addClass("is-invalid");
	}
});

//ocualtar botones modal editar paciente
$(document).on("click", "#botonEdicionRapidaPaciente", function () {
	setTimeout(function () {
		$("#modalEditarPacientePacienteEquivocado, #modalEditarPacienteContinuar").hide();
	}, 400);
});

//editar paciente MODAL
function editarPaciente(str) {
	pacienteSeleccionadaGrilla = str;
	$("#modalEditarPacientePacienteEquivocado, #modalEditarPacienteContinuar").show();
	$.ajax({
		url: "../php/receptionTurns/cargarDatosPaciente.php",
		type: "post",
		data: {
			id: pacienteSeleccionadaGrilla,
		},
		success: function (data) {
			$("#modalEditarPacienteContenido").html(data);
			if ($("#modalEditarPacienteDNI").val() == "") {
				$("#modalEditarPacienteDNI").addClass("is-invalid");
			} else {
				$("#modalEditarPacienteDNI").addClass("is-valid");
			}
			if ($("#modalEditarPacienteApellido").val() == "") {
				$("#modalEditarPacienteApellido").addClass("is-invalid");
			} else {
				$("#modalEditarPacienteApellido").addClass("is-valid");
			}
			if ($("#modalEditarPacienteNombre").val() == "") {
				$("#modalEditarPacienteNombre").addClass("is-invalid");
			} else {
				$("#modalEditarPacienteNombre").addClass("is-valid");
			}
			if ($("#modalEditarPacienteEmail").val() == "") {
				$("#modalEditarPacienteEmail").addClass("is-invalid");
			} else {
				$("#modalEditarPacienteEmail").addClass("is-valid");
			}
			// if ($("#modalEditarPacienteCobrtura").val() == "") {
			// 	$("#modalEditarPacienteCobrtura").addClass("is-invalid");
			// } else {
			// 	$("#modalEditarPacienteCobrtura").addClass("is-valid");
			// }
			if ($("#modalEditarPacienteObservacion").val() == "") {
				$("#modalEditarPacienteObservacion").addClass("is-invalid");
			} else {
				$("#modalEditarPacienteObservacion").addClass("is-valid");
			}
			if ($("#modalEditarPacienteFechaNacimiento").val() == "") {
				$("#modalEditarPacienteFechaNacimiento").addClass("is-invalid");
			} else {
				$("#modalEditarPacienteFechaNacimiento").addClass("is-valid");
			}
			// if ($("#modalEditarPacienteSexo").val() == "") {
			// 	$("#modalEditarPacienteSexo").addClass("is-invalid");
			// } else {
			// 	$("#modalEditarPacienteSexo").addClass("is-valid");
			// }
			if ($("#modalEditarPacienteDomicilio").val() == "") {
				$("#modalEditarPacienteDomicilio").addClass("is-invalid");
			} else {
				$("#modalEditarPacienteDomicilio").addClass("is-valid");
			}
			// if ($("#modalEditarPacienteLocalidad").val() == "") {
			// 	$("#modalEditarPacienteLocalidad").addClass("is-invalid");
			// } else {
			// 	$("#modalEditarPacienteLocalidad").addClass("is-valid");
			// }
			if ($("#modalEditarPacienteTelFijo1").val() == "" || $("#modalEditarPacienteTelFijo1").val() == "-") {
				$("#modalEditarPacienteTelFijo1").addClass("is-invalid");
			} else {
				$("#modalEditarPacienteTelFijo1").addClass("is-valid");
			}
			if ($("#modalEditarPacienteTelFijo2").val() == "" || $("#modalEditarPacienteTelFijo2").val() == "-") {
				$("#modalEditarPacienteTelFijo2").addClass("is-invalid");
			} else {
				$("#modalEditarPacienteTelFijo2").addClass("is-valid");
			}
			if ($("#modalEditarPacienteCelular").val() == "" || $("#modalEditarPacienteCelular").val() == "-") {
				$("#modalEditarPacienteCelular").addClass("is-invalid");
			} else {
				$("#modalEditarPacienteCelular").addClass("is-valid");
			}
			nCarnetCoberturaPrevio = $("#modalEditarPacienteN_carnet").val();
			nCarnetCoseguroPrevio = $("#modalEditarPacienteCarnetCoseguro").val();
			if ($("#modalEditarPacienteCoseguro").val() == "0") {
				$("#modalEditarPacienteCarnetCoseguro").attr("disabled", true);
			}
			if ($("#modalEditarPacienteCobrtura").val() == "0") {
				$("#modalEditarPacienteN_carnet").attr("disabled", true);
			}
			$("#modalEditarPacientePacienteEquivocado, #modalEditarPacienteContinuar").show();
			$("#modalEditarPaciente").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//cacular edad nuevo paciente
$(document).on("change", "#modalNuevoPacienteFechaNacimiento", function () {
	fecha = $(this).val();
	nacimiento = moment(fecha);
	hoy = moment();
	anios = hoy.diff(nacimiento, "years");
	$("#modalNuevoPacienteEdad").val(anios);
});

//cacular edad edicion paciente
$(document).on("change", "#modalEditarPacienteFechaNacimiento", function () {
	fecha = $(this).val();
	nacimiento = moment(fecha);
	hoy = moment();
	anios = hoy.diff(nacimiento, "years");
	$("#modalEditarPacienteEdad").val(anios);
});

//guardar cambios paciente
$(document).on("click", "#modalEditarPacienteGuardar", function () {
	$.ajax({
		url: "../php/receptionTurns/actualizarPaciente.php",
		type: "post",
		data: {
			id: $("#modalEditarPacienteId").val(),
			dni: $("#modalEditarPacienteDNI").val(),
			apellido: $("#modalEditarPacienteApellido").val(),
			nombre: $("#modalEditarPacienteNombre").val(),
			fechaNacimiento: $("#modalEditarPacienteFechaNacimiento").val(),
			domicilio: $("#modalEditarPacienteDomicilio").val(),
			provincia: $("#modalEditarPacienteProvincia").val(),
			localidad: $("#modalEditarPacienteLocalidad").val(),
			sexo: $("#modalEditarPacienteSexo").val(),
			tel1: $("#modalEditarPacienteTelFijo1").val(),
			tel2: $("#modalEditarPacienteTelFijo2").val(),
			cel: $("#modalEditarPacienteCelular").val(),
			email: $("#modalEditarPacienteEmail").val(),
			coberturaSocial: $("#modalEditarPacienteCobrtura").val(),
			nCarnetCobertura: $("#modalEditarPacienteN_carnet").val(),
			coseguro: $("#modalEditarPacienteCoseguro").val(),
			nCarnetCoseguro: $("#modalEditarPacienteCarnetCoseguro").val(),
			observacion: $("#modalEditarPacienteObservacion").val(),
		},
		success: function (data) {
			if (data == "1") {
				$("#modalAgregarDatosPacienteDNISolicitante").val($("#modalEditarPacienteDNI").val());
				$("#modalAgregarDatosDelPacienteApyNom").val($("#modalEditarPacienteApellido").val() + ", " + $("#modalEditarPacienteNombre").val());
				$("#modalEditarPaciente").modal("hide");
				if (turnosActivo == false) {
					$("#recepcionPacientes").click();
				}
				if (idPacienteSeleccionadoGrilla != "") {
					setTimeout(function () {
						buscarTurnos($("#selectTurnosPorDoctor").val(), $("#inputFechaABuscar").val());
						console.log("refresco de tabla");
					}, 500);
				}
			} else {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//desasctivar input n° cobertura
$(document).on("change", "#modalEditarPacienteCobrtura", function () {
	if ($(this).val() == "0") {
		$("#modalEditarPacienteN_carnet").val("").attr("disabled", true);
	} else {
		$("#modalEditarPacienteN_carnet").val(nCarnetCoberturaPrevio).removeAttr("disabled");
	}
});

//desasctivar input n° coseguro
$(document).on("change", "#modalEditarPacienteCoseguro", function () {
	if ($(this).val() == "0") {
		$("#modalEditarPacienteCarnetCoseguro").val("").attr("disabled", true);
	} else {
		$("#modalEditarPacienteCarnetCoseguro").val(nCarnetCoseguroPrevio).removeAttr("disabled");
	}
});

//focus seleccionar medico
$(document).on("click", "#modalEditarPacienteContinuar", function () {
	setTimeout(function () {
		$("#nuevoTurnoMedicoMatricula").focus();
	}, 400);
});

//editar turno MODAL
function editarReserva(str) {
	ultimoIdTurno = str;
	$.ajax({
		url: "../php/receptionTurns/cargarDetallesDeTurno.php",
		type: "post",
		data: {
			id: str,
		},
		success: function (data) {
			$("#modalEditarTurnoContenido").html(data);
			$("#modalEditarTurno").modal("show");
			$("#modalInformacionTurno").modal("hide");
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//mostar opciones edicion de tipo turno
$(document).on("change", "#modalEditarTurnoTipoTurno", function () {
	$("#modalEditarTurnoColEstudio").hide();
	$("#modalEditarTurnoColCirugia").hide();
	switch ($("#modalEditarTurnoTipoTurno").val()) {
		case "2":
			$("#modalEditarTurnoColEstudio").show();
			break;
		case "3":
			$("#modalEditarTurnoColCirugia").show();
			break;
	}
});

//actualizar tuno
$(document).on("click", "#modalEditarTurnoConfirmar", function () {
	if ($("#modalEditarTurnoUrgencia").prop("checked")) {
		turnoUrgencia = "1";
	} else {
		turnoUrgencia = "0";
	}
	$.ajax({
		url: "../php/receptionTurns/actualizarTurno.php",
		type: "post",
		data: {
			id: ultimoIdTurno,
			urgencia: turnoUrgencia,
			title: $("#modalEditarTurnoTitle").val(),
			observacion: $("#modalEditarTurnoObservacion").val(),
		},
		success: function (data) {
			$("#modalEditarTurno").modal("hide");
			$("#actualizarGrilla").click();
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//eliminarTurno
$(document).on("click", "#modalConfirmarQuitarTurnoBoton", function () {
	$.ajax({
		url: "../php/receptionTurns/eliminarTurno.php",
		type: "post",
		data: {id: ultimoIdTurno},
		success: function () {
			if (turnoDesdeGrilla == false) {
				$("#modalConfirmarQuitarTurnoConfirmacion").val("0");
				$("#modalConfirmarQuitarTurnoBoton").attr("disabled", "disabled");
			} else {
				$("#actualizarGrilla").click();
				turnoDesdeGrilla = false;
			}
			$("#modalConfirmarQuitarTurno").modal("hide");
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//mostrar modal agregar datos del paciente
$(document).on("click", "#agregarTurnoDiaSeleccionado", function () {
	if ($("#modalAgregarDatosSobreTurno").prop("cheked")) {
		$("#modalAgregarDatosSobreTurno").click();
	}
	if ($("#modalAgregarDatosPacienteOD").prop("cheked")) {
		$("#modalAgregarDatosPacienteOD").click();
	}
	if ($("#modalAgregarDatosPacienteOI").prop("cheked")) {
		$("#modalAgregarDatosPacienteOI").click();
	}
	$("#modalAgregarDatosPacienteHora").val($(this).attr("data-hora"));
	$("#modalAgregarDatosPacienteHora").attr("disabled", "disabled");
	$("#modalAgregarDatosPacienteHora").removeClass("is-invalid");
	$("#modalAgregarDatosPacienteTurno, #modalAgregarDatosCantidad").val("1");
	$("#modalAgregarDatosPacienteL, #modalAgregarDatosPacienteD").val("");
	$(
		"#modalAgregarDatosPacientePractica, #modalAgregarDatosPacienteCirugia, #modalAgregarDatosPacienteLente, #modalAgregarDatosPacienteDioptrias, #modalAgregarDatosPacienteOjos"
	).hide();
	$("#modalAgregarDatosPaciente").modal("show");
	$("#horaMsg").html("");
	verificarCantidadPosible($("#nuevoTurnoMedicoNombre").val(), $(this).attr("data-hora"));
});

//verificar cantidad posible de turnos a entergar
function verificarCantidadPosible(idMedico, h) {
	$.ajax({
		url: "../php/receptionTurns/verificarCantidadTurnos.php",
		type: "post",
		data: {
			idMed: idMedico,
			fecha: fecha,
			hora: h,
		},
		success: function (data) {
			if (data >= 1) {
				cant = data;
			} else {
				cant = 1;
			}
			$("#modalAgregarDatosCantidad").attr("max", cant);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//ajustar tipo de turno 1, 2 y 3
$("#modalAgregarDatosPacienteTurno").on("change", function () {
	$(
		"#modalAgregarDatosPacientePractica, #modalAgregarDatosPacienteCirugia, #modalAgregarDatosPacienteLente, #modalAgregarDatosPacienteDioptrias, #modalAgregarDatosPacienteOjos"
	).hide();
	switch ($("#modalAgregarDatosPacienteTurno").val()) {
		case "2":
			$("#modalAgregarDatosPacientePractica").show();
			break;
		case "3":
			$(
				"#modalAgregarDatosPacienteCirugia, #modalAgregarDatosPacienteLente, #modalAgregarDatosPacienteDioptrias, #modalAgregarDatosPacienteOjos"
			).show();
			break;
	}
});

//guardar turno
$("#modalAgregarDatosPacienteGuardar").on("click", function () {
	if (
		$("#modalAgregarDatosPacienteTitle").val() != "" &&
		$("#modalAgregarDatosPacienteDNISolicitante").val() != "" &&
		$("#modalAgregarDatosDelPacienteApyNom").val() != ""
	) {
		const motivoMensaje = $("#modalAgregarDatosPacienteTitle").val();
		const doctorMensaje = $("#nuevoTurnoMedicoNombre option:selected").text();
		const fechaMensaje = fecha + " " + $("#modalAgregarDatosPacienteHora").val();
		const celularMensaje = $("#modalEditarPacienteCelular").val();
		const mailMensaje = $("#modalEditarPacienteEmail").val();
		const apellidoMensaje = $("#modalEditarPacienteApellido").val();
		const nombreMensaje = $("#modalEditarPacienteNombre").val();
		switch ($("#modalAgregarDatosPacienteTurno").val()) {
			case "1":
				medicoEfector = "-";
				medicoSolicitante = "-";
				break;
			case "2":
				medicoEfector = $("#nuevoTurnoMedicoNombre").val();
				medicoSolicitante = $("#modalAgregarDatosMSolicitante").val();
				break;
			case "3":
				medicoEfector = "-";
				medicoSolicitante = "-";
				break;
		}
		if ($("#modalAgregarDatosSobreTurno").prop("checked")) {
			sobreT = 1;
		} else {
			sobreT = 0;
		}
		if ($("#modalAgregarDatosConfirmado").prop("checked")) {
			conf = 1;
		} else {
			conf = 0;
		}
		if ($("#modalAgregarDatosUrgencia").prop("checked")) {
			urg = 1;
		} else {
			urg = 0;
		}
		if ($("#modalAgregarDatosPacienteOD").prop("checked")) {
			OD = 1;
		} else {
			OD = 0;
		}
		if ($("#modalAgregarDatosPacienteOI").prop("checked")) {
			OI = 1;
		} else {
			OI = 0;
		}
		if ($("#modalAgregarDatosPacienteL").val() == "") {
			lent = "-";
		} else {
			lent = $("#modalAgregarDatosPacienteL").val();
		}
		if ($("#modalAgregarDatosPacienteD").val() == "") {
			di = "-";
		} else {
			di = $("#modalAgregarDatosPacienteD").val();
		}
		$.ajax({
			url: "../php/receptionTurns/guardarTurno.php",
			type: "post",
			data: {
				tipoTurno: $("#modalAgregarDatosPacienteTurno").val(),
				title: $("#modalAgregarDatosPacienteTitle").val(),
				idMedico: $("#nuevoTurnoMedicoNombre").val(),
				mSolicitante: medicoSolicitante,
				mEfector: medicoEfector,
				dniSolicitante: $("#modalAgregarDatosPacienteDNISolicitante").val(),
				inicio: fecha + " " + $("#modalAgregarDatosPacienteHora").val(),
				sobreturno: sobreT,
				confirmado: conf,
				urgencia: urg,
				cantidad: $("#modalAgregarDatosCantidad").val(),
				lente: lent,
				diop: di,
				ojoD: OD,
				ojoI: OI,
				observacion: $("#modalAgregarDatosPacienteObservacion").val(),
			},
			success: function (data) {
				if (data == "0") {
					$("#horaMsg").html("<span class='text-danger'> Reservado</span>");
					$("#modalAgregarDatosPacienteHora").addClass("is-invalid");
				} else {
					$("#calendarioDetalles").html(msgCalendarioDetalles);
					$("#horaMsg").html("");
					$("#modalAgregarDatosPaciente").modal("hide");
					$("#modalAgregarDatosPacienteHora").removeClass("is-invalid");
				}
				$(
					"#modalAgregarDatosPacienteTitle, #modalAgregarDatosPacienteTurno, #modalAgregarDatosDelPacienteApyNom, #modalAgregarDatosPacienteDNISolicitante"
				).removeClass("is-invalid");
				ohSnap("Turno guardado correctamente", {duration: "2000", color: "green"});
				$("#modalAgregarDatosPacienteObservacion, #modalAgregarDatosPacienteTitle").val("");
				//cargarTurnosDelDia(fecha, $("#nuevoTurnoMedicoNombre").val());
				//generarCalendario($("#nuevoTurnoMedicoNombre").val());
				notificarPaciente(apellidoMensaje, nombreMensaje, motivoMensaje, doctorMensaje, fechaMensaje, celularMensaje, mailMensaje);
				setTimeout(function () {
					marcarCantidades();
				}, 400);
				$("#modalAgregarDatosPacienteDNISolicitante, #modalAgregarDatosDelPacienteApyNom, #nuevoTurnoMedicoMatricula")
					.val("")
					.removeClass("is-valid");
				$("#detallesPacienteTurno").html("");
				$("#nuevoTurnoMedicoNombre").val("0").removeClass("is-valid");
				$("#calendario").html('<span class="text-danger">Por favor seleccione un médico efector</span>');
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	} else {
		if ($("#modalAgregarDatosPacienteTitle").val() == "") {
			$("#modalAgregarDatosPacienteTitle").addClass("is-invalid");
			$("#modalAgregarDatosPacienteGuardar").attr("disabled", "disabled");
			setTimeout(function () {
				$("#modalAgregarDatosPacienteTitle").removeClass("is-invalid");
				$("#modalAgregarDatosPacienteGuardar").removeAttr("disabled");
			}, 1500);
		}

		if ($("#modalAgregarDatosPacienteDNISolicitante").val() == "") {
			$("#modalAgregarDatosPacienteDNISolicitante").addClass("is-invalid");
			$("#modalAgregarDatosPacienteGuardar").attr("disabled", "disabled");
			setTimeout(function () {
				$("#modalAgregarDatosPacienteDNISolicitante").removeClass("is-invalid");
				$("#modalAgregarDatosPacienteGuardar").removeAttr("disabled");
			}, 1500);
		}

		if ($("#modalAgregarDatosDelPacienteApyNom").val() == "") {
			$("#modalAgregarDatosDelPacienteApyNom").addClass("is-invalid");
			$("#modalAgregarDatosPacienteGuardar").attr("disabled", "disabled");
			setTimeout(function () {
				$("#modalAgregarDatosDelPacienteApyNom").removeClass("is-invalid");
				$("#modalAgregarDatosPacienteGuardar").removeAttr("disabled");
			}, 1500);
		}

		if ($("#modalAgregarDatosPacienteTurno").val() == "0") {
			$("#modalAgregarDatosPacienteTurno").addClass("is-invalid");
			$("#modalAgregarDatosPacienteGuardar").attr("disabled", "disabled");
			setTimeout(function () {
				$("#modalAgregarDatosPacienteTurno").removeClass("is-invalid");
				$("#modalAgregarDatosPacienteGuardar").removeAttr("disabled");
			}, 1500);
		}
	}
});

//notificar paciente
function notificarPaciente(apellido, nombre, motivo, doctor, fecha, celular, mail) {
	var f = new Date(fecha);
	dia = f.getDate() + "/" + (f.getMonth() + 1) + "/" + f.getFullYear();
	hora = f.getHours() + ":" + f.getMinutes();
	const mensaje =
		apellido.toUpperCase() +
		" " +
		nombre.toUpperCase() +
		". Su turno " +
		motivo.toUpperCase() +
		" ha sido confirmado con éxito para el día " +
		dia +
		" a las " +
		hora +
		"horas con el doctor " +
		doctor.toUpperCase() +
		".";
	//cel = celular.replace("(", "").replace(")", "").replace("-", "").replace("-", "").replace(" ", "");
	//const urlWhatsapp = "https://api.whatsapp.com/send?phone=" + cel + "&text=" + mensaje;
	//$("#notificarPorWhatsapp").attr("href", urlWhatsapp);
	notificarPorMail(mail, mensaje);
	// if ($("#modalEditarPacienteEmail").val() != "") {
	// 	$("#notificarPorMailCol").show();
	// } else {
	// 	$("#notificarPorMailCol").hide();
	// }
	//$("#modalNotificarPaciente").modal("show");
}

//enviar mail paciente
function notificarPorMail(mail, mensaje) {
	$.ajax({
		url: "../php/receptionTurns/mailNotificarPaciente.php",
		type: "post",
		data: {
			m: mail,
			msg: mensaje,
		},
		beforeSend: function () {
			ohSnap("Enviando email a " + mail, {duration: "2000", color: "blue"});
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				ohSnap("Email enviado a " + mail, {duration: "2000", color: "green"});
			} else if (data == "0") {
				ohSnap("No se pudo enviar el email a " + mail, {duration: "2000", color: "red"});
			}
		},
		error: function () {
			ohSnap("No tiene conexión", {duration: "2000", color: "red"});
		},
	});
}

//mover evento
// function moverEvento(id, nuevaFecha){
//   console.log(nuevaFecha);
//   $.ajax({
//     url: '../php/receptionTurns/moverTurno.php',
//     type: 'post',
//     data: {id: id,
//     nuevaFecha: nuevaFecha},
//     success: function(data){
//       console.log(data)
//       if(data == "0"){
//         $("#modalConfirmarDrop").modal("hide");
//         $("#modalErrorTurnoExistente").modal('show');
//         $("#modalConfirmarDropCancelar").click();
//       }else if(data == "1"){
//         $("#modalErrorTurnoExistente").modal("hide");
//         $("#modalConfirmarDrop").modal("hide");
//       }
//       generarCalendario($("#nuevoTurnoMedicoNombre").val());
//     },
//     error: function(){
//       $("#contenedorCategoriaRecepcion").html(errorMsg);
//     }
//   })
// }

//nuevo sobreturno
$(document).on("click", "#nuevoSobreTurno", function () {
	var hora = new Date();
	if (hora.getMinutes().length == 1) {
		minutos = "0" + hora.getMinutes();
	} else {
		minutos = hora.getMinutes();
	}
	if ($("#modalAgregarDatosSobreTurno").prop("checked") == false) {
		$("#modalAgregarDatosSobreTurno").click();
	}
	$("#modalAgregarDatosPacienteHora").val(hora.getHours() + ":" + minutos);
	$("#modalAgregarDatosPacienteTurno, #modalAgregarDatosCantidad").val("1");
	$("#modalAgregarDatosPacienteL, #modalAgregarDatosPacienteD").val("");
	$(
		"#modalAgregarDatosPacientePractica, #modalAgregarDatosPacienteCirugia, #modalAgregarDatosPacienteLente, #modalAgregarDatosPacienteDioptrias, #modalAgregarDatosPacienteOjos"
	).hide();
	$("#modalAgregarDatosPaciente").modal("show");
	$("#horaMsg").html("");
});

//cargar turnos del dia
function cargarTurnosDelDia(str, medico) {
	if ($("#modalAgregarDatosPacienteDNISolicitante").val() == "" || $("#modalAgregarDatosDelPacienteApyNom").val() == "") {
		$("#calendarioDetalles").html("<span class='text-danger'>Por favor complete DNI del paciente</span>");
		$("#modalAgregarDatosPacienteDNISolicitante").addClass("is-invalid");
	} else {
		$.ajax({
			url: "../php/receptionTurns/detectarEventos.php",
			type: "post",
			data: {
				fecha: str,
				medico: medico,
			},
			success: function (data) {
				//$("#modalVerTurnosDelDiaContenido").html(data)
				$("#calendarioDetalles").html(data);
				$("#modalAgregarDatosPacienteDNISolicitante").removeClass("is-invalid");
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	}
}

//#region TURNOS RESERVADOS

//actualizar grilla
$(document).on("click", "#actualizarGrilla", function () {
	flagAgregarWPTEL = false;
	if ($("#selectTurnosPorDoctor").val() != "0") {
		buscarTurnos($("#selectTurnosPorDoctor").val(), $("#inputFechaABuscar").val());
		$("#buscarTurnoReservado").val("");
		$(
			"#marcarConfirmado, #opcionEditarPaciente, #cortarTurno, #botonEliminarTurno, #opcionEditarTurno, #opcionMarcarLlegada, #opcionCobrarTurno, #opcionHistorialDeTurnos, #mensajeWhatsapp, #llamarPaciente"
		).hide();
	}
});

//seleccionar fila turno
$(document).on("click", ".filaTurno", function () {
	tipoTurnoFilaTurno = $(this).attr("data-tipoTurno");
	$(this).children().children().children()[0].click();
	$(this).addClass("bg-info text-white").siblings().removeClass("bg-info text-white");
	if ($(this).attr("data-idPago")) {
		idPagoTurno = $(this).attr("data-idPago");
	} else {
		idPagoTurno = "";
	}
});

//almacenar id turno seleccionado
function idRegistroSeleccionado(
	id,
	tel,
	dni,
	fecha,
	medico,
	paciente,
	nombrePaciente,
	cobertura,
	coseguro,
	modulada,
	tipo_turno,
	nCarnet,
	idPaciente
) {
	tipoCoberturaSeleccionadaGrilla = modulada;
	coberturaSeleccionadaGrilla = cobertura;
	coseguroSeleccionadaGrilla = coseguro;
	medicoSeleccionadaGrilla = medico;
	pacienteSeleccionadaGrilla = paciente;
	nombrePacienteSeleccionadaGrilla = nombrePaciente;
	fechaSeleccionadaGrilla = fecha;
	dniSeleccionadoGrilla = dni;
	turnoSeleccionadoGrilla = id;
	tipoTurnoSeleccionadoGrilla = tipo_turno;
	numeroCarnetSeleccionadoGrilla = nCarnet;
	idPacienteSeleccionadoGrilla = idPaciente;
	const telefono = tel.replace("+", "").replace("(", "").replace(")", "").replace("-", "").replace("-", "").replace(" ", "");
	const whatsapp =
		'<a title="Enviar mensaje usando Whatsapp" id="mensajeWhatsapp" target="_blank" href="https://api.whatsapp.com/send?phone=' +
		telefono +
		'"><i role="button" class="fab fa-whatsapp text-success mr-3" style="font-size: 20px;"></i></a>';
	if (flagAgregarWPTEL == false) {
		const phone =
			'<a title="Llamar desde smartphone" id="llamarPaciente" target="_blank" href="tel:' +
			telefono +
			'"><i role="button" class="fas fa-phone-alt mr-3 text-primary" style="font-size: 20px;"></i></a>';
		$("#barraHerramientasTurnosTomados").append(whatsapp, phone);
		$(
			"#marcarConfirmado, #opcionEditarPaciente, #cortarTurno, #botonEliminarTurno, #opcionEditarTurno, #opcionCobrarTurno, #opcionHistorialDeTurnos, #opcionMarcarLlegada"
		).show();
		flagAgregarWPTEL = true;
	} else {
		$("#mensajeWhatsapp").attr("href", "https://api.whatsapp.com/send?phone=" + telefono);
		$("#llamarPaciente").attr("href", "tel:+" + telefono);
	}
	if ($("#ingresoPaciente" + turnoSeleccionadoGrilla).html() != "-") {
		$("#opcionMarcarLlegada").addClass("fa-arrow-up text-danger").removeClass("fa-arrow-down text-success").attr("title", "Anular ingreso");
	} else {
		$("#opcionMarcarLlegada").addClass("fa-arrow-down text-success").removeClass("fa-arrow-up text-danger").attr("title", "Marcar llegada");
	}
	if ($("#paciente" + turnoSeleccionadoGrilla).prop("checked")) {
		$("#opcionCobrarTurno").addClass("fa-undo text-danger").removeClass("fa-hand-holding-usd text-success").attr("title", "Anular cobro");
	} else {
		$("#opcionCobrarTurno").removeClass("fa-undo text-danger").addClass("fa-hand-holding-usd text-success");
	}
	if ($("#confirmado" + turnoSeleccionadoGrilla).hasClass("fa-check")) {
		$("#marcarConfirmado").addClass("fa-times text-danger").removeClass("fa-check text-success").attr("title", "Remover confirmación");
	} else {
		$("#marcarConfirmado").removeClass("fa-times text-danger").addClass("fa-check text-success");
	}
}

//marcar llegada
$(document).on("click", "#opcionMarcarLlegada", function () {
	if ($("#ingresoPaciente" + turnoSeleccionadoGrilla).html() != "-") {
		marcarLlegada("0");
	} else {
		marcarLlegada("1");
	}
});

//llamar a editar paciente
$(document).on("click", "#opcionEditarPaciente", function () {
	editarPaciente(idPacienteSeleccionadoGrilla);
	setTimeout(function () {
		$("#modalEditarPacientePacienteEquivocado, #modalEditarPacienteContinuar").hide();
	}, 500);
});

//obtener cobertura social por codigo
$(document).on("change", "#modalCobrarTurnoCodigoCoberturaSocial", function () {
	flagCobertura = true;

	$.ajax({
		url: "../php/receptionTurns/verificarTipoCobertura.php",
		type: "post",
		data: {
			codigo: $("#modalCobrarTurnoCodigoCoberturaSocial").val(),
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				$("#modalCobrarTurnoCoseguro").removeAttr("disabled");
				$("#modalCobrarTurnoCodigoCoseguro").removeAttr("disabled", true);
			} else {
				$("#modalCobrarTurnoCodigoCoseguro").val("").attr("disabled", true);
				$("#modalCobrarTurnoCoseguro").val("0").attr("disabled", true);
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});

	$("#modalCobrarTurnoCoberturaSocial option").each(function () {
		if ($(this).val() == $("#modalCobrarTurnoCodigoCoberturaSocial").val()) {
			$(this).attr("selected", true);
			$("#modalCobrarTurnoCoberturaSocial").val($(this).val());
			$("#modalCobrarTurnoCoberturaSeleccionada").html($("#modalCobrarTurnoCoberturaSocial option:selected").text());
			flagCobertura = true;
			return false;
		} else {
			$(this).removeAttr("selected");
			flagCobertura = false;
		}
	});
	if (flagCobertura == false) {
		$("#modalCobrarTurnoCodigoCoberturaSocial").addClass("text-danger");
		setTimeout(function () {
			$("#modalCobrarTurnoCodigoCoberturaSocial").val("").focus().removeClass("text-danger");
		}, 500);
		flagCobertura = true;
	}
});

//obtener coseguro por codigo
$(document).on("change", "#modalCobrarTurnoCodigoCoseguro", function () {
	flagCoseguro = true;
	$("#modalCobrarTurnoCoseguro option").each(function () {
		if ($(this).val() == $("#modalCobrarTurnoCodigoCoseguro").val()) {
			$(this).attr("selected", true);
			$("#modalCobrarTurnoCoseguro").val($(this).val());
			flagCoseguro = true;
			return false;
		} else {
			$(this).removeAttr("selected");
			flagCoseguro = false;
		}
	});
	if (flagCoseguro == false) {
		$("#modalCobrarTurnoCodigoCoseguro").addClass("text-danger");
		setTimeout(function () {
			$("#modalCobrarTurnoCodigoCoseguro").val("").focus().removeClass("text-danger");
		}, 500);
		flagCoseguro = true;
	}
});

//completar codigo de cobertura social
/////////////IMPORTANTE/////////////
// 1 - MODULADA (NO USA COSEGURO) - SANCOR Y/O OSDE
// 2 - RESTO (USA COSEGURO - NO OBLIGATORIO)
// COSEGURO (USA COSEGURO)
/////////////IMPORTANTE/////////////
$(document).on("change", "#modalCobrarTurnoCoberturaSocial", function () {
	$("#modalCobrarTurnoCoseguro option").each(function () {
		if ($(this).val() == "0") {
			$(this).remove();
		}
	});
	$("#modalCobrarTurnoCodigoCoseguro").val($("#modalCobrarTurnoCoseguro").val());

	$("#modalCobrarTurnoCodigoCoberturaSocial").val($(this).val());
	$("#modalCobrarTurnoCoberturaSeleccionada").html($("#modalCobrarTurnoCoberturaSocial option:selected").text());
	$.ajax({
		url: "../php/receptionTurns/verificarTipoCobertura.php",
		type: "post",
		data: {
			codigo: $(this).val(),
		},
		success: function (data) {
			if (data == "1") {
				$("#modalCobrarTurnoCoseguro").removeAttr("disabled");
				$("#modalCobrarTurnoCodigoCoseguro").removeAttr("disabled", true);
			} else {
				$("#modalCobrarTurnoCodigoCoseguro").val("").attr("disabled", true);
				$("#modalCobrarTurnoCoseguro").val("0").attr("disabled", true);
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//completar codigo coseguro
$(document).on("change", "#modalCobrarTurnoCoseguro", function () {
	$("#modalCobrarTurnoCodigoCoseguro").val($(this).val());
});

//mostrar vacia la lista de coberturas sociales
var flagOption = false;
$(document).on("click", "#modalCobrarTurnoFiltrarCoberturas", function () {
	if (flagOption == false) {
		$("#modalCobrarTurnoCoberturaSocial").append("<option value='0' selected></option>");
		flagOption = true;
	}
	$("#modalCobrarTurnoCodigoCoberturaSocial").val("");
	$("#modalCobrarTurnoCoberturaSeleccionada").html('<i class="fas fa-exclamation text-warning oscilar mr-2"></i> Seleccione una cobertura social');
});

//eliminar opcion vacia
$("#modalCobrarTurnoCoberturaSocial").hover(function () {
	flagOption = false;
	$("#modalCobrarTurnoCoberturaSocial option").each(function () {
		if ($(this).val() == "0") {
			$(this).remove();
			//$("#modalCobrarTurnoCoberturaSocial, #modalCobrarTurnoCodigoCoberturaSocial").val(coberturaSeleccionadaGrilla);
			$("#modalCobrarTurnoCoberturaSeleccionada").html($("#modalCobrarTurnoCoberturaSocial option:selected").text());
		}
	});
});

//buscar coberturas sociales
$(document).on("keyup", "#modalCobrarTurnoFiltrarCoberturas", function () {
	var buscarDato = $(this)
		.val()
		.trim()
		.toLowerCase()
		.replace("á", "a")
		.replace("é", "e")
		.replace("í", "i")
		.replace("ó", "o")
		.replace("ú", "u")
		.toUpperCase();
	cantidad = 0;
	if (buscarDato == "") {
		$(".cobertura").each(function () {
			$(this).show();
			cantidad++;
		});
	} else {
		$(".cobertura").each(function () {
			var Dato = $(this)
				.attr("data-buscar")
				.toLowerCase()
				.replace("á", "a")
				.replace("é", "e")
				.replace("í", "i")
				.replace("ó", "o")
				.replace("ú", "u")
				.toUpperCase();
			if (Dato.indexOf(buscarDato) > -1) {
				$(this).show();
				cantidad++;
			} else {
				$(this).hide();
			}
		});
	}
});

//funcion marcar llegada
function marcarLlegada(str) {
	$.ajax({
		url: "../php/receptionTurns/marcarLlegada.php",
		type: "post",
		data: {
			idTurno: turnoSeleccionadoGrilla,
			accion: str,
		},
		success: function (data) {
			if (data == "1") {
				if ($("#ingresoPaciente" + turnoSeleccionadoGrilla).html() == "-") {
					ohSnap("Ingreso registrado.", {duration: "3500", color: "green"});
				} else {
					ohSnap("Ingreso anulado.", {duration: "3500", color: "red"});
				}
				$("#actualizarGrilla").click();
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//marcar turno como confirmado
$(document).on("click", "#marcarConfirmado", function () {
	$.ajax({
		url: "../php/receptionTurns/confirmarTurno.php",
		type: "post",
		data: {
			id: turnoSeleccionadoGrilla,
		},
		success: function (data) {
			if (data == "1") {
				ohSnap("Turno confirmado.", {duration: "3000", color: "green"});
			} else if (data == "2") {
				ohSnap("Confirmación removida.", {duration: "3000", color: "yellow"});
			} else {
				ohSnap("La operación no pudo realizarse.", {duration: "3000", color: "red"});
			}
			$("#actualizarGrilla").click();
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//cortar turno
$(document).on("click", "#cortarTurno", function () {
	if ($("#cortarTurno").hasClass("fa-ban")) {
		flagCortar = false;
		$("#inputFechaABuscar").val(fechaPrevia);
		buscarTurnos($("#selectTurnosPorDoctor").val(), $("#inputFechaABuscar").val());
		$("#cortarTurno").addClass("fa-cut text-info").removeClass("fa-ban text-danger rotar");
		$("#selectTurnosPorDoctor, #buscarTurnoReservado").removeAttr("disabled");
		$("#pegarTurno").hide();
		$(
			"#marcarConfirmado, #opcionEditarPaciente, #botonEliminarTurno, #opcionEditarTurno, #opcionMarcarLlegada, #opcionCobrarTurno, #opcionHistorialDeTurnos, #mensajeWhatsapp, #llamarPaciente"
		).show();
		fechaPrevia = "";
	} else {
		flagCortar = true;
		fechaPrevia = $("#inputFechaABuscar").val();
		$(
			"#marcarConfirmado, #opcionEditarPaciente, #botonEliminarTurno, #opcionEditarTurno, #opcionMarcarLlegada, #opcionCobrarTurno, #opcionHistorialDeTurnos, #mensajeWhatsapp, #llamarPaciente"
		).hide();
		$("#cortarTurno").removeClass("fa-cut text-info").addClass("fa-ban text-danger rotar");
		ohSnap("Seleccione una nueva fecha para pegar el turno.", {duration: "3000", color: "blue"});
		$("#inputFechaABuscar").focus();
		$("#inputFechaABuscar, #buscarTurnoReservado").val("");
		$("#buscarTurnoReservado, #selectTurnosPorDoctor").attr("disabled", "disabled");
		$("#respuestaTurnosReservados").html(msgTurnoCortar);
	}
});

//preprar turno
function prepararTurno(h) {
	horaNuevoTurnoPegado = h;
	$("#pegarTurno").show();
}

//pegar turno
function pegarTurno() {
	if (turnoSeleccionadoGrilla != "" && horaNuevoTurnoPegado != "") {
		$.ajax({
			url: "../php/receptionTurns/pegarTurno.php",
			type: "post",
			data: {
				id: turnoSeleccionadoGrilla,
				fecha: $("#inputFechaABuscar").val(),
				hora: horaNuevoTurnoPegado,
				medico: $("#selectTurnosPorDoctor").val(),
			},
			success: function (data) {
				if (data == "1") {
					oraNuevoTurnoPegado = "";
					turnoSeleccionadoGrilla = "";
					flagCortar = false;
					ohSnap("Turno pegado.", {duration: "3500", color: "green"});
					$("#cortarTurno").addClass("fa-cut text-info").removeClass("fa-ban text-danger rotar");
					//$("#cortarTurno, #marcarConfirmado, #botonEliminarTurno, #opcionEditarTurno, #opcionMarcarLlegada, #opcionCobrarTurno, #mensajeWhatsapp, #llamarPaciente").show();
					$("#pegarTurno").hide();
					$("#actualizarGrilla").click();
					$("#selectTurnosPorDoctor").removeAttr("disabled");
					buscarTurnos($("#selectTurnosPorDoctor").val(), $("#inputFechaABuscar").val());
				} else {
					ohSnap("El turno no pudo pegarse en esta posición.", {duration: "3000", color: "red"});
				}
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	} else {
		ohSnap("Antes de pegar un turno, debes seleccionar uno primero.", {
			duration: "3000",
			color: "red",
		});
	}
}

//cargar turnos reservados
$(document).on("click", "#turnosReservados-tab", function () {
	buscarTurnos("-", "-");
	$("#inputFechaABuscar, #buscarTurnoReservado").attr("disabled", "disabled").val("");
	$("#selectTurnosPorDoctor").focus().val("0");
});

//seleccionar doctor
$(document).on("change", "#selectTurnosPorDoctor", function () {
	if ($("#selectTurnosPorDoctor").val() != "0") {
		fecha = new Date();
		mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
		dia = ("0" + fecha.getDate()).slice(-2);
		hoy = fecha.getFullYear() + "-" + mes + "-" + dia;
		$("#inputFechaABuscar").removeAttr("disabled").val(hoy);
		if ($("#inputFechaABuscar").val() != "") {
			buscarTurnos($("#selectTurnosPorDoctor").val(), $("#inputFechaABuscar").val());
			if ($("#buscarTurnoReservado").val() == "") {
				$("#buscarTurnoReservado").removeAttr("disabled").val("");
			}
		}
	} else {
		$("#inputFechaABuscar, #buscarTurnoReservado").attr("disabled", "disabled").val("");
		buscarTurnos("-", "-");
	}
});

//buscar registros por fecha
$(document).on("change", "#inputFechaABuscar", function () {
	buscarTurnos($("#selectTurnosPorDoctor").val(), $("#inputFechaABuscar").val());
	$("#buscarTurnoReservado, #pegarTurno").removeAttr("disabled");
	$("#actualizarGrilla").click();
});

//buscar turnos
$(document).on("keyup blur", "#buscarTurnoReservado", function () {
	var buscarDato = $(this)
		.val()
		.trim()
		.toLowerCase()
		.replace("á", "a")
		.replace("é", "e")
		.replace("í", "i")
		.replace("ó", "o")
		.replace("ú", "u")
		.toUpperCase();
	cantidad = 0;
	if (buscarDato == "") {
		$(".filaTurno").each(function () {
			$(this).show();
			cantidad++;
		});
	} else {
		$(".filaTurno").each(function () {
			var Dato = $(this)
				.attr("data-buscar")
				.toLowerCase()
				.replace("á", "a")
				.replace("é", "e")
				.replace("í", "i")
				.replace("ó", "o")
				.replace("ú", "u")
				.toUpperCase();
			if (Dato.indexOf(buscarDato) > -1) {
				$(this).show();
				cantidad++;
			} else {
				$(this).hide();
			}
		});
	}
});

//buscar turnos reservados
function buscarTurnos(idDoc, f) {
	if (flagCortar) {
		$.ajax({
			url: "../php/receptionTurns/tablaTurnosDelDia.php",
			type: "post",
			data: {
				medico: idDoc,
				fecha: f,
			},
			success: function (data) {
				$("#respuestaTurnosReservados").html(data);
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	} else {
		$.ajax({
			url: "../php/receptionTurns/obtenerTurnosReservados.php",
			type: "post",
			data: {
				medico: idDoc,
				fecha: f,
			},
			success: function (data) {
				$("#respuestaTurnosReservados").html(data);
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	}
}

//funcion ver informacion del turno
function verInformacionTurno(str) {
	$.ajax({
		url: "../php/receptionTurns/verDetallesTurno.php",
		type: "post",
		data: {
			id: str,
		},
		success: function (data) {
			$("#modalInformacionTurnoContenido").html(data);
			$("#modalInformacionTurno").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//eliminar turno
$(document).on("click", "#botonEliminarTurno", function () {
	$("#modalConfirmarQuitarTurnoConfirmacion").val("0");
	ultimoIdTurno = turnoSeleccionadoGrilla;
	turnoDesdeGrilla = true;
	if (
		$("#confirmado" + turnoSeleccionadoGrilla).attr("data-estado") == "0" &&
		$("#paciente" + turnoSeleccionadoGrilla).prop("checked") == false &&
		$("#ingresoPaciente" + turnoSeleccionadoGrilla).html() == "-"
	) {
		$("#modalConfirmarQuitarTurno").modal("show");
	} else if ($("#paciente" + turnoSeleccionadoGrilla).prop("checked")) {
		ohSnap("No puede eliminar este turno porque ya se pagó.", {duration: "3000", color: "red"});
		console.log("pagado");
	} else if ($("#ingresoPaciente" + turnoSeleccionadoGrilla).html() != "-") {
		ohSnap("No puede eliminar este turno porque el paciente ya se presentó.", {
			duration: "3000",
			color: "red",
		});
		console.log("presentado");
	} else if ($("#confirmado" + turnoSeleccionadoGrilla).attr("data-estado") == "1") {
		ohSnap("No puede eliminar este turno porque ya se confirmó.", {duration: "3000", color: "red"});
		console.log("confirmado");
	}
});

//editar turno
$(document).on("click", "#opcionEditarTurno", function () {
	editarReserva(turnoSeleccionadoGrilla);
});

//ver detalles del dia
$(document).on("click", "#verDetallesDelDia", function () {
	const fecha = $(this).attr("data-fecha");
	const medico = $(this).attr("data-medico");
	setTimeout(function () {
		$("#selectTurnosPorDoctor option").each(function () {
			$(this).removeAttr("selected");
		});
		$("#selectTurnosPorDoctor option[value=" + medico + "]").attr("selected", true);
		$("#selectTurnosPorDoctor").val(medico);
		$("#inputFechaABuscar").removeAttr("disabled").val(fecha);
		buscarTurnos(medico, fecha);
	}, 500);
	$("#turnosReservados-tab").click();
});

//historial de tunos
$(document).on("click", "#opcionHistorialDeTurnos", function () {
	$.ajax({
		url: "../php/receptionTurns/historialDeTurnos.php",
		type: "post",
		data: {
			dni: dniSeleccionadoGrilla,
		},
		success: function (data) {
			$("#modalHistorialDeTurnosContenido").html(data);
			$("#modalHistorialDeTurnos").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//#endregion FIN TURNOS RESERVADOS

//#endregion turnos
//////////////////////////////////FIN TURNOS////////////////////////////////////

//////////////////////////////////PACIENTES////////////////////////////////////
//#region pacientes
//cargar pacientes
$(document).on("click", "#recepcionPacientes", function () {
	$.ajax({
		url: "../php/receptionTurns/pacientes.php",
		success: function (data) {
			$("#contenedorCategoriaRecepcion").html(data);
			turnosActivo = false;
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//guardar paciente
$(document).on("click", "#modalNuevoPacienteBoton", function () {
	if (
		$("#modalNuevoPacienteCobrtura").val() == "0" ||
		$("#modalNuevoPacienteCelular").val() == "" ||
		$("#modalNuevoPacienteDomicilio").val() == "" ||
		$("#modalNuevoPacienteDNI").val() == "" ||
		$("#modalNuevoPacienteApellido").val() == "" ||
		$("#modalNuevoPacienteNombre").val() == "" ||
		$("#modalNuevoPacienteFechaNacimiento").val() == ""
	) {
		if ($("#modalNuevoPacienteCobrtura").val() == "0") {
			$("#modalNuevoPacienteCobrtura").addClass("is-invalid");
		}
		if ($("#modalNuevoPacienteDNI").val() == "") {
			$("#modalNuevoPacienteDNI").addClass("is-invalid");
		}
		if ($("#modalNuevoPacienteFechaNacimiento").val() == "") {
			$("#modalNuevoPacienteFechaNacimiento").addClass("is-invalid");
		}
		if ($("#modalNuevoPacienteApellido").val() == "") {
			$("#modalNuevoPacienteApellido").addClass("is-invalid");
		}
		if ($("#modalNuevoPacienteNombre").val() == "") {
			$("#modalNuevoPacienteNombre").addClass("is-invalid");
		}
		if ($("#modalNuevoPacienteDomicilio").val() == "") {
			$("#modalNuevoPacienteDomicilio").addClass("is-invalid");
		}
		if ($("#modalNuevoPacienteCelular").val() == "") {
			$("#modalNuevoPacienteCelular").addClass("is-invalid");
		}
		$("#modalNuevoPacienteGuardar").attr("disabled", "disabled");
		setTimeout(function () {
			$("#modalNuevoPacienteCobrtura").removeClass("is-invalid");
			$("#modalNuevoPacienteDNI").removeClass("is-invalid");
			$("#modalNuevoPacienteApellido").removeClass("is-invalid");
			$("#modalNuevoPacienteNombre").removeClass("is-invalid");
			$("#modalNuevoPacienteFechaNacimiento").removeClass("is-invalid");
			$("#modalNuevoPacienteDomicilio").removeClass("is-invalid");
			$("#modalNuevoPacienteCelular").removeClass("is-invalid");
			$("#modalNuevoPacienteGuardar").removeAttr("disabled");
		}, 1500);
	} else {
		if ($("#modalNuevoPacienteCarnetCoseguro").val() == "") {
			n_coseguro = "-";
		} else {
			n_coseguro = $("#modalNuevoPacienteCarnetCoseguro").val();
		}
		if ($("#modalNuevoPacienteCoseguro").val() == "") {
			coseguro = "-";
		} else {
			coseguro = $("#modalNuevoPacienteCoseguro").val();
		}
		if ($("#modalNuevoPacienteN_carnet").val() == "") {
			n_carnet = "-";
		} else {
			n_carnet = $("#modalNuevoPacienteN_carnet").val();
		}
		if ($("#modalNuevoPacienteTelFijo1").val() == "") {
			telefono1 = "-";
		} else {
			telefono1 = $("#modalNuevoPacienteTelFijo1").val();
		}
		if ($("#modalNuevoPacienteTelFijo2").val() == "") {
			telefono2 = "-";
		} else {
			telefono2 = $("#modalNuevoPacienteTelFijo2").val();
		}
		if ($("#modalNuevoPacienteEmail").val() == "") {
			correo = "-";
		} else {
			correo = $("#modalNuevoPacienteEmail").val();
		}
		$.ajax({
			url: "../php/receptionTurns/guardarPaciente.php",
			type: "post",
			data: {
				dni: $("#modalNuevoPacienteDNI").val(),
				apellido: $("#modalNuevoPacienteApellido").val(),
				nombre: $("#modalNuevoPacienteNombre").val(),
				fechaNacimiento: $("#modalNuevoPacienteFechaNacimiento").val(),
				sexo: $("#modalNuevoPacienteSexo").val(),
				domicilio: $("#modalNuevoPacienteDomicilio").val(),
				provincia: $("#modalNuevoPacienteProvincia").val(),
				localidad: $("#modalNuevoPacienteLocalidad").val(),
				tel1: telefono1,
				tel2: telefono2,
				cel: $("#modalNuevoPacienteCelular").val(),
				email: correo,
				coberturaSocial: $("#modalNuevoPacienteCobrtura").val(),
				nCarnet: n_carnet,
				coseg: coseguro,
				nCoseguro: n_coseguro,
				observacion: $("#modalNuevoPacienteObservacion").val(),
			},
			success: function (data) {
				if (data == "1") {
					$("#modalAgregarDatosPacienteDNISolicitante").val($("#modalNuevoPacienteDNI").val());
					$("#modalAgregarDatosDelPacienteApyNom").val($("#modalNuevoPacienteApellido").val() + ", " + $("#modalNuevoPacienteNombre").val());
					$("#departamentos").val($("#modalNuevoPacienteLocalidad").val());
					$("#modalNuevoPaciente").modal("hide");
					$("#modalAgregarDatos1eraVez").attr("checked", true);
					$("#nuevoTurnoMedicoNombre").focus();
					$("#recepcionPacientes").click();
				}
			},
		});
	}
});

//seleccionar paciente
$(document).on("click", "#filaTablaPacientes", function () {
	pacienteSeleccionadoTabla = $(this).attr("data-id");
	dniUltimoPacienteSeleccionado = $(this).attr("data-dni");
	$(this).addClass("bg-info text-white").siblings().removeClass("bg-info text-white");
	$(this).children().children().click();
	$("#botonEliminarPaciente, #botonEditarPaciente").show();
});

//editar paciente
$(document).on("click", "#botonEditarPaciente", function () {
	editarPaciente(pacienteSeleccionadoTabla);
});

//boton nuevo paciente
$(document).on("click", "#botonNuevoPaciente", function () {
	$("#modalNuevoPacienteDNI").removeAttr("disabled");
	$(
		"#modalNuevoPacienteDNI, #modalNuevoPacienteApellido, #modalNuevoPacienteNombre, #modalNuevoPacienteFechaNacimiento, #modalNuevoPacienteDomicilio, #modalNuevoPacienteCelular"
	)
		.removeClass("is-valid")
		.addClass("is-invalid");
	cargarLocalidades($("#modalNuevoPacienteProvincia").val(), "Paciente");
	setTimeout(function () {
		$("#modalNuevoPacienteLocalidad, #modalNuevoPacienteSexo").val("");
	}, 200);
	$("#modalNuevoPaciente input").each(function () {
		$(this).val("");
	});
	//$("#modalNuevoPacienteEdad, #modalNuevoPacienteTelFijo1, #modalNuevoPacienteTelFijo2").removeClass("is-invalid");
	// $(
	// 	"#modalNuevoPacienteProvincia, #modalNuevoPacienteLocalidad, #modalNuevoPacienteSexo, #modalNuevoPacienteN_carnet, #modalNuevoPacienteCarnetCoseguro"
	// ).removeClass("is-invalid");
	$("#modalNuevoPaciente textarea").val("");
	$("#modalNuevoPaciente").modal("show");
});

//boton nueva cobertura
$(document).on("click", "#botonAgregarCoberturaSocial", function () {
	cargarLocalidades($("#modalAgregarCoberturaSocialProvincia").val(), "Cobertura");
	$("#modalAgregarCoberturaSocial input, #modalAgregarCoberturaSocial textarea").each(function () {
		$(this).val("");
	});
	$("#modalAgregarCoberturaSocial").modal("show");
});

//habilitar campo n° credencial cobertura social
$(document).on("change", "#modalNuevoPacienteCobrtura", function () {
	if ($(this).val() == "434") {
		$("#modalNuevoPacienteN_carnet").attr("disabled", true);
	} else {
		$("#modalNuevoPacienteN_carnet").removeAttr("disabled");
	}
});

//habilitar campo n° credencial coseguro
$(document).on("change", "#modalNuevoPacienteCoseguro", function () {
	if ($(this).val() == "0") {
		$("#modalNuevoPacienteCarnetCoseguro").attr("disabled", true);
	} else {
		$("#modalNuevoPacienteCarnetCoseguro").removeAttr("disabled");
	}
});

//cargar nuevas localidades en pacientes
$(document).on("change", "#modalNuevoPacienteProvincia", function () {
	cargarLocalidades($(this).val(), "Paciente");
});

//buscar localidad
function cargarLocalidades(provincia, destino) {
	$.ajax({
		url: "../php/receptionTurns/buscarLocalidad.php",
		type: "post",
		data: {
			id: provincia,
		},
		success: function (data) {
			if (destino == "Paciente") {
				$("#modalNuevoPacienteLocalidad").html(data);
			} else {
				$("#modalAgregarCoberturaSocialLocalidad").html(data);
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
			$("#modalAgregarCoberturaSocialLocalidad").html(errorMsg);
		},
	});
}

//cargar nuevas localidades en coberturas sociales
$(document).on("change", "#modalEditarCoberturaSocialProvincia", function () {
	cargarLocalidades($(this).val());
});

//eliminar paciente
$(document).on("click", "#modalEliminarPacienteBoton", function () {
	$.ajax({
		url: "../php/receptionTurns/eliminarPaciente.php",
		type: "post",
		data: {
			id: pacienteSeleccionadoTabla,
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				$("#modalEliminarPaciente").modal("hide");
				$("#recepcionPacientes").click();
				ohSnap("Paciente eliminado correctamente", {duration: "2000", color: "green"});
			} else {
				ohSnap("No se pudo eliminar el paciente", {duration: "2000", color: "red"});
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//#endregion
//////////////////////////////////FIN PACIENTES////////////////////////////////////
