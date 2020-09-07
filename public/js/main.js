jQuery(document).ready(function () {
    getTags();

    jQuery('.add-another').click(function (e) {
        var list = jQuery(jQuery(this).attr('data-list-selector'));
        var counter = list.data('widget-counter') || list.children().length;

        if ($(this).hasClass('page-button') && counter > 0) {
            return;
        }

        var newWidget = list.attr('data-prototype');
        newWidget = newWidget.replace(/__name__/g, counter);
        counter++;
        list.data('widget-counter', counter);
        var deleteButton = "<a id='delButton_" + (counter - 1) + "' class='btn btn-danger form-control' href='javascript:remove(" + (counter - 1) + ")' >Delete</a>";
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget + deleteButton);
        newElem.appendTo(list);
        countImgs++;
        updateCounter();
    });

    $(".myTags").tagit();



    // $('#teste').pagination({
    //     dataSource: function(done) {
    //         $.ajax({
    //             type: 'GET',
    //             url: '/product/all',
    //             success: function(response) {
    //                 done([response]);
    //             }
    //         })},
         
       
    // })




});

function getTags() {
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
        tags = JSON.parse(xhr.response);
        $("#form_query").autocomplete({
            source: tags,
        })



    }
    xhr.open("GET", `/tag/all`);
    xhr.send();
}

function buy() {
    alert("No you won't! hehehe");
}


