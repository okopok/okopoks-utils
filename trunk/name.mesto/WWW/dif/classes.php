<?


class Cart {
    var $items;  // Количество вещей в корзине покупателя
  
    // Добавить $num наименований типа $artnr в корзину

    function add_item ($artnr, $num) {
        $this->items[$artnr] += $num;
    }
  
    // Убрать $num наименований  $artnr из корзины

    function remove_item ($artnr, $num) {
        if ($this->items[$artnr] > $num) {
            $this->items[$artnr] -= $num;
            return true;
        } else {
            return false;
        }   
    }
}
$cart = new Cart;
$cart->add_item("10", 1);

class Named_Cart extends Cart {
    var $owner;
 
    function set_owner ($name) {
        $this->owner = $name;
    }
}
$ncart = new Named_Cart;    // Создать корзину
$ncart->set_owner ("kris"); // Указать владельца
print $ncart->owner;        // Распечатать имя владельца корзины
$ncart->add_item ("10", 1); // (унаследовано из обычной корзины)


class Auto_Cart extends Cart {
    function Auto_Cart () {
        $this->add_item ("10", 1);
    }
}
/*
Мы определили класс Auto_Cart который является тем же классом Cart плюс имеет конструктор, который инициализирует корзину при создании, наполняя еЈ одним товаром типа "10".
*/

class Constructor_Cart {
    function Constructor_Cart ($item = "10", $num = 1) {
        $this->add_item ($item, $num);
    }
}

// Покупаем вся одно и то же :


$default_cart   = new Constructor_Cart;

// А тут что-то новое :

$different_cart = new Constructor_Cart ("20", 17);



class Webpage { 
var $bgcolor;
function Webpage($color) {
$this->bgcolor = $color;
}
}
// Вызвать конструктор класса Webpage
$page = new Webpage("brown");
echo "<table $page><tr><td>1</td></tr></table>";
?>