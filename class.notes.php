<?php
class Notes {

  public $id = '';
  public $touched = '';
  public $color = '#000000';
  public $subject = 'Note Subject';
  public $content = '# Note Content';

  public function __construct($id = NULL) {
    if(!empty($id)) $this->load($id);
  }

  public function load($id) {
    $db = new Database();

    $statement = $db->prepare('select id, touched, color, subject, content from notes where id=:id');
    $statement->bindValue(':id', $id);
    $result = $statement->execute();

    if(!$result || $db->lastErrorCode()) {
      die($db->lastErrorMsg());
    }

    $return = array();
    $this->id = NULL;
    while($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $this->id = $row['id'];
      $this->touched = $row['touched'];
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
      $query = 'insert into notes (color, subject, content, touched) values (:color, :subject, :content, :touched)';
    }
    else {
      $query = "update notes set touched=:touched,color=:color,subject=:subject,content=:content where id=:id";
    }

    $db = new Database();
    $statement = $db->prepare($query);
    $statement->bindValue(':color', $this->color);
    $statement->bindValue(':content', $this->content);
    $statement->bindValue(':subject', $this->subject);
    $statement->bindValue(':touched', time());
    if(!empty($this->id)) {
      $statement->bindValue(':id', $this->id);
    }

    $result = $statement->execute();

    if(!$result || $db->lastErrorCode()) {
      return array(
        'Error Code' => $db->lastErrorCode(),
        'Error Message' => $db->lastErrorMsg(),
      );
    }

    if(empty($this->id)) {
      $this->load($db->lastInsertRowID());
    }
    else {
      $this->load($this->id);
    }
    return TRUE;

  }

  public function delete() {
    if(empty($this->id)) throw new Exception('Cannot delete note when no Id is specified');
    $db = new Database();
    $db->query("delete from notes where id=:id");
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $this->id);
    $result = $statement->execute();
    if(!$result || $db->lastErrorCode()) {
      return array(
        'Error Code' => $db->lastErrorCode(),
        'Error Message' => $db->lastErrorMsg(),
      );
    }
    $this->id = NULL;
    return TRUE;
  }

  public static function load_notes() {
    $db = new Database();
    $result = $db->query('select id, touched, color, subject, content from notes order by touched desc');
    $return = array();
    while($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $return[$row['id']] = $row;
    }
    return $return;
  }

}
