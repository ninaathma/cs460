<?php
    // ENVIRONMENT VARS
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";
    
    
    $z_selected = $_GET['zip'];
    $results = [];

    
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $zip_condition = isset($z_selected) && !empty($z_selected)? " Location.zip = '{$z_selected}'" : '';

        $query = "SELECT 
        People.name AS DirectorName,
        MotionPicture.name AS SeriesName
        FROM People
        INNER JOIN Role ON Role.pid = People.id AND Role.role_name = 'Director'
        INNER JOIN MotionPicture ON MotionPicture.id = Role.mpid
        INNER JOIN Series ON Series.mpid = MotionPicture.id
        INNER JOIN Location ON Location.mpid = MotionPicture.id
        WHERE {$zip_condition}
        GROUP BY People.name, MotionPicture.name;
        
        
        ";
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