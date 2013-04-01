/*

  lt3 Shortcode Scripts

------------------------------------------------
  shortcode.js
  @version 2.0 | April 1st 2013
  @package lt3
  @author  Beau Charman | @beaucharman | http://beaucharman.me
  @link    https://github.com/beaucharman/lt3
  @licence GNU http://www.gnu.org/licenses/lgpl.txt
------------------------------------------------ */

jQuery(document).ready(function($){

  /* Tabbed content shortcode scripts
  ------------------------------------- */
  var pane_height = 0, // the height of the highest element (after the function runs)
    test_pane;  // the highest element (after the function runs)
    $pane = $('.tabbed-content-container .pane');
    $panes = $('.tabbed-content-container .panes');
  $pane.each(function () {
      $this = $(this);
      if ($this.height() > pane_height) {
          test_pane = this;
          pane_height = $this.height();
      }
  });
  $pane.css('max-width', '100%');
  $panes.css('min-height', pane_height);
  $('.tabbed-content-container .tabs li:first').addClass('tab-active');
  $pane.not(':eq(0)').css('display','none');
  $('.tabbed-content-container .tabs li').click(function() {
      $('.tabbed-content-container .tabs li').removeClass('tab-active');
      $(this).addClass('tab-active');
      var which = $('.tabs li').index(this);
      $(this).parent().parent().find('.pane').css('display','none');
      $(this).parent().parent().find('.pane').eq(which).css('display','block');
  });

  /* Toggle content shortcode scripts
  ------------------------------------- */
  $('.toggle-content').hide();

  $('.toggle-handle').toggle(function(){
    $(this).addClass('toggle-active');
  }, function () {
    $(this).removeClass('toggle-active');
  });

  $('.toggle-handle').click(function(){
    $(this).next('.toggle-content').stop(true, true).slideToggle();
  });

});