<?php
class Database extends SQLite3 {

  private $db = NULL;

  public function __construct() {
    parent::__construct('notes.db');
  }

  public function setup_database() {
    $this->query('drop table if exists notes');
    $this->query('create table notes(
      id integer primary key autoincrement not null,
      touched int not null,
      color text not null,
      subject text,
      content blob)');
  }

  public function install_demo_data() {
    $query = 'insert into notes (id, touched, color, subject, content) values' . PHP_EOL
      . ' (1, \'1544582405\', \'#000000\', \'Koala Fact #1\', \'No koala has the same fingerprints as another.\'), ' . PHP_EOL
      . ' (2, \'1544582404\', \'#FF0000\', \'Koala Fact #2\', \'There are around 700 of species of eucalyptus, but koalas are picky eaters. They will only eat about 30 species.\'), ' . PHP_EOL
      . ' (3, \'1544582403\', \'#0000FF\', \'Koala Fact #3\', \'Koalas are born the size of a jellybean.\'), ' . PHP_EOL
      . ' (4, \'1544582402\', \'#800080\', \'Koala Fact #4\', \'Koalas are sometimes called "koala bears," but they are not actually related to bears. They are marsupials, so are more closely related to the opossum.\'), ' . PHP_EOL
      . ' (5, \'1544582401\', \'#00FF00\', \'Koala Fact #5\', \'A diet of eucalyptus is not very nutritious, which is why koalas sleep as many as 20 hours per day.\') ';
    $this->query($query);
  }

}
