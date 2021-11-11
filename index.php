<?php
    $servername = "localhost";
    $dbname = "project1";
    $username = "root";
    $password = "";
    $dsn = "mysql:host=$servername;dbname=$dbname";
    
    $all_nationalities = [];
    $all_likinguser = [];
    $all_actors=[];

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT nationality FROM People GROUP BY nationality");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $all_nationalities = $stmt->fetchAll();



    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL
        $stmt = $conn->prepare("SELECT uemail FROM Likes GROUP BY uemail");
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $all_likinguser = $stmt->fetchAll();

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL
        $stmt = $conn->prepare("SELECT zip FROM Location GROUP BY zip");
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $all_zip = $stmt->fetchAll();

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    </head>

    <body>

        <div class="container">
            <h1 style="text-align:center"> Movie Database </h1><br>
            <h3 style="text-align:center"> Nina Athma & Sarina Singh </h3><br>
        </div>
        
        <div class = "container">
            <button
                class = "btn btn-outline-secondary"
                type="submit"
                onClick="getMovies()"
                id="button-addon2">All Movies
            </button>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="getSeries()"
                id="button-addon2">All Series
            </button>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="getActors()"
                id="button-addon2">All Actors
            </button>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="getLikedMovies()"
                id="button-addon2">All Liked Movies
            </button>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="getAwardWinners()"
                id="button-addon2">All Award Winners
            </button>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="getGenres()"
                id="button-addon2">All Genres
            </button>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="getLocations()"
                id="button-addon2">All Shooting Locations
            </button>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="getPeople()"
                id="button-addon2">All People
            </button>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="getUsers()"
                id="button-addon2">All Users
            </button>
        </div>
        
        <div class="container"> <!--Queries 2 & 4-->
            <h2></h2>
            <h6>Query 1: All tables</h6>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="query1()"
                id="button-addon2">Show All Tables
            </button>
            <h6>Query 2: Search motion picture by name</h6>
            <form method="post">
                <div class="input-group mb-3">
                    <input type="text" name="mp_name" id="mp_name" class="form-control" placeholder="Search by name..." required/>
                    <button type="button" class = "btn btn-outline-secondary" onclick="query2()">Search</button>
                </div>
            </form>

            <h6>Query 3: Find liked movies from users</h6>
            <select id="likeuser_select">
                <option value=""></option>
                <?php foreach($all_likinguser as $useremail) { ?>
                    <option value="<?php echo $useremail['uemail']; ?>"><?php echo $useremail['uemail']; ?></option>
                <?php } ?>
            </select>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="query3()"
                id="button-addon2">Search
            </button>

            <h6>Query 4: Search motion picture by location</h6>
            <form method="post">
                <div class="input-group mb-3">
                    <input type="text" name="mp_loc" id="mp_loc" class="form-control" placeholder="Search by location..." required/>
                    <button type="button" class = "btn btn-outline-secondary" onclick="query4()">Search</button>
                </div>
            </form>
            
            <h6>Query 5: Find directors by motion picture zipcode</h6>
            <select id="zip_select">
                <option value=""></option>
                <?php foreach($all_zip as $zip) { ?>
                    <option value="<?php echo $zip['zip']; ?>"><?php echo $zip['zip']; ?></option>
                <?php } ?>
            </select>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="query5()"
                id="button-addon2">Search
            </button>

            <h6>Query 6: Find people with at least K awards </h6>
            <form method="post">
                <div class="input-group mb-3">
                    <input type="number" name="input_k" id="input_k" placeholder="K" required/>
                    <button type="button" class = "btn btn-outline-secondary" onclick="query6();">Submit</button>
                </div>
            </form>

            <h6>Query 7: Youngest and oldest actors to win awards</h6>
            <button
                class="btn btn-outline-secondary"
                type="button"
                onClick="query7()"
                id="button-addon2">Query
            </button>

            <h6>Query 8: Find American producers by budget & box office collection</h6>
            <form method="post">
                <div class="input-group mb-3">
                    <input type="number" name="min_boxoff" id="min_boxoff" placeholder="Min Box Office" required/>
                    <input type="number" name="max_budget" id="max_budget" placeholder="Max Budget" required/>
                    <button type="button" class = "btn btn-outline-secondary" onclick="query8();">Submit</button>
                </div>
            </form>

            <h6>Query 9: People who have played multiple roles in motion pictures rated higher than: </h6>
            <input id="search_input" type="text" placeholder="Rating"/>
            <button type="button" class ="btn btn-outline-secondary" onclick="query9()">Search</button>

            <h6>Query 10: Top 2 rated thriller movies shot exclusively in Boston</h6>
            <button class="btn btn-outline-secondary" type="button" onClick="query10()">Query</button>

            <h6>Query 11: Movies with more than "X" likes by users of less than "Y" age </h6> 
            <label for="search_input1">Enter # of Likes:</label>
            <input id="search_input1" type="text" />
            <label for="search_input2">Enter User Age:</label>
            <input id="search_input2" type="text"/>
            <button onclick="query11()">Search</button>

            <h6>Query 12: Actors in Marvel and Warner Bros productions</h6>
            <button
                class = "btn btn-outline-secondary"
                type="submit"
                onClick="query12();"
                id="button-addon2">Query
            </button>

            <h6>Query 13: Find Motion Pictures w/ Rating > Avg Comedy</h6>
            <button
                class = "btn btn-outline-secondary"
                type="button"
                onClick="query13()"
                id="button-addon2">Search
            </button>

            <h6>Query 14: Top 5 movies with the highest number of people playing a role</h6>
            <button
                class = "btn btn-outline-secondary"
                type="submit"
                onClick="query14();"
                id="button-addon2">Query
            </button>
            
            <h6>Query 15: Actors with the Same Birthdays</h6>
            <button 
                class = "btn btn-outline-secondary"
                type="button"
                onClick="query15()"
                id="button-addon2">Query
            </button>
        </div>
        
        <div class="container">
           <table border ="1" id="results_table"><thead></thead><tbody></tbody></table>
        </div>
    
    
    </body>
