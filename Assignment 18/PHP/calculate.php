<?php
function calculate($number1, $number2, $operator = 'a') {
    switch ($operator) {
        case 's':
            $result = $number1 - $number2;
            break;
        case 'd':
           
            if ($number2 == 0) {
                return "Error: Division by zero.";
            }
            $result = $number1 / $number2;
            break;
        case 'm':
            $result = $number1 * $number2;
            break;
        case 'a':
        default:
            $result = $number1 + $number2;
            break;
    }
    return $result;
}


$number1 = 36;
$number2 = 42;
$operator = 'a'; 


$result = calculate($number1, $number2, $operator);


echo "Number 1 = $number1<br>";
echo "Number 2 = $number2<br>";
echo "Operator = \"$operator\"<br>";
echo "Result = $result<br>";
?>
