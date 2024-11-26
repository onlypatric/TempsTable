<?php
// Load the JSON file
$jsonFile = 'temps.json';
$jsonData = json_decode(file_get_contents($jsonFile), true);

if (!$jsonData) {
  die("Error reading JSON file.");
}

// Find the max and min temperatures across all data
$allTemperatures = [];
foreach ($jsonData as $year => $data) {
  $allTemperatures = array_merge($allTemperatures, array_values($data));
}
$maxTemp = max($allTemperatures);
$minTemp = min($allTemperatures);

// Generate the HTML table
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Temperature Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: fit-content;
            margin:auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        td.mo, th.mo {
            background-color: #f4f4f4;
            font-weight: bold;
            width:15ch;
        }
    </style>
</head>
<body>
    <h1>Temperature Data</h1>";

// Start the table
echo "<table>
        <thead>
            <tr>
                <th class='mo'>Month</th>";

// Add table headers for each year
foreach (array_keys($jsonData) as $year) {
  echo "<th>{$year}</th>";
}

echo "      </tr>
        </thead>
        <tbody>";

// Collect all months from the JSON data
$months = array_keys(current($jsonData));

// Function to determine cell color based on temperature
function getTemperatureColor($temp, $maxTemp, $minTemp)
{
  if ($temp === $maxTemp) {
    return 'background-color: red; color: white;font-weight:bold;';
  }
  if ($temp === $minTemp) {
    return 'background-color: lightblue; color: black;font-weight:bold;';
  }
  if ($temp > 18) {
    return 'background-color: wheat; color: black;';
  }
  return '';
}

foreach ($months as $month) {
  echo "<tr>
            <td class='mo'>{$month}</td>";

  foreach ($jsonData as $year => $data) {
    if (isset($data[$month])) {
      $temp = $data[$month];
      $style = getTemperatureColor($temp, $maxTemp, $minTemp);
      echo "<td style='{$style}'>{$temp}</td>";
    } else {
      echo "<td>-</td>";
    }
  }

  echo "</tr>";
}

echo "      </tbody>
    </table>
</body>
</html>";
