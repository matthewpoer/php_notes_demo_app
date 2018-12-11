<?php

require_once('class.database.php');
require_once('class.notes.php');

echo '<script type="text/javascript" src="script.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="style.css">';
echo '<h1>Notes Listing</h1>';

echo "<div class='new_note'>";
echo "  <input type='button' onclick='note_new()' value='New Note' />";
echo "</div>";

$notes = Notes::load_notes();
if(empty($notes)) {
  echo '<div>No Notes Found</div>';
}
else {
  foreach($notes as $note) {
    echo "<div class='note note_id_{$note['id']}' style='border-color:{$note['color']};'>";
    echo "  <div class='subject'>{$note['subject']}</div>";
    echo "  <div class='content'>{$note['content']}</div>";
    echo "  <div class='buttons'>";
    echo "    <input type='button' onclick='note_edit({$note['id']})' value='edit' />";
    echo "    <input type='button' onclick='note_delete({$note['id']})' value='delete' />";
    echo "  </div>";
    echo '</div>';
  }
}
