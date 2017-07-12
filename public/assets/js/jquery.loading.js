/**
 * Adds a loading overlay on the element.
 *
 * That jQuery function must be run with a CSS style.
 * See the stylesheet bellow for more informations.
 *
 * @param {Boolean} state    [optional] Set to false to remove the overlay.
 * @param {String}  addClass [optional] One or several class to add to the overlay
 * @return {jQuery} The current jQuery object (allow chaining)
 */
$.fn.loading = function(state, addClass) {

  // element to animate
  var $this = $(this);
  // hide or show the overlay
  state = state === undefined ? true : !!state;

  $this.each(function(i, element) {

    var $element = $(element);

    // if we want to create and overlay and any one exists
    if( state && $element.find(".js-loading-overlay").length === 0 ) {

      // creates the overlay
      var $overlay = $("<div/>").addClass("js-loading-overlay");
      // add a class
      if(addClass !== undefined) {
          $overlay.addClass(addClass);
      }
      // appends it to the current element
      $element.append( $overlay ).addClass("js-loading");
      // show the element
      $overlay.stop().hide().fadeIn(10);

      // Disables all inputs
      $this.find("input,button,.btn").addClass("disabled").prop("disabled", true);

    // if we want to destroy this overlay
    } else if(!state) {
      // just destroys it
      $element.removeClass("js-loading").find(".js-loading-overlay").remove();

      // Unabled all inputs
      $this.find("input,button,.btn").removeClass("disabled").prop("disabled", false);
    }

  });

  return this;

};