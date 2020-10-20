<?php

/**
 * Exports values from a csv-file to an array
 * 
 * Each csv-row must contain at least two values.
 * The first value of csv-row is put into the key of the associative array and contains the matrix cell id. 
 * The second value of csv-row is put into the value of the associative array and contains the matrix cell value.
 * Other values from the row are ignored.
 *
 * @param  string $filename - path to source csv file
 * @param  string $delimiter - separator for column values in a scv-row
 * 
 * @return array|boolean of matrix elements or false if source file not exists or not readable
 */
function csv_to_array($filename="", $delimiter=",") {
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $keys = array();
    $values = array();
    
    if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
            if (count($row) >= 2) {
                array_push($keys, $row[0]);
                array_push($values, $row[1]);
            }
        }
        
        $data = array_combine($keys, $values);

        fclose($handle);
    }

    return $data;
}

/**
 * Prepare an array of csv-rows
 * 
 * Adds empty values to the source array if no value was found in it by id-key
 *
 * @param  array $sourse_arr - associative array, contains the matrix cell id in keys and the matrix cell value in value
 * @param  int $rows - number of matrix rows
 * @param  int $cols - number of matrix cols
 * 
 * @return array - two-dimensional array containing the rows of the csv-file. rows contains the values of the matrix.
 */
function prepare_array_of_matrix_values($sourse_arr, $rows, $cols) {

    $result = array();
    
    for ($i = 1; $i <= $rows; $i++) {
        $row_arr = array();
        for ($j = 1; $j <= $cols; $j++) {
            $counter = $j + ($i - 1) * $cols;
            if (array_key_exists($counter, $sourse_arr)) {
                $row_arr[] = $sourse_arr[$counter];
            }
            else {
                $row_arr[] = 0;
            }
        }
        $result[] = $row_arr;
    }
    
    return $result;
}

/**
 * Writes values from an array to a csv-file
 *
 * 
 * @param  string $filename - path to the resulting file
 * @param  array $array_of_matrix_values - array of csv-rows
 * 
 * @return void
 */
function array_to_csv($filename="", $array_of_matrix_values) {
    $file = fopen($filename, "w");
    
    foreach ($array_of_matrix_values as $fields) {
        $written_string_length = fputcsv($file, $fields);
    }

    if ($written_string_length !== FALSE) {
        echo("Матрица успешно записана в файл " . $filename);
    }
    else {
        echo("Ошибка записи в файл");
    }
    
    fclose($file);
}

$source__file = __DIR__ . "/../data/source__300.csv";
$matrix__file = __DIR__ . "/../data/matrix.csv";

$array_of_csv_values = csv_to_array($source__file, "|");

$matrixArray = prepare_array_of_matrix_values($array_of_csv_values, 300, 300);

array_to_csv($matrix__file, $matrixArray);
