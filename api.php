<?php
ini_set('display_errors', 0);
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
    $result = $note->save();
    if(is_array($result)) {
      echo json_encode($result);die();
    }
    break;
  case 'edit';
    $note = new Notes($payload['id']);
    $note->color = $payload['color'];
    $note->subject = $payload['subject'];
    $note->content = $payload['content'];
    $result = $note->save();
    if(is_array($result)) {
      echo json_encode($result);die();
    }
    break;
  case 'delete';
    $note = new Notes($payload['id']);
    $result = $note->delete();
    if(is_array($result)) {
      echo json_encode($result);die();
    }
    break;
  default:
    die('invalid API call');
}
echo json_encode(TRUE);
