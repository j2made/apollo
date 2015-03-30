$(document).ready(function(){
  $('.pattern-button').click(function(event) {
    event.preventDefault();

    var nextEl = $(this).next('.pattern-code-input');
    $(nextEl).slideToggle(300);
  });
});