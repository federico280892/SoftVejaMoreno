$(document).on("click", "#stockAppSignIn", function (e) {
	if ($("#stockAppUser").val() == "" || $("#stockAppPassowrd").val() == "") {
		e.preventDefault();
		$("#msg-box").html("<div class='alert alert-danger text-center' style='padding:2px;'><small>Debe completar sus credenciales.</small></div>");
		setTimeout(function () {
			$("#msg-box").html("");
		}, 2000);
	} else {
		$.ajax({
			url: "../checkUser.php",
			type: "post",
			data: {
				user: $("#stockAppUser").val(),
				pass: $("#stockAppPassowrd").val(),
				stock: "1",
			},
			success: function (data) {
				console.log(data);
				if (data == 1) {
					$(location).attr("href", "../../pages/principal.php");
				} else if (data == 0) {
					$("#msg-box").html(
						"<div class='alert alert-danger text-center' style='padding:2px;'><small>Sus credenciales no son correctas.</small></div>"
					);
					setTimeout(function () {
						$("#msg-box").html("");
					}, 2000);
				}
			},
			error: function () {
				$("#msg-box").html("<div class='alert alert-danger text-center' style='padding:2px;'><small>Sin acceso al servidor.</small></div>");
			},
		});
	}
});

//mostrar solo stock
function mostrarSoloStock() {
	$(".header, .columnaItem").hide();
	$(".content").css("margin-top", "-15px");
	$("#seccionStock").css("height", "100vh");
	$("#contenedorCategoriaStock .posRelativa img").css("top", "-50%");
	setTimeout(function () {
		$("#cardStock").css("height", "100%");
		$("#stockItem").click();
	}, 5);
	console.log("SOLO STOCK!!!!!!");
}
