<?php
// MySQL 데이터베이스 연결 정보
$servername = "localhost"; // 예: "localhost"
$username = "root"; // 예: "root"
$password = "e0425820"; // 예: "password"
$dbname = "jsdb"; // 예: "jsdb";

// 폼에서 데이터 가져오기
$email = $_POST['email'];

try {
    // 데이터베이스 연결 생성
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 이메일 삭제 쿼리
    $sql = "DELETE FROM lg_lunch WHERE email = :email";

    // SQL 문 준비
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);

    // 쿼리 실행
    $stmt->execute();

    // 성공 후 등록 페이지로 리디렉션
    echo "구독취소 성공!!";
} catch(PDOException $e) {
    echo "에러발생(아마 없는 이메일일듯?) , 상세에러 : Error: " . $e->getMessage();
}

// 연결 종료
$conn = null;
?>

