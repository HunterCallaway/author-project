<?php

namespace Jcallaway3\AuthorProject;

require_once(dirname(__DIR__, 2) . "Classes/Author.php");

use Ramsey\Uuid\Uuid;

$myAuthor = new Author("7555b1e4-d564-4ff5-9ced-f833da3135cc", "http://www.authoravatar.com", "hehehehehehehehehehehehehehehehe", "huntercallaway@hotmail.com", "nanananananananananananananananananananananananananananananananananananananananananananananananan", "HunterCallaway");
var_dump($myAuthor);



