<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: ../user/login.php");
    exit();
}

$currentPage = 'client';

include("../db/dbh.inc.php");
include("../config.php");
include("../userincludes/userfunctions.inc.php");

$highlightId = '';
if (isset($_GET['highlight'])) {
    $highlightId = htmlspecialchars(urldecode($_GET['highlight']));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klanten | Gilde DevOps</title>
    <link rel="stylesheet" href="client.css">
    <link rel="stylesheet" href="../assets/layout.css">
    <link rel="stylesheet" href="../assets/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    <style>
    </style>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".invoice-button").click(function() {
            var clientId = $(this).data('client-id');
            var assignmentId = $(this).data('assignment-id');
            $.ajax({
                url: 'generate_invoice.php',
                type: 'post',
                data: {
                    clientId: clientId,
                    assignmentId: assignmentId
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var blob = new Blob([response], {
                        type: 'application/pdf'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "invoice_" + clientId + "_" + assignmentId + ".pdf";
                    link.click();
                },
                error: function() {
                    alert('Error generating invoice');
                }
            });
        });
    });
</script>

<body>
    <main>
        <?php include("../assets/navbar.php") ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-window">
                <div class="client-container">
                    <div class="title-wrapper">
                        <span>Klanten</span>
                    </div>
                    <div class="client-registration-wrapper">
                        <div class="subheading-wrapper">
                            <span>Registreer een klant</span>
                        </div>
                        <form action="client.php" method="POST">
                            <div class="input-container">
                                <div class="input">
                                    <input type="text" id="clientFirstname" name="clientFirstname" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="clientFirstname">Klant voornaam</label>
                                </div>
                            </div>

                            <div class="input-container">
                                <div class="input">
                                    <input type="text" id="clientLastname" name="clientLastname" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="clientLastname">Klant achternaam</label>
                                </div>
                            </div>

                            <div class="input-container">
                                <div class="input">
                                    <input type="email" id="clientEmail" name="clientEmail" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="clientEmail">Klant E-mail</label>
                                </div>
                            </div>

                            <div class="input-container">
                                <div class="input">
                                    <input type="text" id="clientPhoneNumber" name="clientPhoneNumber" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="clientPhoneNumber">Telefoonnummer</label>
                                </div>
                            </div>

                            <div class="input-container">
                                <div class="input">
                                    <input type="text" id="companyName" name="companyName" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="companyName">Bedrijfsnaam</label>
                                </div>
                            </div>

                            <div class="input-container">
                                <div class="input">
                                    <input type="text" id="companyAddress" name="companyAddress" value="" onkeyup="this.setAttribute('value', this.value);">
                                    <label for="companyAddress">Adress(bedrijf)</label>
                                </div>
                            </div>

                            <div class="submit-button">
                                <input type="submit" value="Register Client">
                            </div>
                        </form>
                        <?php 
                        
                        echo $_SESSION["userId"];

                        ?>
                    </div>
                    <div class="client-list-wrapper">
                        <div class="subheading-wrapper">
                            <span>Alle klanten</span>
                        </div>
                        <?php
                        // Adjusted SQL query to select distinct clients without assignments
                        $sql = "SELECT DISTINCT client.clientFirstname, client.clientLastname, client.clientEmail, client.clientPhoneNumber, client.clientId, client.companyName, client.companyAddress FROM client";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Fetch the results into an associative array
                            while ($row = $result->fetch_assoc()) {
                                $isHighlighted = ($highlightId === $row['clientId']) ? 'highlighted' : '';
                                echo "<div class='client-list-item {$isHighlighted}'>";
                                echo "<div class='client-list-item-information'>";
                                echo "<span><span class='bolder'>Voornaam: </span>" . htmlspecialchars($row['clientFirstname']) . "</span>";
                                echo "<span><span class='bolder'>Achternaam: </span>" . htmlspecialchars($row['clientLastname']) . "</span>";
                                echo "<span><span class='bolder'>E-mailadres: </span>" . htmlspecialchars($row['clientEmail']) . "</span>";
                                echo "<span><span class='bolder'>Telefoonnummer: </span>" . htmlspecialchars($row['clientPhoneNumber']) . "</span>";
                                echo "<span><span class='bolder'>Bedrijfsnaam: </span>" . htmlspecialchars($row['companyName']) . "</span>";
                                echo "<span><span class='bolder'>Adress(bedrijf): </span>" . htmlspecialchars($row['companyAddress']) . "</span>";
                                echo "</div>";
                                echo "<div class='client-list-item-button'>";
                                echo "<button class='invoice-button' data-client-id='" . $row['clientId'] . "'>Factuur genereren</button>";
                                echo "</div>";
                            }
                        } else {
                            echo "<div><span>0 results</span></div>";
                        }

                        $conn->close();
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </main>
</body>

</html>