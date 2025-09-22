<?php
// MySQL 데이터베이스 연결 정보
$servername = "localhost"; // 예: "localhost"
$username = "root"; // 예: "root"
$password = "e0425820"; // 예: "password"
$dbname = "jsdb"; // 예: "jsdb"

// 데이터베이스 연결 생성
$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 등록된 이메일 리스트 가져오기
$sql = "SELECT email FROM lg_lunch";
$stmt = $conn->prepare($sql);
$stmt->execute();
$emails = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LG E14동 점심정보 구독</title>
</head>
<body>
    <h2>LG 사이언스파크 E14동 점심정보 구독서비스 입니다.<br>Email을 입력하고 구독 또는 구독취소 버튼을 클릭하세요</h2>
    <form action="submit.php" method="post">
        <label for="email">Email: (ex aaaa@lgcnspartner.com / 외부메일도 가능)</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="구독">
        <input type="submit" formaction="unsubscribe.php" value="구독취소">
    </form>
<br>
<h3>구독자 리스트</h3>
    <ul>
        <?php foreach ($emails as $email): ?>
            <li><?php echo htmlspecialchars($email['email']); ?></li>
        <?php endforeach; ?>
    </ul>

<h2>평일 11시 20분에 발송되며 샘플이미지는 아래와 같습니다.</h2>
<h3>더 일찍 보내고 싶으나 11시에는 식단 이미지가 업로드가 안되어있음..</h3>
<img style="vertical-align: middle; width:30%;" src="./lglunch_info.png">
</body>
</html>

