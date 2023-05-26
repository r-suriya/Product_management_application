<?php

$pid = array();
$pname = [];
$pvalue = [];

if (array_key_exists('button1', $_POST)) {

    readfromfile($pid, $pname, $pvalue);
    add((int) $_POST["pid"], $_POST["pname"], $_POST["pvalue"], $pid, $pname, $pvalue);
    writetofile($pid, $pname, $pvalue);
    echo "<h1>Added Successfully</h1>";
} else if (array_key_exists('button2', $_POST)) {

    readfromfile($pid, $pname, $pvalue);
    update($pid, $pname, $pvalue, $_POST["pid"], $_POST["pname"], $_POST["pvalue"]);
    writetofile($pid, $pname, $pvalue);
    echo "<h1>Updated Successfully</h1>";

} else if (array_key_exists('button3', $_POST)) {

    readfromfile($pid, $pname, $pvalue);
    delete_prod($_POST["pid"], $pid, $pname, $pvalue);
    writetofile($pid, $pname, $pvalue);
    echo "<h1>Deleted Successfully</h1>";

} else if (array_key_exists('button4', $_POST)) {

    readfromfile($pid, $pname, $pvalue);
    search($pid, $pname, $pvalue, (int) $_POST["pid"]);
    echo "<h1>Search Successful!</h1>";

} else if (array_key_exists('button5', $_POST)) {

    readfromfile($pid, $pname, $pvalue);
    display($pid, $pname, $pvalue);

}
function readfromfile(&$pid, &$pname, &$pvalue)
{
    $fp = fopen("contents.txt", "r");
    $i = 0;
    while (!feof($fp)) {
        $line = fgets($fp);
        if (strlen($line) > 0) {
            if ($i == 0) {
                $pid = explode(",", $line);
                $pid[count($pid) - 1] = substr($pid[count($pid) - 1], 0, -1);
            } else if ($i == 1) {
                $pname = explode(",", $line);
                $pname[count($pname) - 1] = substr($pname[count($pname) - 1], 0, -1);

            } else if ($i == 2) {
                $pvalue = explode(",", $line);
                // $pvalue[count($pvalue) - 1] = substr($pvalue[count($pvalue) - 1], 0, -1);

            }
            $i++;

        }
    }

}
function writetofile(&$pid, &$pname, &$pvalue)
{


    $fp = fopen("contents.txt", "w");
    fwrite($fp, implode(",", $pid));
    fwrite($fp, "\n");
    fwrite($fp, implode(",", $pname));
    fwrite($fp, "\n");
    fwrite($fp, implode(",", $pvalue));
}

function update(&$pid, &$pname, &$pvalue, $index, $prodname, $prodvalue)
{
    $pname[$index - 1] = $prodname;
    $pvalue[$index - 1] = $prodvalue;
}

function search(&$pid, &$pname, &$pvalue, $pid_search)
{

    //display
    echo "product Id: " . $pid[$pid_search - 1] . "\nproduct name: " . $pname[$pid_search - 1] . "\nproduct price: " . $pvalue[$pid_search - 1] . "\n";
}

function add($newpid, $prodname, $prodvalue, &$pid, &$pname, &$pvalue)
{

    array_push($pid, $newpid);
    array_push($pname, $prodname);
    array_push($pvalue, $prodvalue);
}
function delete_prod($prodid, &$pid, &$pname, &$pvalue)
{
    $index = array_search($prodid, $pid);
    array_splice($pid, $index, 1);
    array_splice($pname, $index, 1);
    array_splice($pvalue, $index, 1);
}

function display(&$pid, &$pname, &$pvalue)
{
    $header = sprintf("%s %s %s", str_pad("PID", 6, " ", STR_PAD_RIGHT), str_pad("PNAME", 20, " ", STR_PAD_RIGHT), str_pad("PVALUE", 4, " ", STR_PAD_RIGHT));
    echo $header . "\n";
    for ($i = 0; $i < count($pid); $i++) {

        $line = sprintf("%s,%s,%s, <br>", $pid[$i], $pname[$i], $pvalue[$i]);
        echo $line . "\n";
    }
}
?>