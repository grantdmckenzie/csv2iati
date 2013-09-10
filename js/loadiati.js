var _iatiCodes = {};
var _iatiNames = [];
var _iatiTypeCodes = {};
var _iatiTypeNames = [];

$(document).ready(function() {
    iatiIDs();
    iatiTypes();
  
    $("#orgname").autocomplete({
      source: _iatiNames,
      select: function(event, ui) {
	  $("#orgref").val(_iatiCodes[ui.item.value]);
      }
    });
    
    $("#orgtypenames").autocomplete({
      source: _iatiTypeNames,
      select: function(event, ui) {
	  $("#orgtype").val(_iatiTypeCodes[ui.item.value]);
      }
    });
  
});

  function iatiIDs() {
    
    // https://docs.google.com/spreadsheet/tq?tqx=out:json&tq=select%20A,%20C&key=0AnWngmdQt3stdFppMWdkcXJqVTRWTk9menR1N0FXNGc#gid=0'
    $.ajax({
      type: "GET",
      url: 'iati_ref.xml',
      success: function(data) {
	  /* data = data.replace("// Data table response\ngoogle.visualization.Query.setResponse(","");
	  data = data.substring(0,data.length-2);
	  var r = $.parseJSON(data);
	  for(var i=1;i<r.table.rows.length;i++) {
	      _iatiIDs[r.table.rows[i].c[0].v] = r.table.rows[i].c[1].v;
	  } */
	  
	  $(data).find('OrganisationalIdentifier').each(function(){
	      _iatiCodes[$(this).find('name').text()] = $(this).find('code').text();
	      _iatiNames.push($(this).find('name').text());
	  });
      },
      error: function(a,b,c) {
	  var x = 1;
      },
      dataType: 'xml'
    });
  }
  
  function iatiTypes() {
    $.ajax({
      type: "GET",
      url: 'iati_type.xml',
      success: function(data) {
	  $(data).find('OrganisationType').each(function(){
	      _iatiTypeCodes[$(this).find('name').text()] = $(this).find('code').text();
	      _iatiTypeNames.push($(this).find('name').text());
	  });
      },
      error: function(a,b,c) {
	  var x = 1;
      },
      dataType: 'xml'
    });
  }