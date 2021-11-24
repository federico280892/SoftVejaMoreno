<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $color = mysqli_query($veja, "SELECT theme_color, font_theme_color FROM users WHERE id = '".$_POST['user']."' LIMIT 1");
    while($c = mysqli_fetch_assoc($color)){
      $theme_color = $c['theme_color'];
      $font_theme_color = $c['font_theme_color'];
      $fixed_theme_color = explode(",", $theme_color);
      $dark15 = ($fixed_theme_color[0] - 19).', '.($fixed_theme_color[1] - 57).', '.($fixed_theme_color[2] - 36);
      $dark10 = ($fixed_theme_color[0] - 13).', '.($fixed_theme_color[1] - 38).', '.($fixed_theme_color[2] - 24);
      $dark20 = ($fixed_theme_color[0] - 25).', '.($fixed_theme_color[1] - 77).', '.($fixed_theme_color[2] - 48);
      $lighten10 = ($fixed_theme_color[0] + 13).', '.($fixed_theme_color[1] + 38).', '.($fixed_theme_color[2] + 24);
      echo 'body{
          background: rgba('.$theme_color.', 0.3);
        }

        .header{
          background: rgb('.$theme_color.');
        }
        
        .nav-tabs .nav-link{
          color: rgb('.$theme_color.');
        }

        .nav-tabs .nav-link.active{
          color: rgb('.$dark20.');
        }

        .modal .modal-header{
          background: rgb('.$theme_color.');
          color: rgb('.$font_theme_color.');
        }

        .content #seccionABMMedicos nav .navbar-brand, .content #seccionPrincipal nav .navbar-brand, .content #seccionAdministracion nav .navbar-brand, .content #contenedorCategoriaConfiguracionGeneral nav .navbar-brand{
          color: rgb('.$dark10.');
        }

        .content #turnosReservados table thead tr{
          color: rgb('.$font_theme_color.');
        }

        .header .fa-hospital-alt{
          color: rgb('.$font_theme_color.'); 
        }
        
        .header #veja_moreno{
          color: rgb('.$font_theme_color.'); 
        }

        .content #menuGeneral .categoria i{
          background: rgb('.$theme_color.');
          color: rgb('.$font_theme_color.'); 
        }

        .content #seccionABMMedicos #calendario .fc-highlight, .content #seccionPrincipal #calendario .fc-highlight {
          background: rgba('.$dark10.', 0.5);
        }

        .content #seccionABMMedicos #calendario .fc-scrollgrid-sync-inner .fc-col-header-cell-cushion, .content #seccionPrincipal #calendario .fc-scrollgrid-sync-inner .fc-col-header-cell-cushion {
          color: rgb('.$font_theme_color.');
        }

        .content #seccionABMMedicos #calendario .fc-day-today, .content #seccionPrincipal #calendario .fc-day-today {
          background: rgb('.$dark15.');
        }

        .urgencia{
          color: rgb('.$font_theme_color.');
        }';
    }
    mysqli_close($veja);
}
?>




