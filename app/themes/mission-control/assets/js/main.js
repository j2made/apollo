
(function($) {

/**
 * Page Specific Functions
 *
 * Fires js based on body class. If body class contains a dash, replace it
 * with an underscore. So the class `front-page` should be `front_page`
 */
var Apollo = {
  // All pages
  common: {
    init: function() {
      // JavaScript to be fired on all pages
      var commonScripts = require('commonScripts.js');
      commonScripts();
    },
    finalize: function() {
      // JavaScript to be fired on all pages, after page specific JS is fired
    }
  },
  // Home page
  front_page: {
    init: function() {

    },
    finalize: function() {

    }
  }
};

// Fire page specific events
var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = Apollo;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {
    // Fire common init JS
    UTIL.fire('common');

    // Fire page-specific init JS, and then finalize JS
    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
      UTIL.fire(classnm, 'finalize');
    });

    // Fire common finalize JS
    UTIL.fire('common', 'finalize');
  }
};

// Load Events
$(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.