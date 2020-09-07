jQuery(document).ready(function () {
    getTags();
    $('.carousel-item').first().addClass('active');
    $('.carouselCustomer:odd').carousel({
        interval: 6000
    })
    $('.carouselCustomer:even').carousel({
        interval: 5000
    })
  
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
        var deleteButton = "<a id='delButton_" + (counter - 1) + "' class='btn btn-danger form-control' href='javascript:remove(" + (counter - 1) + ")' >Cancel the upload for this image</a>";
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget + deleteButton);
        newElem.appendTo(list);
        countImgs++;
        updateCounter();
    });

    $(".myTags").tagit();
    $(".readTags").tagit({
        readOnly: true
    });

    // $('.readTags').each($('li').click( function(e){

    //     window.location.href = '/customerView/' +$(this).find('.tagit-label').text();

    // }));

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
    var prototypeFieldName = 'product[tags][__name__][name]';
    var fieldIndex = 0;

    $('.myTags').tagit({
        fieldName: prototypeFieldName.replace('__name__', fieldIndex),
        beforeTagAdded: function (event, ui) {
            fieldIndex++;
            $(this).tagit({ fieldName: prototypeFieldName.replace('__name__', fieldIndex) });
        }
    });

    countImgs = 0;

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
    alert("Hire me! :D");
}


function updateCounter() {

    jQuery("#countImgs").html(countImgs + ' images added.');
}


function remove(counter) {
    jQuery('#form_imagesFiles_' + counter).remove();
    jQuery('#delButton_' + counter).remove();
    countImgs--;
    updateCounter();


}

