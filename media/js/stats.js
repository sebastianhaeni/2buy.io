
function showStats(el){
	el.parent().parent().children().removeClass('active');
	el.parent().addClass('active');
	$('#transactionlist').hide();
	$('#shoppinglist').hide();
	$('#productlist').hide();
	$('#statslist').show();
	
	loadStats();
}


function loadStats(){

}