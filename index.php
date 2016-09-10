<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <link rel="stylesheet" href="css/jquery-jvectormap-2.0.3.css" type="text/css" media="screen"/>
  <script src="https://d3js.org/d3.v4.min.js"></script>
  <script src="js/jquery-3.0.0.min.js"></script>
  <script src="js/jquery-jvectormap-2.0.3.min.js"></script>
  <script src="js/jquery-jvectormap-world-mill-en.js"></script>
</head>
<body>
  <div id="world-map" style="width: 600px; height: 400px"></div>
  <script>
    $(function(){
      $('#world-map').vectorMap({map: 'world_mill_en'});
    });
  </script>
</body>
</html>