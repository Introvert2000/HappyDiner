<!DOCTYPE html>
<html>
<head>
    <title>Search Page</title>
    <script>
        function search() {
            var query = document.getElementById("searchInput").value;
            if (query.trim() !== "") {
                // Perform an AJAX request to fetch search results
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("searchResults").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", "search.php?query=" + query, true);
                xmlhttp.send();
            } else {
                document.getElementById("searchResults").innerHTML = "Please enter a search query.";
            }
        }
    </script>
</head>
<body>
    <h1>Search Page</h1>
    <input type="text" id="searchInput" placeholder="Search for names">
    <button onclick="search()">Search</button>
    <div id="searchResults"></div>
</body>
</html>
