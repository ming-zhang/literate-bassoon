function tooltipHtml(n, d){ /* function to create html content string in tooltip div. */
  return "<h4>"+n+"</h4><table>"+
  "<tr><td>Percentage:</td><td>"+(d.feeling)+"%</td></tr>"
  "</table>";
}

/*
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

            for (var i = 0; i < 50; i++) {
            	for (var key in emos[i].state) {
            		if(key != null) {
            			dict[key] = {};
            			console.log(1);
            		}
            	}
                
                
            }


        }
    });
}*/

function getEmoNum(emotion, state) {
	var emoNum;
	$.ajax({
        type:     	"POST",
        data: 		{state: state, emo: emo},
        async: 		 false,
        url:     "../get_emotion.php",
        success: function(data) {
           console.log(data);
           emoNum = data;
        }
    });
    return paresInt(emoNum);
}

function getEmotionVals(emotion, state) {
	emo_score();
	return Math.round(100*Math.random());
}


function abbrState(input, to){
    
    var states = [
        ['Arizona', 'AZ'],
        ['Alabama', 'AL'],
        ['Alaska', 'AK'],
        ['Arizona', 'AZ'],
        ['Arkansas', 'AR'],
        ['California', 'CA'],
        ['Colorado', 'CO'],
        ['Connecticut', 'CT'],
        ['Delaware', 'DE'],
        ['Florida', 'FL'],
        ['Georgia', 'GA'],
        ['Hawaii', 'HI'],
        ['Idaho', 'ID'],
        ['Illinois', 'IL'],
        ['Indiana', 'IN'],
        ['Iowa', 'IA'],
        ['Kansas', 'KS'],
        ['Kentucky', 'KY'],
        ['Kentucky', 'KY'],
        ['Louisiana', 'LA'],
        ['Maine', 'ME'],
        ['Maryland', 'MD'],
        ['Massachusetts', 'MA'],
        ['Michigan', 'MI'],
        ['Minnesota', 'MN'],
        ['Mississippi', 'MS'],
        ['Missouri', 'MO'],
        ['Montana', 'MT'],
        ['Nebraska', 'NE'],
        ['Nevada', 'NV'],
        ['New Hampshire', 'NH'],
        ['New Jersey', 'NJ'],
        ['New Mexico', 'NM'],
        ['New York', 'NY'],
        ['North Carolina', 'NC'],
        ['North Dakota', 'ND'],
        ['Ohio', 'OH'],
        ['Oklahoma', 'OK'],
        ['Oregon', 'OR'],
        ['Pennsylvania', 'PA'],
        ['Rhode Island', 'RI'],
        ['South Carolina', 'SC'],
        ['South Dakota', 'SD'],
        ['Tennessee', 'TN'],
        ['Texas', 'TX'],
        ['Utah', 'UT'],
        ['Vermont', 'VT'],
        ['Virginia', 'VA'],
        ['Washington', 'WA'],
        ['West Virginia', 'WV'],
        ['Wisconsin', 'WI'],
        ['Wyoming', 'WY'],
    ];

    if (to == 'abbr'){
        input = input.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
        for(i = 0; i < states.length; i++){
            if(states[i][0] == input){
                return(states[i][1]);
            }
        }    
    } else if (to == 'name'){
        input = input.toUpperCase();
        for(i = 0; i < states.length; i++){
            if(states[i][1] == input){
                return(states[i][0]);
            }
        }    
    }
}


function setStates() {
	var states ={};

	["HI", "AK", "FL", "SC", "GA", "AL", "NC", "TN", "RI", "CT", "MA",
	"ME", "NH", "VT", "NY", "NJ", "PA", "DE", "MD", "WV", "KY", "OH", 
	"MI", "WY", "MT", "ID", "WA", "DC", "TX", "CA", "AZ", "NV", "UT", 
	"CO", "NM", "OR", "ND", "SD", "NE", "IA", "MS", "IN", "IL", "MN", 
	"WI", "MO", "AR", "OK", "KS", "LS", "VA"]
	.forEach(function(d){
	  //var feeling=getEmotionVals(0,0);
	  var feeling=getEmoNum("disgust", abbrState(d, 'name'));
	  states[d]={feeling:feeling, color:d3.interpolate("#ffffcc", "#800026")*feeling}; 
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