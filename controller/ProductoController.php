<?php

class ProductoController
{

    public $page_title;
    public $view;
    private $productoServicio;

    public const PANTALON_COOKIE = "pantalon";
    public const PANTALON_COOKIE_SECONDS = 3600*24;

    public function __construct()
    {
        $this->view = 'producto/list_products';
        $this->page_title = '';
        $this->productoServicio = new ProductoServicio();
    }

    /* List all products */

    public function list()
    {
        $this->page_title = 'Listado de productos';

        return $this->productoServicio->getProductos();
    }





    public function addToCart()
    {
        $prodId = -1;
        $qty = 0;

        if (isset($_POST["prodId"])) {
            $prodId = $_POST["prodId"];
        }

        if (isset($_POST["qty"])) {
            $qty = $_POST["qty"];
        }

        echo "prodId: $prodId";
        echo "qty: $qty";

        if ($prodId != -1 && $qty > 0) {


            SessionManager::iniciarSesion();
            if (isset($_SESSION["carrito"]["prodId"])) {
                $_SESSION["carrito"]["prodId"] += $qty;
            } else {
                $_SESSION["carrito"]["prodId"] = $qty;
            }


            if($prodId == 1){
                if(isset($_COOKIE[self::PANTALON_COOKIE])){
                    $qty +=$_COOKIE[self::PANTALON_COOKIE];
                }
              
                    setcookie(self::PANTALON_COOKIE, $qty, time()+ self::PANTALON_COOKIE_SECONDS);
                
            }
        }



        $this->redirectToProductList();
        
    }

    public function clearCart()
    {
        SessionManager::iniciarSesion();
        unset ($_SESSION["carrito"]);
     $this->redirectToProductList();
        
    }

    private function redirectToProductList(){
        header('Location: FrontController.php?controller=Producto&action=list');
        die;
    }

  
}
