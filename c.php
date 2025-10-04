<?php
$text = trim($_POST['data']);

$textAr = explode("\n", $text);

// $textAr[] = array_filter($textAr, 'trim'); // remove any extra \r characters left behind

echo '<table>';
foreach ($textAr as $line) {
    echo '<tr>';
        $new_line=explode(",",$line);
        foreach ($new_line as $value){
             echo '<td>'.$value.'</td>';
        } 
    echo '</tr>';
} 
echo '</table>';
?>


<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <textarea name="data"></textarea>
    <input type="submit">
</form>