<?php
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";

    $x = $_GET['X'];
    $y = $_GET['Y'];
    
    // connect to database
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL
        $stmt = $conn->prepare("SELECT People.name, MotionPicture.name, Role.pid, Role.mpid, Movie.boxoffice_collection, MotionPicture.budget 
                                FROM People, Role, Movie, MotionPicture 
                                WHERE People.id=Role.pid AND People.nationality='USA' AND MotionPicture.id=Movie.mpid AND MotionPicture.id=Role.mpid AND Role.role_name='Producer' AND Movie.boxoffice_collection>={$x} AND MotionPicture.budget<={$y};");

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