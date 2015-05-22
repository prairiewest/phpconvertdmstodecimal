<?php

$test_cases = array(
	" N 53 03 47.7 "," s53 03 47.7"," E53  03  47.7"," w53 03 47.7 ","  53 03 47.7 n"," 53 03 47.7S",
	" 53  03  47.7e "," W 53 03 47.7 "," N53 03 47.7"," s.53.03.47.7 "," E53.03.47.7"," w53..03..47.7",
	" n53.03.47.7 ","  53.03.47.7 S"," 53.03.47.7e"," 53..03..47.7W "," N.53.03.47.7 "," s53.03.47.7",
	" E-53-03-47.7 "," w53-03-47.7"," n53--03--47.7"," S53-03-47.7 ","  53-03-47.7 e"," 53-03-47.7W",
	" 53--03--47.7N "," s-53-03-47.7 "," E53-03-47.7","53.06325w","53.06325","53.06325 s",
	"53.06325 N","-53.06325","53 03 47.7","-53 03 47.7","53 03 47.7W","-53º 03' 47.7\"",
	"53º 03' 47.7\"","53º 03' 47.7\"s"," N 44 35 26"," s44 35 26","E 44  35 26","44 35 26w",
	"N44.35.26"," 44.35.26s","-44 35 26","44º 35' 26\"w"
);

foreach ($test_cases as $t) {
        echo $t . "\t=>\t" . convertDMSToDecimal($t) . "\n";
}

function convertDMSToDecimal($latlng) {
        $valid = false;
        $decimal_degrees = "";
        $degrees = 0; $minutes = 0; $seconds = 0; $direction = 1;
        $num_periods = substr_count($latlng, '.');
        if ($num_periods > 1) {
                $temp = trim(preg_replace('/\./', ' ', $latlng, $num_periods - 1)); // replace all but last period with delimiter
                $temp = preg_replace('/[a-zA-Z]/','',$temp); // when counting chunks we only want numbers
                $chunk_count = count(explode(" ",$temp));
                if ($chunk_count > 2) {
                        $latlng = $temp; // remove last period
                } else {
                        $latlng = str_replace("."," ",$latlng); // remove all periods, not enough chunks left by keeping last one
                }
        }
        $latlng = trim($latlng);
        $latlng = str_replace("º","",$latlng);
        $latlng = str_replace("'","",$latlng);
        $latlng = str_replace("\"","",$latlng);
        $latlng = substr($latlng,0,1) . str_replace('-', ' ', substr($latlng,1)); // remove all but first dash
        if ($latlng != "") {
                if (preg_match("/^([nsewNSEW]?)\s*(\d{1,3})\s+(\d{1,3})\s+(\d+\.?\d*)$/",$latlng,$matches)) {
                        $valid = true;
                        $degrees = intval($matches[2]);
                        $minutes = intval($matches[3]);
                        $seconds = floatval($matches[4]);
                        if (strtoupper($matches[1]) == "S" || strtoupper($matches[1]) == "W")
                                $direction = -1;
                }
                if (preg_match("/^(-?\d{1,3})\s+(\d{1,3})\s+(\d+(?:\.\d+)?)\s*([nsewNSEW]?)$/",$latlng,$matches)) {
                        $valid = true;
                        $degrees = intval($matches[1]);
                        $minutes = intval($matches[2]);
                        $seconds = floatval($matches[3]);
                        if (strtoupper($matches[4]) == "S" || strtoupper($matches[4]) == "W" || $degrees < 0) {
                                $direction = -1;
                                $degrees = abs($degrees);
                        }
                }
                if ($valid) {
                        $decimal_degrees = ($degrees + ($minutes / 60) + ($seconds / 3600)) * $direction;
                } else {
                        if (preg_match("/^(-?\d+(?:\.\d+)?)\s*([nsewNSEW]?)$/",$latlng,$matches)) {
                                $valid = true;
                                if (strtoupper($matches[2]) == "S" || strtoupper($matches[2]) == "W" || $degrees < 0) {
                                        $direction = -1;
                                        $degrees = abs($degrees);
                                }
                                $decimal_degrees = $matches[1] * $direction;
                        }

                        if (preg_match("/^([nsewNSEW]?)\s*(\d+(?:\.\d+)?)$/",$latlng,$matches)) {
                                $valid = true;
                                if (strtoupper($matches[1]) == "S" || strtoupper($matches[1]) == "W")
                                        $direction = -1;
                                $decimal_degrees = $matches[2] * $direction;
                        }
                }
        }
        if ($valid) {
                return $decimal_degrees;
        } else {
                return false;
        }
}

?>