<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TempMail Lookup</title>
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
        <div id="tempmail-lookup" class="content">
            <h2>TempMail Lookup</h2>
            <form class="mb-4" method="GET" action="">
                <div class="input-group">
                    <input type="text" class="form-control" name="domain" placeholder="Enter domain" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>

            <?php
            if (isset($_GET['domain'])) {
                $domain = htmlspecialchars($_GET['domain'], ENT_QUOTES, 'UTF-8');
                $apiUrl = "https://mailcheck.p.rapidapi.com/?domain={$domain}";
                $apiHost = 'mailcheck.p.rapidapi.com';
                $apiKey = '3202e091aamsh7dbea6603002e6ep1d4787jsn9b4d7e760111';

                $curl = curl_init($apiUrl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, [
                    "x-rapidapi-host: $apiHost",
                    "x-rapidapi-key: $apiKey"
                ]);

                $response = curl_exec($curl);
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                if ($response === false) {
                    echo '<div class="alert alert-danger">Curl error: ' . curl_error($curl) . '</div>';
                    curl_close($curl);
                    exit;
                }

                curl_close($curl);

                if ($httpCode != 200) {
                    echo '<div class="alert alert-danger">Error: Received HTTP status code ' . $httpCode . '.</div>';
                    echo "<pre>Raw response: " . htmlspecialchars($response, ENT_QUOTES, 'UTF-8') . "</pre>";
                    exit;
                }

                $data = json_decode($response, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    echo '<div class="alert alert-danger">JSON decode error: ' . json_last_error_msg() . '</div>';
                    echo "<pre>Raw response: " . htmlspecialchars($response, ENT_QUOTES, 'UTF-8') . "</pre>";
                    exit;
                }

                array_walk_recursive($data, function (&$item) {
                    if ($item === true) {
                        $item = 'Yes';
                    } elseif ($item === false) {
                        $item = 'No';
                    }
                });

                if (isset($data) && is_array($data)) {
                    echo "<h2 class='mt-4'>Mailcheck Information for '{$domain}'</h2>";
                    echo "<table class='table table-striped table-bordered'>";
                    echo "<tr><th>Key</th><th>Value</th></tr>";
                    displayDataInTable($data);
                    echo "</table>";
                } else {
                    echo '<div class="alert alert-warning">No Mailcheck information found for ' . htmlspecialchars($domain, ENT_QUOTES, 'UTF-8') . '.</div>';
                }
            }

            function displayDataInTable($data) {
                foreach ($data as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '</td>';
                    if (is_array($value) || is_object($value)) {
                        echo '<td><pre>' . htmlspecialchars(json_encode($value, JSON_PRETTY_PRINT), ENT_QUOTES, 'UTF-8') . '</pre></td>';
                    } else {
                        echo '<td>' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</td>';
                    }
                    echo '</tr>';
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
