/**
 * Plugins
 * ========================================================================
 * plugins.js
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * Basically any modular, stand alone script or plugin lives here
 * ======================================================================== */

/**
 * Remove the .no-js class from the html tag
 * to flag that is javascript is enabled
 */
var documentClassName = document.documentElement.className;
documentClassName = documentClassName.replace(/\bno-js\b/g, '') + ' js ';

/**
 * Avoid `console` errors in browsers that lack a console. [from boilerplate]
 */
(function () {
  'use strict';
  var method;
  var noop = function () {};
  var methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error', 'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd', 'timeStamp', 'trace', 'warn'];
  var length = methods.length;
  var console = (window.console = window.console || {});
  while (length--) {
    method = methods[ length ];
    if (! console[method]) {
      console[ method ] = noop;
    }
  }
}());

// let the plugin definitions begin.
