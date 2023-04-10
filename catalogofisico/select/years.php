<?php
$current_year = date("Y"); // Obtiene el año actual
// Llena el select con el listado de años desde el presente hasta 1500 
for ($year = $current_year; $year >= 1500; $year--) {
  echo "<option value=\"$year\">$year</option>";
}
?>