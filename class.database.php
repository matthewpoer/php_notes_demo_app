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
    $query = 'insert into notes (id, touched, color, subject, content) values' . PHP_EOL;
    $query .= '(1, \'1544582405\', \'#00BB00\', \'Reasons to Hire Matt Poer\', \'1. knows markdown
2. made this note-taking app [just for you](https://stackoverflow.com/jobs/204945/lead-full-stack-developer-brandboom)
  * the note-taking app uses PHP, SQL Lite (because MySQL seemed a little heavy here), jQuery and [is available for review or cloning on Github](https://github.com/matthewpoer/php_notes_demo_app).
3. can tell you a lot about fun animals and a little about classic jazz and R&B\'),' . PHP_EOL;
    $query .= '(2, \'1544582404\', \'#00FFFF\', \'Koala Facts\', \'* No koala has the same fingerprints as another.
* There are around 700 of species of eucalyptus, but koalas are picky eaters. They will only eat about 30 species.
* Koalas are born the size of a jellybean.
* Koalas are sometimes called "koala bears," but they are not actually related to bears. They are marsupials, so are more closely related to the opossum.
* A diet of eucalyptus is not very nutritious, which is why koalas sleep as many as 20 hours per day.\'),' . PHP_EOL;

    // Editors like Atom.io will probably try to strip the spaces off the end of
    // each line of markdown content, even if it is there intentionally to
    // preserve desired newlines. We'll keep our lyrical example in its own file
    // to try to prevent that. We have to make sure we load the contents,
    // respecting all characters, but then swap single quotes for doubled single
    // quotes
    $chartreuse = file_get_contents('chartreuse.md');
    $chartreuse = trim(str_replace("'", "''", $chartreuse));
    $query .= "(3, '1544582403', '#7FFF00', 'Louis Jordan', '{$chartreuse}')" . PHP_EOL;
    $this->query($query);
  }

}
