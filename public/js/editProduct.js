jQuery(document).ready(function () {
    var tags = jQuery('#hidTags').text()
    
    
    var tags = tags.split(",").map(function(item) {
        return item.trim();
      });
      jQuery('.myTags').val(tags); 
      jQuery('.myTags').tagit();
      $('.carousel-item').first().addClass('active');
      $('#carouselExampleFade').carousel({
        interval: false
      })


      
});

function deleteImage(){
  console.log($('.carousel-item.active').find('.id'))
 var id= $('.carousel-item.active').find('.id').text().trim()
  if(confirm('Are You sure?' + id)){
    fetch(`/image/delete/`+id, {
        method: 'DELETE',

    }).then(res => window.location.reload())
}
}