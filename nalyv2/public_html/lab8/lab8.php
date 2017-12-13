<!DOCTYPE html>

<html>

    <head>

    <title>Lab 8</title>

    <style>

        #submitBtn {

            margin-top: 10px;

        }             

    </style>

    </head>

    <body>

<form action="" method="post">
    <div>
        <h3>Select a query</h3>
        <select name="query" muliple>
            <option value="">Please select</option>
            
            <option value="SELECT District, Population FROM City WHERE Name='Springfield';">Show all Springfield cities</option>
            
            <option value="SELECT Name, District, Population FROM City WHERE CountryCode='BRA' ORDER BY Name;">Show  all cities in Brazil</option>
            
            <option value="SELECT Name, Continent, SurfaceArea FROM Country ORDER BY SurfaceArea  ASC LIMIT 20;">Show 20 smallest countries (by surface area)</option>
            
            <option value="SELECT Name, Continent, GovernmentForm, GNP FROM Country WHERE GNP > 200000 ORDER BY Name;">Show countries having a GNP > 200,000</option>
            
            <option value="SELECT Name FROM Country WHERE LifeExpectancy IS NOT NULL ORDER BY LifeExpectancy LIMIT 9, 10;">Show the 10 countries with the 10th through 19th best life expectancy rates</option>
            
            <option value="SELECT Name FROM City WHERE Name LIKE 'B%%s' ORDER BY Population;">Show all city names that start with the letter B and ends in the letter s</option>
            
            <option value="SELECT City.Name, City.Population, Country.Name FROM City INNER JOIN Country ON City.CountryCode=Country.Code WHERE City.Population > 6000000 ORDER BY City.Population DESC;">Show all where population > 6,000,000</option>
            
            <option value="SELECT Country.Name, Country.IndepYear, Country.Region FROM CountryLanguage INNER JOIN Country ON CountryLanguage.CountryCode=Country.Code WHERE CountryLanguage.Language = 'English' AND IsOfficial='T' ORDER BY Country.Region DESC;">Show all where the official language is English</option>
            
            <option value="SELECT Country.Name, City.Name, City.Population/Country.Population*100 AS Percentage FROM Country INNER JOIN City ON Country.Capital = City.ID ORDER BY Percentage">Percentage of each capital</option>
            
            <option value="SELECT CountryLanguage.Language, Country.Name, (CountryLanguage.Percentage*Country.Population)/100 AS NumberOfSpeakers FROM CountryLanguage INNER JOIN Country ON Country.Code = CountryLanguage.CountryCode WHERE CountryLanguage.IsOfficial='T' ORDER BY NumberOfSpeakers DESC;">Show all official languages, the country for which it is spoken, and the number of speakers in that country</option>
            
            <option value="SELECT Name, Region, GNP, GNPOld, (GNP-GNPOld)/GNPOld AS GNPChange FROM Country WHERE GNP AND GNPOld IS NOT NULL ORDER BY GNPChange DESC;">Show all countries who have most improved relative wealth</option>
        </select>
    </div>
    <div>
        <input id="submitBtn" type="submit" value="Submit">
    </div>
</form>
<p>

<?php   

if(isset($_POST['query'])) {

    include "../secure/database.php";
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }      

    $sql = $_POST["query"];
    $result = $conn->query($sql);
    $col = $result->field_count;
    $row = $result->num_rows;
    echo "Results: " . $row;

    echo " <style>
        table, td, tr {
            border: 2px solid black;
            border-collapse: collapse;
            margin: 5px;
            padding: 5px;
}
</style>";

echo "<table>";
$result = $conn->query($sql);

$field_info = $result->fetch_fields();

echo "<table>";
echo "<tr>";
foreach ($field_info as $val) {
    echo "<td>" . $val->name . "</td>";
}
echo "</tr>";

while($rowInfo = $result->fetch_row()) {
    echo "<tr>";
    for($y = 0; $y < $col; $y++) {
        echo "<td>" . $rowInfo[$y] . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
}
?>

</p>

    </body>

    </html>
