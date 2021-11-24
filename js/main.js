//#region //DOM login
const btnLogin = document.getElementById("btn-login");
const user = document.getElementById("user");
const pass = document.getElementById("pass");
const msgBox = document.getElementById("msg-box");
//#endregion

//#region //verificar login
btnLogin.addEventListener("click", () => {
	if (user.value != "" && pass.value != "") {
		// const data = {user: user.value, pass: pass.value}
		// fetch('./php/checkUser.php', {
		//     method: 'POST',
		//     body: data
		//  }).then((data)=>{
		//     if(data == 1){
		//         $(location).attr('href','./pages/principal.php');
		//     }else if(data == 0){
		//         $("#msg-box").html("<br><div class='alert alert-danger'>Sus credenciales no son correctas.</div>");
		//     }
		//  }).catch(()=>{
		//      console.log("Error");
		//  });
		$.ajax({
			url: "./php/checkUser.php",
			type: "post",
			data: {
				user: $("#user").val(),
				pass: $("#pass").val(),
				stock: "0",
			},
			success: function (data) {
				if (data == 1) {
					$(location).attr("href", "./pages/principal.php");
				} else if (data == 0) {
					$("#msg-box").html("<br><div class='alert alert-danger'>Sus credenciales no son correctas.</div>");
				}
			},
			error: function () {
				$("#msg-box").html("<br><div class='alert alert-danger'>ERROR. Problemas con su conexión.</div>");
			},
		});
	} else {
		msgBox.innerHTML = "<br><div class='alert alert-danger'>Por favor complete los campos.</div>";
	}
});

//#endregion
