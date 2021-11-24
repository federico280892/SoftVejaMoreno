<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $subtotal = 0;
    $total = 0;
    $fechaCarga = "";
    echo '<script>
    $("#tabla-consulta-comprobante").DataTable({
		paging: false,
		ordering: false,
		searching: false,
		info: false,
		"language": {
			"zeroRecords": "Sin prestaciones cargadas",
		},
	});
    </script>';

    echo '<table id="tabla-consulta-comprobante" class="table table-striped table-hover" style="font-size:0.9rem;">
        <thead>
            <tr>
                <th class="text-left" style="min-width:95px;">Artículo</th>
                <th class="text-left" style="min-width:95px;">Grupo</th>
                <th class="text-left">Marca</th>
                <th class="text-center">Lote</th>
                <th class="text-center">Vencimiento</th>
                <th class="text-center" style="width: 65px;">P Costo</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Subtotal</th>
            </tr>
        </thead>
        <tbody>';
        $peticion = mysqli_query($stock, "SELECT 
        articulos.nombre AS 'nombre',
        grupos.nombre AS 'grupo',
        articulos.marca AS 'marca',
        articulos.n_lote AS 'lote',
        articulos.vencimiento AS 'vencimiento',
        existencias.cantidad AS 'stock',
        articulos.precio_costo AS 'precio_costo',
        cantidades_cargadas.cantidad_cargada AS 'cantidad_cargada',
        comprobantes.fecha_carga AS 'fecha_carga'
        FROM cantidades_cargadas
        INNER JOIN articulos
        ON articulos.id = cantidades_cargadas.id_articulo
        INNER JOIN grupos
        ON grupos.id = articulos.id_grupo
        INNER JOIN existencias
        ON existencias.id_articulo = articulos.id
        INNER JOIN comprobantes
        ON comprobantes.id = '".$_POST['comprobante']."'
        WHERE cantidades_cargadas.id_comprobante = '".$_POST['comprobante']."'");

        while($c = mysqli_fetch_assoc($peticion)){
            $fechaCarga = $c['fecha_carga'];
            $subtotal = (floatval($c['precio_costo'])*floatval($c['cantidad_cargada']));
            echo '<tr>
            <td>'.$c['nombre'].'</td>
            <td>'.$c['grupo'].'</td>
            <td>'.$c['marca'].'</td>
            <td>'.$c['lote'].'</td>';
            if($c['vencimiento'] == "" || $c['vencimiento'] == "-"){
                echo '<td class="text-center">-</td>';
            }else{
                echo '<td class="text-center">'.date("d-m-Y", strtotime($c['vencimiento'])).'</td>';
            }
            
            echo '<td class="text-right">'.number_format($c['precio_costo'], 2, ',', '.').'</td>
            <td class="text-center">'.$c['cantidad_cargada'].'</td>';
            echo '<td class="text-right">'.number_format($subtotal, 2, ',', '.').'</td>
            </tr>';
            $total += $subtotal;
        }
        echo '<tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-right">$</td>
        <td class="text-right font-weight-bold">'.number_format($total, 2, ',', '.').'</td>
        </tr>';

        echo '</tbody>
        </table>';

        $user = mysqli_query($veja, "SELECT apellido, nombre FROM users WHERE id = '".$_SESSION['id']."'");
        while($u = mysqli_fetch_assoc($user)){
            $usuario = $u['apellido'].", ".$u['nombre'];

        }

        echo '<div class="row mt-3">
            <div class="col">
                <h6>Usuario: '.$usuario.'</h6>
                <h6>Fecha De Carga: '.$fechaCarga.'</h6>
            </div>
        </div>';

    mysqli_close($stock);
}
?>