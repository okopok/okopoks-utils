<?


class Cart {
    var $items;  // ���������� ����� � ������� ����������
  
    // �������� $num ������������ ���� $artnr � �������

    function add_item ($artnr, $num) {
        $this->items[$artnr] += $num;
    }
  
    // ������ $num ������������  $artnr �� �������

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
$ncart = new Named_Cart;    // ������� �������
$ncart->set_owner ("kris"); // ������� ���������
print $ncart->owner;        // ����������� ��� ��������� �������
$ncart->add_item ("10", 1); // (������������ �� ������� �������)


class Auto_Cart extends Cart {
    function Auto_Cart () {
        $this->add_item ("10", 1);
    }
}
/*
�� ���������� ����� Auto_Cart ������� �������� ��� �� ������� Cart ���� ����� �����������, ������� �������������� ������� ��� ��������, �������� � ����� ������� ���� "10".
*/

class Constructor_Cart {
    function Constructor_Cart ($item = "10", $num = 1) {
        $this->add_item ($item, $num);
    }
}

// �������� ��� ���� � �� �� :


$default_cart   = new Constructor_Cart;

// � ��� ���-�� ����� :

$different_cart = new Constructor_Cart ("20", 17);



class Webpage { 
var $bgcolor;
function Webpage($color) {
$this->bgcolor = $color;
}
}
// ������� ����������� ������ Webpage
$page = new Webpage("brown");
echo "<table $page><tr><td>1</td></tr></table>";
?>