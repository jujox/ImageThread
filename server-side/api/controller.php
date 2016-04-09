<?php

class MainController {

    public function __construct() {
    }

    public function Hello() {
        return  '{"status": "OK", "data" : "Hello"}';
    }

    public function ListItems($app) {
        $sql = "SELECT id, name, title FROM images order by id";
        try {
            $result = $app['db']->fetchAll($sql);
        } catch (Exception $e) {
            error_log("ERROR: " . $e);
            return  $app->json("[]");
        }
        return  $app->json($result);
    }

    public function SaveItem($app, $title, $name) {
        $sql = "INSERT INTO images (name, title) values(?, ?);";
        try {
            $app['db']->executeUpdate($sql, array($name, $title));
        } catch (Exception $e) {
            throw new Exception("Error on DB access");
        }
        return  '{"status": "OK", "data" : "' . $name . '"}';
    }

}

?>

