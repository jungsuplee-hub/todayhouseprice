<?php
include_once "./top_page.php";

// Request Parameters
$user_update = $_REQUEST["user_update"];
$area_main_name = $_REQUEST["area_main_name"];
$area_sub_name = $_REQUEST["area_sub_name"];
$insert_date = $_REQUEST["insert_date"];
$type = $_REQUEST["type"];
$size1 = $_REQUEST["size1"];
$size2 = $_REQUEST["size2"];
$size3 = $_REQUEST["size3"];
$size4 = $_REQUEST["size4"];

// Date calculations
$today = date("Y-m-d");
$before1Day = date("Y-m-d", strtotime($today . " -1 day"));
$before2Day = date("Y-m-d", strtotime($today . " -2 day"));
$before3Day = date("Y-m-d", strtotime($today . " -3 day"));
$before4Day = date("Y-m-d", strtotime($today . " -4 day"));
$before5Day = date("Y-m-d", strtotime($today . " -5 day"));
$before6Day = date("Y-m-d", strtotime($today . " -6 day"));
$before7Day = date("Y-m-d", strtotime($today . " -7 day"));
$this_hour = date('H');

if (empty($area_main_name)) {
  $size1 = "true";
  $size2 = "true";
  $size3 = "true";
  $size4 = "true";
}

if (empty($insert_date)) {
  $insert_date = ($this_hour < 7) ? date('Y-m-d', strtotime("-1 day")) : $today;
  if ($userid) {
    $user_update = "true";
  }
}

if ($userid && $user_update == "true") {
  $sql_select_user = "SELECT area_main_name, size1, size2, size3, size4 FROM user WHERE id = '$userid'";
  $rs_user = mysqli_query($Conn, $sql_select_user);
  $row_user = mysqli_fetch_assoc($rs_user);

  $area_main_name = $row_user["area_main_name"];
  $size1 = $row_user["size1"];
  $size2 = $row_user["size2"];
  $size3 = $row_user["size3"];
  $size4 = $row_user["size4"];
}

$size1_text = ($size1 == "true") ? "OR CAST(today.size AS DECIMAL(10,5)) <= 40" : "";
$size2_text = ($size2 == "true") ? "OR (CAST(today.size AS DECIMAL(10,5)) > 40 AND CAST(today.size AS DECIMAL(10,5)) <= 60)" : "";
$size3_text = ($size3 == "true") ? "OR (CAST(today.size AS DECIMAL(10,5)) > 60 AND CAST(today.size AS DECIMAL(10,5)) <= 85)" : "";
$size4_text = ($size4 == "true") ? "OR CAST(today.size AS DECIMAL(10,5)) > 85" : "";

$area_main_name_text = ($area_main_name == '전체') ? "1=1" : "today.area_main_name = '".$area_main_name."'";

if ($area_sub_name != "") {
  $area_sub_name_text = "AND REPLACE(REPLACE(today.area_name, CONCAT(today.area_main_name,' '),''),' ','') = '$area_sub_name'";
}

if ($type == "") {
  $type = "all";
}

if ($area_main_name == '충청도') {
  $area_main_name_text = "today.area_main_name IN ('충청북도','충청남도')";
} elseif ($area_main_name == '경상도') {
  $area_main_name_text = "today.area_main_name IN ('경상북도','경상남도')";
} elseif ($area_main_name == '전라도') {
  $area_main_name_text = "today.area_main_name IN ('전라북도','전라남도')";
} elseif ($area_main_name == '전체') {
  $area_main_name_text = "1=1";
}

