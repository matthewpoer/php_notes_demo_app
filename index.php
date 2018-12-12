<?php

require_once('class.database.php');
require_once('class.notes.php');

echo '<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>';
echo '<script type="text/javascript" src="script.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="style.css">';
echo '<h1>Notes Listing</h1>';

$notes = Notes::load_notes();
if(empty($notes)) {
  echo '<div>No Notes Found';
}
else {
  echo '<div class="notes_wrapper">';
  foreach($notes as $note) {
    echo "<div class='note note_id_{$note['id']}' style='border-color:{$note['color']};'>";
    echo "  <div class='subject'>{$note['subject']}</div>";
    echo "  <div class='content'>{$note['content']}</div>";
    echo '  <div class="buttons">';
    echo "    <input type='button' onclick='note_edit({$note['id']})' value='edit' />";
    echo "    <input type='button' onclick='note_delete({$note['id']})' value='delete' />";
    echo '  </div>';
    echo '</div>';
  }
}

echo "<div class='note new_note'>";
echo "  <label for='new_note_subject'>Subject</label>";
echo "  <input name='new_note_subject' type='text' /><br />";
echo "  <label for='new_note_content'>Content</label><br />";
echo "  <textarea name='new_note_content'></textarea><br />";
echo "  <div class='buttons'><input type='button' onclick='note_new()' value='Save New Note' /></div>";
echo "</div>";

echo '</div>';
