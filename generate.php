<?php
require('class.iplFixtureGenerator.php');

// Provide opponents in an array format
$teams = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');

$stadiums = array(
    'A' => 'Home Ground Team A',
    'B' => 'Home Ground Team B',
    'C' => 'Home Ground Team C',
    'D' => 'Home Ground Team D',
    'E' => 'Home Ground Team E',
    'F' => 'Home Ground Team F',
    'G' => 'Home Ground Team G',
    'H' => 'Home Ground Team H',
);

$roundrobin = new iplFixtureGenerator($teams);

$roundrobin->createMatches();

if ($roundrobin->finished) {
    $round = $roundrobin->matches;    
}
$matches_home = array();
$matches_away = array();

//team 0 would be home team
foreach ($round as $key => $value) {
	foreach ($value as $k ) {
		$matches_home[] = array(
			'home_team' => $k[0],
			'away_team' => $k[1],
			'stadium'	=> $stadiums[$k[0]]
			);
	}
}

//team 1 would be home team
foreach ($round as $key => $value) {
	foreach ($value as $k ) {
		$matches_away[] = array(
			'home_team' => $k[0],
			'away_team' => $k[1],
			'stadium'	=> $stadiums[$k[1]]
			);
	}
}

$matches = array_merge($matches_home, $matches_away);

!isset($_POST['tournamentStartDate']) ? $date = date('Y-m-d') : $date = $_POST['tournamentStartDate'];

$matches = $roundrobin->setDates($matches, $date);


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CoStrategix Assignment</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="container">
	<h1>IPL Fixture Algorithm</h1>
	<hr>
	
	<div id="row">
		<div class="col-md-4">
			<form method="post" class="form-horizontal">
				<div class="form-group">
				    <label class="control-label col-sm-6" for="email">Tournament start date:</label>
				    <div class="col-sm-6">
				      	<input type="date" class="form-control" id="email" value="<?php echo $date; ?>" name="tournamentStartDate">
				    </div>
				</div>
				<div class="form-group"> 
				    <div class="col-sm-offset-6 col-sm-6">
				    	<button type="submit" class="btn btn-default">Get Schedule</button>
				    </div>
				</div>
			</form>
		</div>
	</div>

	<div class="clearfix"></div>

	<div class="row">
		<div class="col-sm-10">
			<h4>Teams & their home grounds</h4>
			<hr>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Team</th>
						<th>Home Ground</th>
					</tr>
				</thead>
				<tbody>
					<?php $count = 1; foreach ($teams as $key) : ?>
					<tr>
						<td><?php echo $count; ?>. Team <?php echo $key; ?></td>
						<td><?php echo $stadiums[$key]; ?></td>
					</tr>
				<?php $count++; endforeach; ?>
				</tbody>
			</table>
			<h4>IPL Schedule</h4>
			<hr>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Match #</th>
						<th>Date </th>
						<th>Team Names</th>
						<th>City</th>
					</tr>
				</thead>
				<tbody>
					<?php $count = 1; foreach ($matches as $key) : ?>
					<tr>
						<td><?php echo $count; ?></td>
						<td><?php echo date('l, d M, Y', strtotime($key['date'])) ; ?></td>
						<td>Team <?php echo $key['home_team']; ?> v/s Team <?php echo $key['away_team']; ?></td>
						<td><?php echo $key['stadium']; ?></td>
					</tr>
				<?php $count++; endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

</div>

</body>
</html>