// SQL Query to fetch data
$sql = "SELECT
          today.yearmonthday,
          today.area_main_name,
          REPLACE(today.area_name,today.area_main_name,'') AS area_name,
          today.doing,
          today.apart_name,
          today.size,
          today.stair,
          today.price,
          today.TYPE,
          today.STATUS,
          today.max_price,
          today.max_price_date,
          today.min_price,
          today.min_price_date,
          today.last_price,
          today.last_price_date,
          ROUND((CAST(today.price AS DECIMAL(10,5)) - CAST(today.last_price AS DECIMAL(10,5))),2) AS price_last,
          CASE
            WHEN CAST(today.price AS DECIMAL(10,5)) > CAST(today.last_price AS DECIMAL(10,5))
            THEN ROUND(((CAST(today.price AS DECIMAL(10,5))/CAST(today.last_price AS DECIMAL(10,5))*100)-100),0)
            WHEN CAST(today.price AS DECIMAL(10,5)) < CAST(today.last_price AS DECIMAL(10,5))
            THEN ROUND(100-(CAST(today.price AS DECIMAL(10,5))/CAST(today.last_price AS DECIMAL(10,5)))*100,0)
            ELSE 0 END AS percent,
          ROUND((CAST(today.price AS DECIMAL(10,5)) - CAST(today.max_price AS DECIMAL(10,5))),2) AS price_max,
          ROUND(100-(CAST(today.price AS DECIMAL(10,5))/CAST(today.max_price AS DECIMAL(10,5)))*100,0) AS max_percent,
          IFNULL(rent.last_price,0) AS rent_last_price,
          IFNULL(rent.max_price,0) AS rent_max_price,
          IFNULL(rent.min_price,0) AS rent_min_price
        FROM molit_today_update today
        LEFT JOIN molit_max_min_rent_all_group rent
        ON today.area_main_name = rent.area_main_name
        AND today.doing = rent.dong
        AND today.apart_name = rent.apart_name
        AND ROUND(CAST(today.size AS DECIMAL(10,5))) = rent.size
        WHERE $area_main_name_text
        AND today.insert_date = '$insert_date'
        $area_sub_name_text
        AND (1!=1 $size1_text $size2_text $size3_text $size4_text)
        AND today.status IS NOT NULL
        AND !(today.last_price = '0' AND today.max_price != '0')
        ORDER BY ABS(ROUND((CAST(today.price AS DECIMAL(10,5)) - CAST(today.last_price AS DECIMAL(10,5))),2)) DESC
        LIMIT 100;";

$rs = mysqli_query($Conn, $sql);
$rows = [];
while ($row = mysqli_fetch_assoc($rs)) {
    $rows[] = $row;
}

// Additional SQL Queries
// ... (The rest of the queries)

// UI Rendering
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Apartment Today</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
  }
  header, footer {
    background-color: #333;
    color: #fff;
    padding: 10px 0;
    text-align: center;
  }
  .container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin: 20px;
  }
  .container > div {
    margin: 10px;
  }
  .search-bar {
    text-align: center;
    margin: 20px;
  }
  .search-bar input {
    font-size: 20px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
  .search-bar select {
    font-size: 20px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
  }
  table, th, td {
    border: 1px solid #ddd;
  }
  th, td {
    padding: 10px;
    text-align: center;
  }
  th {
    background-color: #333;
    color: white;
  }
  tr:nth-child(even) {
    background-color: #f9f9f9;
  }
  .highlight {
    background-color: #ff0;
  }
</style>
</head>
<body>
<header>
  <h1>Apartments Available Today</h1>
</header>

<div class="search-bar">
  <input id="search" type="search" size="40" placeholder="Search by apartment name or address" onkeyup="showResult(this.value)" autofocus autocomplete="off">
  <div id="livesearch"></div>
</div>

<div class="container">
  <div>
    <label for="day">Select Date:</label>
    <select id="day" onchange="apart_day_list(this)">
      <option value="<?= $today ?>" <?= $insert_date == $today ? 'selected' : '' ?>><?= $today ?></option>
      <option value="<?= $before1Day ?>" <?= $insert_date == $before1Day ? 'selected' : '' ?>><?= $before1Day ?></option>
      <option value="<?= $before2Day ?>" <?= $insert_date == $before2Day ? 'selected' : '' ?>><?= $before2Day ?></option>
      <!-- More options... -->
    </select>
  </div>
  <div>
    <label for="type">Select Type:</label>
    <select id="type" onchange="apart_type(this)">
      <option value="all" <?= $type == 'all' ? 'selected' : '' ?>>매매/전세</option>
      <option value="meme" <?= $type == 'meme' ? 'selected' : '' ?>>매매</option>
      <option value="rent" <?= $type == 'rent' ? 'selected' : '' ?>>전세</option>
    </select>
  </div>
  <div>
    <label for="main">Select Area:</label>
    <select id="main" onchange="apart_list(this)">
      <option value="전체" <?= $area_main_name == '전체' ? 'selected' : '' ?>>전체</option>
      <!-- More options... -->
    </select>
  </div>
  <div>
    <label for="sub">Select Sub-Area:</label>
    <select id="sub" onchange="apart_sub_list(this)">
      <option value=''>선택</option>
      <!-- More options... -->
    </select>
  </div>
  <div>
    <form name="mform">
      <label>Size:</label>
      <input type="checkbox" id="size1" onclick="check1(this)" <?= $size1 == "true" ? "checked" : "" ?>> 40 ㎡ 이하
      <input type="checkbox" id="size2" onclick="check2(this)" <?= $size2 == "true" ? "checked" : "" ?>> 40-60 ㎡
      <input type="checkbox" id="size3" onclick="check3(this)" <?= $size3 == "true" ? "checked" : "" ?>> 60-85 ㎡
      <input type="checkbox" id="size4" onclick="check4(this)" <?= $size4 == "true" ? "checked" : "" ?>> 85 ㎡ 초과
    </form>
  </div>
</div>

<table>
  <thead>
    <tr>
      <th>아파트명</th>
      <th>전용면적</th>
      <th>신규가격</th>
      <th>최근가격</th>
      <th>최고가격</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $row) : ?>
      <tr>
        <td><?= $row['apart_name'] ?><br><?= $row['yearmonthday'] ?><br><?= $row['area_main_name'] ?> <?= $row['area_name'] ?> <?= $row['doing'] ?></td>
        <td><?= $row['size'] ?>㎡<br><?= $row['stair'] ?>층<br><?= $row['TYPE'] ?></td>
        <td><?= $row['price'] ?>억</td>
        <td><?= $row['last_price'] ?>억<br><?= $row['last_price_date'] ?></td>
        <td><?= $row['max_price'] ?>억<br><?= $row['max_price_date'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script>
function showResult(str) {
  if (str.length == 0) {
    document.getElementById("livesearch").innerHTML = "";
    document.getElementById("livesearch").style.border = "0px";
    return;
  }
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("livesearch").innerHTML = this.responseText;
      document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
    }
  };
  xmlhttp.open("GET", "./ajax/apart_search_select.php?q=" + str, true);
  xmlhttp.send();
}

