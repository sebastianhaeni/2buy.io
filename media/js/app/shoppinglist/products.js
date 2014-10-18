function showProducts(el){
	el.parent().parent().children().removeClass('active');
	el.parent().addClass('active');
	$('#transactionlist').hide();
	$('#shoppinglist').hide();
	$('#statslist').hide();
	$('#productlist').show();
	

}
function loadProductList(){

}