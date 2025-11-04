<?php
class TreeNode {
    public string $value;
    public ?TreeNode $left = null;
    public ?TreeNode $right = null;

    public function __construct(string $value) {
        $this->value = $value;
    }
}

class BST {
    private ?TreeNode $root = null;

  
    public function add(string $value): void {
        $this->root = $this->insert($this->root, $value);
    }

    private function insert(?TreeNode $node, string $value): TreeNode {
        if ($node === null) return new TreeNode($value);

        if (strcasecmp($value, $node->value) < 0) {
            $node->left = $this->insert($node->left, $value);
        } else {
            $node->right = $this->insert($node->right, $value);
        }
        return $node;
    }

    
    public function inorder(): array {
        $result = [];
        $this->traverse($this->root, $result);
        return $result;
    }

    private function traverse(?TreeNode $node, array &$list): void {
        if (!$node) return;
        $this->traverse($node->left, $list);
        $list[] = $node->value;
        $this->traverse($node->right, $list);
    }

 
    public function find(string $value): bool {
        return $this->search($this->root, $value);
    }

    private function search(?TreeNode $node, string $value): bool {
        if (!$node) return false;

        $cmp = strcasecmp($value, $node->value);
        if ($cmp === 0) return true;
        return $cmp < 0
            ? $this->search($node->left, $value)
            : $this->search($node->right, $value);
    }
}


if (php_sapi_name() === 'cli') {
    $tree = new BST();
    $books = ["Moby Dick", "The Hobbit", "Pride and Prejudice", "Dracula", "1984"];

    foreach ($books as $book) {
        $tree->add($book);
    }

    echo "Inorder Traversal:\n";
    print_r($tree->inorder());

    echo "\n🔍 Searching for 'Dracula': ";
    echo $tree->find('Dracula') ? "Found\n" : "Not Found\n";
}
?>