</html>
<script>
    function readJSON(data, like_col) {
    /* Takes input JSON 'data' and writes it into table. Boolean var 'like_col' 
    refers to whether the table contains a Like Button column. */
        console.log(data);
        $("#results_table thead").empty();
        $("#results_table tbody").empty();
        if(data.length > 0) {
            let first_row = data[0];
            let headers = Object.keys(data[0]);
            // Create table headers
            let table_headers = $("<tr>");
            headers.forEach(function(element) {
                $("<th>").text(element).appendTo(table_headers);
            });
            if (like_col) $("<th>").text("like").appendTo(table_headers); //like func
            table_headers.appendTo($("#results_table thead"));

            // Populate table

            data.forEach(function(row) {
                let new_row = $("<tr>");
                for (const column_name in row) {
                    let new_col = $("<td>");
                    new_col.text(row[column_name]);
                    new_col.appendTo(new_row);
                }
                if (like_col) $(`<td><button class='movie_like_btn' onClick='likeMovie(${row['mpid']})'>Like</button></td>`).appendTo(new_row); //like func
                new_row.appendTo($("#results_table tbody"));
            });
        }
    }
    function likeMovie(mpid) {
        $.confirm({
            title: 'Prompt!',
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>Enter something here</label>' +
            '<input type="text" placeholder="Your email" class="email_input form-control" required />' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var email_input = this.$content.find('.email_input').val();
                        if(!email_input){
                            $.alert('provide a valid email');
                            return false;
                        }
                        fetch(`like_movie.php?mpid=${mpid}&email=${email_input}`)
                        .then(response => response.json())
                        .then( (data) => { console.log (data)} )
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }
    function query1() {
        fetch("query1.php")
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=false)} );
    }
    function query2() { 
        query = $("#mp_name").val();
        fetch("query2.php?search="+query)
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=true)} );
    } 
    function query3() {
        selection = $("#likeuser_select").val();
        fetch("query3.php?user="+selection)
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=false) } );
    }
    function query4(){
        query = $("#mp_loc").val();
        fetch("query4.php?search="+query)
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=true)} );
    }
    function query5(){
        selection = $("#zip_select").val();
        fetch("query5.php?zip="+selection)
        .then(response => response.json())
        .then( (data) => {readJSON(data, like_col=false)} );
    }
    function query6() {
        /* Gets people with more than K awards for a single motion picture in the same year. 
        Lists the person name, motion picture name, award year and award count. */
        k=$("#input_k").val();

        fetch("query6.php?K="+k)
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=false)} );
    }
    function query7() {
        fetch("query7.php")
        .then(response => response.json())
        .then( (data) => {readJSON(data, like_col=false)} );
    }
    function query8(){
        /* Find the American Producers who had a box office collection of more than or equal to “X”
        with a budget less than or equal to “Y”. List the producer name, movie name, box office collection and budget. */
        x=$("#min_boxoff").val();
        y=$("#max_budget").val();

        fetch("query8.php?X="+x+"&Y="+y)
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=false)} );
    }
    function query9() {
        selection = $("#search_input").val();
        fetch("query9.php?rating="+selection)
        .then(response => response.json())
        .then( (data) => {readJSON(data, like_col=false)} );
    }
    function query10() {
        fetch("query10.php?")
        .then(response => response.json())
        .then( (data) => {readJSON(data, like_col=false)} );
    }
    function query11() {
        l_selected = $("#search_input1").val();
        a_selected = $("#search_input2").val();
        fetch(`query11.php?likecount_selected=${l_selected}&age_selected=${a_selected}`)
        .then(response => response.json())
        .then( (data) => {readJSON(data, like_col=false)} );
    }
    function query12(){
        fetch("query12.php")
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=false) } );
    }
    function query13(){
        fetch("query13.php")
        .then(response => response.json())
        .then( (data) => {readJSON(data, like_col=false)} );
    }
    function query14(){
        fetch("query14.php?")
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=false)} );

    }
    function query15(){
        fetch("query15.php")
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=false)} );
    }
    
    // PA 1.2 Simple Queries
    function getMovies() {
        fetch("movies.php")
        .then(response => response.json())
        .then( (data) => {readJSON(data, like_col=true)} );
    }
    function getActors() {
        fetch("actors.php")
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=false)} );
    }
    function getSeries() {
        fetch("series.php")
        .then(response => response.json())
        .then( (data) => {readJSON(data, like_col=true)} );
    }
    function getGenres(){
        fetch("genres.php")
        .then(response => response.json())
        .then( (data) => {readJSON(data, like_col=false)} );

    }
    function getLocations(){
        fetch("locations.php")
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=false)} );
    }
    function getPeople(){
        fetch("people.php")
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=false)} );
    }
    function getUsers(){
        fetch("users.php")
        .then(response => response.json())
        .then( (data) => { readJSON(data, like_col=false)} );
    }
    function getLikedMovies() {
        fetch("liked_movies.php")
        .then(response => response.json())
        .then( (data) => {readJSON(data, like_col=false)} );
    }
    function getAwardWinners() {
        fetch("award_winners.php?")
        .then(response => response.json())
        .then( (data) => {readJSON(data, like_col=false)} );
    }
    
</script>