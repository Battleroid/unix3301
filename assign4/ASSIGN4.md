Assignment 4
============

Things I should have done different and better:

1. I should have tried to use PDO's transaction/commit features. Doing this could have been great when having any issues inserting; I could have rolled back the entire insertion if a problem occurred. It looks to be pretty simple (cool stuff [documentation](http://php.net/manual/en/pdo.transactions.php)):
```
$db->beginTransaction();
$stmt = $db->exec("SQL STATEMENT");
$db->rollBack(); // mistake, forget we did that
// or
$db->commit(); // commit transaction
```
2. Maybe a bit more orderly.
