    <?php
    session_start();

    if (!isset($_SESSION["userId"])) {
        header("location: ../user/login.php");
        exit();
    }

    include("../config.php");
    include("../userincludes/userfunctions.inc.php");
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" lang="en" content="width=device-width, initial-scale=1.0">
        <title>Dashboard | Gilde DevOps</title>
        <link rel="stylesheet" href="client.css">
        <link rel="stylesheet" href="../assets/layout.css">
    </head>

    <body>
        <main>
            <?php include("../assets/navbar.php") ?>

            <div class="dashboard-wrapper">
                <div class="dashboard-window">
                    <div class="client-wrapper">
                        <div class="client-registration-wrapper">
                            <form action="client.php" method="POST">
                                <label for="clientFirstname">Klant voornaam</label>
                                <input type="text" id="clientName" name="clientFirstname">

                                <label for="clientLastname">Klant achternaam</label>
                                <input type="text" id="clientName" name="clientLastname">

                                <label for="ClientEmail">Klant E-mail</label>
                                <input type="email" id="clientEmail" name="clientEmail">

                                <label for="clientPhoneNumber">Telefoonnummer</label>
                                <input type="text" id="clientPhoneNumber" name="clientPhoneNumber">

                                <label for="companyName">Bedrijfsnaam</label>
                                <input type="text" id="companyName" name="companyName">

                                <label for="companyAddress">Adress(bedrijf)</label>
                                <input type="text" id="companyAddress" name="companyAddress">

                                <input type="submit" value="Register Client">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </body>

    </html>