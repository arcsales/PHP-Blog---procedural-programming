$(document).ready(function() {
  // CKEditor
  ClassicEditor.create(document.querySelector("#body")).catch(error => {
    console.error(error);
  });

  //Rest of the code
  $("#selectAllBoxes").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
});

/*   $('#selectAllBoxes').click(function(event) {
    if (this.checked) {
      $('.checkBoxes').each(function() {
        this.checked = true;
      });
    } else {
      $('.checkBoxes').each(function() {
        this.checked = false;
      });
    }
  }); */
});
