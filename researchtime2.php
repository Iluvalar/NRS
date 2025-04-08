<?php
error_reporting(E_ERROR | E_PARSE);

$basedir = './mp454/';
$str = file_get_contents($basedir . 'stats/research.json');
$data['research'] = json_decode($str, TRUE);

// Initialize arrays for initial researches (starting technologies)
$initialResearches = [
    'R-Sys-Sensor-Turret01',
    'R-Wpn-MG1Mk1',
    'R-Sys-Engineering01'
];
foreach ($initialResearches as $id) {
    //$done[$id] = 0;               // Shortest time
    $donetotrp[$id] = 0;          // Total RP
    $donepow[$id] = 0;            // Total power
    $prereq_sets[$id] = [$id => true]; // Prerequisite set includes only itself
	
	
}

// Process researches in topological order
$stop = false;
while (!$stop) {
    $stop = true;
    foreach ($data['research'] as $id => $val) {
        if (!isset($done[$id])) {
            $allPrerequisitesDone = true;
            $time = 0;           // Shortest time from prerequisites
            $prereq_set = [];    // Set of all unique prerequisites
            $pow = 0;            // Total power from prerequisites

            // Check prerequisites
            if (!empty($val['requiredResearch'])) {
                foreach ($val['requiredResearch'] as $id2) {
                    if (!isset($done[$id2])) {
                        $allPrerequisitesDone = false;
                        break;
                    }
                    $time = max($done[$id2], $time);
                    $pow += $donepow[$id2];
                    $prereq_set = array_merge($prereq_set, $prereq_sets[$id2]);
                }
            }

            if ($allPrerequisitesDone) {
                // Add current research to its prerequisite set
                $prereq_set[$id] = true;
                $prereq_sets[$id] = $prereq_set;

                // Calculate total RP and power from unique prerequisites
                $totRP = 0;
                $totPower = 0;
                foreach ($prereq_set as $prereq_id => $dummy) {
                    $totRP += $data['research'][$prereq_id]['researchPoints'];
                    $totPower += $data['research'][$prereq_id]['researchPower'];
                }
				// Check for research speed upgrade
                $researchSpeedIncrease = 0;
				$researchSpeedIncrease2=0;
                if (isset($val['results'])) {
                    foreach ($val['results'] as $result) {
                        if (isset($result['class']) && $result['class'] === 'Building' &&
                            isset($result['parameter']) && $result['parameter'] === 'ResearchPoints' &&
                            isset($result['value'])) {
                            $researchSpeedIncrease = $result['value'];
                            break; // Assume one upgrade per research for simplicity
                        }
                    }
                }
				foreach($val['resultStructures'] as $nostruct => $idStruct){
					//echo $idStruct;
						if($idStruct=="A0ResearchModule1"){
							//echo "found A0ResearchModule1 in $id";
							$researchSpeedIncrease2=50;
						}	
				}
                // Store results
                $temp = [
                    'id' => $id,
                    'rp' => $time + $val['researchPoints'], // Shortest time (cumulative RP)
                    'totRP' => $totRP,                      // Total RP
                    'rpow' => $totPower,                    // Total power
                    'researchSpeedIncrease' => $researchSpeedIncrease, // Upgrade value (0 if none)
					'researchSpeedIncrease2' => $researchSpeedIncrease2 // Upgrade value (0 if none)
                ];
                $done[$id] = $temp['rp'];
                $donetotrp[$id] = $totRP;
                $donepow[$id] = $totPower;
                $resData[] = $temp;
				$resDataKey[$id]=count($resData)-1;
				if($researchSpeedIncrease or $researchSpeedIncrease2){
					$upgrade[$id]=$totRP;
				}
                $stop = false; // Continue processing
            }
        }
    }
}

asort($upgrade);
// Second loop: Simulate research time with upgrades
$N = 1;          // Number of labs (adjustable)
$S0 = 14;       // Base research speed per lab (RP per second, adjust based on game data)

$completionTime = []; // Optional: Store completion time for each research

foreach ($resData as $temp) {
	$S = $S0;        // Current research speed per lab
	$currentUpgrade=0;
	$currentUpgrade2=0;
	$t = 0;          // Total time in seconds
    $id = $temp['id'];
    $rp = $temp['totRP'] ; // RP for this research only
	//echo '<br><b>'. $id .'RP:'. $rp .'</b>';
	foreach($upgrade as $idup=>$timeup){
		$speed=(100+$currentUpgrade)/100*(100+$currentUpgrade2)/100;
		$upgData=$resData[$resDataKey[$idup]];
		$reduction=$timeup*$speed;
		if($rp>$reduction){
			$rp-=$reduction;
			$t+=$timeup/($S0*$speed);
		}
		else{
			$t+=$timeup/($S0*$speed)*$rp/$reduction;
			$rp=0;
		}
		//print_r($upgData);
		//echo '<br>'. $idup .' speed:'. $S .' '. $currentUpgrade .' '. $upgData['researchSpeedIncrease'] .' red:'. $reduction .'RP:'. $rp;
		$currentUpgrade+=$upgData['researchSpeedIncrease'];
		$currentUpgrade2+=$upgData['researchSpeedIncrease2'];
		if($rp<=0){
			break;
		}
	}
	/*
    // Calculate time to complete this research
    $T = $rp / ($N * $S);
    $t += $T;
*/
    // Store completion time (optional)
    $completionTime[$id] = $t;

}

// Output total time
echo "<h3>Total Research Time:</h3>";
echo "With $N lab(s) at base speed $S0 RP/s per lab:<br>";
echo "Total time: " . round($t, 2) . " seconds (" . round($t / 60, 2) . " minutes)<br>";

/*
// Optional: Output completion times for each research
echo "<h3>Completion Times:</h3>";
foreach ($completionTime as $id => $time) {
    echo "$id completed at " . round($time, 2) . " seconds<br>";
}
*/

// Output completion times with details in a table
echo "<h3>Completion Times with Details:</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>
        <th>In-Game Name</th>
        <th>ID</th>
        <th>Completion Time (s)</th>
		<th>Completion Time (minutes)</th>
        <th>Total Cost</th>
        <th>Total RP</th>
        <th>Shortest RP</th>
      </tr>";

// Loop through each research in the order of completion
asort($completionTime);
foreach ($completionTime as $id => $time) {
    $inGameName = $data['research'][$id]['name']; // Get the in-game name
    $totalCost = $donepow[$id];
    $totalRP = $donetotrp[$id];
    $shortestRP = $done[$id];
    $completionTimeRounded = round($time, 2); // Round completion time to 2 decimal places
	$completionTimeMinutesRounded = round($time/60, 2); // Round completion time to 2 decimal places

    // Output the row
    echo "<tr>
            <td>$inGameName</td>
            <td>$id</td>
            <td>$completionTimeRounded s</td>
			<td>$completionTimeMinutesRounded m</td>
            <td>$totalCost</td>
            <td>$totalRP</td>
            <td>$shortestRP</td>
          </tr>";
}

echo "</table>";

/*
// Output results sorted by shortest research time
echo '<h3>Research ordered by research points:</h3>';
asort($done);
foreach ($done as $id => $val) {
    $labs = 0;
    if ($val > 0) {
        $labs = floor($donetotrp[$id] / $val * 1000) / 1000; // Labs calculation (unchanged)
    }
    echo '<br>' . $id . ' is researchable with ' . $val . ' RP (total: ' . $donetotrp[$id] . ' RP or ~' . $labs . ' labs) and ' . $donepow[$id] . '$';
}
*/
?>