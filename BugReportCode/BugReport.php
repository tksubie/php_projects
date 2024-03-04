<!--PHP File to get, store, update bug information-->
<!-- Thaine Koen, 8/24/2023 -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <title>Bug Report Database</title>
    <!--Link stylesheet -->
    <link href="/BugReportStyles.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
$errorCount = 0;

/*from lecture week 7 creating database
Champlain College. (n.d.). Opening a Database.
https://champlain.instructure.com/courses/2073016/pages/opening-a-database?module_item_id=98063855  */


//Create connection to database
$connectDB = mysqli_connect('localhost:3308','root', '');
//if connection fails
if(!$connectDB){
    echo "Connection Failed: " . mysqli_connect_error();
    exit();
}
//encode
if(!mysqli_set_charset($connectDB, 'utf8')){
    echo "Unable to set encoding.";
    exit();
}
//create database
$database = "CREATE DATABASE IF NOT EXISTS bugDatabase";
mysqli_query($connectDB,$database);

//open database
if(!mysqli_select_db($connectDB, 'bugDatabase')){
    echo "Database not found!";
    exit();
}

//complete connection to database
echo "Database connection is GREEN!<br>";

//create table
$bugTable = "CREATE TABLE IF NOT EXISTS bugTABLE (
        bug_Number INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        prod_Name VARCHAR(25),
        version VARCHAR(10),
        hardware VARCHAR(10),
        os VARCHAR (10),
        freq VARCHAR(20),
        solution VARCHAR(100)
) DEFAULT CHARACTER SET utf8";

mysqli_query($connectDB, $bugTable);
echo "Table created for Bug Reports!<br>";


//make sure form is complete and use submit button
if (isset($_POST['bugSubmit'])) {

    //take inputs and validate
    $product = validateInput($_POST['prodName'], "Product Name");
    $ver = validateInput($_POST['version'], "Version");
    $hardType = validateInput($_POST['hardware'], "Hardware Type");
    $os = $_POST['osList'];
    $frequency = $_POST['ocurrList'];
    $propSolution = validateInput($_POST['solution'], "Proposed solution");
    $bugNum = $_POST['bugNumber'];



    if ($errorCount > 0 || !empty($bugNum)) {
        echo "Bug submit error, make sure you do not have a Bug number selected!\n";
    }
    else {
        //escape inputs
        $product = mysqli_real_escape_string($connectDB, $_POST['prodName']);
        $ver = mysqli_real_escape_string($connectDB, $_POST['version']);
        $hardType = mysqli_real_escape_string($connectDB, $_POST['hardware']);
        $os = mysqli_real_escape_string($connectDB, $_POST['osList']);
        $frequency = mysqli_real_escape_string($connectDB, $_POST['ocurrList']);
        $propSolution = mysqli_real_escape_string($connectDB, $_POST['solution']);
        $bugNum = mysqli_real_escape_string($connectDB, $_POST['bugNumber']);

        //insert statement
        $insertValues ="INSERT INTO bugTABLE (prod_Name,version,hardware,os,freq,solution) 
                        VALUES ('$product','$ver','$hardType','$os','$frequency','$propSolution')";
        mysqli_query($connectDB,$insertValues);
            echo "Bug has been submitted!\n";

    }

}
//make sure form is complete and use update button
if (isset($_POST['update'])) {

    //take inputs and validate
    $product = validateInput($_POST['prodName'], "Product Name");
    $ver = validateInput($_POST['version'], "Version");
    $hardType = validateInput($_POST['hardware'], "Hardware Type");
    $os = $_POST['osList'];
    $frequency = $_POST['ocurrList'];
    $propSolution = validateInput($_POST['solution'], "Proposed solution");
    $bugNum = $_POST['bugNumber'];


    if ($errorCount > 0 || empty($bugNum)) {
        echo "Bug update error, make sure you have a Bug number selected!\n";
    }
    else {
        //escape inputs
        $product = mysqli_real_escape_string($connectDB, $_POST['prodName']);
        $ver = mysqli_real_escape_string($connectDB, $_POST['version']);
        $hardType = mysqli_real_escape_string($connectDB, $_POST['hardware']);
        $os = mysqli_real_escape_string($connectDB, $_POST['osList']);
        $frequency = mysqli_real_escape_string($connectDB, $_POST['ocurrList']);
        $propSolution = mysqli_real_escape_string($connectDB, $_POST['solution']);
        $bugNum = mysqli_real_escape_string($connectDB, $_POST['bugNumber']);

        //update statement
        $updateValues = sprintf("UPDATE bugTABLE SET
                        prod_Name = '%s',
                        version = '%s',
                        hardware = '%s',
                        os = '%s',
                        freq = '%s',
                        solution = '%s' 
                        WHERE bug_Number = '%s'", $product, $ver, $hardType, $os, $frequency, $propSolution, $bugNum);
        mysqli_query($connectDB,$updateValues);
        echo "Bug " . $bugNum . " has been updated!\n";

    }

}
//make sure form is complete and use delete button
if (isset($_POST['delete'])) {

    //take inputs and validate
    $bugNum = $_POST['bugNumber'];


    if ( empty($bugNum)) {
        echo "Bug delete error, make sure you have a Bug number selected!\n";
    }
    else {
        //escape inputs
        $bugNum = mysqli_real_escape_string($connectDB, $_POST['bugNumber']);

        //delete statement
        $deleteValues = sprintf("DELETE FROM bugTABLE WHERE bug_Number = '%s'", $bugNum);

        mysqli_query($connectDB,$deleteValues);
        echo "Bug " . $bugNum . " has been deleted!\n";

    }

}
//See Bug Report
if (isset($_POST['seeBugs'])) {

    $showTable = "SELECT * FROM bugTable";

    $table = mysqli_query($connectDB,$showTable);
    //header for table

    echo "<table>
            <tr>
                '<th>Bug Number</th>'
                '<th>Product</th>'
                '<th>Version</th>'
                '<th>Hardware</th>'
                '<th>Operating System</th>'
                '<th>Frequency of Occurrence</th>'
                '<th>Proposed Solution</th>'
            </tr>";
    /*from lecture week 7 using while loop
    Champlain College. (n.d.). Handling SELECT Results.
    https://champlain.instructure.com/courses/2073016/pages/handling-select-results?module_item_id=98063873 */
    while ($row = mysqli_fetch_array($table)){
        $bugNum = $row['bug_Number'];
        $product = $row['prod_Name'];
        $ver = $row['version'];
        $hardType = $row['hardware'];
        $os = $row['os'];
        $frequency = $row['freq'];
        $propSolution = $row['solution'];
        echo sprintf("<tr>
                    '<td>%s</td>'
                    '<td>%s</td>'
                    '<td>%s</td>'
                    '<td>%s</td>'
                    '<td>%s</td>'
                    '<td>%s</td>'
                    '<td>%s</td>'
                </tr>", $bugNum, $product, $ver, $hardType, $os, $frequency, $propSolution);

    }
    echo "</table>";
}

//Validate usage
function validateInput($data, $fieldName)
{      //Validate input
    global $errorCount;
    if (empty($data)) {      //if value is empty
        ++$errorCount;      //increase error counter
        $input = null;
        echo "The \"$fieldName\" is blank.</br>";
    } else {
        $input = $data;    //round to 2 decimal places
    }
    return ($input);
}

?>
</body>
</html>

