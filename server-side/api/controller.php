<?php

class MainController {
    // Main controller for the app

    public function __construct() {
        // TODO: Nothing to do here... really?
    }

    // Test function
    public function Hello() {
        return  '{"status": "OK", "data" : "Hello"}';
    }

    // List all photos in db
    public function ListItems($app) {
        $sql = "SELECT id, name, title FROM images order by id desc";
        try {
            $result = $app['db']->fetchAll($sql);
        } catch (Exception $e) {
            error_log("ERROR: " . $e);
            return  $app->json("[]");
        }
        return  $app->json($result);
    }

    // Return the number of views in DB
    public function GetViews($app) {
        $sql = "SELECT count(*) 'numviews' FROM views";
        try {
            $result = $app['db']->fetchAll($sql);
        } catch (Exception $e) {
            error_log("ERROR: " . $e);
            return  $app->json("[]");
        }
        return  $app->json($result);
    }

    // This will save a photo in DB
    public function SaveItem($app, $title, $name) {
        $sql = "INSERT INTO images (name, title) values(?, ?);";
        try {
            $app['db']->executeUpdate($sql, array($name, $title));
        } catch (Exception $e) {
            throw new Exception("Error on DB access");
        }
        return  '{"status": "OK", "data" : "' . $name . '"}';
    }

    // Add another entry into views table
    public function AddView($app) {
        $sql = "INSERT INTO views (date) values (now());";
        try {
            $app['db']->executeUpdate($sql);
        } catch (Exception $e) {
            throw new Exception("Error on DB access");
        }
        return  '{"status": "OK"}';
    }

    // This will export DB content to a CSV file
    public function Export($app) {
         $sql = "SELECT name, title FROM images order by id desc";
        try {
            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename=export-images.csv");
            $output = fopen("php://output", "w");
            $result = $app['db']->fetchAll($sql);
            fputcsv($output, array("name", "title"), ";");
            foreach ($result as $line) {
                fputcsv($output, $line, ";");
            }
            fclose($output);
            exit();
        } catch (Exception $e) {
            error_log("ERROR: " . $e);
            return  "ERROR";
        }
    }

}

?>

