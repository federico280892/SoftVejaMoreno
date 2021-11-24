<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    echo '<script>
    //tabla completar comprobante
	$("#tabla-completar-comprobante").DataTable({
		ordering: true,
		searching: true,
		info: true,
		pageLength: 10,
		// "lengthMenu": [4],
		bInfo: false,
		// "paging": false,
		autoWidth: true,
		bPaginate: true,
		bSort: false,
		language: {
			"decimal": "",
			"emptyTable": "No hay datos registrados",
			"info": "Mostrando _START_ de _END_ de un total de _TOTAL_ registros",
			"info": "Mostrando un total de _TOTAL_ registros",
			"infoEmpty": "No existen registros cargados",
			"infoFiltered": "(Filtrado de un total de _MAX_ registros)",
			"infoPostFix": "",
			"thousands": ",",
			"lengthMenu": "Mostrando _MENU_ registros por página",
			"loadingRecords": "Cargando...",
			"processing": "Procesando...",
			"search": "Buscar:",
			"zeroRecords": "No existen coincidencias",
			"paginate": {
				"first": "Primero",
				"last": "Último",
				"next": "Siguiente",
				"previous": "Anterior",
			},
			"aria": {
				"sortAscending": ": Activado el orden de columna ascendente",
				"sortDescending": ": Activado el orden de columna descendente",
			},
		},
	})
    </script>';

    echo '<table class="table table-striped table-hover" id="tabla-completar-comprobante" style="font-size:0.9rem;">
        <thead>
        <tr>
            <th>Artículo</th>
        </tr>
        </thead>
        <tbody>';
            $peticion = mysqli_query($stock, "SELECT 
                articulos.id AS 'id',
                articulos.nombre AS 'nombre',
				rubros.dioptria AS 'dioptria'
                FROM articulos
				INNER JOIN rubros
				ON rubros.id = articulos.id_rubro
                ORDER BY articulos.id ASC");
            while($i = mysqli_fetch_assoc($peticion)){
                echo '<tr data-articulo="'.$i['id'].'" data-dioptria="'.$i['dioptria'].'" id="filaArticulo">
					<td>'.$i['nombre'].'</td>
				</tr>';
            }
        echo '</tbody>
    </table>';

    mysqli_close($stock);
}
?>