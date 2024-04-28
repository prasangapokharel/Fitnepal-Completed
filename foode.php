<!DOCTYPE html>
<html>
<head>
    <title>Food Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .list-group-item {
            background-color: #f8f9fa;
            border: none;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .list-group-item:hover {
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
        .nutrition-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Search Food Data</h2>
        <form method="GET" action="">
            <div class="form-group">
                <label for="food_name">Enter Food Name:</label>
                <input type="text" id="food_name" name="food_name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <div class="container mt-5">
    <h2>Search Food Data</h2>
    <form method="GET" action="">
        <div class="form-group">
            <label for="food_name">Enter Food Name:</label>
            <input type="text" id="food_name" name="food_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="mt-4">
        <?php
        // API key
        $api_key = "5yx5jp+p7hYIpsP2J2USrg==hOUD2NS3Au3KDfZT";

        // Check if the food name is submitted
        if(isset($_GET['food_name'])) {
            // URL encode the food name
            $food_name = urlencode($_GET['food_name']);
            
            // API endpoint
            $url = "https://api.calorieninjas.com/v1/nutrition?query={$food_name}";
            
            // Initialize cURL session
            $curl = curl_init($url);
            
            // Set the request headers
            $headers = array(
                'Content-Type:application/json',
                'X-Api-Key:'.$api_key
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            
            // Set cURL options
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            // Execute the cURL request
            $response = curl_exec($curl);
            
            // Close cURL session
            curl_close($curl);
            
            // Check if response is received
            if($response) {
                // Decode JSON response
                $data = json_decode($response, true);
                
                // Check if items are present in response
                if(isset($data['items']) && !empty($data['items'])) {
                    // Output HTML format
                    echo "<div class='list-group'>";
                    foreach($data['items'] as $item) {
                        echo "<div class='list-group-item'>";
                        echo "<h4>{$item['name']}</h4>";
                        echo "<p class='nutrition-label'>Calories: {$item['calories']} kcal</p>";
                        
                        // Check if fat, protein, and carbohydrates exist
                        if(isset($item['fat_total'])) {
                            echo "<p class='nutrition-label'>Fat: {$item['fat_total']} g</p>";
                        } else {
                            echo "<p class='nutrition-label'>Fat: Information not available</p>";
                        }
                        
                        if(isset($item['protein'])) {
                            echo "<p class='nutrition-label'>Protein: {$item['protein']} g</p>";
                        } else {
                            echo "<p class='nutrition-label'>Protein: Information not available</p>";
                        }
                        
                        if(isset($item['carbohydrates'])) {
                            echo "<p class='nutrition-label'>Carbohydrates: {$item['carbohydrates']} g</p>";
                        } else {
                            echo "<p class='nutrition-label'>Carbohydrates: Information not available</p>";
                        }
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>No data found for the given food name.</p>";
                }
            } else {
                echo "<p>Failed to fetch data from the API.</p>";
            }
        }
        ?>
    </div>
</div>

    </div>
</body>
</html>
