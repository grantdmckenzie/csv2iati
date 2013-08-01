var _count = 0;

$(document).ready(function() {
  
  $.each( iati_template, function( key, value ) {
    $('#iati_fields')
         .append($("<option></option>")
         .attr("value",key)
         .text(key)); 
  });
  
  $('#iati_fields').change(function() {
      var field = $("select option:selected").val();
      fieldLookUp(field);
  });
  
});



  function fieldLookUp(field) {
    _count = Math.floor((Math.random()*10000)+1);
    var x = iati_template[field];
    if(x['datatype'] == "compound") {
      jQuery('<div/>', {
	    id: field+"."+_count,
	    title: x.label,
	    text: x.label,
	    class: 'field'
	}).appendTo('#workspace');
      
      // Allow users to remove field
      var remove = "<div class='close' onclick='removeField(\""+field+"."+_count+"\")' style='cursor:pointer' title='remove'>x</div>";
      $('[id='+field+"\\."+_count+']').append(remove);
      
      // Loop through all fields
      $.each(x['fields'], function(k1,v1) {
	  if(v1.hasOwnProperty('fields')) {
	    var section = "<div class='sub1' id='"+field+"."+_count+"_"+k1+"'><b>"+k1+"</b></div>";
	    $('#'+field+"\\."+_count).append(section);
	    $.each(v1['fields'], function(k2,v2) {
		if(v2.hasOwnProperty('fields')) {
		  var section = "<div class='sub2' id='"+field+"."+_count+"_"+k1+"_"+k2+"'><b>"+k2+"</b></div>";
		  $('#'+field+"\\."+_count+"_"+k1).append(section);
		  $.each(v2['fields'], function(k3,v3) {
		    if(v3.hasOwnProperty('fields')) {
		      var section = "<div class='sub3' id='"+field+"."+_count+"_"+k1+"_"+k2+"_"+k3+"'><b>"+k3+"</b></div>";
		      $('#'+field+"\\."+_count+"_"+k1+"_"+k2).append(section);
		      $.each(v3['fields'], function(k4,v4) {
			  if(v4.hasOwnProperty('fields')) {
			    var section = "<div class='sub4' id='"+field+"."+_count+"_"+k1+"_"+k2+"_"+k3+"_"+k4+"'><b>"+k4+"</b></div>";
			    $('#'+field+"\\."+_count+"_"+k1+"_"+k2+"_"+k3).append(section);
			    $.each(v4['fields'], function(k5,v5) {
			      if(v5.hasOwnProperty('fields')) {
				var section = "<div class='sub5' id='"+field+"."+_count+"_"+k1+"_"+k2+"_"+k3+"_"+k4+"_"+k5+"'><b>"+k5+"</b></div>";
				$('#'+field+"\\."+_count+"_"+k1+"_"+k2+"_"+k3+"_"+k4).append(section);
			      } else {
				var section = "<div class='sub5' id='"+field+"."+_count+"_"+k1+"_"+k2+"_"+k3+"_"+k4+"_"+k5+"'>"+k5+"</div>";
				$('#'+field+"\\."+_count+"_"+k1+"_"+k2+"_"+k3+"_"+k4).append(section);
				if(v5['datatype'] == "column") {
				    $('#'+field+"\\."+_count+"_"+k1+"_"+k2+"_"+k3+"_"+k4+"_"+k5).append(showCSVColumns(field+"."+_count+"_"+k1+"_"+k2+"_"+k3+"_"+k4+"_"+k5));
				}
			      }
			    });
			  } else {
			    var section = "<div class='sub4' id='"+field+"."+_count+"_"+k1+"_"+k2+"_"+k3+"_"+k4+"'>"+k4+"</div>";
			    $('#'+field+"\\."+_count+"_"+k1+"_"+k2+"_"+k3).append(section);
			    if(v4['datatype'] == "column") {
				$('#'+field+"\\."+_count+"_"+k1+"_"+k2+"_"+k3+"_"+k4).append(showCSVColumns(field+"."+_count+"_"+k1+"_"+k2+"_"+k3+"_"+k4));
			    }
			  }
		      });
		    } else {
		      var section = "<div class='sub3' id='"+field+"."+_count+"_"+k1+"_"+k2+"_"+k3+"'>"+k3+"</div>";
		      $('#'+field+"\\."+_count+"_"+k1+"_"+k2).append(section);
		      if(v3['datatype'] == "column") {
			  $('#'+field+"\\."+_count+"_"+k1+"_"+k2+"_"+k3).append(showCSVColumns(field+"."+_count+"_"+k1+"_"+k2+"_"+k3));
		      }
		    }
		  });
		} else {
		  var section = "<div class='sub2' id='"+field+"."+_count+"_"+k1+"_"+k2+"'>"+k2+"</div>";
		  $('#'+field+"\\."+_count+"_"+k1).append(section);
		  if(v2['datatype'] == "column") {
		      $('#'+field+"\\."+_count+"_"+k1+"_"+k2).append(showCSVColumns(field+"."+_count+"_"+k1+"_"+k2));
		  } 
		}
	    });
	  } else {
	    var section = "<div class='sub1' id='"+field+"."+_count+"_"+k1+"'>"+k1+"</div>";
	    $('#'+field+"\\."+_count).append(section);
	    if(v1['datatype'] == "column") {
		$('#'+field+"\\."+_count+"_"+k1).append(showCSVColumns(field+"."+_count+"_"+k1));
	    }
	  }
      });
    }
  }
  
  
  function showCSVColumns(iati_field_key) {
      var select = "<select onchange='checkForManual(\""+iati_field_key+"\")' id='"+iati_field_key+"'>";
      $.each(csvcolumns, function(key,value) {
	  select += "<option value='"+value+"'>"+value+"</option>";
      });
      select += "</select>";
      select += "<input type='text' id='"+iati_field_key+"_txt' style='display:none'/>";
      return select;
  }
  
  function checkForManual(id) {
    var x = id.split(".");
    var y = x[0]+"\\."+x[1];
    var field = $("#"+y+" option:selected").val();
    if (field == "Manual Entry") {
      $('#'+y+'_txt').show();
    } else {
      $('#'+y+'_txt').hide();
    }
  }
  
  function removeField(id) {
    var x = id.split(".");
    var y = x[0]+"\\."+x[1];
    $('#'+y).remove(); 
  }
  
  
  function saveMapping() {
    _mapping = {};
    var matrix = new Array();
    var matchval = new Array();
    $("select").each(function(index, domEle) {
	
	if (domEle.id != "iati_fields") {
	  var e = domEle.id.split("_");
	  if (domEle.value == "Manual Entry") {
	    var x = domEle.id.split(".");
	    var y = x[0]+"\\."+x[1];
	    matchval.push($('#'+y+'_txt').val());
	  } else {	    
	    matchval.push(domEle.value);
	  }
	  matrix.push(e);
	}
    });

    for(var j=0;j<matrix.length;j++) {
      var match = false;
      for(var i=0;i<_mapping.length;i++) {
	if(temp[i] == matrix[j][0])
	   var match = true
      }
      if (!match) {
	_mapping[matrix[j][0]] = {};
      }
    }
    for(var i=0;i<matrix.length;i++) {
      if(matrix[i].length == 2) {
	_mapping[matrix[i][0]][matrix[i][1]] = matchval[i];
      }
    }
    for(var i=0;i<matrix.length;i++) {
      if(matrix[i].length == 3) {
	if(!_mapping[matrix[i][0]])
	  _mapping[matrix[i][0]] = {};
	if(!_mapping[matrix[i][0]][matrix[i][1]])
	  _mapping[matrix[i][0]][matrix[i][1]] = {};
	_mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]] = matchval[i];
      }
    }
    for(var i=0;i<matrix.length;i++) {
      if(matrix[i].length == 4) {
	if(!_mapping[matrix[i][0]])
	  _mapping[matrix[i][0]] = {};
	if(!_mapping[matrix[i][0]][matrix[i][1]])
	  _mapping[matrix[i][0]][matrix[i][1]] = {};
	if(!_mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]])
	  _mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]] = {};
	_mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]][matrix[i][3]] = matchval[i];
      }
    }
    for(var i=0;i<matrix.length;i++) {
      if(matrix[i].length == 5) {
	if(!_mapping[matrix[i][0]])
	  _mapping[matrix[i][0]] = {};
	if(!_mapping[matrix[i][0]][matrix[i][1]])
	  _mapping[matrix[i][0]][matrix[i][1]] = {};
	if(!_mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]])
	  _mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]] = {};
	if(!_mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]][matrix[i][3]])
	  _mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]][matrix[i][3]] = {};
	_mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]][matrix[i][3]][matrix[i][4]] = matchval[i];
      }
    }
    for(var i=0;i<matrix.length;i++) {
      if(matrix[i].length == 6) {
	if(!_mapping[matrix[i][0]])
	  _mapping[matrix[i][0]] = {};
	if(!_mapping[matrix[i][0]][matrix[i][1]])
	  _mapping[matrix[i][0]][matrix[i][1]] = {};
	if(!_mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]])
	  _mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]] = {};
	if(!_mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]][matrix[i][3]])
	  _mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]][matrix[i][3]] = {};
	if(!_mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]][matrix[i][3]][matrix[i][4]])
	  _mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]][matrix[i][3]][matrix[i][4]] = {};
	_mapping[matrix[i][0]][matrix[i][1]][matrix[i][2]][matrix[i][3]][matrix[i][4]][matrix[i][5]] = matchval[i];
      }
    }
    var ser = escape(JSON.stringify(_mapping, null, 2));
    $('#map').val(ser);
  }
  