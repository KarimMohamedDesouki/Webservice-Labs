<?php
require("vendor/autoload.php");
ini_set('memory_limit', '-1');
$weather = new Weather();
$egyption_cities = $weather->get_cities();
if (isset($_POST["submit"])) {
    $cityId = $_POST["cities"];
    $weather_data = $weather->get_weather($cityId);
    $get_current_time = $weather->get_current_time();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
  <label for="city">Select city</label>
  <select name="cities" id="cities">
    <?php
    foreach($egyption_cities as $city){
        if($city["country"]=="EG"){
            
        
     ?>
     <option value="<?php echo $city["id"]?>"><?php echo $city["name"]?></option>
     <?php }    
    }?>
     </select>
     <input name="submit" type="submit" value="Submit">
</form>
<?php
    // if (isset($weather_data))
    // {
    //  $weather_data["weather"][0]['description']; 
    // }
    if ($weather_data && $weather_data['cod'] == 200) {
        $cityName = $weather_data['name'];
        $tempMin = $weather_data['main']['temp_min'];
        $tempMax = $weather_data['main']['temp_max'];
        $humidity = $weather_data['main']['humidity'];
    echo "<h3>Weather in $cityName</h3>";
            echo "<p>Minimum Temperature: $tempMin&deg;C</p>";
            echo "<p>Maximum Temperature: $tempMax&deg;C</p>";
            echo "<p>Humidity: $humidity%</p>";
        } else {
            echo "<p>Unable to fetch weather information for $city. Please try again later.</p>";
        }
    ?>
    </body>
</html>
