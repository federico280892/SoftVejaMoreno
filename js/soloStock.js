//////////VARIABLES GENERALES//////////
var rubroSeleccionado = "";
var proveedorSeleccionado = "";
var articuloSeleccionado = "";
var itemSeleccionado = "";
var nombreFoto = "default_product.jpg";
var insumoSeleccionadoExistencias = "";
var articuloSeleccionadoTabla = "";
var posicionListaArticulo = "";
var flagDescontar = false;
var articuloEgresoSeleccionado = false;
var lenteSeleccionado = false;
var flagLentes = 0;
var unidadesADescontar = [];
var idArticuloEgreso = [];
var dioptriasAGuardar = [];
var cantidadLentesAGuardar = [];
var columnaDioptria = [];
var grupoArticuloEgreso = [];
var columnaLente = [];
var idComprbanteSeleccionado = "";
var valorPrecioCosto = "";
var articuloParaAjustar = "";

//////////////////////////////////////MASCARAS//////////////////////////////////////
$("#modalProveedoresCuit_cuil").mask("00-00000000-0", {placeholder: "00-00000000-0"});
$("#modalProveedoresCBU").mask("0000000000000000000000", {placeholder: "0000000000000000000000"});
//////////////////////////////////////FIN MASCARAS//////////////////////////////////////

//#region USUARIOS
function verificarUsuariosConectados() {
	$.ajax({
		url: "../php/stock/access/usuariosConectados.php",
		success: function (data) {
			$("#usuariosConectados").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStockCategoriaStock").html(errorMsg);
		},
	});
	setTimeout(function () {
		verificarUsuariosConectados();
	}, 5000);
}
//#endregion

//#region RUBROS

