<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$host = 'localhost';
//$user = 'root';
//$password = 'e0425820';
//$dbname = 'jsdb';

//$conn = new mysqli($host, $user, $password, $dbname);
$Conn = mysqli_connect("localhost", "root", "e0425820", "jsdb", 3306);
mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

if ($Conn->connect_error) {
    die("Connection failed: " . $Conn->connect_error);
}

// 기본값 설정
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 30;
$offset = ($page - 1) * $limit;

// 검색 조건과 페이징을 적용한 SQL 쿼리
$sql = "SELECT SVC_ID, 
        CASE 
            WHEN img_nm IS NULL OR img_nm = '' THEN 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg'
            ELSE concat('https://yeyak.seoul.go.kr',img_nm)
        END AS img_nm, 
        SVC_NM, RCEPT_BEGIN_DT, RCEPT_END_DT, USE_BEGIN_DT, USE_END_DT, 
        CASE 
           WHEN SVC_URL IS NULL OR SVC_URL = 'none' THEN CONCAT('https://yeyak.seoul.go.kr/web/reservation/selectReservView.do?rsv_svc_id=', SVC_ID)
           ELSE SVC_URL
        END AS SVC_URL 
        FROM Seoul_YeYak
        WHERE SVC_NM LIKE '%$search%'
        ORDER BY RCEPT_BEGIN_DT DESC 
        LIMIT $limit OFFSET $offset";

$result = mysqli_query($Conn, $sql);

if (!$result) {
    die("Query failed: " . $Conn->error);
}


// 전체 데이터 개수를 가져와서 페이지 수 계산
$count_sql = "SELECT COUNT(*) as total FROM Seoul_YeYak WHERE SVC_NM LIKE '%$search%'";
$count_result = mysqli_query($Conn, $count_sql);
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);


// 페이지 그룹 계산 (한 번에 10페이지씩 표시)
$pages_per_group = 10;
$current_group = ceil($page / $pages_per_group);
$start_page = ($current_group - 1) * $pages_per_group + 1;
$end_page = min($start_page + $pages_per_group - 1, $total_pages);

$Conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>서울 체험</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 0 10px;
        }

        h2 {
            margin-bottom: 20px;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            width: 100%;
        }

        .search-container input[type="text"] {
            width: 300px;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 5px;
            outline: none;
            box-sizing: border-box;
            transition: width 0.4s ease-in-out;
        }

        .search-container input[type="text"]:focus {
            width: 400px;
            border-color: #007bff;
        }

        .search-container input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }

        .search-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            width: 100%;
            max-width: 1400px;
        }

        .gallery-item {
            width: 180px;
            text-align: center;
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .gallery-item h2 {
            font-size: 18px;
            margin: 10px 0;
        }

        .gallery-item p {
            font-size: 14px;
            color: #666;
        }

        .gallery-item a {
            text-decoration: none;
            color: inherit;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: #333;
        }

        .pagination a.active {
            font-weight: bold;
        }

    </style>
</head>
<body>

    <h1><a href="http://1.239.38.238/seoul_yeyak/seoul_yeyak.php" style="text-decoration: none; color: black;">서울 체험 모아보기<a/></h1>

    <form method="GET" action="">
        <input type="text" name="search" placeholder="검색어를 입력하세요" value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="검색">
    </form>
<br>
    <div class="gallery">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="gallery-item">';
            echo '<a href=' . $row['SVC_URL'] . '>';
            echo '<img src=' . $row['img_nm'] . ' alt=' . $row['SVC_NM'] . '>';
            echo '<h2>' . $row['SVC_NM'] . '</h2>';
            echo '<p>접수기간</p>';
            echo '<p>' . $row['RCEPT_BEGIN_DT'] . ' ~ ' . $row['RCEPT_END_DT'] . '</p>';
            echo '<p>이용기간</p>';
            echo '<p>' . $row['USE_BEGIN_DT'] . ' ~ ' . $row['USE_END_DT'] . '</p>';
            echo '</a>';
            echo '</div>';
        }
    } else {
        echo "No records found.";
    }
    ?>
    </div>


    <div class="pagination">
    <?php
    // 처음으로 버튼
    if ($page > 1) {
        echo '<a href="?search=' . urlencode($search) . '&page=1">처음으로</a>';
    } else {
        echo '<a class="disabled">처음으로</a>';
    }

    // 이전 페이지 그룹
    if ($current_group > 1) {
        echo '<a href="?search=' . urlencode($search) . '&page=' . ($start_page - 1) . '">&laquo; 이전</a>';
    } else {
        echo '<a class="disabled">&laquo; 이전</a>';
    }

    // 페이지 번호
    for ($i = $start_page; $i <= $end_page; $i++) {
        echo '<a href="?search=' . urlencode($search) . '&page=' . $i . '"' . ($i == $page ? ' class="active"' : '') . '>' . $i . '</a>';
    }

    // 다음 페이지 그룹
    if ($end_page < $total_pages) {
        echo '<a href="?search=' . urlencode($search) . '&page=' . ($end_page + 1) . '">다음 &raquo;</a>';
    } else {
        echo '<a class="disabled">다음 &raquo;</a>';
    }

    // 끝으로 버튼
    if ($page < $total_pages) {
        echo '<a href="?search=' . urlencode($search) . '&page=' . $total_pages . '">끝으로</a>';
    } else {
        echo '<a class="disabled">끝으로</a>';
    }
    ?>
    </div>

<br><br>
</body>
</html>

