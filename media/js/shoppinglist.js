function showShoppingList(el) {
    el.parent().parent().children().removeClass('active');
    el.parent().addClass('active');
    $('#transactionlist').hide();
    $('#statslist').hide();
    $('#productlist').hide();
    $('#shoppinglist').show();

    loadShoppingList();
}

function loadShoppingList() {

}

