<?php
// MySQL 데이터베이스 연결 정보
$servername = "localhost"; // 예: "localhost"
$username = "root"; // 예: "root"
$password = "e0425820"; // 예: "password"
$dbname = "jsdb"; // 예: "jsdb"

// 폼에서 데이터 가져오기
$email = $_POST['email'];

try {
    // 데이터베이스 연결 생성
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // 에러 모드를 예외 모드로 설정
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 데이터 삽입 또는 업데이트 쿼리
    $sql = "INSERT INTO lg_lunch (email) VALUES (:email)";

    // SQL 문 준비
    $stmt = $conn->prepare($sql);
    // 파라미터 바인딩
    $stmt->bindParam(':email', $email);

    // 쿼리 실행
    $stmt->execute();

    echo "등록이 정상적으로 완료되었습니다.";
} catch(PDOException $e) {
    echo "등록실패(아마 등록되어있을듯??) , 상세 에러: " . $e->getMessage();
}

// 연결 종료
$conn = null;
?>

