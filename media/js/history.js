
function showHistory(el){
	el.parent().parent().children().removeClass('active');
	el.parent().addClass('active');
	$('#shoppinglist').hide();
	$('#statslist').hide();
	$('#productlist').hide();
	$('#transactionlist').show();
	
	loadTransactionList();
}

function loadTransactionList(){

}
