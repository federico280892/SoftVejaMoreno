////////////////////////////////////VARIABLES GLOBALES////////////////////////////////////

//////////////////////////////////////MASCARAS//////////////////////////////////////

//#region turnos
//$("#modalNuevoPacienteDNI").mask('00000000', {placeholder: '00000000'});

//#endregion

//////////////////////////////////////FIN MASCARAS//////////////////////////////////////

//////////////////////////////////ADMINISTRACION////////////////////////////////////

//cargar administracion del tema
$(document).on("click", "#administracionTema", function(){
    $.ajax({
        url: '../php/generalSettings/ajustarTema.php',
        success: function(data){
            $("#contenedorCategoriaConfiguracionGeneral").html(data);
        },
        error: function(){
          $("#contenedorCategoriaConfiguracionGeneral").html(errorMsg);
        }
    })
})


//cambiar color de tema
$(document).on("change", "#colorTema", function(){
    const usuario = $(this).attr("data-user");
    $.ajax({
        url: '../php/generalSettings/cambiarTema.php',
        type: 'post',
        data: {
            themeColor: $("#colorTema").val(),
            user: usuario
        },
        success: function(data){
            if(data == "1"){
                loadTheme(usuario);
            }else{
                $("#contenedorCategoriaConfiguracionGeneral").html(errorMsg);
            }
        },
        error: function(){
            $("#contenedorCategoriaConfiguracionGeneral").html(errorMsg);
        }
    })
})

//cambiar color de fuente
$(document).on("change", "#colorFont", function(){
    const usuario = $(this).attr("data-user");
    $.ajax({
        url: '../php/generalSettings/cambiarFuente.php',
        type: 'post',
        data: {
            fontColor: $("#colorFont").val(),
            user: usuario
        },
        success: function(data){
            if(data == "1"){
                loadTheme(usuario);
            }else{
                $("#contenedorCategoriaConfiguracionGeneral").html(errorMsg);
            }
        },
        error: function(){
            $("#contenedorCategoriaConfiguracionGeneral").html(errorMsg);
        }
    })
})

//cargar tema
function loadTheme(str){
    $.ajax({
        url: '../php/generalSettings/cargarTema.php',
        type: 'post',
        data: {
            user: str
        },
        success: function(data){
            //console.log(data);
            $("#coloresDeTema").html(data);
        },
        error: function(){
            $("#contenedorCategoriaConfiguracionGeneral").html(errorMsg);
        }
    })
}


//////////////////////////////////FIN ADMINISTRACION////////////////////////////////////