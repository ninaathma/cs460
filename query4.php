<?php
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";

    $search = $_GET["search"];  
    
    // connect to database
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        // SQL
        $stmt = $conn->prepare("SELECT MotionPicture.name FROM MotionPicture, Location 
        WHERE MotionPicture.id=Location. mpid and (MATCH(Location.city) AGAINST ('{$search}') ) 
        GROUP BY MotionPicture.id;");
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $results = $stmt->fetchAll();

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    
    // convert to JSON and output   
    echo json_encode( $results);   
   
?>