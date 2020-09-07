jQuery(document).ready(function () {

    jQuery('.add-another').click(function (e) {
        var list = jQuery(jQuery(this).attr('data-list-selector'));
        var counter = list.data('widget-counter') || list.children().length;
        
        if ($(this).hasClass('page-button') && counter>0 ){
           return;
        }
      
        var newWidget = list.attr('data-prototype');
        newWidget = newWidget.replace(/__name__/g, counter);
        counter++;
        list.data('widget-counter', counter);
        var deleteButton = "<a id='delButton_"+(counter-1)+"' class='btn btn-danger form-control' href='javascript:remove("+ (counter-1) +")' >Delete</a>";
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget +deleteButton );       
        newElem.appendTo(list);
        countImgs++;
        updateCounter();
    });

    $(".myTags").tagit();
});

function buy(){
    alert("No you won't! hehehe");
}