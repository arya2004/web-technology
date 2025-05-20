// script.js
// Ensure DOM is ready
$(function() {
  // 1. Copy selected items from #sourceList to #targetList
  $('#copyBtn').on('click', function() {
    // Find all selected <option> in source
    $('#sourceList option:selected').each(function() {
      const val = $(this).val();
      const txt = $(this).text();

      // Only copy if not already in target
      if ($('#targetList option[value="' + val + '"]').length === 0) {
        // Clone the option and append
        $('#targetList').append(
          $('<option></option>').val(val).text(txt)
        );
      }
    });
  });

  // 2. Create new paragraph elements in #dynamicArea
  $('#addParaBtn').on('click', function() {
    const text = $('#newText').val().trim();
    if (text) {
      // Create a new <p> element and append
      const $p = $('<p></p>').text(text);
      $('#dynamicArea').append($p);

      // Clear input
      $('#newText').val('');
    } else {
      // If empty, give a quick shake animation
      $('#newText').addClass('is-invalid');
      setTimeout(() => {
        $('#newText').removeClass('is-invalid');
      }, 500);
    }
  });
});
