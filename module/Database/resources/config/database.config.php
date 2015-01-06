<?php
/**
 * Acamar-SkeletonApplication
 *
 * @link https://github.com/brian978/Acamar-SkeletonApplication
 * @copyright Copyright (c) 2014
 * @license https://github.com/brian978/Acamar-SkeletonApplication/blob/master/LICENSE New BSD License
 */

// Need to make sure the database file exists
$dbFile = 'data/database/bookstore.sqlite';
if (!file_exists($dbFile)) {
    touch($dbFile);
}

// Now we can build the configuration
return [
    'db' => [
        'default' => [
            'sql' => 'sqlite', // This is used by \Aura\SqlQuery\QueryFactory class
            'pdo' => [
                'dsn' => 'sqlite:' . $dbFile,
                'username' => '',
                'password' => '',
                'options' => []
            ]
        ]
    ]
];
