<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Address Lookup</title>
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
        .table {
            margin-top: 20px;
            width: 80%;
            margin: 20px auto;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #f2f2f2;
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
        <div id="ip-lookup" class="content">
            <h2>IP Lookup</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="ip">Enter IP Address:</label>
                    <input type="text" id="ip" name="ip" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Lookup</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $ip = htmlspecialchars($_POST['ip']);
                $url = "http://ip-api.com/php/{$ip}";

                $response = file_get_contents($url);
                if ($response !== FALSE) {
                    $data = unserialize($response);

                    if ($data['status'] == 'success') {
                        echo '<table class="table table-striped table-bordered">';
                        echo '<thead class="thead-dark"><tr><th>Field</th><th>Value</th></tr></thead>';
                        echo '<tbody>';
                        foreach ($data as $key => $value) {
                            echo '<tr><td>' . ucfirst($key) . '</td><td>' . htmlspecialchars($value) . '</td></tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo '<p style="color:red; text-align:center;">Error: ' . htmlspecialchars($data['message']) . '</p>';
                    }
                } else {
                    echo '<p style="color:red; text-align:center;">Unable to fetch data. Please try again later.</p>';
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
