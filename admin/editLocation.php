<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit location</title>
</head>
<body>
<h1>Hub location</h1>
    <ul id="locationList">
        <li><a href="#" onclick="removeLocation(this)">Location 1</a></li>
        <li><a href="#" onclick="removeLocation(this)">Location 2</a></li>
        <li><a href="#" onclick="removeLocation(this)">Location 3</a></li>
    </ul>

    <button onclick="window.location.href='addLocation.php'">Add location</button>

    <script>
        function removeLocation(element) {
            var listItem = element.parentNode;
            listItem.parentNode.removeChild(listItem);
        }
    </script>
</body>
</html>