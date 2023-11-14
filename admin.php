<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <h1>Restaurant Approval Dashboard</h1>
    <table>
        <tr>
            <th>Restaurant Name</th>
            <th>Address</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        
        // Fetch and display restaurant data from the database
        $db = new mysqli("localhost", "root", "", "login");
        $query = "SELECT * FROM restaurant WHERE STATUS = 'Pending'"  ;
        $result = $db->query($query);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['restaurant_name']}</td>";
            echo "<td>{$row['city']}</td>";
            echo "<td>{$row['cuisine']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td><a href='approve.php?restaurant_id={$row['restaurant_id']}'>Approve</a></td>
            <td><a href='reject.php?restaurant_id={$row['restaurant_id']}'>Reject</a></td>
            >";
            echo "</tr>";
        }

        
        ?>
    </table>

    <table>
        <tr>
            <th>Restaurant Name</th>
            <th>Address</th>
            <th>Status</th>
        </tr>
        <?php
        $query = "SELECT * FROM restaurant WHERE STATUS = 'Approved'"  ;
        $result = $db->query($query);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['restaurant_name']}</td>";
            echo "<td>{$row['city']}</td>";
            echo "<td>{$row['cuisine']}</td>";
            echo "<td>{$row['status']}</td>";
            
            echo "</tr>";
        }
        $db->close();
        ?>
</body>
</html>
