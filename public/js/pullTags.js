jQuery(document).ready(function () {
    var tags = jQuery('#hidTags').text()
    
    
    var tags = tags.split(",").map(function(item) {
        return item.trim();
      });
      jQuery('.myTags').val(tags); 
      jQuery('.myTags').tagit();
      $('.carousel-item').first().addClass('active');
      $('#carouselExampleFade').carousel({
        interval: 2000
      })
});