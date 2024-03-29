<?php
session_start();

$conn = new SQLite3("Bushtucker") or die ("unable to open database");

function createTable($sqlStmt, $tableName)
{
    global $conn;
    $stmt = $conn->prepare($sqlStmt);
    if ($stmt->execute()) {
//        echo "<p style='color: green'>" . $tableName . ": Table Created Successfully</p>";
    } else {
        echo "<p style='color: red'>" . $tableName . ": Table Created Failure</p>";
    }
}

function addUser($username, $unhashedPassword, $name, $profilePic, $accessLevel)
{
    global $conn;
    $hashedPassword = password_hash($unhashedPassword, PASSWORD_DEFAULT);
    $sqlstmt = $conn->prepare("INSERT INTO user (username, password, name, profilePic, accessLevel) VALUES (:userName, :hashedPassword, :name, :profilePic, :accessLevel)");
    $sqlstmt->bindValue(':userName', $username);
    $sqlstmt->bindValue(':hashedPassword', $hashedPassword);
    $sqlstmt->bindValue(':name', $name);
    $sqlstmt->bindValue(':profilePic', $profilePic);
    $sqlstmt->bindValue(':accessLevel', $accessLevel);
    if ($sqlstmt->execute()) {
        echo "<p style='color: green'>User: " . $username . ": Created Successfully</p>";
    } else {
        echo "<p style='color: red'>User: " . $username . ": Created Failure</p>";
    }
}

function addProduct($productName, $category, $quantity, $price, $image, $code)
{
    global $conn;
    $sqlstmt = $conn->prepare("INSERT INTO products (productName, category, quantity, price, image, code) VALUES (:productName, :category, :quantity, :price, :image, :code)");
    $sqlstmt->bindValue(':productName', $productName);
    $sqlstmt->bindValue(':category', $category);
    $sqlstmt->bindValue(':quantity', $quantity);
    $sqlstmt->bindValue(':price', $price);
    $sqlstmt->bindValue(':image', $image);
    $sqlstmt->bindValue(':code', $code);
    if ($sqlstmt->execute()) {
        echo "<p style='color: green'>Product: " . $productName . ": Created Successfully</p>";
    } else {
        echo "<p style='color: red'>Product: " . $productName . ": Created Failure</p>";
    }
}

$query = file_get_contents("sql/create-user.sql");
createTable($query, "User");
$query = file_get_contents("sql/create-orderDetails.sql");
createTable($query, "Order Details");
$query = file_get_contents("sql/create-products.sql");
createTable($query, "Products");
$query = file_get_contents("sql/create-messaging.sql");
createTable($query, "Messaging");



$query = $conn->query("SELECT COUNT(*) as count FROM user");
$rowCount = $query->fetchArray();
$userCount = $rowCount["count"];

if ($userCount == 0) {
    addUser("admin", "admin", "Administrator", "admin.jpg", "Administrator");
    addUser("user", "user", "User", "user.jpg", "User");
    addUser("ryan", "ryan", "Ryan", "ryan.jpg", "User");
}

$query = $conn->query("SELECT COUNT(*) as count FROM products");
$rowCount = $query->fetchArray();
$productCount = $rowCount["count"];

if ($productCount == 0) {
    addProduct('False Sarsaparilla', 'Plants - Medicinal', 29, 26.11, '4389883142_5142ceb6a7_b.jpg', 'a4d84470');
    addProduct('Cats Whiskers', 'Plants - Medicinal', 97, 9.13, '5220911110_1214b10fa0_c.jpg', '677cc2fc');
    addProduct('Native Geranium', 'Plants - Medicinal', 26, 14.11, '45466644401_2225243feb_b.jpg', '209ea37a');
    addProduct('Gumbi Gumbi', 'Plants - Medicinal', 78, 8.84, 'Gumbi-Gumbi-Pittosporum-angustifolium-1.jpg', '2f41672b');
    addProduct('Deeringia Amaranthoides', 'Plants - Medicinal', 45, 9.23, '800px-Deeringia_amaranthoides_fruit.jpg', 'b3b9707d');
    addProduct('Kangaroo Paw', 'Seeds', 66, 28.27, 'wildflower-seed-kangaroo-paw-red-and-green-seeweskpr.jpg', '6f21f1f0');
    addProduct('Heath Banksia', 'Seeds', 10, 2.34, 'wildflower-seed-heath-banksia-seewsehba.jpg', 'f5ed04c4');
    addProduct('Dwarf Wattle', 'Seeds', 5, 4.18, 'Wildflower-Seed-Dwarf-Wattle.jpg', '45f4013e');
    addProduct('Waratah', 'Seeds', 77, 20.56, 'wildflower-seed-waratah-seewsewar.jpg', '1e74bc4c');
    addProduct('Everlasting Daisies', 'Seeds', 75, 18.01, 'wildflower-seed-everlasting-daisesr-seewseeve.jpg', 'b4f02e1e');
    addProduct('Lemon Myrtle', 'Herbs & Spices', 34, 7.42, '1600px-CSIRO_ScienceImage_3022_Dried_Lemon_Myrtle_Leaves_Backhousia_citriodora.jpg', '32a84017');
    addProduct('Pepperberry', 'Herbs & Spices', 72, 7.23, 'Pepperberry.jpg', 'd8ad4a48');
    addProduct('Wattleseed', 'Herbs & Spices', 65, 7.64, '1600px-CSIRO_ScienceImage_3155_Roasted_and_Ground_Seeds_of_the_Elegant_Wattle_Acacia_victoriae.jpg', 'eb054b01');
    addProduct('Bush Tomato', 'Herbs & Spices', 98, 24.75, '900px-Australian_bush_tomato_fruit.jpg', 'b6ff18d1');
    addProduct('Native Mint', 'Herbs & Spices', 60, 22.17, '2743900696_002883df2d_b.jpg', '7e88e419');
    addProduct('Mountain pepper', 'Bushtucker', 23, 13.97, 'CSIRO_ScienceImage_3982_Leaves_and_Berries_of_the_Mountain_Pepper_Tasmannia_lanceolata.jpg', 'a73704d4');
    addProduct('Kurrajong seed', 'Bushtucker', 72, 25.16, '6674421121_f9472c2772_b.jpg', '36dee4d8');
    addProduct('False Sarsaparilla tea', 'Bushtucker', 18, 4.99, 'Sarsaparilla-1271142_1920.jpg', '7ef0adfe');
    addProduct('Peppermint gum tea', 'Bushtucker', 70, 17.18, 'XO-Tea_Peppermint-Gum_Loose-Leaf_DSCF0927-768x768.jpg', '419d0ab8');
    addProduct('Quandong', 'Bushtucker', 4, 3.4, 'Quandong.JPG', '063a0b4f');
    addProduct('Kangaroo Apple', 'Fruit', 4, 2.34, 'Kangaroo-Apple-5739.jpeg', '708bb6e1');
    addProduct('Brush Cherry', 'Fruit', 4, 43.1, '5461318098_665cac98f7_b.jpg', '9b6d9156');
    addProduct('Illawarra Plum', 'Fruit', 4, 2, '8611945282_e3c1b9b0d3_b.jpg', '062addfa');
    addProduct('Sugarwood', 'Fruit', 4, 34.42, 'Myoporum_platycarpum.jpg', 'c943f6b7');
    addProduct('Sparrows mango', 'Fruit', 4, 5.1, '1600px-Buchanania_arborescens_Kewarra_4166.jpg', 'd3c86956');
}


?>