<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Schooling Children</title>

<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />

<link href='http://fonts.googleapis.com/css?family=Rokkitt' rel='stylesheet' type='text/css'>
	<style type="text/css">
html, body, #googft-mapCanvas {
height: 500px;
margin: 0;
padding-left: 100px;
padding-top: 10px;
width: 800px;
}
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
function initialize() {
var map = new google.maps.Map(document.getElementById('googft-mapCanvas'), {
center: new google.maps.LatLng(28.368583702635124, 84.40221406249998),
zoom: 7,
mapTypeId: google.maps.MapTypeId.ROADMAP
});
map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('googft-legend'));

layer = new google.maps.FusionTablesLayer({
map: map,
heatmap: { enabled: false },
query: {
select: "col8\x3e\x3e0",
from: "1zUbm15-uPO2EUmSw481zJEBvilzQj6FiwbuA7wo",
where: ""
},
options: {
styleId: 2,
templateId: 2
}
});
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
</head>

<body>
	<div id="wrapper">
		<div id="page">
			<div id="logo-wrap">
				<h1><img src="images/logo.png" /></h1>
			</div>
			
			<div id="googft-mapCanvas"></div>
			
			<div id="filter-wrap">
				
                                <?php if(isset($_GET['district'])):?>
                                <?php
                                $districts = array();
                                $jsonData = '';
                               if (($handle = fopen("data/report.csv", "r")) !== FALSE) {
                                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                        if(strtolower($data[0]) == strtolower($_GET['district'])){
                                            $out['one_to_six'] = $data[6];
                                            $out['six_to_eight'] = $data[7];
                                            $out['eight_to_ten'] = $data[8];
                                            $jsonData = json_encode($out);
                                        }
                                        $districts[] = strtolower($data[0]);
                                    }
                                    fclose($handle);
                                } else {
                                    print ('could not open');exit;
                                }
                                ?>
                                <div class="filter">
                                    <form id="district-form" method='get'>
					<label for="">Enrollment by District:</label>
					<select name="district" id="district" onchange="this.form.submit()">
                                            	<option value="">---Select District---</option>
                                            <?php foreach($districts as $district): ?>
						<option value="<?php echo $district;?>"><?php echo ucfirst($district) ?></option>
                                            <?php endforeach;?>
					</select>
                                    </form>
				</div>
                                <div id="chart-data" class='<?php echo $jsonData;?>'></div>
                                <?php endif; ?>
                                <div id="chart">
				</div>
                                <?php if($jsonData):?>
                                <script>
                                google.load('visualization', '1.0', {'packages':['corechart']});
                                
                                // Set a callback to run when the Google Visualization API is loaded.
                                google.setOnLoadCallback(drawChart);
                                
                                      // Callback that creates and populates a data table,
                                      // instantiates the pie chart, passes in the data and
                                      // draws it.
                                      function drawChart() {
                                        var inputData = $('#chart-data').attr('class');
                                        console.log(inputData);
                                        // Create the data table.
                                        var data = new google.visualization.DataTable();
                                        data.addColumn('string', 'Topping');
                                        data.addColumn('number', 'Slices');
                                        data.addRows([
                                          ['Level 1-6', <?php echo $out['one_to_six'];?>],
                                          ['Level 6-8', <?php echo $out['six_to_eight'];?>],
                                          ['Level 8-10', <?php echo $out['eight_to_ten'];?>],
                                        ]);
                                
                                        // Set chart options
                                        var options = {'title':'Students Enrolling in different Level',
                                                       'width':400,
                                                       'height':300};
                                
                                        // Instantiate and draw our chart, passing in some options.
                                        var chart = new google.visualization.PieChart(document.getElementById('chart'));
                                        chart.draw(data, options);
                                      }
                                      </script>
                                <? endif;?>
			</div>
		</div><!--End #page-->
	</div><!--End #wrapper-->
</body>
</html>