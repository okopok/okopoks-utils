<!doctype html public "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
  <title>Untitled web-page</title>
</head>
<body>
<?
    /* shoppingcart.php
     *
     *
     */
        $session = md5(uniqid(rand()));
    if(!$session && !$scid) {
        $session = md5(uniqid(rand()));
        SetCookie("scid", "$session", time() + 14400);
    } /* last number is expiration time in seconds, 14400 sec = 4 hrs */

    class Cart {
        function check_item($table, $session, $product) {
            $query = "SELECT * FROM $table WHERE session='$session' AND product='$product' ";
            $result = mysql_query($query);

            if(!$result) {
                return 0;
            }

            $numRows = mysql_num_rows($result);

            if($numRows == 0) {
                return 0;
            } else {
                $row = mysql_fetch_object($result);
                return $row->quantity;
            }
        }

        function add_item($table, $session, $product, $quantity) {
            $qty = $this->check_item($table, $session, $product);
            if($qty == 0) {
                $query = "INSERT INTO $table (session, product, quantity) VALUES ";
                $query .= "('$session', '$product', '$quantity') ";
                mysql_query($query);
            } else {
                $quantity += $qty;
                $query = "UPDATE $table SET quantity='$quantity' WHERE session='$session' AND ";
                $query .= "product='$product' ";
                mysql_query($query);
            }
        }

        function delete_item($table, $session, $product) {
            $query = "DELETE FROM $table WHERE session='$session' AND product='$product' ";
            mysql_query($query);
        }

        function modify_quantity($table, $session, $product, $quantity) {
            $query = "UPDATE $table SET quantity='$quantity' WHERE session='$session' ";
            $query .= "AND product='$product' ";
            mysql_query($query);
        }

        function clear_cart($table, $session) {
            $query = "DELETE FROM $table WHERE session='$session' ";
            mysql_query($query);
        }

        function cart_total($table, $session) {
            $query = "SELECT * FROM $table";
            $result = mysql_query($query);
            if(mysql_num_rows($result) > 0) {
                while($row = mysql_fetch_object($result)) {
                    $query = "SELECT price FROM inventory";
                    $invResult = mysql_query($query);
                    $row_price = mysql_fetch_object($invResult);
                    $total += ($row_price->price * $row->quantity);
                }
            }
            return $total;
        }

        function display_contents($session) {
            $count = 0;
            $query = "SELECT * FROM inventory ORDER BY id ";
            $result = mysql_query($query);
            while($row = mysql_fetch_object($result)) {
                $query = "SELECT * FROM inventory WHERE product='$row->product' ";
                $result_inv = mysql_query($query);
                $row_inventory = mysql_fetch_object($result_inv);
                $contents["product"][$count] = $row_inventory->product;
                $contents["price"][$count] = $row_inventory->price;
                $contents["quantity"][$count] = $row->quantity;
                $contents["total"][$count] = ($row_inventory->price * $row->quantity);
                $contents["description"][$count] = $row_inventory->description;
                $count++;
            }
            $total = $this->cart_total("", $session);
            $contents["final"] = $total;
            return $contents;
        }

        function num_items($table, $session) {
            $query = "SELECT * FROM $table WHERE session='$session' ";
            $result = mysql_query($query);
            $num_rows = mysql_num_rows($result);
            return $num_rows;
        }

        function quant_items($table, $session) {
            $quant = 0;
            $query = "SELECT * FROM $table WHERE session='$session' ";
            $result = mysql_query($query);
            while($row = mysql_fetch_object($result)) {
                $quant += $row->quantity;
            }
            return $quant;
        }
    }

/*
   This part contains a description of how to create the tables on your mysql server.

# MySQL dump 6.0
#
# Host: localhost    Database: kmartShopper
#--------------------------------------------------------
# Server version    3.22.25

#
# Table structure for table 'inventory'
#
CREATE TABLE inventory (
  product tinytext NOT NULL,
  quantity tinytext NOT NULL,
  id int(4) DEFAULT '0' NOT NULL auto_increment,
  description tinytext NOT NULL,
  price float(10,2) DEFAULT '0.00' NOT NULL,
  category char(1) DEFAULT '' NOT NULL,
  KEY id (id),
  PRIMARY KEY (id),
  KEY price (price)
);

#
# Table structure for table 'shopping'
#
CREATE TABLE shopping (
  session tinytext NOT NULL,
  product tinytext NOT NULL,
  quantity tinytext NOT NULL,
  card tinytext NOT NULL,
  id int(4) DEFAULT '0' NOT NULL auto_increment,
  KEY id (id),
  PRIMARY KEY (id)
);
*/

#Example

    $cart = new Cart;
@mysql_connect("localhost", "root", "");
@mysql_select_db("gbook");
@mysql_query("CREATE TABLE inventory (
  product tinytext NOT NULL,
  quantity tinytext NOT NULL,
  id int(4) DEFAULT '0' NOT NULL auto_increment,
  description tinytext NOT NULL,
  price float(10,2) DEFAULT '0.00' NOT NULL,
  category char(1) DEFAULT '' NOT NULL,
  KEY id (id),
  PRIMARY KEY (id),
  KEY price (price)
)");
@mysql_query("CREATE TABLE shopping (
  session tinytext NOT NULL,
  product tinytext NOT NULL,
  quantity tinytext NOT NULL,
  card tinytext NOT NULL,
  id int(4) DEFAULT '0' NOT NULL auto_increment,
  KEY id (id),
  PRIMARY KEY (id)
)");
 /* heh, use whatever database name you put the 2 tables under in place of kmartShopper */
$table="inventory";
$cart->display_contents($table, $session);

?>
/* call functions like $cart->add_item and such, see the code.  */
</body>
</html>
