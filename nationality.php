<?php
    // ENVIRONMENT VARS
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";
    
    
    $n_selected = $_GET['nationality'];
    $results = [];

    // echo json_encode($_GET);
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $nationality_condition = isset($n_selected) && !empty($n_selected)? "People.nationality = '{$n_selected}'" : '';
        // SQL
        $stmt = $conn->prepare("SELECT People.name, People.id, People.nationality, People.dob, People.gender
        FROM People
        WHERE {$nationality_condition};");
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