jQuery(document).ready(function () {


    var prototypeFieldName = 'product[tags][__name__][name]';
        var fieldIndex = 0;
 
        $('.myTags').tagit({
            fieldName: prototypeFieldName.replace('__name__', fieldIndex),
            beforeTagAdded: function (event, ui) {
                fieldIndex++;
                $(this).tagit({fieldName: prototypeFieldName.replace('__name__', fieldIndex)});
            }
        });
 
    countImgs = 0;
   


    
});

function updateCounter(){
    
    jQuery("#countImgs").html(countImgs+ ' images added.');
}


function remove(counter){
    jQuery('#form_imagesFiles_'+counter).remove();
    jQuery('#delButton_'+counter).remove();
    countImgs--;
    updateCounter();

    
}
