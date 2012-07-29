<?php
function play($width, $rows, $max_turns, $turn = 1) {
	$new_rows = $rows;

	for($x = 1; $x < $width-1; $x++) {
		for($y = 1; $y < $width-1; $y++) {
			$black_neighbors =
				knock(&$rows, $x, $y-1) + 
				knock(&$rows, $x, $y+1) + 
				knock(&$rows, $x+1, $y) + 
				knock(&$rows, $x-1, $y) + 
				knock(&$rows, $x+1, $y+1) + 
				knock(&$rows, $x+1, $y-1) + 
				knock(&$rows, $x-1, $y+1) + 
				knock(&$rows, $x-1, $y-1);

			if($black_neighbors > 0) {
				$new_rows[$x][$y] = 'b';
			} else if ($black_neighbors < 0) {
				$new_rows[$x][$y] = 'w';
			}
		}
	}

	if($max_turns > $turn) {
		return play($width, $new_rows, $max_turns, $turn + 1);
	}

	return $new_rows;
}

function knock($rows, $x, $y) {
	if ($rows[$x][$y] === 'b') {
		return 1;
	} else if ($rows[$x][$y] === 'w') {
		return -1;
	}
}

$boards = array();

$total_tests = 0;
$test = 0;

$ln = 0;
while (FALSE !== ($line = fgets(STDIN)))
{
	if($ln === 0) {
		$total_tests = trim($line);
	} else {
		if(preg_match("/[0-9\s]+/", trim($line)) > 0) {
			$test++;
			list($boards[$test]['width'], $boards[$test]['runs']) = explode(' ', trim($line));
		} else {
			$boards[$test]['rows'][] = str_split(trim($line));
		}
	}

	$ln++;
}

foreach($boards as $num => $board) {
	$final_rows = play($board['width'], $board['rows'], $board['runs']);
	echo "Board {$num}\n";

	foreach($final_rows as $row) {
		echo implode('', $row)."\n";
	}
}

echo "\n";

?>