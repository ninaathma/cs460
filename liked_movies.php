<?php
    // ENVIRONMENT VARS
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $n_selected = $_GET['nationality_selected'];
    $results = [];


    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL
        $stmt = $conn->prepare("SELECT MotionPicture.name, MotionPicture.id, MotionPicture.rating, MotionPicture.production, MotionPicture.budget, Likes.mpid FROM MotionPicture, Likes
        WHERE MotionPicture.id=Likes.mpid;");
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
