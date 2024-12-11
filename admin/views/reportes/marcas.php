<?php
$content="
<img src='../images/logo.png'>
<h1>Listado de Marcas</h1>
<p> Se encontraron ". count($datos)." marcas</p>
<table>
<thead>
<tr>
<th>Id</th>
<th>Marca</th>
</tr>
</thead>
<tbody>
";
foreach ($datos as $dato) {
    $content.="
    <tr>
    <td>".$dato['id_marca']."</td>
    <td>".$dato['marca']."</td>
    </tr>
    ";
}
$content.="</tbody>
</table>
";