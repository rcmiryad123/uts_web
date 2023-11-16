<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>
<body>
    <?php
        require './config/db.php';

        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            // Fetch data dari database berdasarkan ID
            $result = mysqli_query($db_connect, "SELECT * FROM products WHERE id=$id");
            $data = mysqli_fetch_assoc($result);

            if(isset($_POST['update'])) {
                $name = $_POST['name'];
                $price = $_POST['price'];

                // Upload gambar (jika ada file yang diunggah)
                if ($_FILES['image']['name']) {
                    $uploadDir = 'uploads/';
                    $uploadFile = $uploadDir . basename($_FILES['image']['name']);

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        // Hapus gambar lama jika ada
                        if (!empty($data['image'])) {
                            unlink($data['image']);
                        }

                        // Update data di database
                        $query = "UPDATE products SET name='$name', price='$price', image='$uploadFile' WHERE id=$id";
                        mysqli_query($db_connect, $query);

                        header("Location: show.php"); // Redirect kembali ke halaman show.php setelah update
                    } else {
                        echo "Error uploading file!";
                    }
                } else {
                    // Jika tidak ada file yang diunggah, update data tanpa mengubah gambar
                    $query = "UPDATE products SET name='$name', price='$price' WHERE id=$id";
                    mysqli_query($db_connect, $query);

                    header("Location: show.php"); // Redirect kembali ke halaman show.php setelah update
                }
            }
    ?>
    
    <h1>Edit Produk</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="name">Nama produk:</label>
        <input type="text" id="name" name="name" value="<?=$data['name']?>" required><br>

        <label for="price">Harga:</label>
        <input type="text" id="price" name="price" value="<?=$data['price']?>" required><br>

        <label for="image">Gambar produk:</label>
        <input type="file" id="image" name="image"><br>

        <input type="submit" name="update" value="Update">
    </form>

    <?php } else { ?>
        <p>Invalid Request</p>
    <?php } ?>
</body>
</html>
