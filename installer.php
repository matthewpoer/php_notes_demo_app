<?php
require_once('class.database.php');
$db = new Database();
$db->setup_database();
$db->install_demo_data();
