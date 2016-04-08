<?php

class MainController {

    public function __construct() {
    }

    public function Hello() {
        return  '{"status": "OK", "data" : "Hello"}';
    }

    public function ListItems($app) {
        $sql = "SELECT id, name, title FROM images order by id";
        $result = $app['db']->fetchAll($sql);
        return  $app->json($result);
    }

    public function SaveItem($app, $title, $name) {
        $sql = "INSERT INTO images (name, title) values(?, ?);";
        $app['db']->executeUpdate($sql, array($name, $title));

        return  '{"status": "OK", "data" : "' . $name . '"}';
    }

}

?>

