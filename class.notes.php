<?php
class Notes {

  public $id = '';
  public $color = '#000000';
  public $subject = 'Note Subject';
  public $content = '# Note Content';

  public function __construct($id) {
    if(!empty($id)) $this->load($id);
  }

  public function load($id) {
    $db = new Database();
    $result = $db->query("select id, color, subject, content from notes where id = \'{$id}\'");
    $return = array();
    $this->id = NULL;
    while($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $this->id = $row['id'];
      $this->color = $row['color'];
      $this->subject = $row['subject'];
      $this->content = $row['content'];
    }
    if(empty($this->id)) {
      throw new Exception('Unable to load Note');
    }
  }

  public function save() {

    if(empty($this->id)) {
      $query = 'insert into notes (color, subject, content) values'
        . " ('{$this->color}', '{$this->subject}', '{$this->content}') ";
    }
    else {
      $query = "update notes set color='{$this->color}',subject='{$this->subject}',content='{$this->content}' where id='{$this->id}'";
    }

    $db = new Database();
    $db->query($query);
    if(empty($this->id)) {
      $this->load($db->lastInsertRowID());
    }
    else {
      $this->load($this->id);
    }

  }

  public function delete() {
    if(empty($this->id)) throw new Exception('Cannot delete note when no Id is specified');
    $db = new Database();
    $db->query("delete from notes where id = '{$this->id}'");
    $this->id = NULL;
  }

  public static function load_notes() {
    $db = new Database();
    $result = $db->query('select id, color, subject, content from notes');
    $return = array();
    while($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $return[$row['id']] = $row;
    }
    return $return;
  }

}
