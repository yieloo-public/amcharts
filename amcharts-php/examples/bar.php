<?php

/*
 * Read README file first.
 *
 * This example shows how to create a simple bar chart with a few configuration
 * directives.
 * The values are from http://www.globalissues.org/article/26/poverty-facts-and-stats
 */

// Require necessary files
require("../lib/AmBarChart.php");

// Alls paths are relative to your base path (normally your php file)
// Path to swfobject.js
AmChart::$swfObjectPath = "swfobject.js";
// Path to AmCharts files (SWF files)
AmChart::$libraryPath = "../../../amcharts";
// Path to jquery.js
AmChart::$jQueryPath = "jquery.js";

// Initialize the chart (the parameter is just a unique id used to handle multiple
// charts on one page.)
$chart = new AmBarChart("myBarChart");

// The title we set will be shown above the chart, not in the flash object.
// So you can format it using CSS.
$chart->setTitle("People in the world at different poverty levels, 2005");

// Add a label to describe the X values (inside the chart).
$chart->addLabel("The values on the X axis describe the Purchasing Power in USD Dollars a day.", 0, 20);

// Add all values for the X axis
$chart->addSerie(0, "$1.00");
$chart->addSerie(1, "$1.25");
$chart->addSerie(2, "$1.45");
$chart->addSerie(3, "$2.00");
$chart->addSerie(4, "$2.50");
$chart->addSerie(5, "$10.00");

// Define graphs data
$belowPovertyLine = array(
	0 => 0.88,
	1 => 1.40,
	2 => 1.72,
	3 => 2.60,
	4 => 3.14,
	5 => 5.15
);
$abovePovertyLine = array(
	0 => 5.58,
	1 => 5.06,
	2 => 4.74,
	3 => 3.86,
	4 => 3.32,
	5 => 1.31
);

// Add graphs
$chart->addGraph("below", "Below the poverty line", $belowPovertyLine);
$chart->addGraph("above", "Above the poverty line", $abovePovertyLine);

// Print the code
echo $chart->getCode();

?>