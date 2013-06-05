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
</head>

<body>
	<div id="wrapper">
		<div id="page">
			<div id="logo-wrap">
				<h1>Schooling Children</h1>
			</div>
			
			<div id="googft-mapCanvas"></div>
			
			<div id="filter-wrap">
				<div class="filter">
                                    <form id="district" method='post'>
					<label for="">Filter</label>
					<select name="district" id="district">
						<option value="">---Select District---</option>
						<option value="kathmandu">Kathmandu</option>
						<option value="">Kavre</option>
						<option value="">Bhaktapur</option>
						<option value="">Lalitpur</option>
						<option value="">Nuwakot</option>
					</select>
                                    </form>
				</div>
				<div class="chart">
                                <?php if(isset($_GET['district'])):?>
                                <?php 
                               if (($handle = fopen("data/report.csv", "r")) !== FALSE) {
                                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                        if(strtolower($data[0]) == strtolower($_GET['district'])){
                                            $out['one_to_six'] = $data[6];
                                            $out['six_to_eight'] = $data[7];
                                            $out['eight_to_ten'] = $data[8];
                                            $jsonData = json_encode($out);
                                        }
                                    }
                                    fclose($handle);
                                } else {
                                    print ('could not open');exit;
                                }
                                ?>
                                <div id="chart-data" data:json="<?php echo $jsonData;?>"></div>
                                <?php endif; ?>
				</div>
			</div>
		</div><!--End #page-->
	</div><!--End #wrapper-->
</body>
</html>