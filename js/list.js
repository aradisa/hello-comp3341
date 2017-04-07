$(document).ready(function() {

	$('#addProduct').click(function() {
		//Get value of item name
		var itemName_input = $('#productName').val();        
		var listid_input = $('#listid').val();

		//Lets disable all input fields to stop users from entering twice
		$('#productName, #addProduct').prop("disabled", true);

		//Lets send the data to our PHP file
		request = $.ajax({
			url: "ajax/addItemsToList.php",
			type: "post",
			data: { listid : listid_input, itemName : itemName_input}
		});

		// If we're successfull!
		request.done(function (response, textStatus, jqXHR){
            var newItemID = response;
			$("#toDoList").append('<li>'+itemName_input+'<span data-itemid="'+newItemID+'" class="glyphicon glyphicon-remove deleteItem"></span></li></li>');
			$('#productName').val("");
		});

		// If we're successfull or it failed - re-enable fields
	    request.always(function () {
	        $('#productName, #addProduct').prop("disabled", false);
	    });

	});


    $('body').on('click', '.deleteItem', function() {
        //GET itemID
        var itemId = $(this).data("itemid");
        var listItem = $(this).parent();
        
        request = $.ajax({
            url: "ajax/removeItemsFromList.php",
            type: "post",
            data: {itemid : itemId}
        });
        
        request.done(function (response, textStatus, jqXHR){
            listItem.remove();
        });
    });
});