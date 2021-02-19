<?php

function prePrint($array)
{
	echo '<pre>';
	print_r($array);
	echo '<pre>';
}

$validData;
$somministrateArr = $primaDoseArr = $secondaDoseArr = [];

$json = file_get_contents('https://raw.githubusercontent.com/italia/covid19-opendata-vaccini/master/dati/somministrazioni-vaccini-summary-latest.json');

$dataArr = json_decode($json, true);


foreach ($dataArr as $key => $value) {
	if ($key = "data") {
		$validData = $value;
	}
}



foreach ($validData as $elem) {
	foreach ($elem as $key => $value) {
		switch ($key) {
			case 'totale':
				array_push($somministrateArr, $value);
				break;
			case 'prima_dose':
				array_push($primaDoseArr, $value);
				break;
			case 'seconda_dose':
				array_push($secondaDoseArr, $value);
				break;
		}
		//echo $key . "=>" . $value . "<br>";
	}
}

$somministrateTot = array_sum($somministrateArr);
$primaDoseTot = array_sum($primaDoseArr);
$secondaDoseTot = array_sum($secondaDoseArr);

$italia = "{\"dataset\":
    {
    \"somministrate\":" . json_encode($somministrateTot) .",
    \"prima_dose\":" . json_encode($primaDoseTot) .",
    \"seconda_dose_vaccinati\":" . json_encode($secondaDoseTot) ."
    }
}";


$myfile = fopen( "../_json/vaccini-dati-nazionali.json", "w") or die("Unable to open file vaccini-dati-nazionali.json!");
fwrite($myfile, $italia);
fclose($myfile);