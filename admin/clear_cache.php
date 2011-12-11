<?php
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(DOC_ROOT . '/includes/authorization.php');

Project::getInstance()->getCache()->clean();
location('/administrator/pages.php', '<p class="imp">Cache cleared!</p>');
?>
