function note_new() {
  api_call(JSON.stringify({
    verb: 'create',
    color: $('input[name="new_note_color"]').val(),
    subject: $('input[name="new_note_subject"]').val(),
    content: $('textarea[name="new_note_content"]').val()
  }));
}

function note_edit(note_id) {
  api_call(JSON.stringify({
    verb: 'edit',
    id: note_id,
    color:  '#000001',
    subject: 'some-subject',
    content: 'some-content'
  }));
}

function note_delete(note_id) {
  api_call(JSON.stringify({
    verb: 'delete',
    id:  note_id
  }));
}

function api_call(data) {
  $.ajax({
    method: 'POST',
    url: 'api.php',
    contentType: 'application/x-www-form-urlencoded',
    data: data
  }).done(function() {
    location.reload();
  });
}
