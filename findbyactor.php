<?php
    // ENVIRONMENT VARS
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";
    
    $a_selected = $_GET['actor'];
    $results = [];

    // echo json_encode($_GET);
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $condition = isset($a_selected) && !empty($a_selected)? " People.name = '{$a_selected}'" : '';
        $stmt = $conn->prepare("SELECT MotionPicture.name, MotionPicture.id, MotionPicture.rating, MotionPicture.production, MotionPicture.budget FROM MotionPicture, Role WHERE Role.mpid=MotionPicture.id AND Role.pid=(SELECT People.id FROM People WHERE {$condition});");
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