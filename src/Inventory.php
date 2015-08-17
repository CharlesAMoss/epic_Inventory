<?php
    class Inventory
    {
        private $item;
        private $id;

        function __construct($item, $id = null)
        {
            $this->item = $item;
            $this->id = $id;
        }

        function setItem($new_item)
        {
            $this->item = (string) $new_item;
        }

        function getItem()
        {
            return $this->item;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO items (name) VALUES ('{$this->getItem()}')");
            $this->id= $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_inventory = $GLOBALS['DB']->query("SELECT * FROM items;");
            $inventory_array = array();
            foreach($returned_inventory as $inventory_item) {
                $name = $inventory_item['name'];
                $id = $inventory_item['id'];
                $new_inventory = new Inventory($name, $id);
                array_push($inventory_array, $new_inventory);
            }
            return $inventory_array;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM items;");
        }

        static function find($search_id)
        {
            $found_inventory = null;
            $inventory_array = Inventory::getAll();
            foreach($inventory_array as $inventory_item) {
                $inventory_id = $inventory_item->getId();
                if ($inventory_id == $search_id) {
                  $found_inventory = $inventory_item;
                }
            }
            return $found_inventory;
        }
    }
?>
