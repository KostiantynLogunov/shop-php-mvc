<?php

class Cart
{
    public static function addProduct($id)
    {
        $id = intval($id);

        //Empty array for products in cart
        $productsInCart = [];

        //якщо в корзині уже є фкі небудь товари(вони зберігаються в сесії)
        if (isset($_SESSION['products'])) {
            // То заповнемо наш масив товарами
            $productsInCart = $_SESSION['products'];
        }

        //якщо в корзині уже є товар, але мии добавили його знову-збільшуємо кількість
        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] ++;
        } else {
            //додаємо новий товaр в корзину
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;
        //отладка
//        echo '<pre>'; print_r($_SESSION['products']); die();
        return self::countItems();
    }

    /**
     * підраховує кількість товарів в корзині (в сесії)
     * @return int
     */
    public static function countItems()
    {
        if (isset($_SESSION['products'])) {
            $count = 0;
            foreach ($_SESSION['products'] as $id=>$quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();

        if ($productsInCart) {
            $total = 0;
            foreach ($products as $item) {
                $total +=$item['price'] * $productsInCart[$item['id']];
            }
        }
        return $total;
    }

    public static function clear(){
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

    public static function deleteProductById($id)
    {
        $id = intval($id);

        if (isset($_SESSION['products']))
        {
            $productsInCart = $_SESSION['products'];

            if (array_key_exists($id, $productsInCart)) {
                if ($productsInCart[$id] > 1) {
                    $productsInCart[$id] --;
                } else {
                    unset($productsInCart[$id]);
                }
            }
            $_SESSION['products'] = $productsInCart;
        }
    }


}

/**
 * Created by PhpStorm.
 * User: Kostiantyn
 * Date: 31.01.2018
 * Time: 12:32
 */