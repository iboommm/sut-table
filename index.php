<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test Table</title>
	<link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body>
	<?php 
		$maxDay = 0;
		$minDay = 10;
		$maxTime = 0;
		$minTime = 24;

		$fData[0] = "We08:00-10:00 Lab Com 1\nTu08:00-10:00 Lab Com 1";
		$fData[1] = "Tu13:00-15:00 Lab Com 1\nMo13:00-15:00 Lab Com 1";
		$fData[2] = "Th09:00-12:00 Lab Com 1";
		$fData[3] = "Mo17:00-19:00 Lab Com 1";
		$fData[4] = "Mo08:00-10:00 Lab Com 1";
		$fData[5] = "Fr08:00-10:00 Lab Com 1\nTh18:00-20:00 Lab Com 1";
		
		$fName[0] = "514124";
		$fName[1] = "543545";
		$fName[2] = "234234";
		$fName[3] = "121133";
		$fName[4] = "202122";
		$fName[5] = "764223";
		$c2 = 0;
		for($i=0;$i<sizeof($fName);$i++) {
			$xx = explode("\n", $fData[$i]);
			if(sizeof($xx) == 1) {
				$test[$c2] = $xx[0]."<=".$fName[$i];
				$c2++;
			}else{
				for($j = 0;$j < sizeof($xx);$j++) {
					$test[$c2] = $xx[$j]."<=".$fName[$i];
					$c2++;
				}
			}
			
		}


		foreach ($test as $a) {
			echo "UnSort : ".$a."<br >";
		}

		for ($i=0;$i<sizeof($test);$i++) {
			$b = substr($test[$i], 0,2);
			$c[$i] = searchDay($b).",".$i;
		}
		sort($c);

		for ($i=0;$i<sizeof($test);$i++) {
			$cc = $c[$i][2];
			$tmp[$i] = $test[$cc];
		}

		foreach ($tmp as $a) {
			echo "Sort Day : ".$a."<br >";
		}

		$numTime = array(0,0,0,0,0,0,0,0,0);

		for($i=0;$i<sizeof($tmp);$i++) {
			$b = substr($tmp[$i], 0,2);
			if(strcmp($b, "Mo") == 0) {
				$numTime[1]++;
			}else if(strcmp($b,"Tu") == 0) {
				$numTime[2]++;
			}else if(strcmp($b,"We") == 0) {
				$numTime[3]++;
			}else if(strcmp($b,"Th") == 0) {
				$numTime[4]++;
			}else if(strcmp($b,"Fr") == 0) {
				$numTime[5]++;
			}else if(strcmp($b,"Sa") == 0) {
				$numTime[6]++;
			}
		}
			
		for($i=0;$i<sizeof($tmp);$i++) {

			$bb = substr($tmp[$i], 0,2);

			if(strcmp($bb, "Mo") == 0) {
				$day=1;
			}else if(strcmp($bb,"Tu") == 0) {
				$day=2;
			}else if(strcmp($bb,"We") == 0) {
				$day=3;
			}else if(strcmp($bb,"Th") == 0) {
				$day=4;
			}else if(strcmp($bb,"Fr") == 0) {
				$day=5;
			}else if(strcmp($bb,"Sa") == 0) {
				$day=6;
			}

			$str ="";
			if($numTime[$day] > 1) {
				$numk = $numTime[$day];
					for($j = $i;$j<($i+$numk);$j++) {
						$cc = substr($tmp[$j], 2,2);
						$str .= $cc."-$j,";
					}
					$str = substr($str, 0,strlen($str)-1);
					$zx = explode(",", $str);
					sort($zx);
					$dd = 0;
					for($j = $i;$j<($i+$numk);$j++) {
						$yy= $zx[$dd++][3];
						$test[$j] = $tmp[$yy];
					}
					for($j = $i;$j<($i+$numk);$j++) {
						$tmp[$j] = $test[$j];
					}
					$i+=$numk;
					break;
			}
		}


		
		foreach ($test as $a) {
			$b = substr($a, 2,11);
			$min  = explode("-", $b);
			$max  = explode("-", $b);
			$minTime_tmp = explode(":", $min[0]);
			$maxTime_tmp = explode(":", $max[1]); 

			$minTime_tmp[0] +=0;//$maxTime[0]+=0;
			if($minTime > $minTime_tmp[0]) {
				$minTime = $minTime_tmp[0];
			}

			$maxTime_tmp[0] +=0;//$maxTime[0]+=0;
			if($maxTime < $maxTime_tmp[0]) {
				$maxTime = $maxTime_tmp[0];
			}
		}

		foreach ($tmp as $a) {
			$b = substr($a, 0,2);
			$c = searchDay($b);
			if($maxDay <= $c) {
				$maxDay = $c;
			}
			if($minDay >= $c) {
				$minDay = $c;
			}
		}

		// calculate range of Time
		function calRange($time1,$time2) {
			$b1 = substr($time1, 0,2);
			$b2 = substr($time2, 0,2);

			if(strcasecmp($b1, $b2) == 0) {
				$b1 = substr($time1, 8,2);
				$b2 = substr($time2, 8,2);
				return abs($b1-$b2);
			}else {
				return 0;
			}
		}

		function calLastTime($time,$maxTime) {
			$b1 = substr($time, 8,2);
			$b1 = $maxTime-$b1;
			return abs($b1);
		}

		function calFirstTime($time,$minTime){
			$b1 = substr($time, 2,2);
			$b1 = $b1-$minTime;
			return abs($b1);
		}

		// calculate colspans
		function calTimeRange($time) {
			$time = substr($time, 2,11);
			$cc  = explode("-", $time);
			$result = $cc[0]-$cc[1];
			return abs($result);
		}

		// calculate day 
		function searchDay($day) {
			$num=0;
			if(strcmp($day, "Mo") == 0) {
				$num = 1;
			}else if(strcmp($day,"Tu") == 0) {
				$num = 2;
			}else if(strcmp($day,"We") == 0) {
				$num = 3;
			}else if(strcmp($day,"Th") == 0) {
				$num = 4;
			}else if(strcmp($day,"Fr") == 0) {
				$num = 5;
			}else if(strcmp($day,"Sa") == 0) {
				$num = 6;
			}
			return $num;
		}

		// genrate day from day Integer to String
		function genDay($day) {
			if($day == 1) {
				$day = "Monday";
			}else if($day == 2) {
				$day = "Tuesday";
			}else if($day == 3) {
				$day = "Wednesday";
			}else if($day == 4) {
				$day = "Thursday";
			}else if($day == 5) {
				$day = "Friday";
			}else if($day == 6) {
				$day = "Saturday";
			}
			return $day;
		}

		echo "<br>";

		
		foreach ($tmp as $a) {
			echo "Sort : ".$a."<br >";
		}

		$pe = 100.000/abs($minTime-$maxTime);

	?>
	<style>
		table{
			border:1px #000 solid;
		}
		tr > td  {
			border:1px #000 solid;
		}
	</style>
	<div style="width:600px">
	<table class="table">
		<tr>
		<td width="<?php echo $pe; ?>">Day</td>
		<?php 

			for($i = $minDay[0]; $i < $maxDay;$i++) {
					for($i = $minTime; $i < $maxTime;$i++) {
						$i = $i+0;
						if($i < 10 && $i+1 >= 10) {
							echo "<td width='$pe'>0".$i.":00-".($i+1).":00</td>\n";
						}else if($i < 10 && $i+1 < 10) {
							echo "<td width='$pe'>0".$i.":00-0".($i+1).":00</td>\n";
						}else{
							echo "<td width='$pe'>".$i.":00-".($i+1).":00</td>\n";
						}
					}
			}
			?>
		</tr>
		<?php
		$tmp_c = 0;
		for($day = $minDay;$day <= $maxDay;$day++) {
				echo "<tr><td>".genDay($day)."</td>";
				$i =0;
				while($i < $numTime[$day]) {
					if(calFirstTime($tmp[$tmp_c],$minTime) > 0 && $i == 0) {
						for($x = 0;$x < calFirstTime($tmp[$tmp_c],$minTime);$x++) {
							echo "<td></td>";
						}
					}

					$cut_S = substr($tmp[$tmp_c], 25);

					echo "<td align='center' colspan='".calTimeRange($tmp[$tmp_c])."''>".$cut_S."</td>";

					if($i == $numTime[$day]-1) {
						for($x = 0;$x < calLastTime($tmp[$tmp_c],$maxTime);$x++) {
							echo "<td></td>";
						}
					}
				

					if($i < $numTime[$day]-1) {
						if(calRange($tmp[$tmp_c],$tmp[$tmp_c+1]) > 0) {
							for($x = 0;$x < calRange($tmp[$tmp_c],$tmp[$tmp_c+1])-2;$x++) {
								echo "<td></td>";
							}
						}
					}
					$tmp_c++;
					$i++;

				}
				echo "</tr>";
			} ?>
	</table>
	</div>

</body>
</html>