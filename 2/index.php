<?php
$file = 'books.json';
if (!file_exists($file)) die("Error: Missing books.json");

$data = json_decode(file_get_contents($file), true);
if (!is_array($data)) die("Error: Invalid JSON format");

function showBooks($id, $title, $books) {
  if (empty($books)) return;

  echo "<section class='category' id='cat_$id' data-genre='".strtolower($title)."'>
          <div class='cat-header'>
            <h2>".htmlspecialchars($title)."</h2>
            <div class='scroll-controls'>
              <button class='scroll-btn left' onclick=\"scrollRow('$id', -1)\">&#10094;</button>
              <button class='scroll-btn right' onclick=\"scrollRow('$id', 1)\">&#10095;</button>
            </div>
          </div>
          <div class='book-list' id='$id'>";

  foreach ($books as $b) {
    $img = htmlspecialchars($b['imageLink'] ?? 'default.jpg');
    $bookTitle = htmlspecialchars($b['title'] ?? 'Untitled');
    $author = htmlspecialchars($b['author'] ?? '');
    $year = htmlspecialchars($b['year'] ?? '');

    echo "<div class='book-card'
             data-title='".htmlspecialchars($bookTitle)."'
             data-author='".htmlspecialchars($author)."'
             data-year='".htmlspecialchars($year)."'
             data-genre='".strtolower($title)."'
             data-img='images/$img'
             onclick='showPopup(this)'>
            <div class='book-cover'>
              <img src='images/$img' alt='$bookTitle'>
            </div>
            <div class='book-info'>
              <h3>$bookTitle</h3>";
    if ($author || $year) {
      echo "<p class='book-meta'>";
      if ($author) echo htmlspecialchars($author);
      if ($author && $year) echo " • ";
      if ($year) echo htmlspecialchars($year);
      echo "</p>";
    }
    echo "</div></div>";
  }

  echo "</div></section>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #0d1117;
      color: #e6edf3;
    }

    .container {
      padding: 40px 30px;
      max-width: 1300px;
      margin: auto;
    }

    h1 {
      text-align: center;
      font-size: 2.5em;
      color: #1f6feb;
      margin-bottom: 40px;
    }

    /* Search Bar */
    .search-box {
      text-align: center;
      margin-bottom: 40px;
    }
    .search-box input {
      width: 60%;
      padding: 12px 15px;
      border-radius: 25px;
      border: 2px solid #30363d;
      background: #161b22;
      color: #e6edf3;
      font-size: 16px;
    }
    .search-box input::placeholder {
      color: #8b949e;
    }

    .category {
      margin-bottom: 65px;
    }

    .cat-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 0 10px 15px 10px;
    }

    .category h2 {
      margin: 0;
      font-size: 1.6em;
      color: #58a6ff;
    }

    .book-list {
      display: flex;
      gap: 20px;
      overflow-x: auto;
      scroll-behavior: smooth;
      padding: 10px 0 20px;
    }
    .book-list::-webkit-scrollbar { display: none; }

    .book-card {
      flex: 0 0 auto;
      width: 200px;
      background: #161b22;
      border: 1px solid #30363d;
      border-radius: 12px;
      overflow: hidden;
      cursor: pointer;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .book-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 0 18px #1f6feb;
    }

    .book-cover img {
      width: 100%;
      height: 270px;
      object-fit: cover;
      border-bottom: 1px solid #30363d;
    }

    .book-info {
      padding: 12px 10px 18px;
      text-align: center;
    }

    .book-info h3 {
      font-size: 15px;
      font-weight: 600;
      color: #e6edf3;
      margin: 6px 0;
      height: 40px;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
    }

    .book-meta {
      font-size: 13px;
      color: #8b949e;
      margin-top: 6px;
    }

    /* Scroll Buttons */
    .scroll-controls { display: flex; gap: 8px; }
    .scroll-btn {
      background: #161b22;
      border: 1px solid #30363d;
      border-radius: 50%;
      width: 40px; height: 40px;
      font-size: 20px;
      color: #e6edf3;
      cursor: pointer;
      transition: 0.25s;
    }
    .scroll-btn:hover {
      background: #1f6feb;
      color: white;
      border-color: #1f6feb;
    }

    /* Popup */
    .popup {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.82);
      justify-content: center;
      align-items: center;
      z-index: 10;
    }

    .popup-content {
      background: #161b22;
      border: 1px solid #30363d;
      padding: 25px;
      border-radius: 15px;
      width: 380px;
      text-align: center;
      position: relative;
      box-shadow: 0 0 25px #1f6feb;
      animation: fadeIn 0.3s ease;
    }

    .popup-content img {
      width: 100%;
      border-radius: 10px;
      margin-bottom: 15px;
    }

    .popup-content h3 {
      color: #58a6ff;
      margin: 10px 0;
      font-size: 20px;
    }

    .popup-content p {
      color: #c9d1d9;
      font-size: 15px;
      margin: 4px 0;
    }

    .close-btn {
      position: absolute;
      top: 10px; right: 15px;
      background: #da3633;
      border: none;
      color: white;
      font-size: 18px;
      border-radius: 50%;
      width: 28px; height: 28px;
      cursor: pointer;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body>

<div class="container">
  <h1> ONIS COLLECTION LIBRARY</h1>

  <div class="search-box">
    <input type="text" id="searchInput" placeholder="Search...">
  </div>

  <?php
    showBooks("romance", "Romance Books", $data["romance_books"] ?? []);
    showBooks("fantasy", "Fantasy Books", $data["fantasy_books"] ?? []);
    showBooks("action", "Action Books", $data["action_books"] ?? []);
  ?>
</div>

<div class="popup" id="bookPopup">
  <div class="popup-content">
    <button class="close-btn" onclick="closePopup()">×</button>
    <img id="popupImg" src="" alt="">
    <h3 id="popupTitle"></h3>
    <p id="popupAuthor"></p>
    <p id="popupYear"></p>
  </div>
</div>

<script>
function scrollRow(id, dir) {
  const row = document.getElementById(id);
  if (row) row.scrollBy({left: dir * 400, behavior: 'smooth'});
}

document.getElementById('searchInput').addEventListener('input', function() {
  const q = this.value.toLowerCase();
  document.querySelectorAll('.book-card').forEach(card => {
    const text = (card.dataset.title + card.dataset.author + card.dataset.genre).toLowerCase();
    card.style.display = text.includes(q) ? 'block' : 'none';
  });
});

function showPopup(el) {
  document.getElementById('popupImg').src = el.dataset.img;
  document.getElementById('popupTitle').textContent = el.dataset.title;
  document.getElementById('popupAuthor').textContent = el.dataset.author ? "Author: " + el.dataset.author : "";
  document.getElementById('popupYear').textContent = el.dataset.year ? "Year: " + el.dataset.year : "";
  document.getElementById('bookPopup').style.display = 'flex';
}

function closePopup() {
  document.getElementById('bookPopup').style.display = 'none';
}
</script>

</body>
</html>
