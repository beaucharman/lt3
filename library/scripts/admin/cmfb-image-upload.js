/**
 * Custom Meta Field Boxes Image Upload
 * ========================================================================
 * cmfb-image-upload.js
 * @version 1.0 | May 27th 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license MIT license
 * ======================================================================== */
;(function($) {

  $('.custom_upload_image_button').click(function () {

    var imgUrl, classes, id;
    var formField = $(this).siblings('.custom_upload_image');
    var preview   = $(this).siblings('.custom_preview_image');

    tb_show('', 'media-upload.php?type=image&TB_iframe=true');

    window.send_to_editor = function (html) {

      imgUrl  = $('img',html).attr('src');
      classes = $('img', html).attr('class');
      id      = classes.replace(/(.*?)wp-image-/, '');

      formField.val(id);
      preview.attr('src', imgUrl);
      tb_remove();
    };

    return false;

  });

  $('.custom_clear_image_button').click(function () {

    var defaultImage = $(this).parent().siblings('.custom_default_image').val();

    $(this).parent().siblings('.custom_upload_image').val('');
    $(this).parent().siblings('.custom_preview_image').attr('src', defaultImage);

    return false;

  });

})(jQuery);