
$('#history').click(function(){
    showHistory($(this));
});

$('#stats').click(function(){
    showStats($(this));
});

$('#shopping').click(function(){
    showShoppingList($(this));
});

$('#products').click(function(){
    showProducts($(this));
});



function init(){
    if(window.location.hash == "#history"){
        showHistory($('#history'));
    } else if(window.location.hash == "#stats"){
        showStats($('#stats'));
    } else if(window.location.hash == "#products"){
        showProducts($('#products'));
    }
}