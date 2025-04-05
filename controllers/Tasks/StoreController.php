<?php
require "../Backends/models/Tasks.php";
$task = new tasks($conn);
$task->Store();


?>