<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
</head>
<body>
    <div>
        <h2>Parameters:</h2>
        <table>
            <tr>
                <th>param</th>
            </tr>
            <?php foreach ($params as $param): ?>
                <tr>
                    <td><?php echo $param; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Query String Data:</h2>
        <table>
            <tr>
                <th>key</th>
                <th>val</th>
            </tr>
            <?php foreach ($query as $key => $val): ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td><?php echo $val; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>	
    </div>
</body>
</html>