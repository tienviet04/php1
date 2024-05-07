<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $overview = $_POST['overview'];
    $release_date = $_POST['release_date'];
    $genre_id = $_POST['genre_id'];

    //movie_id
    $movie_id = $_POST['movie_id'];
    $poster = $_POST['poster'];

    //Lấy dữ liệu file
    $file = $_FILES['poster'];
    //Trường hợp người dùng thay ảnh poster mới
    if ($file['size'] > 0) {
        $poster = $file['name'];
        //Upload file
        move_uploaded_file($file['tmp_name'], "images/" . $poster);
    }


    //SQL UPDATE
    $sql = "UPDATE movies SET title='$title', poster='$poster', overview='$overview', release_date='$release_date', genre_id='$genre_id' WHERE movie_id=$movie_id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    setcookie("message", "Cập nhật dữ liệu thành công", time() + 1);
    header("location: index.php");
    die;
}

//Câu lệnh SQL lấy dữ liệu bảng genres
$sql = "SELECT * FROM genres";
$stmt = $conn->prepare($sql);
$stmt->execute();
$genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Lấy movie_id trên thanh URL
$movie_id = $_GET['movie_id'];
//Câu lệnh SQL với điều kiện movie_id
$sql = "SELECT * FROM movies WHERE movie_id=$movie_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$movie = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <input type="hidden" name="movie_id" value="<?= $movie['movie_id'] ?>">
        Tiêu đề: <input type="text" name="title" value="<?= $movie['title'] ?>">
        <br><br>
        <input type="hidden" name="poster" value="<?= $movie['poster'] ?>">
        Áp phích: <input type="file" name="poster" id="">
        <br>
        <img src="images/<?= $movie['poster'] ?>" width="110">
        <br><br>
        Tổng quản:
        <textarea name="overview" id="" cols="100" rows="10"><?= $movie['overview'] ?></textarea>
        <br><br>
        Ngày phát hành: <input type="date" name="release_date" value="<?= $movie['release_date'] ?>">
        <br><br>
        Thể loại:
        <select name="genre_id" id="">
            <?php foreach ($genres as $gen) : ?>
                <option value="<?php echo $gen['genre_id'] ?>" <?= ($gen['genre_id'] == $movie['genre_id']) ? 'selected' : '' ?>>
                    <?= $gen['genre_name'] ?>
                </option>
            <?php endforeach ?>
        </select>
        <br><br>
        <button type="submit">Cập nhật</button>
        <a href="index.php">Danh sách</a>
    </form>
</body>

</html>