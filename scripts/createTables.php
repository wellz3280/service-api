<?php

declare(strict_types=1);

$users = 'CREATE TABLE users (
    id int(11) AUTO_INCREMENT,
    name varchar(200),
    email varchar(200),
    created_at int not null,
    deleted_at int,
    updated_at int,
    PRIMARY KEY(id)
);

SET character_set_client = utf8;
SET character_set_connection = utf8;
SET character_set_results = utf8;
SET collation_connection = utf8_general_ci;';

return function (string $tableName) use($users): string {
    $tables = [
        'users' => $users,
    ];

    if (!array_key_exists($tableName, $tables)) {
        throw new InvalidArgumentException('Table not exists');
    }

    return $tables[$tableName];
};


