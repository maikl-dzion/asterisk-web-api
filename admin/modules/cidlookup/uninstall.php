<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

sql('DROP TABLE IF EXISTS cidlookup');
sql('DROP TABLE IF EXISTS cidlookup_incoming');
?>
