<?php

require_once('class.database.php');
require_once('class.notes.php');

$payload = json_decode(file_get_contents("php://input"), TRUE);
if(empty($payload)) die('invalid api call');

switch($payload['verb']) {
  case 'create';
    $note = new Notes();
    $note->id = '';
    $note->color = $payload['color'];
    $note->subject = $payload['subject'];
    $note->content = $payload['content'];
    $note->save();
    break;
  case 'edit';
    $note = new Notes($payload['id']);
    $note->color = $payload['color'];
    $note->subject = $payload['subject'];
    $note->content = $payload['content'];
    $note->save();
    break;
  case 'delete';
    $note = new Notes($payload['id']);
    $note->delete();
    break;
  default:
    die('invalid API call');
}
