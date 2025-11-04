<?php
$library = [
  "Fiction" => [
    "Fantasy" => ["Harry Potter", "The Hobbit"],
    "Mystery" => ["Sherlock Holmes", "Gone Girl"]
  ],
  "Non-Fiction" => [
    "Science" => ["A Brief History of Time", "The Selfish Gene"],
    "Biography" => ["Steve Jobs", "Becoming"]
  ]
];

function printLibrary(array $sections, int $level = 0): void {
  foreach ($sections as $category => $content) {

    
    if (is_array($content) && array_values($content) === $content) {
      foreach ($content as $book) {
        echo str_repeat(' ', $level + 2) . "- $book" . PHP_EOL;
      }
    }

    
    elseif (is_array($content)) {
      echo str_repeat(' ', $level) . strtoupper($category) . PHP_EOL;
      printLibrary($content, $level + 2);
    }

   
    else {
      echo str_repeat(' ', $level) . $content . PHP_EOL;
    }
  }
}

if (php_sapi_name() === 'cli' && realpath($argv[0]) === __FILE__) {
  echo "Library Sections:\n";
  printLibrary($library);
}
?>