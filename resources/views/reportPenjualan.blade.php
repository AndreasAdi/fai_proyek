@extends('template')
@section('judul')
Report Penjualan
@endsection
@section('isi')
@isset($dataMonth)
<script>
    window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        title:{
            text: "Number of Orders"
        },
        axisY: {
            title: "Number of Orders"
        },
        data: [{        
            type: "column",  
            //showInLegend: true, 
            // legendMarkerColor: "grey",
            // legendText: "Last 12 Months",
            dataPoints: [
                { y: <?php echo $dataMonth[0]; ?>, label: "Jan" },
                { y: <?php echo $dataMonth[1]; ?>,  label: "Feb" },
                { y: <?php echo $dataMonth[2]; ?>,  label: "Mar" },
                { y: <?php echo $dataMonth[3]; ?>,  label: "Apr" },
                { y: <?php echo $dataMonth[4]; ?>,  label: "May" },
                { y: <?php echo $dataMonth[5]; ?>,  label: "Jun" },
                { y: <?php echo $dataMonth[6]; ?>,  label: "Jul" },
                { y: <?php echo $dataMonth[7]; ?>,  label: "Aug" },
                { y: <?php echo $dataMonth[8]; ?>,  label: "Sep" },
                { y: <?php echo $dataMonth[9]; ?>,  label: "Oct" },
                { y: <?php echo $dataMonth[10]; ?>,  label: "Nov" },
                { y: <?php echo $dataMonth[11]; ?>,  label: "Des" },
            ]
        }]
    });
    chart.render();
    var chart2 = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        title:{
            text: "Ammount of Orders"
        },
        axisY: {
            title: "Ammount of Orders"
        },
        data: [{        
            type: "column",  
            //showInLegend: true, 
            // legendMarkerColor: "grey",
            // legendText: "Last 12 Months",
            dataPoints: [
                { y: <?php echo $dataMonth2[0]; ?>, label: "Jan" },
                { y: <?php echo $dataMonth2[1]; ?>,  label: "Feb" },
                { y: <?php echo $dataMonth2[2]; ?>,  label: "Mar" },
                { y: <?php echo $dataMonth2[3]; ?>,  label: "Apr" },
                { y: <?php echo $dataMonth2[4]; ?>,  label: "May" },
                { y: <?php echo $dataMonth2[5]; ?>,  label: "Jun" },
                { y: <?php echo $dataMonth2[6]; ?>,  label: "Jul" },
                { y: <?php echo $dataMonth2[7]; ?>,  label: "Aug" },
                { y: <?php echo $dataMonth2[8]; ?>,  label: "Sep" },
                { y: <?php echo $dataMonth2[9]; ?>,  label: "Oct" },
                { y: <?php echo $dataMonth2[10]; ?>,  label: "Nov" },
                { y: <?php echo $dataMonth2[11]; ?>,  label: "Des" },
            ]
        }]
    });
    chart2.render();
    }
</script>
@endisset



<div class="container mt-5  text-success">
    <form action="{{url('/user/prosesReportPenjualan')}}" method="POST">
        @csrf
        <label>Pilih Tahun</label>
    <select name="tahun" class="form-control w-25">
        <?php 
          $right_now = getdate();
          $this_year = $right_now['year'];
          $start_year = 2010;
          while ($start_year <= $this_year) {
              if ($start_year == 2020) {
                echo "<option selected>{$start_year}</option>";
              }
              else {
                echo "<option>{$start_year}</option>";
              }
              
              $start_year++;
          }
         ?> 
    </select>
    <button type="submit" class="btn btn-success mt-2">Cetak</button>
    </form>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div><br><br>
    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
</div>
<br><br><br>

@endsection
