<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $overview = $_POST['overview'];
    $release_date = $_POST['release_date'];
    $genre_id = $_POST['genre_id'];

    //Lấy dữ liệu file
    $file = $_FILES['poster'];
    $poster = $file['name'];
    //Upload file
    move_uploaded_file($file['tmp_name'], "images/" . $poster);

    //SQL INSERT
    $sql = "INSERT INTO movies(title, poster, overview, release_date, genre_id) VALUES('$title', '$poster', '$overview', '$release_date', '$genre_id')";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    setcookie("message", "Thêm dữ liệu thành công", time() + 1);
    header("location: index.php");
    die;
}

//Câu lệnh SQL lấy dữ liệu bảng genres
$sql = "SELECT * FROM genres";
$stmt = $conn->prepare($sql);
$stmt->execute();
$genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phim</title>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        Tiêu đề: <input type="text" name="title" id="">
        <br><br>
        Áp phích: <input type="file" name="poster" id="">
        <br><br>
        Tổng quản:
        <textarea name="overview" id="" cols="100" rows="10"></textarea>
        <br><br>
        Ngày phát hành: <input type="date" name="release_date" id="">
        <br><br>
        Thể loại:
        <select name="genre_id" id="">
            <?php foreach ($genres as $gen) : ?>
                <option value="<?php echo $gen['genre_id'] ?>">
                    <?= $gen['genre_name'] ?>
                </option>
            <?php endforeach ?>
        </select>
        <br><br>
        <button type="submit">Thêm</button>
        <a href="index.php">Danh sách</a>
    </form>
</body>

</html>