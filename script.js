function note_new() {
  api_call(JSON.stringify({
    verb: 'create',
    color: $('input[name="new_note_color"]').val(),
    subject: $('input[name="new_note_subject"]').val(),
    content: $('textarea[name="new_note_content"]').val()
  }));
}

function note_edit(note_id) {

  // add the .new_note class to get some nicer UI elements
  $('div.note_id_' + note_id).addClass('new_note');

  // drop edit/del buttons
  $('div.note_id_' + note_id + ' div.buttons').remove();

  // turn the subject into an input
  var subject = $('div.note_id_' + note_id + ' div.subject').text();
  $('div.note_id_' + note_id + ' div.subject').remove();
  $('div.note_id_' + note_id).append(
    "<label for='update_note_subject'>Subject</label>" +
    "<input name='update_note_subject' type='text' value='"+subject+"' /><br />"
  );

  // now add the color-picker
  var color = $('div.note_id_' + note_id).css('border-color');
  $('div.note_id_' + note_id).append(
    "<label for='update_note_color'>Color</label>" +
    "<input name='update_note_color' type='color' value='"+color+"' /><br />"
  );

  // and the content
  var content = $('div.note_id_' + note_id + ' div.plaintext').text();
  $('div.note_id_' + note_id + ' div.plaintext').remove();
  $('div.note_id_' + note_id + ' div.html').remove();
  $('div.note_id_' + note_id).append(
    "<label for='update_note_content'>Content</label><br />" +
    "<textarea name='update_note_content'>"+content+"</textarea><br />" +
    "<p>hint: you can use <a href='https://daringfireball.net/projects/markdown/' target='_blank'>markdown</a></p>" +
    "<div class='buttons'>" +
    "<input type='button' onclick='location.reload()' value='Cancel' />" +
    "<input type='button' onclick='note_update("+note_id+")' value='Update Note' />" +
    "</div>"
  );

}

function note_update(note_id) {
  api_call(JSON.stringify({
    verb: 'edit',
    id: note_id,
    color: $('input[name="update_note_color"]').val(),
    subject: $('input[name="update_note_subject"]').val(),
    content: $('textarea[name="update_note_content"]').val()
  }));
}

function note_delete(note_id) {
  if(confirm('Delete Note?')) {
    api_call(JSON.stringify({
      verb: 'delete',
      id:  note_id
    }));
  }
}

function api_call(data) {
  $.ajax({
    method: 'POST',
    url: 'api.php',
    contentType: 'application/x-www-form-urlencoded',
    data: data
  }).done(function(result) {
    if(result == 'true') {
      location.reload();
    }
    else {
      console.log(result);
      alert('API Call Failed');
    }
  });
}
