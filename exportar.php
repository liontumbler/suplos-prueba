<?php
function exportarExcel($datos) {
    // Configurar los encabezados para la descarga
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=reporte_ofertas.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Iniciar la tabla en formato Excel
    echo "<table border='1'>";
    echo "<tr>
            <th>ID oferta</th>
            <th>Creador oferta</th>
            <th>Objeto</th>
            <th>Actividad</th>
            <th>Descripción</th>
            <th>Moneda</th>
            <th>Presupuesto</th>
            <th>Fecha de inicio</th>
            <th>Hora de inicio</th>
            <th>Fecha de cierre</th>
            <th>Estado</th>
          </tr>";

    // Agregar los datos al archivo Excel
    foreach ($datos as $fila) {
        echo "<tr>
                <td>{$fila['id_oferta']}</td>
                <td>{$fila['creador_oferta']}</td>
                <td>{$fila['objeto']}</td>
                <td>{$fila['actividad']}</td>
                <td>{$fila['descripcion']}</td>
                <td>{$fila['moneda']}</td>
                <td>{$fila['presupuesto']}</td>
                <td>{$fila['fecha_inicio']}</td>
                <td>{$fila['hora_inicio']}</td>
                <td>{$fila['fecha_cierre']}</td>
                <td>{$fila['estado']}</td>
              </tr>";
    }

    echo "</table>";
    exit;
}
?>