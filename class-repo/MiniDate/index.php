<?php include_once 'Date.php'; $date = new MiniDate(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>class.MiniDate.php</title>
</head>
<body>

	<?php $date->setTimeZone( 'Europe/Sofia' ); ?>

	<p>Now:  <?php echo $date->now(); ?></p>
	<p>Now:  <?php echo $date->now('H:m d-m-Y'); ?></p>
	<p>Date: <?php echo $date->nowDate(); ?></p>
	<p>Time: <?php echo $date->nowTime(); ?></p>

	<p><?php echo $date->addHour(3); ?>   - Add 3 Hours to current time.  </p>
	<p><?php echo $date->addDay(5); ?>    - Add 5 Days to current time.   </p>
	<p><?php echo $date->addMonth(1); ?>  - Add 1 Month to current time.  </p>
	<p><?php echo $date->addYear(10); ?>  - Add 10 Years to current time. </p>

	<!-- Use a custom format -->
	<p><?php echo $date->addDay(5, 'H:i d-m-Y '); ?> - Custom format. </p>

	<!-- And the all in one method. -->
	<p><?php echo $date->addTo( $date->now(), '6:Days' ); ?> - Adding 6 days to NOW! </p>
	<p><?php echo $date->addTo( '2014-10-22 15:00:21', '1:Month' ); ?> - Adding 1 month to '2014-10-22 15:00:21' (specific date)! </p>
	<p><?php echo $date->addTo( '2014-10-22 15:00:21', '1:Month', 'H:i d-m-Y ' ); ?> - using custom format </p>

</body>
</html>