function apart_day_list(e) {
  window.location.replace(`./apart_today.php?area_main_name=${document.getElementById('main').value}&area_sub_name=${document.getElementById('sub').value}&insert_date=${document.getElementById('day').value}&type=${document.getElementById('type').value}&size1=${document.getElementById('size1').checked}&size2=${document.getElementById('size2').checked}&size3=${document.getElementById('size3').checked}&size4=${document.getElementById('size4').checked}`);
}
function apart_list(e) {
  window.location.replace(`./apart_today.php?area_main_name=${document.getElementById('main').value}&area_sub_name=${document.getElementById('sub').value}&insert_date=${document.getElementById('day').value}&type=${document.getElementById('type').value}&size1=${document.getElementById('size1').checked}&size2=${document.getElementById('size2').checked}&size3=${document.getElementById('size3').checked}&size4=${document.getElementById('size4').checked}`);
}
function apart_sub_list(e) {
  window.location.replace(`./apart_today.php?area_main_name=${document.getElementById('main').value}&area_sub_name=${document.getElementById('sub').value}&insert_date=${document.getElementById('day').value}&type=${document.getElementById('type').value}&size1=${document.getElementById('size1').checked}&size2=${document.getElementById('size2').checked}&size3=${document.getElementById('size3').checked}&size4=${document.getElementById('size4').checked}`);
}
function apart_type(e) {
  window.location.replace(`./apart_today.php?area_main_name=${document.getElementById('main').value}&area_sub_name=${document.getElementById('sub').value}&insert_date=${document.getElementById('day').value}&type=${document.getElementById('type').value}&size1=${document.getElementById('size1').checked}&size2=${document.getElementById('size2').checked}&size3=${document.getElementById('size3').checked}&size4=${document.getElementById('size4').checked}`);
}
function check1(country) {
  apart_day_list(country);
}
function check2(country) {
  apart_day_list(country);
}
function check3(country) {
  apart_day_list(country);
}
function check4(country) {
  apart_day_list(country);
}
</script>

<footer>
  <span>&copy; 2022 TodayHousePrice, Inc. All rights reserved<br>Developer: todayhouseprice.com@gmail.com</span>
</footer>
</body>
</html>

