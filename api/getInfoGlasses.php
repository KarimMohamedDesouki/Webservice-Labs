<?php 

require_once("vendor/autoload.php");

$conn = new MainProgram;
$item = array();
if (($_SERVER["REQUEST_METHOD"] == "GET") && isset($_GET["id"])) {
    if ($conn->connect()) {
        $item = $conn->get_record_by_id($_GET["id"], "id");
    }
    $conn->disconnect();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    </style>
</head>
<body>

<div class="main">
    <?php if (!empty($item)) { ?>
        <table>
                <tr>
                    <td>
                        <h3>Details:</h3>
                        <p><?php echo "item id: " . $item->id ?></p>
                        <p><?php echo "code: " . $item->PRODUCT_code ?></p>
                        <p><?php echo "rating: " . $item->Rating ?></p>
                        <p><?php echo "Type: " . $item->product_name ?></p>
                        <p><?php echo "Price: " . $item->list_price ?></p>
                    </td>
                    <td>
                        <img src=<?php echo "/database/images/" . $item->Photo ?>>
                    </td>
                </tr>
            </table>
    <?php  } ?>
 



</div>
</body>
</html>

