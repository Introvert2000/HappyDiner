<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two Sections</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
            height: 100vh;
        }

        .section-1 {
            flex: 3;
            background-color: #007BFF;
            color: #fff;
            padding: 20px;
        }

        .section-2 {
            flex: 2;
            background-color: #f4f4f4;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="section-1">
        <!-- Content for the first section -->
        <h1>Section 1 (3:2)</h1>
        <p>This is the left section with a 3:2 ratio.</p>
    </div>
    <div class="section-2">
        <!-- Content for the second section -->
        <h1>Section 2 (3:2)</h1>
        <p>This is the right section with a 3:2 ratio.</p>
    </div>
</body>
</html>
