<?php
$books = [
  "Harry Potter" => ["author" => "J.K. Rowling", "year" => 1997, "genre" => "Fantasy"],
  "The Hobbit" => ["author" => "J.R.R. Tolkien", "year" => 1937, "genre" => "Fantasy"],
  "Sherlock Holmes" => ["author" => "Arthur Conan Doyle", "year" => 1892, "genre" => "Mystery"],
  "Gone Girl" => ["author" => "Gillian Flynn", "year" => 2012, "genre" => "Mystery"],
  "A Brief History of Time" => ["author" => "Stephen Hawking", "year" => 1988, "genre" => "Science"],
  "The Selfish Gene" => ["author" => "Richard Dawkins", "year" => 1976, "genre" => "Science"],
  "Steve Jobs" => ["author" => "Walter Isaacson", "year" => 2011, "genre" => "Biography"],
  "Becoming" => ["author" => "Michelle Obama", "year" => 2018, "genre" => "Biography"]
];

function findBook(string $title, array $books): void {
  foreach ($books as $bookTitle => $details) {
    if (strcasecmp($title, $bookTitle) === 0) {
      echo "Title: $bookTitle" . PHP_EOL;
      echo "Author: {$details['author']}" . PHP_EOL;
      echo "Year: {$details['year']}" . PHP_EOL;
      echo "Genre: {$details['genre']}" . PHP_EOL;
      return;
    }
  }
  echo "Book not found: $title" . PHP_EOL;
}

if (php_sapi_name() === 'cli' && realpath($argv[0]) === __FILE__) {
  findBook('Harry Potter', $books);
}
?>