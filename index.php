<?php
$jsonFile = 'temps.json';
$jsonData = json_decode(file_get_contents($jsonFile), true);

if (!$jsonData) {
  die("Error reading JSON file.");
}

$yearlyMaxTemps = [];
$yearlyMinTemps = [];
foreach ($jsonData as $year => $data) {
  $yearlyMaxTemps[$year] = max($data);
  $yearlyMinTemps[$year] = min($data);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Temperature Data</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    table {
      width: fit-content;
      margin: auto;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: #f4f4f4;
    }

    td.mo,
    th.mo {
      background-color: #f4f4f4;
      font-weight: bold;
      width: 15ch;
    }
  </style>
</head>

<body>
  <h1>Temperature Data</h1>
  <table>
    <thead>
      <tr>
        <th class="mo">Month</th>
        <?php foreach (array_keys($jsonData) as $year) { ?>
          <th><?php echo $year; ?></th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php
      // Get all months
      $months = array_keys(current($jsonData));

      // Function to determine cell color based on temperature
      function getTemperatureColor($temp, $maxTemp, $minTemp)
      {
        if ($temp === $maxTemp) {
          return 'background-color: red; color: white; font-weight: bold;';
        }
        if ($temp === $minTemp) {
          return 'background-color: lightblue; color: black; font-weight: bold;';
        }
        if ($temp > 18) {
          return 'background-color: wheat; color: black;';
        }
        return '';
      }

      foreach ($months as $month) { ?>
        <tr>
          <td class="mo"><?php echo $month; ?></td>
          <?php foreach ($jsonData as $year => $data) {
            if (isset($data[$month])) {
              $temp = $data[$month];
              $maxTemp = $yearlyMaxTemps[$year];
              $minTemp = $yearlyMinTemps[$year];
              $style = getTemperatureColor($temp, $maxTemp, $minTemp);
          ?>
              <td style="<?php echo $style; ?>"><?php echo $temp; ?></td>
            <?php } else { ?>
              <td>-</td>
            <?php } ?>
          <?php } ?>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>

</html>