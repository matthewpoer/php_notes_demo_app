<?php

require_once('class.database.php');
require_once('class.notes.php');
require_once('vendor/autoload.php');

echo '<script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.min.js"></script>';
echo '<script src="//cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">';

echo '<script type="text/javascript" src="script.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="style.css">';

$notes = Notes::load_notes();

echo '<div class="notes_wrapper">';
echo "<div class='note new_note'>";
echo "  <label for='new_note_subject'>Subject</label>";
echo "  <input name='new_note_subject' type='text' /><br />";
echo "  <label for='new_note_color'>Color</label>";
echo "  <input name='new_note_color' type='color' /><br />";
echo "  <label for='new_note_content'>Content</label><br />";
echo "  <textarea name='new_note_content'></textarea><br />";
echo "  <p>hint: you can use <a href='https://daringfireball.net/projects/markdown/' target='_blank'>markdown</a></p>";
echo "  <div class='buttons'><input type='button' onclick='note_new()' value='Save New Note' /></div>";
echo "</div>";

foreach($notes as $note) {
  $content_html = Michelf\Markdown::defaultTransform($note['content']);
  echo "<div class='note note_id_{$note['id']}' style='border-color:{$note['color']};'>";
  echo "  <div class='subject'>{$note['subject']}</div>";
  echo "  <div class='content plaintext'>{$note['content']}</div>";
  echo "  <div class='content html'>{$content_html}</div>";
  echo '  <div class="buttons">';
  echo "    <input type='button' onclick='note_edit({$note['id']})' value='edit' />";
  echo "    <input type='button' onclick='note_delete({$note['id']})' value='delete' />";
  echo '  </div>';
  echo '</div>';
}

echo '</div>';
