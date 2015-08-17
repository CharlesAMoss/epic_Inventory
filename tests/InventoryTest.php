<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Inventory.php";

    $server = 'mysql:host=localhost;dbname=inventories_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class InventoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Inventory::deleteAll();
        }

        function test_getItem()
        {
            //Arrange
            $item = 'action figure';
            $test_Inventory = new Inventory($item);

            //Act
            $result = $test_Inventory->getItem();

            //Assert
            $this->assertEquals($item, $result);
        }

        function test_getId()
        {
            //Arrange
            $item = 'action figure';
            $id = 1;
            $test_Inventory = new Inventory($item, $id);

            //Act
            $result = $test_Inventory->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $item = 'action figure';
            $test_inventory = new Inventory($item);
            $test_inventory->save();

            //Act
            $result = Inventory::getAll();

            //Assert
            $this->assertEquals($test_inventory, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $item = 'action figure';
            $item2 = 'stuffed animal';
            $test_Inventory = new Inventory($item);
            $test_Inventory->save();
            $test_Inventory2 = new Inventory($item2);
            $test_Inventory2->save();

            //Act
            $result = Inventory::getAll();

            //Assert
            $this->assertEquals([$test_Inventory, $test_Inventory2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $item = 'action figure';
            $item2 = 'stuffed animal';
            $test_Inventory = new Inventory($item);
            $test_Inventory->save();
            $test_Inventory2 = new Inventory($item2);
            $test_Inventory2->save();

            //Act
            Inventory::deleteAll();
            $result = Inventory::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $item = 'action figure';
            $item2 = 'stuffed animal';
            $test_Inventory = new Inventory($item);
            $test_Inventory->save();
            $test_Inventory2 = new Inventory($item2);
            $test_Inventory2->save();

            //Act
            $result = Inventory::find($test_Inventory->getId());

            //Assert
            $this->assertEquals($test_Inventory, $result);
        }
    }
?>
