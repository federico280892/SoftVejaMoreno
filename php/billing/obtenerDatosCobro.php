<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    
    $pago = mysqli_query($veja, "SELECT * FROM pagos WHERE id = '".$_POST['id']."'");
    while($p = mysqli_fetch_assoc($pago)){
        $detalles = mysqli_query($veja, "SELECT codigo, apellido, nombre FROM medicos WHERE id = '".$p['id_medico']."'");
        while($m = mysqli_fetch_assoc($detalles)){
            $medico = $m['codigo']." - ".$m['apellido']." ".$m['nombre'];
        }
        $datos = mysqli_query($veja, "SELECT DNI, apellido, nombre FROM pacientes WHERE id = '".$p['id_paciente']."'");
        while($dP = mysqli_fetch_assoc($datos)){
            $paciente = $dP['DNI']." - ".$dP['apellido']." ".$dP['nombre'];
        }
        echo $p['num_cobro']."|".
        $p['id_turno']."|".
        $p['fecha_turno']."|".
        $medico."|".
        $paciente."|".
        $p['fecha_cobro']."|".
        $p['control']."|".
        $p['cobertura']."|".
        $p['coseguro']."|";

            $prestaciones = mysqli_query($veja, "SELECT prestaciones.codigo AS 'codigo',
            prestaciones.descripcion AS 'prestacion',
            pagos_prestaciones.cantidad AS 'cantidad',
            convenios.precio_fijo AS 'precio'
            FROM pagos_prestaciones
            INNER JOIN convenios
            ON convenios.id_prestacion = pagos_prestaciones.id_prestacion
            INNER JOIN prestaciones
            ON prestaciones.id = pagos_prestaciones.id_prestacion
            WHERE pagos_prestaciones.id_pago = '".$_POST['id']."'
            AND pagos_prestaciones.id_cobertura_social = convenios.id_cobertura_social");
            while($prestacion = mysqli_fetch_assoc($prestaciones)){
                echo '<tr>
                    <td class="text-left">'.$prestacion['codigo'].'</td>
                    <td class="text-left">'.$prestacion['prestacion'].'</td>
                    <td class="text-center">'.$prestacion['cantidad'].'</td>
                    <td class="text-center">'.number_format($prestacion['precio'], 2, ',', '.').'</td>
                    <td class="text-center">'.number_format((floatval($prestacion['precio']) * floatval($prestacion['cantidad'])), 2, ',', '.').'</td>
                </tr>';
            }

        echo "|".$p['trae_orden']."|".
        $p['n_carnet']."|".
        $p['n_orden']."|".
        $p['id_autorizacion']."|".
        $p['amb_int']."|";

        $cobros = mysqli_query($veja, "SELECT * FROM pagos_metodos_de_pago WHERE id_pago = '".$_POST['id']."'");
        if(mysqli_num_rows($cobros) == 0){
            echo '<tr>
                <td colspan=8 class="text-center">El Turno se Cobró Sin Metodos de Pago</td>
            </tr>';
        }else{
            while($cobro = mysqli_fetch_assoc($cobros)){
                $pago = mysqli_query($veja, "SELECT pago FROM formas_pago WHERE id = '".$cobro['id_metodo_pago']."'");
                while($fP = mysqli_fetch_assoc($pago)){
                    $metodo = $fP['pago'];
                }
                $bancos = mysqli_query($veja, "SELECT nombre FROM bancos WHERE id = '".$cobro['banco']."'");
                while($fB = mysqli_fetch_assoc($bancos)){
                    $banco = $fB['nombre'];
                }
                echo '<tr>
                    <td class="text-left">'.$metodo.'</td>
                    <td class="text-left">'.$banco.'</td>
                    <td class="text-left">'.$cobro['localidad'].'</td>
                    <td class="text-center">'.$cobro['n_cuenta'].'</td>
                    <td class="text-center">'.$cobro['n_cheque'].'</td>
                    <td class="text-center">'.$cobro['f_emision'].'</td>
                    <td class="text-center">'.$cobro['f_vencimiento'].'</td>
                    <td class="text-center">'.number_format($cobro['monto'], 2, ',', '.').'</td>
                </tr>';
            }
        }

        echo "|".$p['observacion'];
    }

    mysqli_close($veja);
}
?>