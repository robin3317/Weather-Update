<?php

  $error = "";
  $result = "";

  if(array_key_exists('city', $_GET)) {
    //for pringing in alert with space
    $cityName = $_GET["city"];

    //removing space
    $_GET["city"] = str_replace(" ", "", $_GET["city"]);

    //check if url exists
    $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$_GET["city"]."/forecasts/latest");

    if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
      $error = "That city could not be found";
    }else {
      $forecastPage = file_get_contents("https://www.weather-forecast.com/locations/".$_GET["city"]."/forecasts/latest");
      $forecastArray = explode('1&ndash;3 days)</span><p class="b-forecast__table-description-content"><span class="phrase">', $forecastPage);
      
      //if forecast page's data change
      if (sizeof($forecastArray) > 1) {
        $forecastArray2 = explode('</span></p></td>', $forecastArray[1]);
        if (sizeof($forecastArray2) > 1) {
          $result = $forecastArray2[0];
        }else {
          $error = "That city could not be found";
        }
      }else {
        $error = "That city could not be found";
      } 
    }
    
  }
?>


  <!doctype html>
  <html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Weather Update</title>
  </head>

  <body>

    <!--html part-->
    <div class="container">
      <!-- <h4>What's The Weather</h4>
      <h1>What's The Weather ?</h1> -->
      <img src="final_logo.PNG" alt="logo">
      <!--input city-->
      <form>
        <div class="form-group">
          <label for="cityName">Enter The Name Of A City</label>
          <input type="text" class="form-control" name="city" id="cityName" placeholder="Eg. London">
        </div>
        <button type="submit" class="btn btn-primary">Show</button>
      </form>
      <div id="result">
        <?php
        if ($result) {
          echo '<div class="alert alert-success" role="alert">
          '.strtoupper($cityName).'<br>'.$result.'
        </div>';
        }elseif ($error) {
          echo '<div class="alert alert-danger" role="alert">
          '.strtoupper($cityName).'<br>'.$error.'</div>';
        }
      ?>
      </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"></script>
  </body>

  </html>