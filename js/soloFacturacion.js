////////////////////////////////////VARIABLES GLOBALES////////////////////////////////////
var idPrestacionSeleccionadaGrilla = "";
var idCoberturaSocialSeleccionada = "";
var idConvenioSeleccionado = "";
var posicionPrestaionPMO = "";
var datosConvenio = [];
var datosFormaPago = [];
var descuentoCoseguro = 0.0;
var idFormaPagoSeleccionada = "";
var filaFormaPago = "";
var montoFormaPago = "";
var prestacionSeleccionadaId = "";
var coberturaSocialSeleccionadaId = "";
var flagFormaPago = true;

var idConvenioAVer = "";
var fechaConvenioAVer = "";
var vencimientoConvenioAVer = "";

const msgSinPrestaciones = '<tr><td colspan="5" class="text-center">Se eliminaron todas las prestaciones</td></tr>';
//////////////////////////////////////MASCARAS//////////////////////////////////////

//////////////////////////////////////FIN MASCARAS//////////////////////////////////////

//////////////////////////////////////NOMENCLADOR//////////////////////////////////////
//#region nomenclador
//cargar nomenclador
$(document).on("click", "#facturacionEntradaDatos", function () {
	$.ajax({
		url: "../php/billing/nomenclador.php",
		success: function (data) {
			$("#contenedorCategoriaFacturacion").html(data);
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//nueva prestacion (MODAL)
$(document).on("click", "#botonNuevaPrestacion", function () {
	$("#modalNuevaPrestacion input").each(function () {
		$(this).val("");
	});
	$("#modalNuevaPrestacion").modal("show");
});

//guardar prestacion
$(document).on("click", "#modalNuevaPrestacionBoton", function () {
	if (
		$("#modalNuevaPrestacionDescripcion").val() == "" ||
		$("#modalNuevaPrestacionCodigo").val() == "" ||
		$("#modalNuevaPrestacionComplejidad").val() == "" ||
		$("#modalNuevaPrestacionExpediente").val() == "" ||
		$("#modalNuevaPrestacionUMedico").val() == "" ||
		$("#modalNuevaPrestacionUGastos").val() == "" ||
		$("#modalNuevaPrestacionNivel").val() == ""
	) {
		if ($("#modalNuevaPrestacionDescripcion").val() == "") {
			$("#modalNuevaPrestacionDescripcion").removeClass("borde-input").addClass("borde-input-danger");
			$("#modalNuevaPrestacionBoton").attr("disabled", true);
			setTimeout(() => {
				$("#modalNuevaPrestacionDescripcion").removeClass("borde-input-danger").addClass("borde-input");
				$("#modalNuevaPrestacionBoton").removeAttr("disabled");
			}, 2000);
		}
		if ($("#modalNuevaPrestacionCodigo").val() == "") {
			$("#modalNuevaPrestacionCodigo").removeClass("borde-input").addClass("borde-input-danger");
			$("#modalNuevaPrestacionBoton").attr("disabled", true);
			setTimeout(() => {
				$("#modalNuevaPrestacionCodigo").removeClass("borde-input-danger").addClass("borde-input");
				$("#modalNuevaPrestacionBoton").removeAttr("disabled");
			}, 2000);
		}
		if ($("#modalNuevaPrestacionComplejidad").val() == "") {
			$("#modalNuevaPrestacionComplejidad").removeClass("borde-input").addClass("borde-input-danger");
			$("#modalNuevaPrestacionBoton").attr("disabled", true);
			setTimeout(() => {
				$("#modalNuevaPrestacionComplejidad").removeClass("borde-input-danger").addClass("borde-input");
				$("#modalNuevaPrestacionBoton").removeAttr("disabled");
			}, 2000);
		}
		if ($("#modalNuevaPrestacionNivel").val() == "") {
			$("#modalNuevaPrestacionNivel").removeClass("borde-input").addClass("borde-input-danger");
			$("#modalNuevaPrestacionBoton").attr("disabled", true);
			setTimeout(() => {
				$("#modalNuevaPrestacionNivel").removeClass("borde-input-danger").addClass("borde-input");
				$("#modalNuevaPrestacionBoton").removeAttr("disabled");
			}, 2000);
		}
		if ($("#modalNuevaPrestacionExpediente").val() == "") {
			$("#modalNuevaPrestacionExpediente").removeClass("borde-input").addClass("borde-input-danger");
			$("#modalNuevaPrestacionBoton").attr("disabled", true);
			setTimeout(() => {
				$("#modalNuevaPrestacionExpediente").removeClass("borde-input-danger").addClass("borde-input");
				$("#modalNuevaPrestacionBoton").removeAttr("disabled");
			}, 2000);
		}
		if ($("#modalNuevaPrestacionUMedico").val() == "") {
			$("#modalNuevaPrestacionUMedico").removeClass("borde-input").addClass("borde-input-danger");
			$("#modalNuevaPrestacionBoton").attr("disabled", true);
			setTimeout(() => {
				$("#modalNuevaPrestacionUMedico").removeClass("borde-input-danger").addClass("borde-input");
				$("#modalNuevaPrestacionBoton").removeAttr("disabled");
			}, 2000);
		}
		if ($("#modalNuevaPrestacionUGastos").val() == "") {
			$("#modalNuevaPrestacionUGastos").removeClass("borde-input").addClass("borde-input-danger");
			$("#modalNuevaPrestacionBoton").attr("disabled", true);
			setTimeout(() => {
				$("#modalNuevaPrestacionUGastos").removeClass("borde-input-danger").addClass("borde-input");
				$("#modalNuevaPrestacionBoton").removeAttr("disabled");
			}, 2000);
		}
	} else {
		$.ajax({
			url: "../php/billing/guardarPrestaciones.php",
			type: "post",
			data: {
				codigo: $("#modalNuevaPrestacionCodigo").val(),
				descripcion: $("#modalNuevaPrestacionDescripcion").val(),
				nivel: $("#modalNuevaPrestacionNivel").val(),
				complejidad: $("#modalNuevaPrestacionComplejidad").val(),
				expediente: $("#modalNuevaPrestacionExpediente").val(),
				unMedico: $("#modalNuevaPrestacionUMedico").val(),
				unGastos: $("#modalNuevaPrestacionUGastos").val(),
			},
			success: function (data) {
				console.log(data);
				$("#modalNuevaPrestacion").modal("hide");
				if (data == "1") {
					$(
						"#modalNuevaPrestacionUGastos, #modalNuevaPrestacionUMedico, #modalNuevaPrestacionExpediente, #modalNuevaPrestacionCodigo, #modalNuevaPrestacionDescripcion, #modalNuevaPrestacionNivel, #modalNuevaPrestacionComplejidad"
					).val("");
					$("#facturacionEntradaDatos").click();
					ohSnap("Prestación guardada correctamente", {duration: "3500", color: "green"});
				} else {
					ohSnap("No se pudo guardar la prestación", {duration: "3500", color: "red"});
				}
			},
			error: function () {
				$("#contenedorCategoriaFacturacion").html(errorMsg);
			},
		});
	}
});

//eliminar prstacion (MODAL)
$(document).on("click", "#botonEliminarPrestacion", function () {
	$("#modalEliminarPrestacionConfirmacion").val("0");
	$("#modalEliminarPrestacionBoton").attr("disabled", true);
	$("#modalEliminarPrestacion").modal("show");
});

//validar modal eliminar prestacion
$(document).on("change", "#modalEliminarPrestacionConfirmacion", function () {
	if ($("#modalEliminarPrestacionConfirmacion").val() == "1") {
		$("#modalEliminarPrestacionBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarPrestacionBoton").attr("disabled", true);
	}
});

//eliminar prestacion
$(document).on("click", "#modalEliminarPrestacionBoton", function () {
	$.ajax({
		url: "../php/billing/eliminarPrestacion.php",
		type: "post",
		data: {
			id: idPrestacionSeleccionadaGrilla,
		},
		success: function (data) {
			console.log(data);
			$("#modalEliminarPrestacion").modal("hide");
			if (data == "1") {
				$("#facturacionEntradaDatos").click();
				ohSnap("Prestación eliminada correctamente", {duration: "3500", color: "green"});
			} else {
				ohSnap("No se pudo eliminar la prestación", {duration: "3500", color: "red"});
			}
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//modificar prestacion (MODAL)
$(document).on("click", "#botonEditarPrestacion", function () {
	$.ajax({
		url: "../php/billing/cargarPrestacion.php",
		type: "post",
		data: {
			id: idPrestacionSeleccionadaGrilla,
		},
		success: function (data) {
			console.log(data);
			prestacion = data.split("|");

			$("#modalEditarPrestacionCodigo").val(prestacion[0]);
			$("#modalEditarPrestacionDescripcion").val(prestacion[1]);
			$("#modalEditarPrestacionNivel").val(prestacion[2]);
			$("#modalEditarPrestacionComplejidad").val(prestacion[3]);
			$("#modalEditarPrestacionExpediente").val(prestacion[4]);
			$("#modalEditarPrestacionUMedico").val(prestacion[5]);
			$("#modalEditarPrestacionUGastos").val(prestacion[6]);
			if (prestacion[7] == "1") {
				$("#modalEditarPrestacionEstado").val("1");
			} else {
				$("#modalEditarPrestacionEstado").val("0");
			}
			$("#modalEditarPrestacion").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//funcion modificar prestacion
$(document).on("click", "#modalEditarPrestacionBoton", function () {
	$.ajax({
		url: "../php/billing/editarPrestacion.php",
		type: "post",
		data: {
			id: idPrestacionSeleccionadaGrilla,
			codigo: $("#modalEditarPrestacionCodigo").val(),
			descripcion: $("#modalEditarPrestacionDescripcion").val(),
			nivel: $("#modalEditarPrestacionNivel").val(),
			complejidad: $("#modalEditarPrestacionComplejidad").val(),
			expediente: $("#modalEditarPrestacionExpediente").val(),
			unMedico: $("#modalEditarPrestacionUMedico").val(),
			unGastos: $("#modalEditarPrestacionUGastos").val(),
			estado: $("#modalEditarPrestacionEstado").val(),
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				$("#facturacionEntradaDatos").click();
				$("#modalEditarPrestacion").modal("hide");
				ohSnap("Prestación actualizada correctamente", {duration: "3500", color: "green"});
			} else {
				ohSnap("Problemas al actualizar la prestación", {duration: "3500", color: "red"});
			}
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//ver presentacion
$(document).on("click", "#botonVerPrestacion", function () {
	$.ajax({
		url: "../php/billing/cargarPrestacion.php",
		type: "post",
		data: {
			verPrestacion: "1",
			id: idPrestacionSeleccionadaGrilla,
		},
		success: function (data) {
			console.log(data);
			prestacion = data.split("|");

			$("#modalVerPrestacionCodigo").val(prestacion[0]);
			$("#modalVerPrestacionDescripcion").val(prestacion[1]);
			$("#modalVerPrestacionNivel").val(prestacion[2]);
			$("#modalVerPrestacionComplejidad").val(prestacion[3]);
			$("#modalVerPrestacionExpediente").val(prestacion[4]);
			$("#modalVerPrestacionUMedico").val(prestacion[5]);
			$("#modalVerPrestacionUGastos").val(prestacion[6]);
			if (prestacion[7] == "1") {
				$("#modalVerPrestacionEstado").val("1");
			} else {
				$("#modalVerPrestacionEstado").val("0");
			}
			$("#modalVerPrestacion").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//seleccionar prestacion
$(document).on("click", "#filaPrestacion", function () {
	idConvenioAVer = $(this).attr("data-idConvenio");
	fechaConvenioAVer = $(this).attr("data-fechaConvenio");
	vencimientoConvenioAVer = $(this).attr("data-vencimientoConvenio");
	$(this).addClass("bg-info text-white").siblings().removeClass("bg-info text-white");
	$(this).children().children()[0].click();
});

//funcion seleccionar prestacion
function seleccionarPrestacion(id) {
	idPrestacionSeleccionadaGrilla = id;
	$("#botonEliminarPrestacion, #botonEditarPrestacion, #botonVerPrestacion").show();
}

//#endregion
//////////////////////////////////////FIN NOMENCLADOR//////////////////////////////////////

//////////////////////////////////////MEDICOS//////////////////////////////////////
//#region
//mostrar ABM medicos
$("#facturacionABMMedicos").on("click", function () {
	$.ajax({
		url: "../php/receptionAdministration/ABMMedicos.php",
		success: function (data) {
			$("#contenedorCategoriaFacturacion").html(data);
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});
//#endregion
//////////////////////////////////////FIN MEDICOS//////////////////////////////////////

//////////////////////////////////////TURNOS//////////////////////////////////////
//#region turnos
//asiganr turno
$(document).on("click", "#facturacionAsignarTurno", function () {
	$.ajax({
		url: "../php/receptionTurns/agregarTurno.php",
		success: function (data) {
			$("#modalAgregarDatosPacienteDNISolicitante").focus();
			$("#nuevoTurnoMedicoNombre, #nuevoTurnoMedicoMatricula").removeClass("is-invalid");
			$("#contenedorCategoriaFacturacion").html(data);
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
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});
//#endregion
//////////////////////////////////////FIN TURNOS//////////////////////////////////////

//////////////////////////////////////COBERTURAS//////////////////////////////////////
//#region coberturas
//cargar coberturas
$(document).on("click", "#facturacionCoberturasMedicas", function () {
	$.ajax({
		url: "../php/billing/coberturasMedicas.php",
		success: function (data) {
			$("#contenedorCategoriaFacturacion").html(data);
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//guardr cobertura social
$(document).on("click", "#modalAgregarCoberturaSocialBoton", function () {
	if ($("#modalAgregarCoberturaSocialEstado").prop("checked")) {
		estado = "1";
	} else {
		estado = "0";
	}
	if ($("#modalAgregarCoberturaSocialCoseguro").prop("checked")) {
		coseseg = "1";
	} else {
		coseseg = "0";
	}
	if ($("#modalAgregarCoberturaSocialModulada").prop("checked")) {
		modul = "1";
	} else {
		modul = "0";
	}
	if ($("#modalAgregarCoberturaSocialNoModulada").prop("checked")) {
		noModul = "1";
	} else {
		noModul = "0";
	}
	$.ajax({
		url: "../php/billing/guardarCoberturaSocial.php",
		type: "post",
		data: {
			codigo: $("#modalAgregarCoberturaSocialCodigo").val(),
			coberturaSocial: $("#modalAgregarCoberturaSocialDescripcion").val(),
			plus: $("#modalAgregarCoberturaSocialPlus").val(),
			cupoPorDia: $("#modalAgregarCoberturaSocialCupoPorDia").val(),
			domicilio: $("#modalAgregarCoberturaSocialDomicilio").val(),
			localidad: $("#modalAgregarCoberturaSocialLocalidad").val(),
			codigoPostal: $("#modalAgregarCoberturaSocialCP").val(),
			provincia: $("#modalAgregarCoberturaSocialProvincia").val(),
			telefono: $("#modalAgregarCoberturaSocialTel").val(),
			celular: $("#modalAgregarCoberturaSocialCel").val(),
			email: $("#modalAgregarCoberturaSocialEmail").val(),
			tipo: $("#modalAgregarCoberturaSocialTipo").val(),
			coseguro: coseseg,
			modulada: modul,
			noModulada: noModul,
			categoriaIVA: $("#modalAgregarCoberturaSocialCategoriaIVA").val(),
			cuit: $("#modalAgregarCoberturaSocialCUIT").val(),
			ingresosBrutos: $("#modalAgregarCoberturaSocialIngresosBrutos").val(),
			valCon: $("#modalAgregarCoberturaSocialValCon").val(),
			galQui: $("#modalAgregarCoberturaSocialGalQui").val(),
			galPra: $("#modalAgregarCoberturaSocialGalPra").val(),
			gasPens: $("#modalAgregarCoberturaSocialGasPens").val(),
			gtoQui: $("#modalAgregarCoberturaSocialGtoQui").val(),
			gtoRadi: $("#modalAgregarCoberturaSocialGtoRadi").val(),
			porcentajeGral: $("#modalAgregarCoberturaSocialPorcentajeGral").val(),
			pagaCategoria: $("#modalAgregarCoberturaSocialPagaCategoria").val(),
			aumentoLiq: $("#modalAgregarCoberturaSocialAumentoEnLiq").val(),
			porcentajeHon: $("#modalAgregarCoberturaSocialPorcentajeHonorarios").val(),
			porcentajeGtos: $("#modalAgregarCoberturaSocialPorcentajeGastos").val(),
			porcentajeN1: $("#modalAgregarCoberturaSocialPorcentajeN1").val(),
			porcentajeN2: $("#modalAgregarCoberturaSocialPorcentajeN2").val(),
			porcentajeN3: $("#modalAgregarCoberturaSocialPorcentajeN3").val(),
			modeloGenTXT: $("#modalAgregarCoberturaSocialModeloTXT").val(),
			longOrden: $("#modalAgregarCoberturaSocialLongOrden").val(),
			longNAfiliado: $("#modalAgregarCoberturaSocialLongNafi").val(),
			longBarra: $("#modalAgregarCoberturaSocialLongBarra").val(),
			observaciones: $("#modalAgregarCoberturaSocialObservaciones").val(),
			alertaCirugia: $("#modalAgregarCoberturaSocialAlertaCirugia").val(),
			alertaSecundaria: $("#modalAgregarCoberturaSocialAlertaSecundaria").val(),
			observaciones: $("#modalAgregarCoberturaSocialObservaciones").val(),
			activo: estado,
		},
		success: function (data) {
			console.log(data);
			$("#modalAgregarCoberturaSocial").modal("hide");
			if (data == "1") {
				$("#facturacionCoberturasMedicas").click();
				ohSnap("Cobertura social guardada correctamente", {duration: "3500", color: "green"});
			} else {
				ohSnap("No se pudo guardar la cobertura social", {duration: "3500", color: "red"});
			}
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//seleccionar cobertura
$(document).on("click", "#filaCoberturaSocial", function () {
	$(this).addClass("bg-info text-white").siblings().removeClass("bg-info text-white");
	$(this).children().children()[0].click();
});

//funcion seleccionar cobertura social
function seleccionarCoberturaSocial(id) {
	idCoberturaSocialSeleccionada = id;
	$("#botonEliminarCobertura, #botonEditarCobertura, #botonVerCobertura").show();
}

//ver cobertura social
$(document).on("click", "#botonVerCobertura", function () {
	$.ajax({
		url: "../php/billing/cargarCobertura.php",
		type: "post",
		data: {
			id: idCoberturaSocialSeleccionada,
		},
		success: function (data) {
			console.log(data);
			detalles = data.split("|");
			if (detalles[38] == "1") {
				$("#modalVerCoberturaSocialEstado").attr("checked", true);
			} else {
				$("#modalVerCoberturaSocialEstado").removeAttr("checked", true);
			}
			$("#modalVerCoberturaSocialCodigo").val(detalles[1]);
			$("#modalVerCoberturaSocialDescripcion").val(detalles[2]);
			$("#modalVerCoberturaSocialPlus").val(detalles[3]);
			$("#modalVerCoberturaSocialTipo").val(detalles[4]);
			$("#modalVerCoberturaSocialCoseguro, #modalVerCoberturaSocialModulada, #modalVerCoberturaSocialNoModulada").removeAttr("checked");
			if (detalles[5] == "1") {
				$("#modalVerCoberturaSocialModulada").attr("checked", true);
			} else if (detalles[5] == "0") {
				$("#modalVerCoberturaSocialNoModulada").attr("checked", true);
			} else {
				$("#modalVerCoberturaSocialCoseguro").attr("checked", true);
			}
			$("#modalVerCoberturaSocialTel").val(detalles[6]);
			$("#modalVerCoberturaSocialCel").val(detalles[7]);
			$("#modalVerCoberturaSocialEmail").val(detalles[8]);
			$("#modalVerCoberturaSocialCupoPorDia").val(detalles[9]);
			$("#modalVerCoberturaSocialDomicilio").val(detalles[10]);
			$("#modalVerCoberturaSocialLocalidad").val(detalles[11]);
			$("#modalVerCoberturaSocialCP").val(detalles[12]);
			$("#modalVerCoberturaSocialProvincia").val(detalles[13]);
			$("#modalVerCoberturaSocialObservaciones").val(detalles[14]);
			$("#modalVerCoberturaSocialLongBarra").val(detalles[15]);
			$("#modalVerCoberturaSocialCategoriaIVA").val(detalles[16]);
			$("#modalVerCoberturaSocialCUIT").val(detalles[17]);
			$("#modalVerCoberturaSocialIngresosBrutos").val(detalles[18]);
			$("#modalVerCoberturaSocialValCon").val(detalles[19]);
			$("#modalVerCoberturaSocialGalQui").val(detalles[20]);
			$("#modalVerCoberturaSocialGalPra").val(detalles[21]);
			$("#modalVerCoberturaSocialGasPens").val(detalles[22]);
			$("#modalVerCoberturaSocialGtoQui").val(detalles[23]);
			$("#modalVerCoberturaSocialGtoRadi").val(detalles[24]);
			$("#modalVerCoberturaSocialPagaCategoria").val(detalles[25]);
			$("#modalVerCoberturaSocialAumentoEnLiq").val(detalles[26]);
			$("#modalVerCoberturaSocialPorcentajeGral").val(detalles[27]);
			$("#modalVerCoberturaSocialPorcentajeHonorarios").val(detalles[28]);
			$("#modalVerCoberturaSocialPorcentajeGastos").val(detalles[29]);
			$("#modalVerCoberturaSocialPorcentajeN1").val(detalles[30]);
			$("#modalVerCoberturaSocialPorcentajeN2").val(detalles[31]);
			$("#modalVerCoberturaSocialPorcentajeN3").val(detalles[32]);
			$("#modalVerCoberturaSocialModeloTXT").val(detalles[33]);
			$("#modalVerCoberturaSocialLongOrden").val(detalles[34]);
			$("#modalVerCoberturaSocialLongNafi").val(detalles[35]);
			$("#modalVerCoberturaSocialAlertaCirugia").val(detalles[36]);
			$("#modalVerCoberturaSocialAlertaSecundaria").val(detalles[37]);
			$("#modalVerCoberturaSocial").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//editar datos cobertura social (MODAL)
$(document).on("click", "#botonEditarCobertura", function () {
	$.ajax({
		url: "../php/billing/cargarCobertura.php",
		type: "post",
		data: {
			id: idCoberturaSocialSeleccionada,
		},
		success: function (data) {
			detalles = data.split("|");
			if (detalles[38] == "1") {
				$("#modalEditarCoberturaSocialEstado").attr("checked", true);
			} else {
				$("#modalEditarCoberturaSocialEstado").removeAttr("checked", true);
			}
			//modulada
			//no modulada
			$("#modalEditarCoberturaSocialCodigo").val(detalles[1]);
			$("#modalEditarCoberturaSocialDescripcion").val(detalles[2]);
			$("#modalEditarCoberturaSocialPlus").val(detalles[3]);
			$("#modalEditarCoberturaSocialTipo").val(detalles[4]);
			$("#modalEditarCoberturaSocialCoseguro, #modalEditarCoberturaSocialModulada, #modalEditarCoberturaSocialNoModulada").removeAttr("checked");
			if (detalles[5] == "1") {
				$("#modalEditarCoberturaSocialModulada").attr("checked", true);
			} else if (detalles[5] == "0") {
				$("#modalEditarCoberturaSocialNoModulada").attr("checked", true);
			} else {
				$("#modalEditarCoberturaSocialCoseguro").attr("checked", true);
			}
			$("#modalEditarCoberturaSocialTel").val(detalles[6]);
			$("#modalEditarCoberturaSocialCel").val(detalles[7]);
			$("#modalEditarCoberturaSocialEmail").val(detalles[8]);
			$("#modalEditarCoberturaSocialCupoPorDia").val(detalles[9]);
			$("#modalEditarCoberturaSocialDomicilio").val(detalles[10]);
			$("#modalEditarCoberturaSocialLocalidad").val(detalles[11]);
			$("#modalEditarCoberturaSocialCP").val(detalles[12]);
			$("#modalEditarCoberturaSocialProvincia").val(detalles[13]);
			$("#modalEditarCoberturaSocialObservaciones").val(detalles[14]);
			$("#modalEditarCoberturaSocialLongBarra").val(detalles[15]);
			$("#modalEditarCoberturaSocialCategoriaIVA").val(detalles[16]);
			$("#modalEditarCoberturaSocialCUIT").val(detalles[17]);
			$("#modalEditarCoberturaSocialIngresosBrutos").val(detalles[18]);
			$("#modalEditarCoberturaSocialValCon").val(detalles[19]);
			$("#modalEditarCoberturaSocialGalQui").val(detalles[20]);
			$("#modalEditarCoberturaSocialGalPra").val(detalles[21]);
			$("#modalEditarCoberturaSocialGasPens").val(detalles[22]);
			$("#modalEditarCoberturaSocialGtoQui").val(detalles[23]);
			$("#modalEditarCoberturaSocialGtoRadi").val(detalles[24]);
			$("#modalEditarCoberturaSocialPagaCategoria").val(detalles[25]);
			$("#modalEditarCoberturaSocialAumentoEnLiq").val(detalles[26]);
			$("#modalEditarCoberturaSocialPorcentajeGral").val(detalles[27]);
			$("#modalEditarCoberturaSocialPorcentajeHonorarios").val(detalles[28]);
			$("#modalEditarCoberturaSocialPorcentajeGastos").val(detalles[29]);
			$("#modalEditarCoberturaSocialPorcentajeN1").val(detalles[30]);
			$("#modalEditarCoberturaSocialPorcentajeN2").val(detalles[31]);
			$("#modalEditarCoberturaSocialPorcentajeN3").val(detalles[32]);
			$("#modalEditarCoberturaSocialModeloTXT").val(detalles[33]);
			$("#modalEditarCoberturaSocialLongOrden").val(detalles[34]);
			$("#modalEditarCoberturaSocialLongNafi").val(detalles[35]);
			$("#modalEditarCoberturaSocialAlertaCirugia").val(detalles[36]);
			$("#modalEditarCoberturaSocialAlertaSecundaria").val(detalles[37]);
			$("#modalEditarCoberturaSocial").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//actualizar cobertura
$(document).on("click", "#modalEditarCoberturaSocialBoton", function () {
	if ($("#modalEditarCoberturaSocialEstado").prop("checked") == false) {
		estado = "0";
	} else {
		estado = "1";
	}
	if ($("#modalEditarCoberturaSocialModulada").prop("checked")) {
		modul = "1";
	} else {
		modul = "0";
	}
	$.ajax({
		url: "../php/billing/actualizarCobertura.php",
		type: "post",
		data: {
			id: idCoberturaSocialSeleccionada,
			codigo: $("#modalEditarCoberturaSocialCodigo").val(),
			coberturaSocial: $("#modalEditarCoberturaSocialDescripcion").val(),
			plus: $("#modalEditarCoberturaSocialPlus").val(),
			cupoPorDia: $("#modalEditarCoberturaSocialCupoPorDia").val(),
			domicilio: $("#modalEditarCoberturaSocialDomicilio").val(),
			localidad: $("#modalEditarCoberturaSocialLocalidad").val(),
			codigoPostal: $("#modalEditarCoberturaSocialCP").val(),
			provincia: $("#modalEditarCoberturaSocialProvincia").val(),
			telefono: $("#modalEditarCoberturaSocialTel").val(),
			celular: $("#modalEditarCoberturaSocialCel").val(),
			email: $("#modalEditarCoberturaSocialEmail").val(),
			tipo: $("#modalEditarCoberturaSocialTipo").val(),
			modulada: modul,
			categoriaIVA: $("#modalEditarCoberturaSocialCategoriaIVA").val(),
			cuit: $("#modalEditarCoberturaSocialCUIT").val(),
			ingresosBrutos: $("#modalEditarCoberturaSocialIngresosBrutos").val(),
			valCon: $("#modalEditarCoberturaSocialValCon").val(),
			galQui: $("#modalEditarCoberturaSocialGalQui").val(),
			galPra: $("#modalEditarCoberturaSocialGalPra").val(),
			gasPens: $("#modalEditarCoberturaSocialGasPens").val(),
			gtoQui: $("#modalEditarCoberturaSocialGtoQui").val(),
			gtoRadi: $("#modalEditarCoberturaSocialGtoRadi").val(),
			porcentajeGral: $("#modalEditarCoberturaSocialPorcentajeGral").val(),
			pagaCategoria: $("#modalEditarCoberturaSocialPagaCategoria").val(),
			aumentoLiq: $("#modalEditarCoberturaSocialAumentoEnLiq").val(),
			porcentajeHon: $("#modalEditarCoberturaSocialPorcentajeHonorarios").val(),
			porcentajeGtos: $("#modalEditarCoberturaSocialPorcentajeGastos").val(),
			porcentajeN1: $("#modalEditarCoberturaSocialPorcentajeN1").val(),
			porcentajeN2: $("#modalEditarCoberturaSocialPorcentajeN2").val(),
			porcentajeN3: $("#modalEditarCoberturaSocialPorcentajeN3").val(),
			modeloGenTXT: $("#modalEditarCoberturaSocialModeloTXT").val(),
			longOrden: $("#modalEditarCoberturaSocialLongOrden").val(),
			longNAfiliado: $("#modalEditarCoberturaSocialLongNafi").val(),
			longBarra: $("#modalEditarCoberturaSocialLongBarra").val(),
			alertaCirugia: $("#modalEditarCoberturaSocialAlertaCirugia").val(),
			alertaSecundaria: $("#modalEditarCoberturaSocialAlertaSecundaria").val(),
			observaciones: $("#modalEditarCoberturaSocialObservaciones").val(),
			activo: estado,
		},
		success: function (data) {
			console.log(data);
			$("#modalEditarCoberturaSocial").modal("hide");
			if (data == "1") {
				$("#facturacionCoberturasMedicas").click();
				ohSnap("Cobertura social actualizada correctamente", {duration: "3500", color: "green"});
			} else {
				ohSnap("No se pudo actualizar la cobertura social", {duration: "3500", color: "red"});
			}
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//eliminar cobertura (MODAL)
$(document).on("click", "#botonEliminarCobertura", function () {
	$("#modalEliminarCoberturaSocialConfirmacion").val("0");
	$("#modalEliminarCoberturaSocialBoton").attr("disabled", true);
	$("#modalEliminarCoberturaSocial").modal("show");
});

//validar modal eliminar cobertura
$(document).on("change", "#modalEliminarCoberturaSocialConfirmacion", function () {
	if ($("#modalEliminarCoberturaSocialConfirmacion").val() == "1") {
		$("#modalEliminarCoberturaSocialBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarCoberturaSocialBoton").attr("disabled", true);
	}
});

//eliminar cobertura
$(document).on("click", "#modalEliminarCoberturaSocialBoton", function () {
	$.ajax({
		url: "../php/billing/eliminarCobertura.php",
		type: "post",
		data: {
			id: idCoberturaSocialSeleccionada,
		},
		success: function (data) {
			console.log(data);
			$("#modalEliminarCoberturaSocial").modal("hide");
			if (data == "1") {
				$("#facturacionCoberturasMedicas").click();
				ohSnap("Cobertura social eliminada correctamente", {duration: "3500", color: "green"});
			} else {
				ohSnap("No se pudo eliminar la cobertura social", {duration: "3500", color: "red"});
			}
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//mostrar ocultar tipos de cobertura social
$(document).on("change", "#modalAgregarCoberturaSocialTipo", function () {
	if ($(this).val() == "1") {
		$("#modalAgregarCoberturaSocialTipoCobertura").show();
	} else {
		$("#modalAgregarCoberturaSocialTipoCobertura").hide();
	}
});

//#endregion
//////////////////////////////////////FIN COBERTURAS//////////////////////////////////////

//////////////////////////////////////CONVENIOS//////////////////////////////////////
//#region convenios
//cargar convenios creados
$(document).on("click", "#facturacionConvenios", function () {
	$.ajax({
		url: "../php/billing/convenios.php",
		success: function (data) {
			$("#contenedorCategoriaFacturacion").html(data);
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//seleccionar convenio
$(document).on("change", "#modalNuevoConvenioCobertura", function () {
	const valor = $("#modalNuevoConvenioCobertura").val();
	datosConvenioSeleccionado(valor);
});

//cargar datos del convenio
function datosConvenioSeleccionado(valor) {
	$.ajax({
		url: "../php/billing/cargarConvenios.php",
		type: "post",
		data: {
			id: valor,
		},
		success: function (data) {
			$("#modalNuevoConvenioDetalles").html(data);
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
}

//opciones del convenio
function opcionesConvenio(id) {
	$("#botonEliminarConvenio, #botonVerConvenio").show();
	idConvenioSeleccionado = id;
}

//crear convenio
$(document).on("click", "#modalNuevoConvenioBoton", function () {
	var prestaciones = [];
	var codigos = [];
	var precios = [];
	$(".modalNuevoConvenioCodigoCoberturaSocial").each(function () {
		codigos.push($(this).val());
	});

	$(".modalNuevoConvenioPrecioPrestacion").each(function () {
		prestaciones.push($(this).attr("data-id"));
		precios.push($(this).val());
	});
	datosConvenio = [
		$("#modalNuevoConvenioCobertura").val(),
		$("#modalNuevoConvenioFecha").val(),
		$("#modalNuevoConvenioVencimiento").val(),
		prestaciones,
		codigos,
		precios,
	];
	$.ajax({
		url: "../php/billing/modificarConvenio.php",
		type: "post",
		data: {
			convenio: datosConvenio,
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				datosConvenio = "";
				$("#facturacionConvenios").click();
				$("#modalNuevoConvenio").modal("hide");
				ohSnap("Convenio actualizado", {duration: "3500", color: "green"});
			} else {
				ohSnap("No se pudo actualizar el convenio", {duration: "3500", color: "red"});
			}
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//nuevo convenio
$(document).on("click", "#botonNuevoConvenio", function () {
	fecha = new Date();
	mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
	dia = ("0" + fecha.getDate()).slice(-2);
	hoy = fecha.getFullYear() + "-" + mes + "-" + dia;
	$("#modalNuevoConvenioFecha").val(hoy);
});

//ver detalles convenio
$(document).on("click", "#botonVerConvenio", function () {
	$("#botonNuevoConvenio").click();
	setTimeout(function () {
		$("#modalNuevoConvenioFecha").val(fechaConvenioAVer);
		$("#modalNuevoConvenioVencimiento").val(vencimientoConvenioAVer);
		$("#modalNuevoConvenioCobertura").val(idConvenioAVer);
		datosConvenioSeleccionado(idConvenioAVer);
	}, 250);
});

//eliminar convenio (MODAL)
$(document).on("click", "#botonEliminarConvenio", function () {
	$("#modalEliminarConvenioConfirmacion").val("0");
	$("#modalEliminarConvenioBoton").attr("disabled", true);
	$("#modalEliminarConvenio").modal("show");
});

//validar seleccion del usuario para desvincular cobertura
$(document).on("change", "#modalEliminarConvenioConfirmacion", function () {
	if ($("#modalEliminarConvenioConfirmacion").val() == "1") {
		$("#modalEliminarConvenioBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarConvenioBoton").attr("disabled", true);
	}
});

//funcion eliminar convenio
$(document).on("click", "#modalEliminarConvenioBoton", function () {
	$.ajax({
		url: "../php/billing/eliminarConvenio.php",
		type: "post",
		data: {
			id: idConvenioSeleccionado,
		},
		success: function (data) {
			if (data == "1") {
				$("#facturacionConvenios").click();
				$("#modalEliminarConvenio").modal("hide");
				ohSnap("Convenio eliminado correctamente", {duration: "3500", color: "green"});
			} else {
				ohSnap("No se pudo eliminar el convenio", {duration: "3500", color: "red"});
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//#endregion
//////////////////////////////////////FIN CONVENIOS//////////////////////////////////////

//////////////////////////////////////COBRAR TURNO//////////////////////////////////////
//#region cobros
//agregar prestacion al cobro
$(document).on("click", "#modalConsultaCodigosAceptar", function () {
	$("#agregarFormaDePago").show();
	$(this).attr("disabled", true);
	var datosPrestacion = [
		$("#modalConsultaCodigosCodigo").val(),
		$("#modalConsultaCodigosDescripcion").val(),
		$("#modalConsultacodigosCantidad").val(),
		$("#modalConsultaCodigosValorUnitario").val(),
		parseFloat($("#modalConsultaCodigosTotal").val()).toFixed(2),
		$("#modalCobrarTurnoCodigoCoberturaSocial").val(),
		prestacionSeleccionadaId,
		coberturaSocialSeleccionadaId,
	];
	$.ajax({
		url: "../php/billing/agregarPrestacionTablaPMO.php",
		type: "post",
		data: {
			datos: datosPrestacion,
			coseguro: $("#modalCobrarTurnoCodigoCoseguro").val(),
		},
		success: function (data) {
			respuesta = data.split("|");
			$("#contenido-tabla-pmo").html(respuesta[0]);
			$("#modalCobrarTurnoTotalACobrar").html(respuesta[1]);
			$("#modalConsultaCodigos").modal("hide");
			if ($("#modalCobrarTurnoTotalACobrar").text() == "0,00") {
				$("#modalCobrarTurnoBoton").removeAttr("disabled");
			}
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//completar inputs con datos de prestacion
$(document).on("click", "#filaDatosPrestacion", function () {
	var total = 0;
	prestacionSeleccionadaId = $(this).attr("data-id");
	coberturaSocialSeleccionadaId = $("#modalCobrarTurnoCoberturaSocial").val();
	prestacionSeleccionadaDescripcion = $(this).attr("data-descripcion");
	prestacionSeleccionadaCodigo = $(this).attr("data-codigo");
	prestacionSeleccionadaPrecio = parseFloat($(this).attr("data-precio"));
	prestacionSeleccionadaPlus = parseFloat($("#modalConsultaCodigosPlus").val());
	prestacionSeleccionadaDescuento = parseFloat($("#modalConsultaCodigosDescuento").val());
	prestacionSeleccionadaCantidad = parseFloat($("#modalConsultacodigosCantidad").val());
	$(this).addClass("bg-info text-white").siblings().removeClass("bg-info text-white");
	$("#modalConsultaCodigosDescripcion").val(prestacionSeleccionadaDescripcion);
	$("#modalConsultaCodigosCodigo").val(prestacionSeleccionadaCodigo);
	$("#modalConsultaCodigosValorUnitario").val(prestacionSeleccionadaPrecio);
	total = prestacionSeleccionadaCantidad * prestacionSeleccionadaPrecio + prestacionSeleccionadaPlus - prestacionSeleccionadaDescuento;
	$("#modalConsultaCodigosTotal").val(total.toFixed(2));
	honorarios1 = prestacionSeleccionadaPrecio * prestacionSeleccionadaCantidad;
	$("#modalConsultaCodigosHonorarios1").val(honorarios1.toFixed(2));
	$("#modalConsultaCodigosAceptar").removeAttr("disabled");
});

//calcular total por cantidad
$(document).on("keyup", "#modalConsultacodigosCantidad", function () {
	const precio = parseFloat($("#modalConsultaCodigosValorUnitario").val());
	const cantidad = parseFloat($("#modalConsultacodigosCantidad").val());
	const plus = parseFloat($("#modalConsultaCodigosPlus").val());
	const descuento = parseFloat($("#modalConsultaCodigosDescuento").val());
	total = cantidad * precio + plus - descuento;
	$("#modalConsultaCodigosTotal").val(total.toFixed(2));
});

//calcular total por plus
$(document).on("keyup", "#modalConsultaCodigosPlus", function () {
	const precio = parseFloat($("#modalConsultaCodigosValorUnitario").val());
	const cantidad = parseFloat($("#modalConsultacodigosCantidad").val());
	const plus = parseFloat($("#modalConsultaCodigosPlus").val());
	const descuento = parseFloat($("#modalConsultaCodigosDescuento").val());
	total = cantidad * precio + plus - descuento;
	$("#modalConsultaCodigosTotal").val(total.toFixed(2));
});

//calcular total por descuento
$(document).on("keyup", "#modalConsultaCodigosDescuento", function () {
	const precio = parseFloat($("#modalConsultaCodigosValorUnitario").val());
	const cantidad = parseFloat($("#modalConsultacodigosCantidad").val());
	const plus = parseFloat($("#modalConsultaCodigosPlus").val());
	const descuento = parseFloat($("#modalConsultaCodigosDescuento").val());
	total = cantidad * precio + plus - descuento;
	$("#modalConsultaCodigosTotal").val(total.toFixed(2));
});

//cerrar modal consulta codigos
$(document).on("click", "#modalConsultaCodigosCancelar", function () {
	$("#modalConsultaCodigos").modal("hide");
});

//opcion cobrar turnos (MODAL)
$(document).on("click", "#opcionCobrarTurno", function () {
	setTimeout(() => {
		var fhoy = $("#modalCobrarTurnoFechaActual").val();
		var respH = fhoy.split("-");
		var fechaDeHoy = new Date(respH[0], respH[1], respH[2]);

		var fTurno = $("#modalCobrarTurnoFechaTurno").val();
		var respT = fTurno.split("-");
		var fechaDeTurno = new Date(respT[2], respT[1], respT[0]);

		if (fechaDeTurno <= fechaDeHoy) {
			$("#modalCobrarTurnoBoton").show();
		} else {
			$("#modalCobrarTurnoBoton").hide();
			ohSnap("No se puede cobrar turnos futuros.", {
				duration: "3500",
				color: "red",
			});
		}
	}, 400);

	$("#listaTurnosReservados").hide();
	if ($("#modalCobrarTurnoControl").prop("checked")) {
		$("#modalCobrarTurnoControl").click();
	}
	$(
		"#modalCobrarTurnoNCarnet, #modalCobrarTurnoNOden, #modalCobrarTurnoAutorizacion, #modalCobrarTurnoAmb, #modalCobrarTurnoFiltrarCoberturas, #modalCobrarTurnoObservaciones"
	).val("");
	if ($("#modalCobrarTurnoCodigoCoseguro").val() == "") {
		$("#modalCobrarTurnoCoseguro").val("");
	} else {
		$("#modalCobrarTurnoCoseguro").val($("#modalCobrarTurnoCodigoCoseguro").val());
	}
	if ($(this).hasClass("fa-undo")) {
		$.ajax({
			url: "../php/billing/obtenerDatosCobro.php",
			type: "post",
			data: {
				id: idPagoTurno,
			},
			success: function (data) {
				console.log(data);
				datos = data.split("|");
				$("#modalCobrarTurnoNumCobro").val(datos[0]);
				$("#modalCobrarTurnoNTurno").val(datos[1]);
				$("#modalCobrarTurnoFechaTurno").val(datos[2]);
				$("#modalCobrarTurnoFechaTurnoMedico").val(datos[3]);
				$("#modalCobrarTurnoNPaciente").val(datos[4]);
				$("#modalCobrarTurnoFechaActual").attr("disabled", true).val(datos[5]);
				if (datos[6] == "1") {
					$("#modalCobrarTurnoControl").attr("checked", true);
				} else {
					$("#modalCobrarTurnoControl").removeAttr("checked");
				}
				$("#modalCobrarTurnoCodigoCoberturaSocial").attr("disabled", true).val(datos[7]);
				$("#modalCobrarTurnoCoberturaSocial").val(datos[7]);
				$("#modalCobrarTurnoCodigoCoseguro").attr("disabled", true).val(datos[8]);
				$("#modalCobrarTurnoCoseguro").val(datos[8]);

				$("#contenido-tabla-pmo").html(datos[9]);
				if (datos[10] == "1") {
					$("#modalCobrarTurnoTraeOrden").attr("disabled", true).attr("checked", true);
				} else {
					$("#modalCobrarTurnoTraeOrden").attr("disabled", true).removeAttr("checked");
				}
				$("#modalCobrarTurnoNCarnet").attr("disabled", true).val(datos[11]);
				$("#modalCobrarTurnoNOden").attr("disabled", true).val(datos[12]);
				$("#modalCobrarTurnoAutorizacion").attr("disabled", true).val(datos[13]);
				$("#modalCobrarTurnoAmb").attr("disabled", true).val(datos[14]);
				$("#contenidoTablaFormasDePago").html(datos[15]);
				$("#modalCobrarTurnoObservaciones").attr("disabled", true).val(datos[16]);

				$("#modalCobrarTurnoBoton")
					.removeAttr("disabled")
					.removeClass("btn-success")
					.addClass("btn-danger")
					.text("Anular")
					.attr("data-modo", "anular");
				$("#consultaCodigos, #modalcobrarTurnoCancelar").hide();
				$("#modalCobrarTurnoControl, #modalCobrarTurnoFiltrarCoberturas, #modalCobrarTurnoCoberturaSocial, #modalCobrarTurnoCoseguro").attr(
					"disabled",
					true
				);
			},
			error: function () {
				$("#contenedorCategoriaFacturacion").html(errorMsg);
			},
		});
	} else {
		$(
			"#modalCobrarTurnoFechaActual, #modalCobrarTurnoObservaciones, #modalCobrarTurnoAutorizacion, #modalCobrarTurnoAmb, #modalCobrarTurnoNOden, #modalCobrarTurnoTraeOrden, #modalCobrarTurnoCoberturaSocial, #modalCobrarTurnoFiltrarCoberturas, #modalCobrarTurnoCodigoCoberturaSocial, #modalCobrarTurnoControl"
		).removeAttr("disabled");
		$("#modalCobrarTurnoBoton").attr("disabled", true).removeClass("btn-danger").addClass("btn-success").text("Cobrar");
		$("#consultaCodigos, #modalcobrarTurnoCancelar").show();

		$("#modalCobrarTurnoTotalACobrar").text("0.00");
		$("#modalCobrarTurnoCodigoCoseguro").val("");
		fecha = new Date();
		mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
		dia = ("0" + fecha.getDate()).slice(-2);
		hoy = fecha.getFullYear() + "-" + mes + "-" + dia;
		if (tipoTurnoSeleccionadoGrilla == "3") {
			$("#modalCobrarTurnoAnestesista").removeAttr("disabled");
		} else {
			$("#modalCobrarTurnoAnestesista").attr("disabled", true);
		}

		if (tipoCoberturaSeleccionadaGrilla == "1") {
			$("#modalCobrarTurnoCodigoCoseguro, #modalCobrarTurnoCoseguro").removeAttr("disabled");
			$("#modalCobrarTurnoCoseguro option").each(function () {
				if ($(this).val() == "0") {
					$(this).remove();
				}
			});
			coseg = coseguroSeleccionadaGrilla;
		} else {
			$("#modalCobrarTurnoCoseguro").append('<option value="0" selected></option>');
			$("#modalCobrarTurnoCodigoCoseguro, #modalCobrarTurnoCoseguro").attr("disabled", true);
			$("#modalCobrarTurnoCodigoCoseguro").val("");
			coseg = "";
		}
		$("#modalCobrarTurnoFechaActual").val(hoy);
		$("#modalCobrarTurnoNTurno").val(turnoSeleccionadoGrilla);
		$("#modalCobrarTurnoFechaTurno").val(fechaSeleccionadaGrilla);
		$("#modalCobrarTurnoFechaTurnoMedico").val(medicoSeleccionadaGrilla);
		$("#modalCobrarTurnoNPaciente").val(nombrePacienteSeleccionadaGrilla);
		$("#modalCobrarTurnoCodigoCoberturaSocial").val(coberturaSeleccionadaGrilla);
		$("#modalCobrarTurnoCoberturaSocial").val(coberturaSeleccionadaGrilla);
		if ($("#modalCobrarTurnoCoseguro").val() == "") {
			$("#modalCobrarTurnoCodigoCoseguro").val("");
		} else {
			$("#modalCobrarTurnoCodigoCoseguro").val(coseg);
			$("#modalCobrarTurnoCoseguro").val(coseg);
		}
		$("#modalCobrarTurnoNCarnet").val(numeroCarnetSeleccionadoGrilla);

		//modalCobrarTurnoCoseguro

		$("#modalCobrarTurnoCoberturaSeleccionada").html($("#modalCobrarTurnoCoberturaSocial option:selected").text());
	}
});

//control activo
$(document).on("click", "#modalCobrarTurnoControl", function () {
	if ($(this).prop("checked")) {
		$(
			"#modalCobrarTurnoFechaActual, #modalCobrarTurnoCodigoCoberturaSocial, #modalCobrarTurnoCodigoCoseguro, #modalCobrarTurnoFiltrarCoberturas, #modalCobrarTurnoTraeOrden, #modalCobrarTurnoNOden, #modalCobrarTurnoNCarnet, #modalCobrarTurnoAmb, #modalCobrarTurnoObservaciones, #modalCobrarTurnoAutorizacion"
		).attr("disabled", true);
		$("#formularioCobrarTurno select").each(function () {
			$(this).attr("disabled", true);
		});
		$("#consultaCodigos").hide();
		$("#modalCobrarTurnoBoton").removeAttr("disabled");
	} else {
		$("#formularioCobrarTurno select").each(function () {
			$(this).removeAttr("disabled", true);
		});

		$(
			"#modalCobrarTurnoFechaActual, #modalCobrarTurnoCodigoCoberturaSocial, #modalCobrarTurnoCodigoCoseguro, #modalCobrarTurnoFiltrarCoberturas, #modalCobrarTurnoTraeOrden, #modalCobrarTurnoNOden, #modalCobrarTurnoNCarnet, #modalCobrarTurnoAmb, #modalCobrarTurnoObservaciones, #modalCobrarTurnoAutorizacion"
		).removeAttr("disabled");
		$("#modalCobrarTurnoBoton").attr("disabled", true);
		$("#consultaCodigos").show();
	}
	//$("#modalCobrarTurnoControl").removeAttr("disabled");
});

//seleccionar prestacion PMO
$(document).on("click", "#filaPrestacionPMO", function () {
	$(this).addClass("bg-info text-white").siblings().removeClass("bg-info text-white");
	posicionPrestaionPMO = $(this).attr("data-id");
	$("#eliminarCodigo").show();
});

//eliminar posicion
$(document).on("click", "#eliminarCodigo", function () {
	$.ajax({
		url: "../php/billing/eliminarCodigo.php",
		type: "post",
		data: {
			id: posicionPrestaionPMO,
			idCobertura: $("#modalCobrarTurnoCodigoCoberturaSocial").val(),
			coseguro: $("#modalCobrarTurnoCodigoCoseguro").val(),
		},
		success: function (data) {
			console.log(data);
			respuesta = data.split("|");
			$("#contenido-tabla-pmo").html(respuesta[0]);
			$("#modalCobrarTurnoTotalACobrar").html(respuesta[1]);
			$("#eliminarCodigo").hide();
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//ajustar precio a cambio de coseguro
$(document).on(
	"change",
	"#modalCobrarTurnoCodigoCoberturaSocial, #modalCobrarTurnoCoberturaSocial, #modalCobrarTurnoCodigoCoseguro, #modalCobrarTurnoCoseguro",
	function () {
		setTimeout(() => {
			$.ajax({
				url: "../php/billing/ajustarTotal.php",
				type: "post",
				data: {
					cobertura: $("#modalCobrarTurnoCodigoCoberturaSocial").val(),
					coseguro: $("#modalCobrarTurnoCodigoCoseguro").val(),
				},
				success: function (data) {
					$("#modalCobrarTurnoTotalACobrar").text(data);
				},
				error: function () {
					$("#contenedorCategoriaFacturacion").html(errorMsg);
				},
			});
		}, 250);
	}
);

//validar valor ingresado contra saldo
$(document).on("keyup", "#modalAgregarFormaDePagoSaldoParcial", function () {
	valorIngresado = parseFloat($("#modalAgregarFormaDePagoSaldoParcial").val()).toFixed(2);
	saldoRestante = parseFloat($("#modalAgregarFormaDePagoSaldoRestante").text()).toFixed(2);
	if (valorIngresado > saldoRestante || valorIngresado < 0) {
		$("#modalAgregarFormaDePagoSaldoParcial").addClass("is-invalid");
		$("#modalAgregarFormaDePagoConfirmar").attr("disabled", true);
	} else {
		$("#modalAgregarFormaDePagoSaldoParcial").removeClass("is-invalid");
		$("#modalAgregarFormaDePagoConfirmar").removeAttr("disabled");
	}
});

//agrgar forma de pago
$(document).on("click", "#agregarFormaDePago", function () {
	$.ajax({
		url: "../php/billing/sesionesPrestaciones.php",
		success: function (data) {
			fecha = new Date();
			mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
			dia = ("0" + fecha.getDate()).slice(-2);
			hoy = fecha.getFullYear() + "-" + mes + "-" + dia;
			$("#modalAgregarFormaDePagoFechaActual").val(hoy);
			$("#modalAgregarFormaDePagoSaldoParcial").val(data);
			$("#modalAgregarFormaDePagoSaldoRestante").text(separadorDeMiles(data));
			$("#modalAgregarFormaDePagoFormaPago").val("1");
			$("#modalAgregarFormaDePago").modal("show");
		},
	});
});

//agregar pago fraccionado
$(document).on("click", "#modalAgregarFormaDePagoConfirmar", function () {
	$("#modalAgregarFormaDePagoConfirmar").attr("disabled", true);
	var datosFormaPago = [
		$("#modalAgregarFormaDePagoFormaPago").val(),
		$("#modalAgregarFormaDePagoBanco").val(),
		$("#modalAgregarFormaDePagoLocalidad").val(),
		$("#modalAgregarFormaDePagoNCuenta").val(),
		$("#modalAgregarFormaDePagoCheque").val(),
		$("#modalAgregarFormaDePagoFechaActual").val(),
		$("#modalAgregarFormaDePagoFechaVencimiento").val(),
		$("#modalAgregarFormaDePagoSaldoParcial").val().replace(",", ""),
	];
	$.ajax({
		url: "../php/billing/procesarPagoFraccionado.php",
		type: "post",
		data: {
			datos: datosFormaPago,
		},
		success: function (data) {
			info = data.split("|");
			$("#modalAgregarFormaDePagoSaldoRestante").text(parseFloat(info[0]).toFixed(2));
			$("#contenidoTablaFormasDePago").html(info[1]);
			$("#modalAgregarFormaDePago").modal("hide");
			controlarCobroTurno($("#modalCobrarTurnoTotalACobrar").text());
			$("#modalAgregarFormaDePagoConfirmar").removeAttr("disabled");
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//controlar turno
function controlarCobroTurno(str) {
	$.ajax({
		url: "../php/billing/controlarCobro.php",
		type: "post",
		data: {
			saldo: str,
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				$("#modalCobrarTurnoBoton").removeAttr("disabled");
				$("#agregarFormaDePago").hide();
			}
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
}

//seleccionar pago fraccionado
$(document).on("click", "#filaFormaPago", function () {
	$(this).addClass("bg-info text-white").siblings().removeClass("bg-info text-white");
	filaFormaPago = $(this).attr("data-id");
	montoFormaPago = $(this).attr("data-monto");
	$("#eliminarFormaDePago").show();
});

//eliminar fila opcion de pago
$(document).on("click", "#eliminarFormaDePago", function () {
	$.ajax({
		url: "../php/billing/eliminarFilaPago.php",
		type: "post",
		data: {
			id: filaFormaPago,
			monto: montoFormaPago,
		},
		success: function (data) {
			console.log(data);
			respuesta = data.split("|");
			if (respuesta[0] == "0") {
				$("#eliminarFormaDePago").hide();
				$("#agregarFormaDePago").show();
				$("#modalCobrarTurnoBoton").attr("disabled", true);
			}
			$("#contenidoTablaFormasDePago").html(respuesta[1]);
			$("#eliminarFormaDePago").hide();
		},
		error: function () {
			$("#contenedorCategoriaFacturacion").html(errorMsg);
		},
	});
});

//opcion consulta codigos
$(document).on("click", "#consultaCodigos", function () {
	fecha = new Date();
	mes = fecha.getMonth() + 1;
	$("#modalConsultaCodigosMes").val(mes);
	$("#modalConsultaCodigosValorUnitario").val("");
	$("#modalConsultacodigosCantidad").val("1");
	$("#modalConsultaCodigosPlus").val("0");
	$("#modalConsultaCodigosDescuento").val("0");
	$("#modalConsultaCodigos").modal("show");
	$.ajax({
		url: "../php/receptionTurns/cargarCoberturasConvenio.php",
		type: "post",
		data: {
			id: $("#modalCobrarTurnoCodigoCoberturaSocial").val(),
			nivel: tipoTurnoFilaTurno,
		},
		success: function (data) {
			$("#modalConsultaCodigosTabla").html(data);
		},
		error: function () {
			$("#contenedorCategoriaRecepcion").html(errorMsg);
		},
	});
});

//cobrar turnos
$(document).on("click", "#modalCobrarTurnoBoton", function () {
	if ($(this).attr("data-modo") == "anular") {
		console.log("anular");
		$.ajax({
			url: "../php/receptionTurns/anularCobro.php",
			type: "post",
			data: {
				idPago: idPagoTurno,
				idTurno: $("#modalCobrarTurnoNTurno").val(),
			},
			success: function (data) {
				console.log(data);
				if (data == "1") {
					$("#actualizarGrilla").click();
				} else {
					$("#contenedorCategoriaRecepcion").html(errorMsg);
				}
				$("#modalCobrarTurnoBoton").removeAttr("data-modo");
				$("#opcionCobrarTurno").click();
				$("#formularioCobrarTurno").hide();
				$("#listaTurnosReservados").show();
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	} else {
		$("#modalCobrarTurnoObservaciones").val("");
		if ($("#modalCobrarTurnoControl").prop("checked")) {
			valorControl = "1";
		} else {
			valorControl = "0";
		}
		if ($("#modalCobrarTurnoTraeOrden").prop("checked")) {
			valorOrden = "1";
		} else {
			valorOrden = "0";
		}
		$.ajax({
			url: "../php/receptionTurns/cobrarTurno.php",
			type: "post",
			data: {
				id: turnoSeleccionadoGrilla,
				fechaTurno: $("#modalCobrarTurnoFechaTurno").val(),
				fechaCobro: $("#modalCobrarTurnoFechaActual").val(),
				idMedico: $("#selectTurnosPorDoctor").val(),
				idPaciente: idPacienteSeleccionadoGrilla,
				controlTurno: valorControl,
				cobertura: $("#modalCobrarTurnoCodigoCoberturaSocial").val(),
				coseguro: $("#modalCobrarTurnoCodigoCoseguro").val(),
				n_carnet: $("#modalCobrarTurnoNCarnet").val(),
				orden: valorOrden,
				amb: $("#modalCobrarTurnoAmb").val(),
				n_orden: $("#modalCobrarTurnoNOden").val(),
				id_autorizacion: $("#modalCobrarTurnoAutorizacion").val(),
				observacion: $("#modalCobrarTurnoObservaciones").val(),
			},
			success: function (data) {
				console.log(data);
				if (data == "1") {
					if ($("#paciente" + turnoSeleccionadoGrilla).prop("checked")) {
						ohSnap("Pago del turno anulado.", {duration: "3500", color: "red"});
					} else {
						ohSnap("Turno cobrado.", {duration: "3500", color: "green"});
					}
					$("#actualizarGrilla").click();
				} else {
					$("#contenedorCategoriaRecepcion").html(errorMsg);
				}
			},
			error: function () {
				$("#contenedorCategoriaRecepcion").html(errorMsg);
			},
		});
	}
});

//detectar cierre del modal
$(document).on("click", "#modalcobrarTurnoCancelar", function () {
	$("#opcionCobrarTurno").click();
	$("#eliminarCodigo").hide();
	$.ajax({
		url: "../php/billing/vaciarTablaPMO.php",
		success: function (data) {
			$("#listaTurnosReservados").show();
			// ohSnap("Prestaciones removidas del cobro", {duration: "3500", color: "red"});
			$("#contenidoTablaFormasDePago").html("<tr><td colspan='9' class='text-center'>Sin registros</td></tr>");
			$("#contenido-tabla-pmo").html(msgSinPrestaciones);
		},
	});
});
//#endregion
//////////////////////////////////////FIN COBRAR TURNO//////////////////////////////////////

//////////////////////////////////////OPCIONES DE PAGO - COBRO//////////////////////////////////////
//#region opciones pago cobro
$(document).on("click", "#facturacionOpcionesCobroPago", function () {
	cargarFormasPago();
	$("#modalTiposDeFormasDePagoNuevoCobroTipo").val("");
	$("#modalTiposDeFormasDePagoDescripcion").val("");
	$("#modalTiposDeFormasDePago").modal("show");
});

//cargar formas de pago
function cargarFormasPago() {
	$.ajax({
		url: "../php/billing/cargarFormasDePago.php",
		success: function (data) {
			$("#listaFormasDePago").html(data);
		},
		error: function () {
			$("#estadoFormaPagoCobro").html("<span>En este momento no se pude realizar la operación.</span>");
		},
	});
}

//activar boton guardar forma de pago
$(document).on("keyup", "#modalTiposDeFormasDePagoNuevoCobroTipo", function () {
	if ($(this).val().length > 3) {
		$("#modalTiposDeFormasDePagoBoton").removeAttr("disabled");
	} else {
		$("#modalTiposDeFormasDePagoBoton").attr("disabled", true);
	}
});

//guardar forma depago
$(document).on("click", "#modalTiposDeFormasDePagoBoton", function (e) {
	e.preventDefault();
	$.ajax({
		url: "../php/billing/guardarFormaDePago.php",
		type: "post",
		data: {
			formaPago: $("#modalTiposDeFormasDePagoNuevoCobroTipo").val(),
			descripcionPago: $("#modalTiposDeFormasDePagoDescripcion").val(),
		},
		success: function (data) {
			if (data == "1") {
				$("#modalTiposDeFormasDePagoNuevoCobroTipo").val("");
				$("#modalTiposDeFormasDePagoDescripcion").val("");
				cargarFormasPago();
			} else {
				$("#estadoFormaPagoCobro").html("<span>En este momento no se pude realizar la operación.</span>");
			}
		},
		error: function () {
			$("#estadoFormaPagoCobro").html("<span>Problemas con la conexión con el servidor.</span>");
		},
	});
});

//activar desactivar forma de pago
function activarDesactivarFormaPago(idFormaPago) {
	$.ajax({
		url: "../php/billing/activarDesactivarFormaPago.php",
		type: "post",
		data: {
			id: idFormaPago,
		},
		success: function (data) {
			if (data == "1") {
				cargarFormasPago();
			} else {
				$("#estadoFormaPagoCobro").html("<span>En este momento no se pude realizar la operación.</span>");
			}
		},
		error: function () {
			$("#estadoFormaPagoCobro").html("<span>Problemas con la conexión con el servidor.</span>");
		},
	});
}

//eliminar forma de pago
function eliminarFormaPago(idFormaPago) {
	$.ajax({
		url: "../php/billing/eliminarFormaPago.php",
		type: "post",
		data: {
			id: idFormaPago,
		},
		success: function (data) {
			if (data == "1") {
				cargarFormasPago();
			} else {
				$("#estadoFormaPagoCobro").html("<span>En este momento no se pude realizar la operación.</span>");
			}
		},
		error: function () {
			$("#estadoFormaPagoCobro").html("<span>Problemas con la conexión con el servidor.</span>");
		},
	});
}

//modificar forma de pago (MODAL)
function modificarFormaDePago(idFormaPago) {
	idFormaPagoSeleccionada = idFormaPago;
	$.ajax({
		url: "../php/billing/cargarInfoFormaPago.php",
		type: "post",
		data: {
			id: idFormaPago,
		},
		success: function (data) {
			console.log(data);
			info = data.split("|");
			$("#modalModificarDeFormasDePagoNuevoCobroTipo").val(info[0]);
			$("#modalModificarDeFormasDePagoDescripcion").val(info[1]);
			$("#modalModificarDeFormasDePago").modal("show");
		},
		error: function () {
			$("#estadoFormaPagoCobro").html("<span>Problemas con la conexión con el servidor.</span>");
		},
	});
}

//funcion modificar forma de pago
$(document).on("click", "#modalModificarDeFormasDePagoBoton", function () {
	$.ajax({
		url: "../php/billing/modificarFormaPago.php",
		type: "post",
		data: {
			id: idFormaPagoSeleccionada,
			descripcionPago: $("#modalModificarDeFormasDePagoDescripcion").val(),
			formaPago: $("#modalModificarDeFormasDePagoNuevoCobroTipo").val(),
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				cargarFormasPago();
				$("#modalModificarDeFormasDePago").modal("hide");
				$("#estadoFormaPagoCobro").html("");
			} else {
				$("#estadoFormaPagoCobro").html("<span>En este momento no se pude realizar la operación.</span>");
			}
		},
		error: function () {
			$("#estadoFormaPagoCobro").html("<span>Problemas con la conexión con el servidor.</span>");
		},
	});
});

//#endregion
//////////////////////////////////////FIN OPCIONES DE PAGO - COBRO//////////////////////////////////////
