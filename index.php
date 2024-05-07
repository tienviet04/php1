<?php
require_once "connection.php";

if (!isset($_COOKIE['username'])) {
    header("location: login.php");
    die;
}

//Câu lệnh SQL Select
$sql = "SELECT movie_id, title, poster, overview, release_date, genre_name FROM movies m JOIN genres g ON m.genre_id=g.genre_id";

//Chuẩn bị
$stmt = $conn->prepare($sql);
//Thực thi
$stmt->execute();
//Lấy dữ liệu
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phim</title>
</head>

<body>
    <div style="color: green;">
        <?= $_COOKIE['message'] ?? '' ?>
    </div>

    <?php if (isset($_COOKIE['username'])) : ?>
        WELCOME <b><?= $_COOKIE['username'] ?></b>
        <a href="logout.php">Thoát</a>
    <?php endif ?>
    <table border="1">
        <tr>
            <th>#ID</th>
            <th>Title</th>
            <th>Poster</th>
            <th>Overview</th>
            <th>Release date</th>
            <th>Genre Name</th>
            <th>
                <a href="add.php">Thêm</a>
            </th>
        </tr>

        <?php foreach ($movies as $m) : ?>
            <tr>
                <td><?= $m['movie_id'] ?></td>
                <td><?= $m['title'] ?></td>
                <td>
                    <img src="images/<?= $m['poster'] ?>" width="100" alt="">
                </td>
                <td><?= $m['overview'] ?></td>
                <td><?= $m['release_date'] ?></td>
                <td><?= $m['genre_name'] ?></td>
                <td>
                    <a href="edit.php?movie_id=<?= $m['movie_id'] ?>">Sửa</a>
                    <a onclick="return confirm('Bạn có muốn xóa không?')" href="delete.php?movie_id=<?= $m['movie_id'] ?>">Xóa</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</body>

</html>