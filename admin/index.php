<?php 
include('views/header.php'); 
include('sistema.class.php');
$app=new Sistema();
$sql="select m.marca, sum(vd.cantidad*p.precio) as monto from marca m
join producto p on m.id_marca=p.id_marca
join venta_detalle vd on p.id_producto = vd.id_producto
group by m.marca
order by m.marca asc ;";
$datos=$app->query($sql);
$app->checkRol('Administrador', true);

?>
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);
  
      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Marca', 'Dinero Ganado'],
          <?php foreach ($datos as $dato):?>
          ["<?php echo $dato['marca'];?>", <?php echo $dato['monto'];?>],
          <?php endforeach;?>
        ]);

        var options = {
          title: 'Chess opening moves',
          width: 900,
          legend: { position: 'none' },
          chart: { title: 'Chess opening moves',
                   subtitle: 'popularity by percentage' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Dinero'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
    </script>
 
    <div id="top_x_div" style="width: 900px; height: 500px;"></div>

<?php include('views/footer.php'); ?>