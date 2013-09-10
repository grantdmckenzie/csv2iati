function removeModel(id) {
  confirm('Are you sure you want to delete this model?');
  OK: deleteFromDB(id);
}

function deleteFromDB(id) {
    $.ajax({
      type: "POST",
      url: 'handler_deletemodel.php',
      data: {id:id},
      success: function(data) {
	if (data == "TRUE\n") {
	  window.location = "models.php";
	} else {
	  alert(data);
	}
      },
      dataType: 'text'
    });
}