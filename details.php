<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-transform: capitalize;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 2px 0;
        }

        button {
            color: white;
            background-color: purple;
            margin: 5px;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div id="download">
        <center>
            <h1 style="color:blue">Trip Details</h1>
            <?php
            include ('db.php');
            $conn = new mysqli($servername, $username, $password, $dbname);
            $plan_id = $_GET['id'];
            $sql_plan = "SELECT * FROM plans WHERE plan_id = $plan_id";
            $result_plan = $conn->query($sql_plan);
            if ($result_plan->num_rows > 0) {
                $row_plan = $result_plan->fetch_assoc();
                echo "<h3>{$row_plan['plan_name']}</h3>";
                echo "<p>Places Cost: {$row_plan['total_cost']} Rs </p>";
                echo "<p>Instructions: {$row_plan['instructions']}</p>";
                $sql_expenses = "SELECT * FROM expenses WHERE plan_id = $plan_id";
$result_expenses = $conn->query($sql_expenses);

$totalExpenses = 0; // Initialize total expenses variable

if ($result_expenses->num_rows > 0) {
    echo "<h1 style='color:red'>Expenses</h1>";
    echo "<table>";
    echo "<tr><th>Name</th><th>Amount</th></tr>";
    while ($row_expense = $result_expenses->fetch_assoc()) {
        // Add expense amount to total expenses
        $totalExpenses += $row_expense['amount'];

        echo "<tr>";
        echo "<td>{$row_expense['name']}</td>";
        echo "<td>{$row_expense['amount']} Rs </td>";
        echo "</tr>";
    }
    echo "</table>";

// Display total expenses
echo "<p>Total Expenses: " . $totalExpenses . " Rs</p>";
}else {
                    echo "<p>No expenses for this plan.</p>";
                }
            } else {
                echo "<p>Plan not found.</p>";
            }
            $conn->close();
            ?>
            <br>
            <footer>
                <div class="container">
                    <p> &copy; 2024 Tripper by Kalash Shah </p>
                </div>
            </footer>
    </div>
    </center>
    <br>
    <center>
        <button onclick="convertHTMLtoPDF();"> Download Plan</button>
    </center>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
        function convertHTMLtoPDF() {
            const { jsPDF } = window.jspdf;
            const pdfWidth = document.getElementById('download').offsetWidth;
            const pdfHeight = document.getElementById('download').offsetHeight;
            const doc = new jsPDF('p', 'px', [pdfWidth, pdfHeight]);
            const options = {
                background: 'white',
                scale: 2 // Increase scale for better quality
            };
            html2canvas(document.getElementById('download'), options).then(canvas => {
                const imgData = canvas.toDataURL('image/jpeg', 1.0); // Use JPEG format
                doc.addImage(imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight);
                doc.save("plan.pdf");
            });
        }
    </script>

    <!--
</body>

</html>