//cargar rubros
$("#rubros").on("click", () => {
	$.ajax({
		url: "../php/stock/heading/rubros.html",
		success: function (data) {
			$("#contenedorCategoriaStock").html(data);
			cargarRubrosTabla();
			cargarRubrosMovil();
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//obtener rubros para tabla
function cargarRubrosTabla() {
	$.ajax({
		url: "../php/stock/heading/obtenerRubrosTabla.php",
		success: function (data) {
			$("#resultadoRubrosTabla").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//obtener rubros para movil
function cargarRubrosMovil() {
	$.ajax({
		url: "../php/stock/heading/obtenerRubrosMovil.php",
		success: function (data) {
			$("#resultadoRubrosMovil").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//guardar rubro (MODAL)
$(document).on("click", "#agregarRubro", () => {
	$("#modalRubrosNombre").val("");
	$("#modalRubrosEstado").val("1");
	$("#modalRubrosObservacion").val("");
	$("#modalRubros").modal("show");
});

//agregar rubro
$(document).on("click", "#modalRubrosGuardar", () => {
	if ($("#modalRubrosNombre").val() == "") {
		$("#modalRubrosNombre").addClass("is-invalid bg-rojoClaro");
		$("#modalRubrosGuardar").attr("disabled", true);
		setTimeout(function () {
			$("#modalRubrosNombre").removeClass("is-invalid bg-rojoClaro");
			$("#modalRubrosGuardar").removeAttr("disabled");
		}, 1500);
	} else {
		$.ajax({
			url: "../php/stock/heading/guardarRubros.php",
			type: "post",
			data: {
				nombre: $("#modalRubrosNombre").val(),
				dioptria: $("#modalRubrosDioptria").val(),
				observacion: $("#modalRubrosObservacion").val(),
				estado: $("#modalRubrosEstado").val(),
			},
			success: function (data) {
				console;
				if (data == "1") {
					$("#rubros").click();
					$("#modalRubros").modal("hide");
					$("#modalRubrosCodigo").val("");
					$("#modalRubrosNombre").val("");
					$("#modalRubrosObservacion").val("");
					$("#modalRubrosEstado").val("1");
				} else if (data == "0") {
					$("#contenedorCategoriaStock").html(errorMsg);
				}
			},
			error: function (data) {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
	}
});

//buscar rubros
$(document).on("keyup", "#buscarRubros", function () {
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
		$(".rubroFila").each(function () {
			$(this).show();
			cantidad++;
		});
	} else {
		$(".rubroFila").each(function () {
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

	$("#rubrosEncontrados").html("<h6>Encontrados: " + cantidad + "</h6>");
});

//buscar rubros movil
$(document).on("keyup change", "#buscarRubrosMovil", function () {
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
		$(".rubroFilaMovil").each(function () {
			$(this).show();
			cantidad++;
		});
	} else {
		$(".rubroFilaMovil").each(function () {
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

	$("#rubrosEncontradosMovil").html("<h6>Encontrados: " + cantidad + "</h6>");
});

//eliminar rubros (MODAL)
function eliminarRubro(id) {
	rubroSeleccionado = id;
	$("#modalEliminarRubroSeleccion").val("0");
	$("#modalEliminarRubroBoton").attr("disabled", "disabled");
	$("#modalEliminarRubro").modal("show");
}

//habilitar boton eliminar
$(document).on("change", "#modalEliminarRubroSeleccion", () => {
	if ($("#modalEliminarRubroSeleccion").val() == "1") {
		$("#modalEliminarRubroBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarRubroBoton").attr("disabled", "disabled");
	}
});

//eliminar rubro
$(document).on("click", "#modalEliminarRubroBoton", () => {
	$.ajax({
		url: "../php/stock/heading/eliminarRubro.php",
		type: "post",
		data: {
			id: rubroSeleccionado,
		},
		success: function (data) {
			if (data == "1") {
				$("#rubros").click();
				$("#modalEliminarRubro").modal("hide");
			} else {
				$("#contenedorCategoriaStock").html(errorMsg);
			}
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//modificar rubro (MODAL)
function editarRubro(str) {
	rubroSeleccionado = str;
	$.ajax({
		url: "../php/stock/heading/buscarRubro.php",
		type: "post",
		data: {
			id: str,
		},
		success: function (data) {
			$("#respuestaModalModificarRubro").html(data);
			$("#modalModificarRubro").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//actualizar rubro
$(document).on("click", "#modalModificarRubroBoton", () => {
	if ($("#modalModificarNombre").val() == "") {
		$("#modalModificarNombre").addClass("is-invalid bg-rojoClaro");
		$("#modalModificarRubroBoton").attr("disabled", true);
		setTimeout(function () {
			$("#modalModificarNombre").removeClass("is-invalid bg-rojoClaro");
			$("#modalModificarRubroBoton").removeAttr("disabled");
		}, 1500);
	} else {
		if ($("#modalModificarObservacion").val() != "") {
			observacionRubro = $("#modalModificarObservacion").val();
		} else {
			observacionRubro = "-";
		}
		$.ajax({
			url: "../php/stock/heading/actualizarRubro.php",
			type: "post",
			data: {
				id: rubroSeleccionado,
				nombre: $("#modalModificarNombre").val(),
				dioptria: $("#modalModificarDioptria").val(),
				observacion: observacionRubro,
				activo: $("#modalModificarEstado").val(),
			},
			success: function (data) {
				if (data == "1") {
					$("#rubros").click();
					$("#modalModificarRubro").modal("hide");
				} else {
					$("#contenedorCategoriaStock").html(errorMsg);
				}
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
	}
});

//#endregion

//#region MOVIMIENTOS

//motivos movimientos
$(document).on("click", "#motivoMovimiento", function () {
	$("#cardStock").removeAttr("style");
	unidadesADescontar = [];
	idArticuloEgreso = [];
	$.ajax({
		url: "../php/stock/movement/motivoMovimientos.php",
		success: function (data) {
			cargarListaArticulos();
			fecha = new Date();
			mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
			dia = ("0" + fecha.getDate()).slice(-2);
			hoy = dia + "-" + mes + "-" + fecha.getFullYear();
			hoy2 = fecha.getFullYear() + "-" + mes + "-" + dia;
			$("#contenedorCategoriaStock").html(data);
			$("#proveedrIngreso, #movimientoEgreso").val("");
			$("#fechaActualMovimiento").text(hoy);
			$("#fechaIngreso").val(hoy2);
			$(
				"#motivoMovimientoIngresoComprobante, #motivoMovimientoIngresoOpcionFecha, #motivoMovimientoIngresoNComprobante, #motivoMovimientoIngresoOpcionProveedor, #contenedor-tabla_ingresos"
			).show();
			$("#motivoMovimientoEgresoOpcionMotivo, #motivoMovimientoEgresoFechaUtilizacion").hide();
			$("#cardStock").css("height", "100%");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//cargar tabla ingresos
function cargarListaArticulos() {
	$.ajax({
		url: "../php/stock/movement/agregarListaArticulo.php",
		success: function (data) {
			$("#contenedor-tabla-egresos").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//mostrar opciones de carga
$(document).on("change", "#motivoMovimientoOpciones", function () {
	$("#cardStock").removeAttr("style");
	if ($(this).val() == "1") {
		$("#proveedrIngreso").val("");
		$("#contenedor-consultas").hide();
		$.ajax({
			url: "../php/stock/movement/tablaEgresos.php",
			success: function (data) {
				cargarTablaEgresos();
				$("#contenedor-tabla-egresos").html(data);
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});

		$(
			"#motivoMovimientoIngresoComprobante, #motivoMovimientoIngresoOpcionFecha, #motivoMovimientoIngresoNComprobante, #motivoMovimientoIngresoOpcionProveedor, #contenedor-tabla_ingresos"
		).hide();
		$("#motivoMovimientoEgresoOpcionMotivo").show();
	} else if ($(this).val() == "0") {
		cargarListaArticulos();
		$("#contenedor-consultas").hide();
		$(
			"#motivoMovimientoIngresoComprobante, #motivoMovimientoIngresoOpcionFecha, #motivoMovimientoIngresoNComprobante, #motivoMovimientoIngresoOpcionProveedor, #contenedor-tabla_ingresos"
		).show();
		$("#motivoMovimientoEgresoOpcionMotivo, #motivoMovimientoEgresoFechaUtilizacion").hide();
	} else if ($(this).val() == "2") {
		$("#contenedor-tabla-egresos").html("");
		$.ajax({
			url: "../php/stock/movement/comprobantes.php",
			success: function (data) {
				// $("#cardStock").attr("style", "height: 100%");
				cargarComprobantes();
				$("#comprobantesComprobantes").html(data);
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
		$("#contenedor-consultas").show();
		$(
			"#motivoMovimientoIngresoComprobante, #motivoMovimientoIngresoOpcionFecha, #motivoMovimientoIngresoNComprobante, #motivoMovimientoIngresoOpcionProveedor, #contenedor-tabla_ingresos"
		).hide();
		$("#motivoMovimientoEgresoOpcionMotivo, #motivoMovimientoEgresoFechaUtilizacion").hide();
	}
});

//funcion cargar tabla egresos
function cargarTablaEgresos() {
	$.ajax({
		url: "../php/stock/movement/tablaEgresosFiltrada.php",
		type: "post",
		data: {
			rubro: "0",
			grupo: "0",
		},
		success: function (data) {
			$("#contenedorTablaEgresosFiltrada").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//funcion cargar tabla egresos
function cargarComprobantes() {
	$.ajax({
		url: "../php/stock/movement/tablaComprobantes.php",
		type: "post",
		data: {
			tipo: "99",
			grupo: "0",
		},
		success: function (data) {
			$("#contenedor-tabla-comprobantes").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//activar filtos tabla egreso
$(document).on("change", "#filtroRubroEgreso, #filtroGrupoEgreso", function () {
	$.ajax({
		url: "../php/stock/movement/tablaEgresosFiltrada.php",
		type: "post",
		data: {
			rubro: $("#filtroRubroEgreso").val(),
			grupo: $("#filtroGrupoEgreso").val(),
		},
		success: function (data) {
			$("#contenedorTablaEgresosFiltrada").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//activar filtos tabla comprobantes
$(document).on("change", "#filtroTipoComprobante", function () {
	$.ajax({
		url: "../php/stock/movement/tablaComprobantes.php",
		type: "post",
		data: {
			tipo: $("#filtroTipoComprobante").val(),
			grupo: $("#filtroGrupoEgreso").val(),
		},
		success: function (data) {
			$("#contenedor-tabla-comprobantes").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//mostrar ocultar fecha de egreso
$(document).on("change", "#motivoMovimientoOpciones", function () {
	if ($(this).val() == "1") {
		$("#fechaMovimientoEgreso").show();
	} else {
		$("#fechaMovimientoEgreso").hide();
	}
});

//seleccionar fila articulo egreso
$(document).on("click", "#filaArticuloEgreso", function () {
	articuloEgresoSeleccionado = true;
	$("#modalAgregarNuevoArticuloAComprobanteGuardar").removeAttr("disabled");
	$(this).addClass("filaSeleccionada text-dark font-weight-bold").siblings().removeClass("filaSeleccionada text-dark font-weight-bold");
});

//llamar a la funcion agregar articulo a comprobante
$(document).on("click", "#agregrArticuloAComprobante", function () {
	agregarArticuloComprobante();
});

//funcion agregar articulo comprobante
function agregarArticuloComprobante() {
	$("#modalAgregarNuevoArticuloAComprobante input").each(function () {
		$(this).val("");
	});
	$.ajax({
		url: "../php/stock/movement/cargarArticulosParaComprobante.php",
		success: function (data) {
			$("#contenido_tabla-completar-comprobante").html(data);
			$("#modalAgregarNuevoArticuloAComprobanteGuardar").attr("disabled", true);
			$("#modalAgregarNuevoArticuloAComprobante").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//seleccionar articulo
$(document).on("click", "#filaArticulo", function () {
	$("#valorDioptria").val("");

	if ($(this).attr("data-dioptria") == "0") {
		$("#valorDioptria").val("-");
		$("#dioptriasDelLente").hide();
		if ($("#modalAgregarArticuloCantidad").val() == "") {
			$("#modalAgregarNuevoArticuloAComprobanteGuardar").attr("disabled", true);
		} else {
			$("#modalAgregarNuevoArticuloAComprobanteGuardar").removeAttr("disabled");
		}
		lenteSeleccionado = false;
	} else {
		$("#valorDioptria").val("");
		$("#dioptriasDelLente").show();
		if ($("#valorDioptria").val() == "") {
			$("#modalAgregarNuevoArticuloAComprobanteGuardar").attr("disabled", true);
		} else {
			$("#modalAgregarNuevoArticuloAComprobanteGuardar").removeAttr("disabled");
		}
		lenteSeleccionado = true;
	}
	articuloSeleccionadoTabla = $(this).attr("data-articulo");
	$(this).addClass("filaSeleccionada text-dark font-weight-bold").siblings().removeClass("filaSeleccionada text-dark font-weight-bold");
});

//habilitar boton guardar solo si hay cantidad y precio
$(document).on("change", "#modalAgregarArticuloCantidad", function () {
	if ($(this).val() != "" && articuloSeleccionadoTabla != "") {
		if (lenteSeleccionado) {
			$("#modalAgregarNuevoArticuloAComprobanteGuardar").attr("disabled");
		} else {
			$("#modalAgregarNuevoArticuloAComprobanteGuardar").removeAttr("disabled");
		}
	} else {
		$("#modalAgregarNuevoArticuloAComprobanteGuardar").attr("disabled");
	}
});

//habilitar boton guardar solo si hay cantidad, precio y diop
$(document).on("change", "#valorDioptria", function () {
	if ($(this).val() != "") {
		$("#modalAgregarNuevoArticuloAComprobanteGuardar").removeAttr("disabled");
	} else {
		$("#modalAgregarNuevoArticuloAComprobanteGuardar").attr("disabled");
	}
});

//seleccionar fila articulo
$(document).on("click", "#filaListaArticulos", function () {
	posicionListaArticulo = $(this).attr("data-pos");
	$(this).addClass("filaSeleccionada text-dark font-weight-bold").siblings().removeClass("filaSeleccionada text-dark font-weight-bold");
	$("#eliminarFilaArticulo").show();
});

//eliminar fila
$(document).on("click", "#eliminarFilaArticulo", function () {
	if ($("#btnGuardarListaArticulos").offset().top - $("#cardStock").height() > 25) {
		console.log($("#btnGuardarListaArticulos").offset().top - $("#cardStock").height());
		// $("#cardStock").removeClass("ajustarCard");
		$("#cardStock").removeAttr("style");
	}
	$.ajax({
		url: "../php/stock/movement/eliminarListaArticulo.php",
		type: "post",
		data: {
			pos: posicionListaArticulo,
		},
		success: function (data) {
			$("#contenedor-tabla-egresos").html(data);
			$("#eliminarFilaArticulo").hide();
			posicionListaArticulo = "";
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//detectar articulo duplicado
$(document).on("keyup", "#modalAgregarArticuloNombre", function () {
	$.ajax({
		url: "../php/stock/movement/buscarArticuloDuplicado.php",
		type: "post",
		data: {
			articulo: $("#modalAgregarArticuloNombre").val(),
		},
		success: function (data) {
			if (data == "1") {
				$("#modalAgregarArticuloGuardar").attr("disabled", true);
				$("#articuloDuplicado").html('<i class="fas fa-clone"></i> Existente').addClass("text-warning").removeClass("text-success");
			} else {
				$("#modalAgregarArticuloGuardar").removeAttr("disabled");
				$("#articuloDuplicado").html('<i class="fas fa-box"></i> Nuevo').addClass("text-success").removeClass("text-warning");
			}
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//limitar cantidad a extraer
$(document).on("keyup", "#unidadesParaDescontar", function () {
	var contador = 0;
	if (parseFloat($(this).val()) > parseFloat($(this).parent().prev().text()) || $(this).val() == "" || $(this).val() <= 0) {
		$(this).addClass("is-invalid bg-rojoClaro");
	} else {
		$(this).addClass("is-valid").removeClass("is-invalid bg-rojoClaro");
	}

	$("#tabla-egresos #unidadesParaDescontar").each(function () {
		if ($(this).hasClass("is-invalid")) {
			contador++;
			if ($(this).val() == "") {
				$(this).removeClass("is-invalid is-valid");
				$("#descontarUnidades").removeAttr("disabled");
				contador--;
			}
		}
	});

	if (contador == 0) {
		$("#descontarUnidades").removeAttr("disabled");
	} else {
		$("#descontarUnidades").attr("disabled", true);
	}
});

//descontar unidades (MODAL)
$(document).on("click", "#descontarUnidades", function () {
	if (
		$("#movimientoEgreso").val() == "" ||
		$("#movimientoEgreso").val() == null ||
		$("#movimientoEgresoFechaUso").val() == "" ||
		$("#movimientoEgresoFechaUso").val() == null
	) {
		if ($("#movimientoEgreso").val() == "" || $("#movimientoEgreso").val() == null) {
			$("#movimientoEgreso").addClass("is-invalid bg-rojoClaro");
			$("#modalConfirmarEgresoBoton").attr("disabled", true);
		}
		if ($("#movimientoEgresoFechaUso").val() == "" || $("#movimientoEgresoFechaUso").val() == null) {
			$("#movimientoEgresoFechaUso").addClass("is-invalid bg-rojoClaro");
			$("#modalConfirmarEgresoBoton").attr("disabled", true);
		}
		setTimeout(function () {
			$("#movimientoEgresoFechaUso, #movimientoEgreso").removeClass("is-invalid bg-rojoClaro");
			$("#modalConfirmarEgresoBoton").removeAttr("disabled");
		}, 1500);
	} else {
		$(".unidades").each(function () {
			if ($(this).val() != "" || $(this).val() != null) {
				unidadesADescontar.push($(this).val());
				idArticuloEgreso.push($(this).attr("data-idarticulo"));
				grupoArticuloEgreso.push($(this).attr("data-lente"));
				columnaLente.push($(this).attr("data-columna"));
			}
		});
		$("#modalConfirmarEgresoSeleccion").val("0");
		$("#modalConfirmarEgresoBoton").attr("disabled", true);
		$("#modalConfirmarEgreso").modal("show");
	}
});

//validar modal confirmar egreso
$(document).on("change", "#modalConfirmarEgresoSeleccion", function () {
	if ($(this).val() == "1") {
		$("#modalConfirmarEgresoBoton").removeAttr("disabled");
	} else {
		$("#modalConfirmarEgresoBoton").attr("disabled", true);
	}
});

//invocar funcion egreso de articulos
$(document).on("click", "#modalConfirmarEgresoBoton", function () {
	egresoDeUnidades(unidadesADescontar, idArticuloEgreso, grupoArticuloEgreso, columnaLente);
});

//funcion descontar unidades
function egresoDeUnidades(unidades, idArt, grupoArt, col) {
	$.ajax({
		url: "../php/stock/movement/descontarUnidades.php",
		type: "post",
		data: {
			cantidades: unidades,
			articulos: idArt,
			grupo: grupoArt,
			columna: col,
			fecha: $("#movimientoEgresoFechaUso").val(),
			motivo: $("#movimientoEgreso").val(),
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				$("#filtroRubroEgreso, #filtroGrupoEgreso").val("0");
				$("#movimientoEgreso").val("");
				cargarTablaEgresos();
				notificarBajoStock();
				unidadesADescontar = [];
				idArticuloEgreso = [];
				grupoArticuloEgreso = [];
				columnaLente = [];
			}
			flagDescontar = false;
			$("#modalConfirmarEgreso").modal("hide");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//agregar articulo a lista ingreso
$(document).on("click", "#modalAgregarNuevoArticuloAComprobanteGuardar", function () {
	if ($("#modalAgregarArticuloCantidad").val() == "") {
		if ($("#modalAgregarArticuloCantidad").val() == "") {
			$("#modalAgregarArticuloCantidad").addClass("is-invalid bg-rojoClaro");
			$("#modalAgregarNuevoArticuloAComprobanteGuardar").attr("disabled", true);
		}
		setTimeout(function () {
			$("#modalAgregarArticuloCantidad").removeClass("is-invalid bg-rojoClaro");
			$("#modalAgregarNuevoArticuloAComprobanteGuardar").removeAttr("disabled");
		}, 1500);
	} else {
		if ($("#modalAgregarArticuloPrecioCosto").val() == "") {
			valorPrecioCosto = 0.0;
		} else {
			valorPrecioCosto = $("#modalAgregarArticuloPrecioCosto").val().replace(".", "").replace(",", ".");
		}
		var infoArticulo = [
			articuloSeleccionadoTabla,
			$("#modalAgregarArticuloNLote").val(),
			$("#modalAgregarArticuloVencimiento").val(),
			valorPrecioCosto,
			$("#modalAgregarArticuloMarca").val().toUpperCase(),
			$("#modalAgregarArticuloCantidad").val(),
			$("#valorDioptria").val(),
		];
		// $("#movimientoIngreso").val();
		$.ajax({
			url: "../php/stock/movement/agregarListaArticulo.php",
			type: "post",
			data: {
				articulo: infoArticulo,
			},
			success: function (data) {
				$("#contenedor-tabla-egresos").html(data);
				$("#articuloDuplicado").html("");
				// if ($("#btnGuardarListaArticulos").offset().top - $("#cardStock").height() < 25) {
				// 	// console.log($("#btnGuardarListaArticulos").offset().top - $("#cardStock").height());
				// 	$("#btnGuardarListaArticulos").removeAttr("disabled");
				// 	$("#cardStock").removeAttr("style");
				// } else {
				// 	$("#cardStock").attr("style", "height: 100%");
				// }
				$("#modalAgregarNuevoArticuloAComprobante").modal("hide");
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
	}
});

//guardar articulo
$(document).on("click", "#btnGuardarListaArticulos", function () {
	if ($("#fechaIngreso").val() == "" || $("#proveedrIngreso").val() == "" || $("#proveedrIngreso").val() == null) {
		if ($("#fechaIngreso").val() == "") {
			$("#fechaIngreso").addClass("is-invalid bg-rojoClaro");
			$("#btnGuardarListaArticulos").attr("disabled", true);
		}
		if ($("#proveedrIngreso").val() == "" || $("#proveedrIngreso").val() == null) {
			$("#proveedrIngreso").addClass("is-invalid bg-rojoClaro");
			$("#btnGuardarListaArticulos").attr("disabled", true);
		}
		setTimeout(function () {
			$("#fechaIngreso, #proveedrIngreso").removeClass("is-invalid bg-rojoClaro");
			$("#btnGuardarListaArticulos").removeAttr("disabled");
		}, 1500);
	} else {
		if ($("#movimientoNComprobante").val() == "") {
			numeroComprobante = "0000-00000000";
		} else {
			numeroComprobante = $("#movimientoNComprobante").val();
		}
		$.ajax({
			url: "../php/stock/movement/agregarStock.php",
			type: "post",
			data: {
				comprobante: $("#motivoMovimientoOpciones").val(),
				fechaComprobante: $("#fechaIngreso").val(),
				nComprobante: numeroComprobante,
				proveedor: $("#proveedrIngreso").val(),
			},
			success: function (data) {
				console.log(data);
				$("#motivoMovimiento").click();
				$("#movimientoIngreso").val("0");
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
	}
});

//seleccionar fila comprobantes
$(document).on("click", "#filaComprobante", function () {
	idComprbanteSeleccionado = $(this).attr("data-comprobante");
	$("#verComprobante").show();
	$(this).addClass("filaSeleccionada text-dark font-weight-bold").siblings().removeClass("filaSeleccionada text-dark font-weight-bold");
});

//ver comprobante
$(document).on("click", "#verComprobante", function () {
	$.ajax({
		url: "../php/stock/movement/verComprobante.php",
		type: "post",
		data: {
			comprobante: idComprbanteSeleccionado,
		},
		success: function (data) {
			$("#modalVerComprobanteContenido").html(data);
			$("#modalVerComprobante").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//seleccionar fila ajustes
$(document).on("click", "#filaAjuste", function () {
	articuloParaAjustar = $(this).attr("data-articulo");
	$(this).addClass("filaSeleccionada text-dark font-weight-bold").siblings().removeClass("filaSeleccionada text-dark font-weight-bold");
	$("#modalAjusteValor").val("");
	$("#modalAjusteNombreArticulo").html($(this).attr("data-nombre"));
	$("#modalAjusteStockMin").html($(this).attr("data-stockMin"));
	$("#modalAjusteCantidad").html($(this).attr("data-cantidad"));
	$("#modalAjuste").modal("show");
});

//ajustar cantidad de articulo
$(document).on("click", "#modalAjusteGuardar", function () {
	$.ajax({
		url: "../php/stock/movement/ajustarCantidad.php",
		type: "post",
		data: {
			articulo: articuloParaAjustar,
			cantidad: $("#modalAjusteValor").val(),
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				$("#modalAjuste").modal("hide");
			}
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//#endregion

//#region BANCOS

//cargar bancos
$(document).on("click", "#bancos", function () {
	$("#modalBancoNombreBanco").val("");
	$.ajax({
		url: "../php/stock/banks/buscarBancos.php",
		type: "post",
		data: {
			nombre: $("#modalBancoNombreBanco").val(),
		},
		success: function (data) {
			console.log(data);
			$("#modalBancosContenido").html(data);
			$("#modalBanco").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//eliminar banco (MODAL)
function eliminarBanco(str) {
	idBancoSeleccionado = str;
	$("#modalEliminarBancoSeleccion").val("0");
	$("#modalBanco").modal("hide");
	$("#modalEliminarBanco").modal("show");
}

//habilitar boton eliminar
$(document).on("change", "#modalEliminarBancoSeleccion", () => {
	if ($("#modalEliminarBancoSeleccion").val() == "1") {
		$("#modalEliminarBancoBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarBancoBoton").attr("disabled", true);
	}
});

//eliminar banco
$(document).on("click", "#modalEliminarBancoBoton", function () {
	$.ajax({
		url: "../php/stock/banks/eliminarBanco.php",
		type: "post",
		data: {
			id: idBancoSeleccionado,
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				$("#modalEliminarBanco").modal("hide");
				$("#bancos").click();
			}
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//guardar banco
$(document).on("click", "#modalBancoGuardar", function () {
	if ($("#modalBancoActivo").prop("checked")) {
		activo = "1";
	} else {
		activo = "0";
	}
	$.ajax({
		url: "../php/stock/banks/guardarBanco.php",
		type: "post",
		data: {
			nombre: $("#modalBancoNombreBanco").val(),
			estado: activo,
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				$("#modalBanco").modal("hide");
				ohSnap("Datos guardados correctamente", {
					duration: "3500",
					color: "green",
				});
			}
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//funcion modificar banco
function modificarBanco(str) {
	idBancoSeleccionado = str;
	$.ajax({
		url: "../php/stock/banks/cargarDAtosBanco.php",
		type: "post",
		data: {
			id: idBancoSeleccionado,
		},
		success: function (data) {
			console.log(data);
			respuesta = data.split("|");
			$("#modalBanco").modal("hide");
			$("#modalEditarBancoNombreBanco").val(respuesta[0]);
			if (respuesta[1] == "1") {
				$("#modalEditarBancoActivo").attr("checked", true);
			} else {
				$("#modalEditarBancoActivo").removeAttr("checked");
			}
			$("#modalEditarBanco").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//actualizar banco
function actualizarBanco(str) {
	idBancoSeleccionado = str;
	$.ajax({
		url: "../php/stock/banks/actualizarBanco.php",
		type: "post",
		data: {
			id: idBancoSeleccionado,
		},
		success: function (data) {
			console.log(data);
			respuesta = data.split("|");
			$("#modalBanco").modal("hide");
			$("#modalEditarBancoNombreBanco").val(respuesta[0]);
			if (respuesta[1] == "1") {
				$("#modalEditarBancoActivo").attr("checked", true);
			} else {
				$("#modalEditarBancoActivo").removeAttr("checked");
			}
			$("#modalEditarBanco").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//funcion actualizar banco
$(document).on("click", "#modalEditarBancoGuardar", function () {
	if ($("#modalEditarBancoActivo").prop("checked")) {
		estado = "1";
	} else {
		estado = "0";
	}
	$.ajax({
		url: "../php/stock/banks/actualizarBanco.php",
		type: "post",
		data: {
			id: idBancoSeleccionado,
			nombre: $("#modalEditarBancoNombreBanco").val(),
			activo: estado,
		},
		success: function (data) {
			console.log(data);
			if (data == "1") {
				$("#modalEditarBanco").modal("hide");
				ohSnap("Datos guardados", {
					duration: "3500",
					color: "green",
				});
			}
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//#endregion

//#region PROVEEDORES

//cargar proveedores
$("#proveedores").on("click", () => {
	$.ajax({
		url: "../php/stock/suppliers/proveedores.html",
		success: function (data) {
			$("#contenedorCategoriaStock").html(data);
			cargarProveedoresTabla();
			cargarProveedoresMovil();
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//cargar proveedores
function cargarProveedoresTabla() {
	$.ajax({
		url: "../php/stock/suppliers/cargarProveedoresTabla.php",
		success: function (data) {
			$("#resultadoProveedoresTabla").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//cargar proveedores movil
function cargarProveedoresMovil() {
	$.ajax({
		url: "../php/stock/suppliers/cargarProveedoresMovil.php",
		success: function (data) {
			$("#resultadoProveedoresMovil").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//ver proveedor
function verProveedor(str) {
	$.ajax({
		url: "../php/stock/suppliers/verProveedor.php",
		type: "post",
		data: {
			id: str,
		},
		success: function (data) {
			$("#modalVerProveedorDetalles").html(data);
			$("#modalVerProveedor").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//agregar proveedor (MODAL)
$(document).on("click", "#agregarProveedores", () => {
	$("#modalProveedores input").each(function () {
		$(this).val("").removeClass("is-invalid is-valid");
	});
	$("#modalProveedoresObs").val("");
	$("#modalProveedores").modal("show");
});

//validar CBU cargar nuevo
$(document).on("keyup", "#modalProveedoresCBU", function () {
	if ($(this).val().length == 22) {
		$(this).addClass("is-valid").removeClass("is-invalid bg-rojoClaro");
	} else {
		$(this).removeClass("is-valid").addClass("is-invalid bg-rojoClaro");
	}
});

//validar CBU editar
$(document).on("keyup", "#modalProveedoresModificarCBU", function () {
	if ($(this).val().length == 22) {
		$(this).addClass("is-valid").removeClass("is-invalid bg-rojoClaro");
	} else {
		$(this).removeClass("is-valid").addClass("is-invalid bg-rojoClaro");
	}
});

//validar cuit/cuil agregar nuevo
$(document).on("keyup", "#modalProveedoresCuit_cuil", function () {
	if ($(this).val().length == 13) {
		$.ajax({
			url: "../php/stock/suppliers/verificarCUITCUIL.php",
			type: "post",
			data: {
				cuit: $("#modalProveedoresCuit_cuil").val(),
			},
			success: function (data) {
				if (data == "1") {
					$("#modalProveedoresInfoCuil").html("Existe");
					$("#modalProveedoresCuit_cuil").addClass("is-invalid bg-rojoClaro").removeClass("is-valid");
					$("#modalProveedoresGuardar").attr("disabled", true);
				} else {
					$("#modalProveedoresInfoCuil").html("");
					$("#modalProveedoresCuit_cuil").addClass("is-valid").removeClass("is-invalid bg-rojoClaro");
					$("#modalProveedoresGuardar").removeAttr("disabled");
				}
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
	} else {
		$("#modalProveedoresInfoCuil").html("");
		$("#modalProveedoresCuit_cuil").removeClass("is-valid is-invalid");
	}
});

//validar cuit/cuil agregar nuevo
$(document).on("keyup", "#modalProveedoresModificarCuit_cuil", function () {
	if ($(this).val().length == 13) {
		$.ajax({
			url: "../php/stock/suppliers/verificarCUITCUIL.php",
			type: "post",
			data: {
				cuit: $("#modalProveedoresModificarCuit_cuil").val(),
			},
			success: function (data) {
				if (data == "1") {
					$("#modalProveedoresModificarInfoCuil").html("Existe");
					$("#modalProveedoresModificarCuit_cuil").addClass("is-invalid bg-rojoClaro").removeClass("is-valid");
					$("#modalModificarProveedorBoton").attr("disabled", true);
				} else {
					$("#modalProveedoresModificarInfoCuil").html("");
					$("#modalProveedoresModificarCuit_cuil").addClass("is-valid").removeClass("is-invalid bg-rojoClaro");
					$("#modalModificarProveedorBoton").removeAttr("disabled");
				}
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
	} else {
		$("#modalProveedoresModificarInfoCuil").html("");
		$("#modalProveedoresModificarCuit_cuil").removeClass("is-valid is-invalid");
	}
});

//agregar proveedor
$(document).on("click", "#modalProveedoresGuardar", () => {
	if ($("#modalProveedoresNombre").val() == "" || $("#modalProveedoresCuit_cuil").val() == "") {
		if ($("#modalProveedoresNombre").val() == "") {
			$("#modalProveedoresNombre").addClass("is-invalid bg-rojoClaro");
		}
		if ($("#modalProveedoresCuit_cuil").val() == "") {
			$("#modalProveedoresCuit_cuil").addClass("is-invalid bg-rojoClaro");
		}
		$("#modalProveedoresGuardar").attr("disabled", true);
		setTimeout(function () {
			$("#modalProveedoresNombre").removeClass("is-invalid bg-rojoClaro");
			$("#modalProveedoresCuit_cuil").removeClass("is-invalid bg-rojoClaro");
			$("#modalProveedoresGuardar").removeAttr("disabled");
		}, 2000);
	} else {
		if ($("#modalProveedoresActivo").prop("checked")) {
			estado = "1";
		} else {
			estado = "0";
		}
		$.ajax({
			url: "../php/stock/suppliers/guardarProveedor.php",
			type: "post",
			data: {
				codigo: $("#modalProveedoresC_proveedor").val(),
				nombre: $("#modalProveedoresNombre").val(),
				r_social: $("#modalProveedoresR_social").val(),
				cuit_cuil: $("#modalProveedoresCuit_cuil").val(),
				domicilio: $("#modalProveedoresDomicilio").val(),
				telefono: $("#modalProveedoresTelefono").val(),
				celular: $("#modalProveedoresCelular").val(),
				cbu: $("#modalProveedoresCBU").val(),
				alias: $("#modalProveedoresAlias").val(),
				banco: $("#modalProveedoresBanco").val(),
				mail: $("#modalProveedoresEmail").val(),
				observacion: $("#modalProveedoresObs").val(),
				activo: estado,
			},
			success: function (data) {
				console.log(data);
				if (data == "1") {
					$("#proveedores").click();
					$("#modalProveedores").modal("hide");
				} else if (data == "0") {
					$("#contenedorCategoriaStock").html(errorMsg);
				}
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
	}
});

//eliminar proveedor (MODAL)
function eliminarProveedor(id) {
	proveedorSeleccionado = id;
	$("#modalEliminarProveedorSeleccion").val("0");
	$("#modalEliminarProveedorBoton").attr("disabled", "disabled");
	$("#modalEliminarProveedor").modal("show");
}

//habilitar boton eliminar
$(document).on("change", "#modalEliminarProveedorSeleccion", () => {
	if ($("#modalEliminarProveedorSeleccion").val() == "1") {
		$("#modalEliminarProveedorBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarProveedorBoton").attr("disabled", "disabled");
	}
});

//eliminar proveedor
$(document).on("click", "#modalEliminarProveedorBoton", () => {
	$.ajax({
		url: "../php/stock/suppliers/eliminarProveedor.php",
		type: "post",
		data: {
			id: proveedorSeleccionado,
		},
		success: function (data) {
			if (data == "1") {
				$("#proveedores").click();
				$("#modalEliminarProveedor").modal("hide");
			} else {
				$("#contenedorCategoriaStock").html(errorMsg);
			}
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//modificar proveedor (MODAL)
function editarProveedor(str) {
	proveedorSeleccionado = str;
	$.ajax({
		url: "../php/stock/suppliers/buscarProveedor.php",
		type: "post",
		data: {
			id: str,
		},
		success: function (data) {
			$("#respuestaModalModificarProveedor").html(data);
			$("#modalModificarProveedor").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//actualizar proveedor
$(document).on("click", "#modalModificarProveedorBoton", () => {
	if ($("#modalProveedoresModificarNombre").val() == "" || $("#modalProveedoresModificarCuit_cuil").val() == "") {
		if ($("#modalProveedoresModificarNombre").val() == "") {
			$("#modalProveedoresModificarNombre").addClass("is-invalid bg-rojoClaro");
		}
		if ($("#modalProveedoresModificarCuit_cuil").val() == "") {
			$("#modalProveedoresModificarCuit_cuil").addClass("is-invalid bg-rojoClaro");
		}
		$("#modalModificarProveedorBoton").attr("disabled", true);
		setTimeout(() => {
			$("#modalProveedoresModificarNombre").removeClass("is-invalid bg-rojoClaro");
			$("#modalProveedoresModificarCuit_cuil").removeClass("is-invalid bg-rojoClaro");
			$("#modalModificarProveedorBoton").removeAttr("disabled");
		}, 1500);
	} else {
		if ($("#modalProveedoresModificarActivo").prop("checked")) {
			estadoProveedor = "1";
		} else {
			estadoProveedor = "0";
		}

		$.ajax({
			url: "../php/stock/suppliers/actualizarProveedor.php",
			type: "post",
			data: {
				id: proveedorSeleccionado,
				codigo: $("#modalProveedoresModificarC_proveedor").val(),
				nombre: $("#modalProveedoresModificarNombre").val(),
				razonSocial: $("#modalProveedoresModificarR_social").val(),
				cuil_cuit: $("#modalProveedoresModificarCuit_cuil").val(),
				domicilio: $("#modalProveedoresModificarDomicilio").val(),
				telefono: $("#modalProveedoresModificarTelefono").val(),
				celular: $("#modalProveedoresModificarCelular").val(),
				CBU: $("#modalProveedoresModificarCBU").val(),
				alias: $("#modalProveedoresModificarAlias").val(),
				banco: $("#modalProveedoresModificarBanco").val(),
				mail: $("#modalProveedoresModificarEmail").val(),
				observacion: $("#modalProveedoresModificarObs").val(),
				activo: estadoProveedor,
			},
			success: function (data) {
				if (data == "1") {
					$("#proveedores").click();
					$("#modalModificarProveedor").modal("hide");
				} else {
					$("#contenedorCategoriaStock").html(errorMsg);
				}
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
	}
});

//buscar proveedor movil
$(document).on("change keyup", "#buscarProveedorMovil", function () {
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
		$(".proveedoresFilaMovil").each(function () {
			$(this).show();
			cantidad++;
		});
	} else {
		$(".proveedoresFilaMovil").each(function () {
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

	$("#proveedorEncontradosMovil").html("<h6>Encontrados: " + cantidad + "</h6>");
});

//#endregion

//#region INSUMOS

//crear nuevo insumo
$(document).on("click", "#nuevaExistencia", () => {
	$.ajax({
		url: "../php/stock/counting/cargarDatosModalExistencias.php",
		success: function (data) {
			console.log("Ok");
			$("#modalAgregarArticuloContenido").html(data);
			//mostrarOcultarDioptrias();
			$("#articulos").click();
			$("#modalAgregarArticulo").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//cargar insumos
$("#insumos").on("click", () => {
	$.ajax({
		url: "../php/stock/stock/stock.html",
		success: function (data) {
			$("#contenedorCategoriaStock").html(data);
			cargarItems();
			cargarItemsMovil();
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//cargar insumos
function cargarItems() {
	$.ajax({
		url: "../php/stock/stock/cargarItems.php",
		success: function (data) {
			$("#resultadoStock").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//cargar insumos para movil
function cargarItemsMovil() {
	$.ajax({
		url: "../php/stock/stock/cargarItemsMovil.php",
		success: function (data) {
			$("#resultadoStockMovil").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//guardar nuevo grupo (MODAL)
$(document).on("click", "#agregarInsumos", () => {
	$("#modalNuevoItem input, #modalNuevoItem textarea").each(function () {
		$(this).val("");
	});
	cargarGrupos();
	$("#modalNuevoItem").modal("show");
});

//cargar nuevo grupo
function cargarGrupos() {
	$.ajax({
		url: "../php/stock/stock/cargarGrupos.php",
		success: function (data) {
			$("#modalNuevoItemRubro").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//guardar nuevo item
$(document).on("click", "#modalNuevoItemGuardar", () => {
	if ($("#modalNuevoItemNombre").val() == "") {
		$("#modalNuevoItemNombre").addClass("is-invalid bg-rojoClaro");
		$("#modalNuevoItemGuardar").attr("disabled", true);
		setTimeout(function () {
			$("#modalNuevoItemNombre").removeClass("is-invalid bg-rojoClaro");
			$("#modalNuevoItemGuardar").removeAttr("disabled");
		}, 1500);
	} else {
		if ($("#modalNuevoItemActivo").prop("checked")) {
			estado = "1";
		} else {
			estado = "0";
		}
		if ($("#modalNuevoItemObservaciones").val() == "") {
			valorObservacionItem = "-";
		} else {
			valorObservacionItem = $("#modalNuevoItemObservaciones").val();
		}
		$.ajax({
			url: "../php/stock/stock/nuevoItem.php",
			type: "post",
			data: {
				nombre: $("#modalNuevoItemNombre").val(),
				descripcion: $("#modalNuevoItemDescripcion").val(),
				rubro: $("#modalNuevoItemRubro").val(),
				observaciones: valorObservacionItem,
				activo: estado,
			},
			success: function (data) {
				console.log(data);
				$("#modalNuevoItem").modal("hide");
				$("#insumos").click();
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
	}
});

//ver item
function verItem(str) {
	$.ajax({
		url: "../php/stock/stock/verItem.php",
		type: "post",
		data: {
			id: str,
		},
		success: function (data) {
			$("#modalVerItemDetalles").html(data);
			$("#modalVerItem").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//eliminar item (MODAL)
function eliminarItem(id) {
	itemSeleccionado = id;
	$("#modalEliminarItemSeleccion").val("0");
	$("#modalEliminarItemBoton").attr("disabled", "disabled");
	$("#modalEliminarItem").modal("show");
}

//habilitar boton eliminar
$(document).on("change", "#modalEliminarItemSeleccion", () => {
	if ($("#modalEliminarItemSeleccion").val() == "1") {
		$("#modalEliminarItemBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarItemBoton").attr("disabled", "disabled");
	}
});

//eliminar ítem
$(document).on("click", "#modalEliminarItemBoton", () => {
	$.ajax({
		url: "../php/stock/stock/eliminarItem.php",
		type: "post",
		data: {
			id: itemSeleccionado,
		},
		success: function (data) {
			if (data == "1") {
				$("#insumos").click();
				$("#modalEliminarItem").modal("hide");
			} else {
				$("#contenedorCategoriaStock").html(errorMsg);
			}
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//editar item
function editarItem(str) {
	itemSeleccionado = str;
	$.ajax({
		url: "../php/stock/stock/buscarItem.php",
		type: "post",
		data: {
			id: str,
		},
		success: function (data) {
			$("#respuestaModalModificarItem").html(data);
			$("#modalModificarItem").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//actualizar item
$(document).on("click", "#modalModificarItemBoton", () => {
	if ($("#modalModificarItemNombre").val() == "") {
		if ($("#modalModificarItemNombre").val() == "") {
			$("#modalModificarItemNombre").addClass("is-invalid bg-rojoClaro");
		}
		$("#modalModificarItemBoton").attr("disabled", true);
		setTimeout(function () {
			$("#modalModificarItemNombre").removeClass("is-invalid bg-rojoClaro");
			$("#modalModificarItemBoton").removeAttr("disabled");
		}, 1500);
	} else {
		if ($("#modalModificarItemEstado").prop("checked")) {
			estado = "1";
		} else {
			estado = "0";
		}
		if ($("#modalModificarItemObservacion").val() == "") {
			valorObservacionItem = "-";
		} else {
			valorObservacionItem = $("#modalModificarItemObservacion").val();
		}
		$.ajax({
			url: "../php/stock/stock/actualizarItem.php",
			type: "post",
			data: {
				id: itemSeleccionado,
				nombre: $("#modalModificarItemNombre").val(),
				descripcion: $("#modalModificarItemDescripcion").val(),
				grupo: $("#modalModificarItemGrupo").val(),
				observaciones: valorObservacionItem,
				activo: estado,
			},
			success: function (data) {
				console.log(data);
				if (data == 1) {
					$("#insumos").click();
					$("#modalModificarItem").modal("hide");
				}
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
	}
});

//buscar items movil
$(document).on("change keyup", "#buscarItemsMovil", function () {
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
		$(".itemFilaMovil").each(function () {
			$(this).show();
			cantidad++;
		});
	} else {
		$(".itemFilaMovil").each(function () {
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

	$("#itemsEncontradosMovil").html("<h6>Encontrados: " + cantidad + "</h6>");
});

//buscar items
$(document).on("keyup", "#buscarItems", function () {
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
		$(".itemFila").each(function () {
			$(this).show();
			cantidad++;
		});
	} else {
		$(".itemFila").each(function () {
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

	$("#itemsEncontrados").html("<h6>Encontrados: " + cantidad + "</h6>");
});

//#endregion

//#region ARTICULOS

//cargar existecnias
$(document).on("click", "#articulos", () => {
	$.ajax({
		url: "../php/stock/counting/articulos.html",
		success: function (data) {
			$("#contenedorCategoriaStock").html(data);
			// $("#cardStock").attr("style", "height: 100%");
			notifcacionRapida();
			cargarExistencias();
			cargarExistenciasMovil();
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//notificaciones rapidas
function notifcacionRapida() {
	$.ajax({
		url: "../php/stock/counting/notifiacionesRapidas.php",
		success: function (data) {
			$("#notificacionRapida").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//cargar articulos
function cargarExistencias() {
	$.ajax({
		url: "../php/stock/counting/cargarExistencias.php",
		success: function (data) {
			$("#resultadoExistenciasTabla").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//cargar existecnias movil
function cargarExistenciasMovil() {
	$.ajax({
		url: "../php/stock/counting/cargarExistenciasMovil.php",
		success: function (data) {
			$("#resultadoExistenciasMovil").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//agregar articulos (MODAL)
$(document).on("click", "#agregarArticulo", () => {
	$.ajax({
		url: "../php/stock/counting/cargarDatosModalExistencias.php",
		success: function (data) {
			$("#modalAgregarArticuloContenido").html(data);
			//mostrarOcultarDioptrias();
			$("#divFileImagen").hide();
			$("#modalAgregarArticuloFoto").val("");
			$("#articuloDuplicado").html("");
			if ($("#modalAgregarArticuloGrupo option:selected").attr("data-dioptria") == "1") {
			}
			$("#modalAgregarArticulo input, #modalAgregarArticulo select, #modalAgregarArticulo textarea").each(function () {
				$(this).val("");
			});
			$("#modalAgregarArticulosStockMin").val("1");
			$("#modalAgregarArticulo").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//actualizar rubro
$(document).on("change", "#modalAgregarArticuloGrupo", function () {
	$("#modalAgregarArticuloRubro").val($("#modalAgregarArticuloGrupo option:selected").attr("data-dioptria"));
});

//cargar imagen
$(document).on("click", "#previewArticulo", function () {
	$("#modalAgregarArticuloFoto").click();
});

//cargar imagen para cambiar
$(document).on("click", "#previewArticuloEditar", function () {
	$("#modalModificarArticuloFoto").click();
});

//render imagen preview a modificar
$(document).on("change", "#modalModificarArticuloFoto", function (input) {
	if ($(this).val() != "") {
		var reader = new FileReader();
		reader.readAsDataURL(document.getElementById("modalModificarArticuloFoto").files[0]);
		reader.onload = function (e) {
			document.getElementById("previewArticuloEditar").src = e.target.result;
			comprobarNombreFotoEnBD($("#modalModificarArticuloFoto").val().replace("C:\\fakepath\\", ""));
		};
		$("#vaciarImgArticuloEditar").show();
	} else {
		$("#previewArticuloEditar").attr("src", "../img/products/default_product.jpg");
		$("#vaciarImgArticuloEditar").hide();
	}
});

function comprobarNombreFotoEnBD(foto) {
	$.ajax({
		url: "../php/stock/counting/verificarNombreFoto.php",
		type: "post",
		data: {
			nombre: foto,
		},
		success: function (data) {
			if (data == "1") {
				$("#nombreFotoOcupado").html("Renombrar imagen");
			} else {
				$("#nombreFotoOcupado").html("");
			}
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//render imagen preview
$(document).on("change", "#modalAgregarArticuloFoto", function (input) {
	if ($(this).val() != "") {
		var reader = new FileReader();
		reader.readAsDataURL(document.getElementById("modalAgregarArticuloFoto").files[0]);
		reader.onload = function (e) {
			document.getElementById("previewArticulo").src = e.target.result;
		};
		$("#vaciarImgArticulo").show();
	} else {
		$("#previewArticulo").attr("src", "../img/products/default_product.jpg");
		$("#vaciarImgArticulo").hide();
	}
});

//vaciar imagen
$(document).on("click", "#vaciarImgArticulo", function () {
	$("#modalAgregarArticuloFoto").val("");
	$("#previewArticulo").attr("src", "../img/products/default_product.jpg");
	$("#vaciarImgArticulo").hide();
});

//vaciar imagen
$(document).on("click", "#vaciarImgArticuloEditar", function () {
	$("#modalModificarArticuloFoto").val("");
	$("#previewArticuloEditar").attr("src", "../img/products/default_product.jpg");
	$("#vaciarImgArticuloEditar").hide();
});

//agregar existencia (VALIDACION)
$(document).on("click", "#modalAgregarArticuloGuardar", () => {
	if ($("#modalAgregarArticuloNombre").val() == "" || $("#modalAgregarArticulosCantidad").val() == "") {
		if ($("#modalAgregarArticuloNombre").val() == "") {
			$("#modalAgregarArticuloNombre").addClass("is-invalid bg-rojoClaro");
		}
		if ($("#modalAgregarArticulosCantidad").val() == "") {
			$("#modalAgregarArticulosCantidad").addClass("is-invalid bg-rojoClaro");
		}
		$("#modalAgregarArticuloGuardar").attr("disabled", true);
		setTimeout(function () {
			$("#modalAgregarArticuloNombre").removeClass("is-invalid bg-rojoClaro");
			$("#modalAgregarArticulosCantidad").removeClass("is-invalid bg-rojoClaro");
			$("#modalAgregarArticuloGuardar").removeAttr("disabled");
		}, 1500);
	} else {
		if ($("#modalAgregarArticuloFoto").val() != "") {
			nombreFoto = $("#modalAgregarArticuloFoto")[0].files[0].name;
			if (
				$("#modalAgregarArticuloFoto")[0].files[0].type != "image/png" ||
				$("#modalAgregarArticuloFoto")[0].files[0].type != "image/jpeg" ||
				$("#modalAgregarArticuloFoto")[0].files[0].type != "image/jpg" ||
				$("#modalAgregarArticuloFoto")[0].files[0].type != "image/gif"
			) {
				if ($("#modalAgregarArticuloFoto")[0].files[0].size <= 28000000) {
					$("#modalAgregarArticuloGuardar").attr("disabled", true);
					$("#modalAgregarArticuloAnular").hide();
					$("#modalAgregarArticuloGuardar").html('<i class="fas fa-spinner rotar"></i>');
					cargarFoto();
				} else {
					$("#modalAgregarArticuloFotoInfo").html('<small class="ml-2 text-danger">Solo archivos .jpg, .jpeg, .gif menores a 3.5MB</small>');
				}
			} else {
				$("#modalAgregarArticuloFotoInfo").html('<small class="ml-2 text-danger">Solo archivos .jpg, .jpeg, .gif menores a 3.5MB</small>');
			}
		} else {
			guardarArticulo();
		}
	}
});

//ajustar miles precio costo
$(document).on("change", "#modalAgregarArticuloPrecioCosto", function () {
	$(this).val(separadorDeMiles($(this).val()));
});

//cargar existencia
function guardarArticulo() {
	if ($("#modalAgregarArticuloActivo").prop("checked")) {
		estado = "1";
	} else {
		estado = "0";
	}
	$.ajax({
		url: "../php/stock/inputOutput/guardarArticulo.php",
		type: "post",
		data: {
			grupo: $("#modalAgregarArticuloGrupo").val(),
			rubro: $("#modalAgregarArticuloGrupo option:selected").attr("data-rubro"),
			codBarras: $("#modalAgregarArticuloCod_Barras").val(),
			nombre: $("#modalAgregarArticuloNombre").val(),
			img: nombreFoto,
			stockMin: $("#modalAgregarArticulosStockMin").val(),
			observaciones: $("#modalAgregarArticuloObservaciones").val(),
			activo: estado,
		},
		success: function (data) {
			if (data == "1") {
				$("#articulos").click();
				$("#modalAgregarArticulo").modal("hide");
				$("#modalAgregarArticulo input, #modalAgregarArticulo select, #modalAgregarArticulo textarea").each(function () {
					$(this).val("");
				});
				$("#modalAgregarArticulosStockMin").val("1");
				if (!$("#modalAgregarArticuloActivo").prop("cheched")) {
					$("#modalAgregarArticuloActivo").click();
				}
				$("#modalAgregarArticuloGuardar").html("Guardar");
			} else if (data == "0") {
				$("#contenedorCategoriaStock").html(errorMsg);
			}
		},
		error: function (data) {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//subir foto
function cargarFoto() {
	var formData = new FormData();
	formData.append("file", $("#modalAgregarArticuloFoto")[0].files[0]);
	$.ajax({
		url: "../php/stock/inputOutput/cargarImagen.php",
		type: "post",
		data: formData,
		contentType: false,
		processData: false,
		success: function (data) {
			guardarArticulo();
			$("#modalAgregarArticuloGuardar").removeAttr("disabled");
		},
		error: function (data) {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//ver existencia
function verExistencia(str, esLente) {
	$.ajax({
		url: "../php/stock/counting/verArticulo.php",
		type: "post",
		data: {
			id: str,
			tipo: esLente,
		},
		success: function (data) {
			$("#modalVerExistenciaDetalles").html(data);
			$("#modalVerExistencia input, #modalVerExistencia select, #modalVerExistencia textarea").each(function () {
				$(this).attr("disabled", true);
			});
			$("#modalVerExistencia").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//modificar existencia (MODAL)
function editarExistencia(str) {
	articuloSeleccionado = str;
	$.ajax({
		url: "../php/stock/counting/buscarArticulo.php",
		type: "post",
		data: {
			id: str,
		},
		success: function (data) {
			$("#respuestaModalModificarArticulo").html(data);
			setTimeout(function () {
				$("#divFileImagenEditar").hide();
				$("#modalModificarArticulo").modal("show");
			}, 300);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//eliminar item (MODAL)
function eliminarExistencia(id) {
	articuloSeleccionado = id;
	$("#modalEliminarArticuloSeleccion").val("0");
	$("#modalEliminarArticuloBoton").attr("disabled", true);
	$("#modalEliminarArticulo").modal("show");
}

//habilitar boton eliminar
$(document).on("change", "#modalEliminarArticuloSeleccion", () => {
	if ($("#modalEliminarArticuloSeleccion").val() == "1") {
		$("#modalEliminarArticuloBoton").removeAttr("disabled");
	} else {
		$("#modalEliminarArticuloBoton").attr("disabled", true);
	}
});

//eliminar ítem
$(document).on("click", "#modalEliminarArticuloBoton", () => {
	$.ajax({
		url: "../php/stock/counting/eliminarArticulo.php",
		type: "post",
		data: {
			id: articuloSeleccionado,
		},
		success: function (data) {
			if (data == "1") {
				$("#articulos").click();
				$("#modalEliminarArticulo").modal("hide");
			} else {
				$("#contenedorCategoriaStock").html(errorMsg);
			}
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
});

//actualizar existencia
$(document).on("click", "#modalModificarArticuloBoton", () => {
	if ($("#modalModificarArticuloNombre").val() == "") {
		if ($("#modalModificarArticuloNombre").val() == "") {
			$("#modalModificarArticuloNombre").addClass("is-invalid bg-rojoClaro");
		}
		$("#modalModificarArticuloBoton").attr("disabled", true);
		setTimeout(() => {
			$("#modalModificarArticuloNombre").removeClass("is-invalid bg-rojoClaro");
			$("#modalModificarArticuloCodigoBarras").removeClass("is-invalid bg-rojoClaro");
			$("#modalModificarArticuloBoton").removeAttr("disabled");
		}, 1500);
	} else {
		if ($("#modalModificarArticuloEstado").prop("checked")) {
			estado = "1";
		} else {
			estado = "0";
		}

		$.ajax({
			url: "../php/stock/counting/actualizarArticulo.php",
			type: "post",
			data: {
				id: articuloSeleccionado,
				grupo: $("#modalModificarArticuloGrupo").val(),
				rubro: $("#modalModificarArticuloGrupo option:selected").attr("data-rubro"),
				cod_barras: $("#modalModificarArticuloCodigoBarras").val(),
				nombre: $("#modalModificarArticuloNombre").val(),
				img: nombreFoto,
				stockMin: $("#modalModificarArticuloStockMin").val(),
				observacion: $("#modalModificarArticuloObs").val(),
				activo: estado,
			},
			success: function (data) {
				console.log(data);
				if (data == 1) {
					if ($("#modalModificarArticuloFoto").val() != "") {
						subirFotoParaActualizar();
					}
					$("#articulos").click();
					$("#modalModificarArticulo").modal("hide");
				}
			},
			error: function () {
				$("#contenedorCategoriaStock").html(errorMsg);
			},
		});
	}
});

function subirFotoParaActualizar() {
	var formData = new FormData();
	formData.append("file", $("#modalModificarArticuloFoto")[0].files[0]);
	formData.append("id", articuloSeleccionado);
	$.ajax({
		url: "../php/stock/inputOutput/actualizarImagen.php",
		type: "post",
		data: formData,
		contentType: false,
		processData: false,
		success: function (data) {
			console.log(data);
			if (data == "1") {
				ohSnap("Imagen actualizada.", {
					duration: "3500",
					color: "green",
				});
			} else {
				ohSnap("No se pudo actualizar la imagen", {
					duration: "3500",
					color: "red",
				});
			}
		},
		error: function (data) {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//buscar insumos movil
$(document).on("change keyup", "#buscarExistenciasMovil", function () {
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
		$(".insumoFilaMovil").each(function () {
			$(this).show();
			cantidad++;
		});
	} else {
		$(".insumoFilaMovil").each(function () {
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

	$("#existenciasEncontradasMovil").html("<h6>Encontrados: " + cantidad + "</h6>");
});

//#endregion

//#region ENTRADAS Y SALIDAS

//cargar contenido
// $("#entradasSalidas").on("click", () => {
// 	$.ajax({
// 		url: "../php/stock/inputOutput/entradasSalidas.html",
// 		success: function (data) {
// 			$("#contenedorCategoriaStock").html(data);
// 			buscarItems();
// 			buscarItemsMovil();
// 		},
// 		error: function () {
// 			$("#contenedorCategoriaStock").html(errorMsg);
// 		},
// 	});
// });

//buscar items
// function buscarItems() {
// 	$.ajax({
// 		url: "../php/stock/inputOutput/buscarItems.php",
// 		success: function (data) {
// 			$("#contendio_tabla-egresos").html(data);
// 		},
// 		error: function () {
// 			$("#contenedorCategoriaStock").html(errorMsg);
// 		},
// 	});
// }

//buscar items
function buscarItemsMovil(item) {
	$.ajax({
		url: "../php/stock/inputOutput/buscarItemsMovil.php",
		type: "post",
		data: {
			str: item,
		},
		success: function (data) {
			$("#resultadoentradasSalidasEncontradasMovil").html(data);
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//actualizar exsitecnias
// $(document).on("click", "#modalItemAltaBajaBoton", () => {
// 	$.ajax({
// 		url: "../php/stock/inputOutput/actualizarExistencias.php",
// 		type: "post",
// 		data: {
// 			id: insumoSeleccionadoExistencias,
// 			accion: $("#modalItemAltaBajaAccion").val(),
// 			cantidad: $("#modalItemAltaBajaCantidad").val(),
// 		},
// 		beforeSend: function () {
// 			$("#modalItemAltaBajaBoton").attr("disabled", "disabled");
// 			$("#modalItemAltaBajaAnular").hide();
// 			$("#resultadoBusquedaAltaBaja").html(
// 				'<tr><td colspan="5" class="text-center"><h3><i class="fas fa-spinner text-success rotar"></i></h3></td></tr>'
// 			);
// 			notificarBajoStock();
// 		},
// 		success: function (data) {
// 			if (data == "1") {
// 				$("#entradasSalidas").click();
// 				$("#modalItemAltaBaja").modal("hide");
// 			} else {
// 				$("#contenedorCategoriaStock").html(errorMsg);
// 			}
// 		},
// 		error: function () {
// 			$("#contenedorCategoriaStock").html(errorMsg);
// 		},
// 	});
// });

//notificar bajo stock
function notificarBajoStock() {
	$.ajax({
		url: "../php/stock/mail/stockBajo.php",
		success: function (data) {
			console.log(data);
			if (data == "1") {
				verProductosBajos();
			}
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//ver productos bajos
function verProductosBajos() {
	$.ajax({
		url: "../php/stock/inputOutput/bajoStock.php",
		success: function (data) {
			$("#modalBajoStockContenido").html(data);
			$("#modalBajoStock").modal("show");
		},
		error: function () {
			$("#contenedorCategoriaStock").html(errorMsg);
		},
	});
}

//buscar insumo
$(document).on("keyup", "#buscarAltaBaja", function () {
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
		$(".altaBajaFila").each(function () {
			$(this).show();
			cantidad++;
		});
	} else {
		$(".altaBajaFila").each(function () {
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

	$("#entradasSalidasEncontradas").html("<h6>Encontrados: " + cantidad + "</h6>");
});

//buscar insumos movil
$(document).on("change keyup", "#buscarAltaBajaMovil", function () {
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
		$(".altaBajaFilaMovil").each(function () {
			$(this).show();
			cantidad++;
		});
	} else {
		$(".altaBajaFilaMovil").each(function () {
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

	$("#entradasSalidasEncontradasMovil").html("<h6>Encontrados: " + cantidad + "</h6>");
});

//#endregion
