<?php
    // ENVIRONMENT VARS
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";

    $results = [];


    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL
        $stmt = $conn->prepare("SELECT 
        all_loc.name,
        all_loc.rating
    FROM (
        SELECT MotionPicture.id,
        MotionPicture.rating,
        MotionPicture.name,
        COUNT(Location.mpid) AS cnt
        FROM MotionPicture
        INNER JOIN Location
        ON Location.mpid = MotionPicture.id
        GROUP BY MotionPicture.id) all_loc
    INNER JOIN (
        SELECT MotionPicture.id,
        COUNT(Location.mpid) AS cnt
        FROM MotionPicture
        INNER JOIN Location
        ON Location.mpid = MotionPicture.id
        AND Location.city = 'Boston'
        GROUP BY MotionPicture.id) boston
    ON boston.id = all_loc.id AND boston.cnt = all_loc.cnt
    ORDER BY all_loc.rating DESC
    LIMIT 2;");
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $query_results = $stmt->fetchAll();

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

   
    //$results = $_POST;
    echo json_encode($query_results);
?>
