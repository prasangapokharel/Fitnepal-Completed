<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cryptocurrency Prices</title>
    <style>
        /* Add some custom styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        #priceTable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        #priceTable th, #priceTable td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }
        #priceTable th {
            background-color: #f2f2f2;
        }
        #priceUpdate {
            font-size: 12px;
            color: #999999;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Cryptocurrency Prices</h1>
    <table id="priceTable">
        <thead>
            <tr>
                <th>Cryptocurrency</th>
                <th>Price (USD)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch cryptocurrency prices from CoinGecko API
            $apiUrl = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,ripple&vs_currencies=usd';
            $data = @file_get_contents($apiUrl); // Suppress warnings
            if ($data === false) {
                echo '<tr><td colspan="2">Error fetching cryptocurrency prices.</td></tr>';
            } else {
                $prices = json_decode($data, true);

                // Check if data was fetched successfully
                if ($prices && isset($prices['bitcoin'], $prices['ethereum'], $prices['ripple'])) {
                    // Iterate through each cryptocurrency in the response data
                    foreach ($prices as $crypto => $price) {
                        echo '<tr>';
                        echo '<td>' . ucfirst($crypto) . '</td>';
                        echo '<td>$' . number_format($price['usd'], 2) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">Error fetching cryptocurrency prices.</td></tr>';
                }
            }
            ?>
        </tbody>
    </table>
    <p id="priceUpdate">Last updated: <?php echo date('Y-m-d H:i:s'); ?></p>
</body>
</html>
