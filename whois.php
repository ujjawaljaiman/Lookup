<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WHOIS Information</title>
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
        <div id="whois-lookup" class="content">
            <h2>WHOIS Information</h2>
            <form class="mb-4" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="domain" placeholder="Enter domain name" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <?php
            if (isset($_GET['domain'])) {
                $apiKey = "bqwhB6JrNxfyfK2qza5ESaNRojl8pZjj";
                $domain = htmlspecialchars($_GET['domain'], ENT_QUOTES, 'UTF-8');

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.apilayer.com/whois/query?domain=$domain",
                    CURLOPT_HTTPHEADER => array(
                        "apikey: $apiKey"
                    ),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "<div class='alert alert-danger'>cURL Error #: $err</div>";
                } else {
                    $result = json_decode($response, true);
                    if (isset($result['result'])) {
                        $whoisData = $result['result'];
                        ?>
                        <table class="table table-striped table-bordered">
                            <tbody>
                            <tr>
                                <th scope="row">Domain Name</th>
                                <td><?php echo $whoisData['domain_name']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Registrar</th>
                                <td><?php echo $whoisData['registrar']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Creation Date</th>
                                <td><?php echo $whoisData['creation_date']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Expiration Date</th>
                                <td><?php echo $whoisData['expiration_date']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Updated Date</th>
                                <td><?php echo $whoisData['updated_date']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td><?php echo is_array($whoisData['status']) ? implode(", ", $whoisData['status']) : $whoisData['status']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Name Servers</th>
                                <td><?php echo implode(", ", $whoisData['name_servers']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Organization</th>
                                <td><?php echo isset($whoisData['organization']) ? $whoisData['organization'] : 'N/A'; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Country</th>
                                <td><?php echo isset($whoisData['country']) ? $whoisData['country'] : 'N/A'; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">State</th>
                                <td><?php echo isset($whoisData['state']) ? $whoisData['state'] : 'N/A'; ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        echo "<div class='alert alert-warning'>No result found.</div>";
                    }
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
