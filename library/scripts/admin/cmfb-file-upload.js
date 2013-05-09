/**
 * Custom Meta Field Boxes File Upload
 * ------------------------------------------------------------------------
 * cmfb-file-upload.js
 * @version 1.0 | May 9th 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license MIT license
 * ------------------------------------------------------------------------ */
(function($) {
  $('.custom_upload_file_button').click(function() {
    var $formField = $(this).siblings('.custom_upload_file');
    tb_show('Select a File', 'media-upload.php?type=image&TB_iframe=true');
    window.send_to_editor = function(html) {
     var $fileUrl = $(html).attr('href');
     $formField.val($fileUrl);
     tb_remove();
    };
    return false;
  } );
  $('.custom_clear_file_button').click(function() {
    $(this).parent().siblings('.custom_upload_file').val('');
    return false;
  });
}(jQuery));