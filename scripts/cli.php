<?php

declare(strict_types=1);

use Dotenv\Dotenv;

require __DIR__ .'/../vendor/autoload.php';

$dotent = Dotenv::createImmutable(__DIR__.'/../');
$dotent->safeLoad();

$container = require __DIR__.'/../config/bootstrap.php';
['mysql' => $conn] = $container->get('services');

$pdo = new PDO(sprintf('mysql:host=%s;dbname=%s', $conn['host'], $conn['database']),
    $conn['username'],
    $conn['password']
);

/** @todo returna uma função */
$tables = require_once 'createTables.php';
$short = 'cdhtv';

$long = [
    'create-tables',
    'create',
    'table:',
    'drop',
    'help',
    'view-table',
    'show-tables'
];

$opt = getopt($short, $long);

$command = array_key_first($opt);

switch ($command) {
    case 'h':
    case 'help':
        echo sprintf('
            -t, --create-tables Recria todas as tabelas
            -c, --create --table=tablename Cria uma tabela
            -d, --drop --table=tablename Deleta uma tabela
            -v, --view-table --table=tablename Vizualizar tabela específica
            --show-tables Vizualizar todas as tabelas
        ');
    break;
    case 'c':
    case 'create':
        try {
            $create = $pdo->prepare($tables($opt['table']));
            $create->execute();

            echo sprintf('table %s created', $opt['table']);
        } catch(InvalidArgumentException $e) {
            echo $e->getMessage() . ': use --view-tables';
        }
    break;
    case 'd':
    case 'drop':
        try {
            $pdo->exec(sprintf('DROP TABLE %s', $opt['table']));
            echo sprintf('table %s deleted', $opt['table']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    break;
    case 'v';
    case 'view-tables';
        try {
            $select = $pdo->query(sprintf('SELECT * FROM %s', $opt['table']));
            $result = $select->fetchAll();

            dump($result);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    break;
    case 'show-tables':
        $show = $pdo->exec('show tables;');
        dump($show);
    break;
    default:
        echo 'commando não encontrado';
}
