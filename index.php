<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Enter Code</title>
    <style>
        body {
            background-color: black;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        input {
            font-size: 18px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div>
        <form action="check_token.php" method="POST">
            <input type="text" name="token" placeholder="Enter code here" required>
            <input type="submit" value="Enter">
        </form>
    </div>
</body>
</html>
