<html>
    <body>
        <?php
        $conn = mysqli_connect("sql11.freemysqlhosting.net","sql11212393", "lE3WJZvwzS", "sql11212393");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM test";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "username: " . $row["username"] . " - password: " . $row["password"];
            }
        }
        mysqli_close($conn);
        ?>
    </body>
</html>

