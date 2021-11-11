<?php
    // ENVIRONMENT VARS
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $user = $_GET['user'];
    $results = [];

    // echo json_encode($_GET);
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $condition = isset($user) && !empty($user)? " Registered_User.email = '{$user}'" : '';

        $query = "SELECT 
        MotionPicture.name,
        MotionPicture.rating,
        MotionPicture.production,
        MotionPicture.budget
        FROM MotionPicture
        INNER JOIN Likes ON Likes.mpid = MotionPicture.id
        INNER JOIN Registered_User ON Registered_User.email = Likes.uemail
        WHERE 
        {$condition}
        GROUP BY MotionPicture.id
        ;";
        // SQL
        $stmt = $conn->prepare($query);
        
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $results = $stmt->fetchAll();

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

   
    //$results = $_POST;
    echo json_encode($results);
?>