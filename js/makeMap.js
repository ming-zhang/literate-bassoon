function tooltipHtml(n, d){ /* function to create html content string in tooltip div. */
  return "<h4>"+n+"</h4><table>"+
  "<tr><td>Percentage:</td><td>"+(d.feeling)+"%</td></tr>"
  "</table>";
}

function emo_score() {
		var dict = {
			
		};
		$.ajax({
        type:     "POST",
        async: 	  false,
        url:     "../get_sentiments.php",
        success: function(data) {
            var emos = $.parseJSON(data);
            console.log(emos);
/*
            for (var i = 0; i < 50; i++) {
            	for (var key in emos[i].state) {
            		if(key != null) {
            			dict[key] = {};
            			console.log(1);
            		}
            	}
                
                
            }*/


        }
    });
}

function getEmotionVals(emotion, state) {
	//emo_score();
	return Math.round(100*Math.random());
}

function setStates() {
	var states ={};
	["HI", "AK", "FL", "SC", "GA", "AL", "NC", "TN", "RI", "CT", "MA",
	"ME", "NH", "VT", "NY", "NJ", "PA", "DE", "MD", "WV", "KY", "OH", 
	"MI", "WY", "MT", "ID", "WA", "DC", "TX", "CA", "AZ", "NV", "UT", 
	"CO", "NM", "OR", "ND", "SD", "NE", "IA", "MS", "IN", "IL", "MN", 
	"WI", "MO", "AR", "OK", "KS", "LS", "VA"]
	.forEach(function(d){
	  var feeling=getEmotionVals(0,0);
	  states[d]={feeling:feeling, color:d3.interpolate("#ffffcc", "#800026")(feeling/100)}; 
	});
	return states;
}

var states = setStates();

/*
var states ={};
["HI", "AK", "FL", "SC", "GA", "AL", "NC", "TN", "RI", "CT", "MA",
"ME", "NH", "VT", "NY", "NJ", "PA", "DE", "MD", "WV", "KY", "OH", 
"MI", "WY", "MT", "ID", "WA", "DC", "TX", "CA", "AZ", "NV", "UT", 
"CO", "NM", "OR", "ND", "SD", "NE", "IA", "MS", "IN", "IL", "MN", 
"WI", "MO", "AR", "OK", "KS", "LS", "VA"]
.forEach(function(d){
  var feeling=getEmotionVals(0,0);
  states[d]={feeling:feeling, color:d3.interpolate("#ffffcc", "#800026")(feeling/100)}; 
});*/

/* draw states on id #statesvg */ 
uStates.draw("#statesvg", states, tooltipHtml);

d3.select(self.frameElement).style("height", "600px");