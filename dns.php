<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DNS Lookup</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #333;
            padding: 1rem;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
        }
        .navbar a:hover {
            background-color: #575757;
            border-radius: 5px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .header {
            text-align: center;
            padding: 2rem 0;
            background-color: #333;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5rem;
        }
        .content {
            padding: 2rem;
        }
        footer {
            text-align: center;
            padding: 1rem;
            background-color: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="ip.php">IP Lookup</a>
        <a href="dns.php">DNS Lookup</a>
        <a href="tempmail.php">TempMail Lookup</a>
        <a href="whois.php">Whois Lookup</a>
    </nav>
    
    <div class="header">
        <h1>Hacking and Lookup Tools</h1>
    </div>
    
    <div class="container">
        <div id="dns-lookup" class="content">
            <h2>DNS Lookup</h2>
            <form method="post" class="mb-5">
                <div class="form-group">
                    <label for="domain">Domain:</label>
                    <input type="text" name="domain" id="domain" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Lookup</button>
            </form>

            <?php
            if (isset($_POST['domain'])) {
                $domain = htmlspecialchars($_POST['domain'], ENT_QUOTES, 'UTF-8');
                $apiKey = 'ZBWCdXCOuDEq43PmrqIziopRN3r82UBB'; // Replace with your actual API key

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "https://api.apilayer.com/dns_lookup/api/a/$domain");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "apikey: $apiKey"
                ));

                $response = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($response, true);

                if (isset($data['results'])) {
                    echo "<h2 class='mb-4'>Results for $domain</h2>";
                    echo "<table class='table table-striped table-bordered'>";
                    echo "<thead class='thead-dark'><tr><th>Record Type</th><th>IP Address</th></tr></thead>";
                    echo "<tbody>";

                    foreach ($data['results'] as $result) {
                        echo "<tr><td>A</td><td>" . htmlspecialchars($result['ipAddress'], ENT_QUOTES, 'UTF-8') . "</td></tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<div class='alert alert-danger'>No results found or an error occurred.</div>";
                }
            }
            ?>
        </div>
    </div>

    <footer>
        &copy; 2024 Hacking and Lookup Tools. All rights reserved.
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
