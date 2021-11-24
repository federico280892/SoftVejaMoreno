$(document).ready(function () {
	verificarUsuariosConectados();

	//tabla consulta codigos
	$("#tabla-consultaCodigos").DataTable({
		"ordering": false,
		"language": {
			"lengthMenu": "Mostrando _MENU_ por página",
			"zeroRecords": "No se encontraron resultados - disculpe",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"search": "Buscar",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(Filtrados _MAX_ del total de registros)",
		},
	});

	//tabla convenios
	$("#tabla-convenioPrestaciones").DataTable({
		paging: false,
		ordering: false,
		searching: false,
		info: false,
		"language": {
			"zeroRecords": "Sin prestaciones cargadas",
		},
	});

	//ingresar a receptcion
	shortcut.add("alt+r", function () {
		$("#ABMMedic").click();
	});

	//asignar turnos
	shortcut.add("alt+t", function () {
		$("#asignarTurno").click();
		setTimeout(function () {
			$("#modalAgregarDatosPacienteDNISolicitante").focus();
		}, 200);
	});

	//ver turnos reservados
	shortcut.add("alt+v", function () {
		$("#turnosReservados-tab").click();
		setTimeout(function () {
			$("#selectTurnosPorDoctor").focus();
		}, 200);
	});

	//confirmar paciente selccionado
	shortcut.add("alt+c", function () {
		$("#modalEditarPacienteContinuar").click();
		setTimeout(function () {
			$("#nuevoTurnoMedicoNombre").focus();
		}, 200);
	});

	//confirmar paciente selccionado
	shortcut.add("f8", function () {
		if ($("#agregarFormaDePago").css("display") == "none") {
			$("#tabla-pmo .dataTables_empty, #modalCobrarTurnoInfoSinPrestacion").html(
				"<span class='text-danger'>No puedes guardar un cobro sin agregar una prestación</span>"
			);
		} else {
			$.ajax({
				url: "../php/billing/sesionesPrestaciones.php",
				success: function (data) {
					fecha = new Date();
					mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
					dia = ("0" + fecha.getDate()).slice(-2);
					hoy = fecha.getFullYear() + "-" + mes + "-" + dia;
					$("#modalAgregarFormaDePagoFechaActual").val(hoy);
					$("#modalAgregarFormaDePagoSaldoParcial").val(data);
					setTimeout(function () {
						$("#modalAgregarFormaDePagoConfirmar").click();
					}, 300);
				},
			});
		}
	});

	//confirmar paciente selccionado
	shortcut.add("f9", function () {
		$("#modalCobrarTurnoBoton").click();
	});

	//#region cerrar todas las secciones
	function closeAllSections() {
		$("#menuGeneral").hide();
		$(".fa-hospital-alt").show();
		if ($("#seccionPrincipal").hasClass("show")) {
			$("#seccionPrincipal").removeClass("show");
		}
		if ($("#seccionABMMedicos").hasClass("show")) {
			$("#seccionABMMedicos").removeClass("show");
		}
		if ($("#seccionHistoriaClinica").hasClass("show")) {
			$("#seccionHistoriaClinica").removeClass("show");
		}
		if ($("#seccionFacturacion").hasClass("show")) {
			$("#seccionFacturacion").removeClass("show");
		}
		if ($("#seccionAdministracion").hasClass("show")) {
			$("#seccionAdministracion").removeClass("show");
		}
		if ($("#seccionStock").hasClass("show")) {
			$("#seccionStock").removeClass("show");
		}
		if ($("#seccionTesoreria").hasClass("show")) {
			$("#seccionTesoreria").removeClass("show");
		}
	}
	//#endregion

	$(document).on("click", ".fa-hospital-alt", function () {
		closeAllSections();
		$("#menuGeneral").show();
		$(".fa-hospital-alt").hide();
	});

	//#region SECCION PRINCIPAL
	$("#principalItem").on("click", function () {
		console.log("SECCION PRINCIPAL INVOCADA");
		closeAllSections();
		// if (sidebarStatus == true) {
		// 	$("#sidebar_btn").click();
		// }
		//sidebarStatus = !sidebarStatus;
		//cambiarIconoSidebar();
	});

	//seccion recepcion
	$("#ABMMedic").on("click", function () {
		console.log("SECCION RECEPCIÓN INVOCADA");
		closeAllSections();
		// if (sidebarStatus == true) {
		// 	$("#sidebar_btn").show();
		// }
		// sidebarStatus = !sidebarStatus;
		// cambiarIconoSidebar();
	});

	//seccion historia clinica
	$("#clinicHistoryItem").on("click", function () {
		console.log("SECCION HISTORICA CLINICA INVOCADA");
		closeAllSections();
		// if (sidebarStatus == true) {
		// 	$("#sidebar_btn").click();
		// }
		// sidebarStatus = !sidebarStatus;
		// cambiarIconoSidebar();
	});

	//seccion facturacion
	$("#bilingItem").on("click", function () {
		console.log("SECCION FACTURACION INVOCADA");
		closeAllSections();
		// if (sidebarStatus == true) {
		// 	$("#sidebar_btn").click();
		// }
		// sidebarStatus = !sidebarStatus;
		// cambiarIconoSidebar();
	});

	//seccion administracion
	$("#administrationItem").on("click", function () {
		console.log("SECCION ADMNISTRACION INVOCADA");
		closeAllSections();
		// if (sidebarStatus == true) {
		// 	$("#sidebar_btn").click();
		// }
		// sidebarStatus = !sidebarStatus;
		// cambiarIconoSidebar();
	});

	//seccion stock
	$("#stockItem").on("click", function () {
		console.log("SECCION STOCK INVOCADA");
		closeAllSections();
		// if (sidebarStatus == true) {
		// 	$("#sidebar_btn").click();
		// }
		// sidebarStatus = !sidebarStatus;
		// cambiarIconoSidebar();
	});

	//seccion stock
	$("#tesoreriaItem").on("click", function () {
		console.log("SECCION TESORERIA INVOCADA");
		closeAllSections();
		// if (sidebarStatus == true) {
		// 	$("#sidebar_btn").click();
		// }
		// sidebarStatus = !sidebarStatus;
		// cambiarIconoSidebar();
	});

	//#endregion

	//#region MENU GENERAL
	$("#menuGeneralPrincipal").on("click", function () {
		$("#principalItem").click();
		//$(".content").css("margin-left", "95px");
	});
	$("#menuGeneralRecepcion").on("click", function () {
		$("#ABMMedic").click();
		//$(".content").css("margin-left", "95px");
	});
	$("#menuGeneralHistoria").on("click", function () {
		$("#clinicHistoryItem").click();
		//$(".content").css("margin-left", "0px");
	});
	$("#menuGeneralFacturacion").on("click", function () {
		$("#bilingItem").click();
		//$(".content").css("margin-left", "0px");
	});
	$("#menuGeneralAdministracion").on("click", function () {
		$("#administrationItem").click();
		//$(".content").css("margin-left", "0px");
	});
	$("#menuGeneralStock").on("click", function () {
		$("#stockItem").click();
		//$(".content").css("margin-left", "0px");
	});

	$("#menuGeneralTesoreria").on("click", function () {
		$("#tesoreriaItem").click();
		//$(".content").css("margin-left", "0px");
	});
	//#endregion

	////////////////////////////////////MASCARAS////////////////////////////////////
	$("#modalAgregarCoberturaSocialCel").mask("(000)000-0000", {placeholder: "(000)000-0000"});
	$("#modalAgregarCoberturaSocialTel").mask("(0000)000000", {placeholder: "(0000)000000"});
	////////////////////////////////////FIN MASCARAS////////////////////////////////////
});

//funcion separador de miles
function separadorDeMiles(num) {
	if (!num || num == "NaN") return "-";
	if (num == "Infinity") return "&#x221e;";
	num = num.toString().replace(/\$|\,/g, "");
	if (isNaN(num)) num = "0";
	sign = num == (num = Math.abs(num));
	num = Math.floor(num * 100 + 0.50000000001);
	cents = num % 100;
	num = Math.floor(num / 100).toString();
	if (cents < 10) cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
		num = num.substring(0, num.length - (4 * i + 3)) + "." + num.substring(num.length - (4 * i + 3));
	return (sign ? "" : "-") + num + "," + cents;
}
