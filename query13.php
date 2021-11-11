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
        MotionPicture.name,
        MotionPicture.rating
        FROM MotionPicture, (SELECT 
        AVG(MotionPicture.rating) AS avg_rating
        FROM MotionPicture
        INNER JOIN Genre
        ON Genre.mpid = MotionPicture.id
        AND Genre.genre_name = 'Comedy') comedy_mp
        WHERE MotionPicture.rating > IFNULL(comedy_mp.avg_rating, 0)
        ORDER BY MotionPicture.rating DESC;");
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
