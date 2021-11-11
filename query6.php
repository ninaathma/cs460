<?php
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";

    $k = $_GET['K'];
    
    // connect to database
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL
        $stmt = $conn->prepare("SELECT People.name Person, MotionPicture.name 'Motion Picture', Award.award_name 'Award', Award.award_year 'Year', COUNT(*) 'Award Count'
        FROM Award, People, MotionPicture
        WHERE Award.pid=People.id AND Award.mpid=MotionPicture.id
        GROUP BY Award.award_year, Award.pid, Award.mpid
        HAVING COUNT(*)>{$k};");

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