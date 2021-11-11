<?php
    // ENVIRONMENT VARS
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $r_selected = $_GET['rating'];
    $results = [];

    // echo json_encode($_GET);
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $rating_condition = isset($r_selected) && !empty($r_selected)? " MotionPicture.rating > '{$r_selected}'" : '';

        $query = "SELECT
        People.name AS PersonName,
        MotionPicture.name AS MotionPictureName,
        COUNT(Role.pid) AS 'number of roles'
        FROM People
        INNER JOIN Role ON Role.pid = People.id 
        INNER JOIN MotionPicture ON MotionPicture.id = Role.mpid
        WHERE MotionPicture.rating > 2 
        GROUP BY People.id, MotionPicture.id
        HAVING COUNT(Role.pid) > 1
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