<?php
    // ENVIRONMENT VARS
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";
    
    $results = [];

    // echo json_encode($_GET);
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        // SQL
        $stmt = $conn->prepare("SELECT People.name, People.id, People.nationality, People.dob, People.gender, Role.pid, Role.role_name
        FROM People, Role
        WHERE People.id=Role.pid 
        AND Role.role_name='Actor';");
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
