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
  <script src="http://d3js.org/d3.v3.min.js"></script>
</head>
<body>
  <div id="emotionSelect"></div>
  <body>
<div id="tooltip"></div><!-- div to hold tooltip. -->
<svg width="960" height="600" id="statesvg"></svg> <!-- svg to hold the map. -->
<script src="js/uStates.js"></script> <!-- creates uStates. -->
<script src="http://d3js.org/d3.v3.min.js"></script>
<script type="text/javascript" src="js/makeMap.js"></script>
<!--script>

  function tooltipHtml(n, d){
    return "<h4>"+n+"</h4><table>"+
      "<tr><td>Low</td><td>"+(d.low)+"</td></tr>"+
      "<tr><td>Average</td><td>"+(d.avg)+"</td></tr>"+
      "<tr><td>High</td><td>"+(d.high)+"</td></tr>"+
      "</table>";
  }
  
  var sampleData ={};
  ["HI", "AK", "FL", "SC", "GA", "AL", "NC", "TN", "RI", "CT", "MA",
  "ME", "NH", "VT", "NY", "NJ", "PA", "DE", "MD", "WV", "KY", "OH", 
  "MI", "WY", "MT", "ID", "WA", "DC", "TX", "CA", "AZ", "NV", "UT", 
  "CO", "NM", "OR", "ND", "SD", "NE", "IA", "MS", "IN", "IL", "MN", 
  "WI", "MO", "AR", "OK", "KS", "LS", "VA"]
    .forEach(function(d){ 
      var low=Math.round(100*Math.random()), 
        mid=Math.round(100*Math.random()), 
        high=Math.round(100*Math.random());
      sampleData[d]={low:d3.min([low,mid,high]), high:d3.max([low,mid,high]), 
          avg:Math.round((low+mid+high)/3), color:d3.interpolate("#ffffcc", "#800026")(low/100)}; 
    });
  
  
  uStates.draw("#statesvg", sampleData, tooltipHtml);
  
  d3.select(self.frameElement).style("height", "600px"); 
</script-->
</body>
</html>