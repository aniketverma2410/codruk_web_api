function deleteRecord(location,word,id)
{
	var con = confirm('Are You Sure to delete this '+word);
	if(con == true)
	{
		$.ajax({
		  method: "POST",
		  url: location+'/'+id
		})
		  .done(function( msg ) {
		    //alert( "Data Saved: " + msg );
		    if(msg!='')
		    $('#row_'+id).remove();
		  });
		//window.location = location+'/'+id;
	}
}

function statusRecord(location,word,id)
{
	var con = confirm('Are You Sure to change status');
	if(con == true)
	{
		$.ajax({
		  method: "POST",
		  url: location+'/'+id
		})
		  .done(function( msg ) {
		    //alert( "Data Saved: " + msg );
		    if(msg!='')
		    $('#row_'+id).remove();
		  });
		//window.location = location+'/'+id;
	}
}
