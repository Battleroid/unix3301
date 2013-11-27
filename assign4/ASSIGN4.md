Assignment 4
============

Things I should have done different and better:

* I should have tried to use PDO's transaction/commit features. Doing this could have been great when having any issues inserting; I could have rolled back the entire insertion if a problem occurred. It looks to be pretty simple ([documentation](http://php.net/manual/en/pdo.transactions.php)). However I've never used it so I don't know too much about it:

```PHP
try {
  $db = new PDO("mysql:host=localhost;dbname=stuff;charset=UTF8", "user", "pass");
  $db->beginTransaction(); // begin transaction
  $db->exec("DROP * FROM table");
  $db->commit(); // commit our changes if no problems occur
} catch (Exception $e) {
  $db->rollBack(); // oh no, something went wrong, forget we did it and give us the problem
  echo $e->getMessage();
}
```

* Population script [add.php](add.php) could have a bit more material to work with and actually make varying lengths of phone numbers. Would have been trivial to do.
