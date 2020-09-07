jQuery(document).ready(function () {
  var tags = jQuery('#hidTags').text()


  var tags = tags.split(",").map(function (item) {
    return item.trim();
  });
  console.log("tags: " + tags)
  jQuery('.myFormTags').val(tags);
  jQuery('.myFormTags').tagit();
  $('#carouselExampleFade').carousel({
    interval: false
  })



});

function deleteImage() {
  console.log($('.carousel-item.active').find('.id'))
  var id = $('.carousel-item.active').find('.id').text().trim()
  if (confirm('Are You Sure?')) {
    fetch(`/image/delete/` + id, {
      method: 'DELETE',

    }).then(() => {
      $('.carousel-item.active').remove()
      $('.carousel-item').first().addClass('active')

    })

  }
}