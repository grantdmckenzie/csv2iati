

function validate() {
	  var e = null;
	  
	  $("input").each(function(index, domEle) {
	    domEle.style.borderColor = '#cccccc';
	  });
	  
	  if ($('[name=first]').val().length < 1)
	    e = '[name=first]';
	  else if ($('[name=last]').val().length < 1)
	    e = '[name=last]';
	  else if ($('[name=username]').val().length < 5)
	    e = '[name=username]';
	  else if ($('[name=password]').val().length < 4)
	    e = '[name=password]';
	  else if ($('[name=organization]').val().length < 5)
	    e = '[name=organization]';  
	  else if ($('[name=reference]').val().length < 2)
	    e = '[name=reference]';  
	  else if ($('[name=orgtype]').val().length < 1)
	    e = '[name=orgtype]'; 
	    
	  
	  
	  if(!e) {
	    registerUser();
	  } else {
	    $(e).css('border-color','#ff0000');
	    $('#error').html('Please fix the highlighted error below before continuing');
	  }
	}
	
	function registerUser() {
	  var data = {}
	  $("input").each(function(index, domEle) {
	    data[domEle.name] = escape(domEle.value);
	  });
	  
	  $.ajax({
	    type: "POST",
	    url: 'handler_updateuser.php',
	    data: data,
	    success: function(data) {
	      if (data == "TRUE") {
		$('#register').fadeOut(function() {
		  $('#registerNotification').html("Your profile was updated successfully.");
		  $('#registerNotification').fadeIn();
		});
	      } else {
		  $('[name=username]').css('border-color','#ff0000');
		  $('#error').html(data);
	      }
	    },
	    dataType: 'text'
	  });
	}