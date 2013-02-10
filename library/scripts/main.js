/*

  lt3-theme Scripts

------------------------------------------------	
  Description: 
  Version:     1.0
------------------------------------------------ */

/* Remove the .js class from the html tag is javascript is enabled
------------------------------------- */
document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/g, '') + ' js ';

/* Avoid `console` errors in browsers that lack a console. [from boilerplate]
------------------------------------- */
(function() 
{
  var method;
  var noop = function () {};
  var methods = [
    'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
    'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
    'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
    'timeStamp', 'trace', 'warn'
  ];
  var length = methods.length;
  var console = (window.console = window.console || {});
  while (length--) 
  {
    method = methods[length];
    if (!console[method]) 
    {
      console[method] = noop;
    }
  }
}());


/* jQuery No Conflict
------------------------------------- */
jQuery.noConflict();

/* Scripts to run after the document is ready
------------------------------------- */
jQuery(document).ready(function($)
{

  /* Replace Placeholder attributes fix for older browsers.
  ------------------------------------- */
  $('[placeholder]').focus(function() 
  {
    var input = $(this);
    if (input.val() == input.attr('placeholder')) 
    {
      input.val('');
      input.removeClass('placeholder');
    }
  }).blur(function() 
  {
    var input = $(this);
    if (input.val() == '' || input.val() == input.attr('placeholder')) 
    {
      input.addClass('placeholder');
      input.val(input.attr('placeholder'));
    }
  }).blur().parents('form').submit(function() 
  {
    $(this).find('[placeholder]').each(function() 
    {
      var input = $(this);
      if (input.val() == input.attr('placeholder')) 
      {
        input.val('');
      }
    })
  });
  
  // any other document ready scripts can go here:

});