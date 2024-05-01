<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Maker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
        }

        header h1 {
            font-size: 2em;
        }

        nav ul {
            list-style-type: none;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        .hero {
            text-align: center;
            padding: 100px 0;
        }

        .hero h2 {
            font-size: 3em;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #f44336;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #ff6f61;
        }

        .features {
            padding: 50px 0;
        }

        .feature {
            text-align: center;
            margin-bottom: 20px;
        }

        .feature h3 {
            font-size: 1.5em;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        .add-place {
            background-color: #fff;
            padding: 50px;
            margin-top: 50px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .add-place h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .add-place form {
            max-width: 600px;
            margin: 0 auto;
        }

        .add-place label {
            display: block;
            margin-bottom: 10px;
        }

        .add-place input[type="text"],
        .add-place textarea,
        .add-place input[type="url"],
        .add-place input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .add-place textarea {
            height: 100px;
        }

        .add-place button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #f44336;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-place button[type="submit"]:hover {
            background-color: #ff6f61;
        }
    </style>
</head>

<body>
    <section class="add-place">
        <div class="container">
            <h2>Edit Expense</h2>
            <?php
            include ("db.php");

            $conn = new mysqli($servername, $username, $password, $dbname);

            $expense_id = $_GET["id"];
            $sql = "SELECT * FROM expenses WHERE expense_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $expense_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <form method="post">
                    <input type="hidden" name="expense_id" value="<?php echo $row['expense_id']; ?>">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>

                    <label for="amount">Amount:</label>
                    <input type="number" id="amount" name="amount" value="<?php echo $row['amount']; ?>" required>

                    <input type="hidden" id="plan_id" value="<?php echo $id ?>" name="plan_id" required>

                    <button type="submit" class="btn">Update</button>
                </form>
                <?php
            } else {
                echo "No expense found.";
            }
            ?>
        </div>
    </section>


    <?php
    include ("db.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $expense_id = $_POST['expense_id'];
        $name = $_POST['name'];
        $amount = $_POST['amount'];

        $sql = "UPDATE expenses SET name = ?, amount = ? WHERE expense_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $name, $amount, $expense_id);

        if ($stmt->execute()) {
            echo "<script>alert('Expense updated successfully!');
            window.history.go(-2); </script>";
        } else {
            echo "Error updating expense: " . $conn->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tripper by Kalash Shah</p>
        </div>
    </footer>
    <!--
</body>

</html>