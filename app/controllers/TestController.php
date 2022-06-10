<?php

namespace controllers;

use models\Product;
use Ubiquity\orm\DAO;
use models\Commanddetail;

/**
 * Controller TestController
 */
class TestController extends ControllerBase
{

    public function index()
    {
        $this->loadDefaultView();
    }

    /**
     * @route("Products/{productId}")
     */
    public function ProductsList($IproductId)
    {
        $OProducts = (DAO::getAll(Product::class,'id = ?', ['section'], [$IproductId]));
        $this->loadView('TestController/product.html', ['products' => $OProducts]);
    }

    /**
     * @route("hello/{message}")
     */
    public function hello($message)
    {
        $this->loadView('TestController/hello.html', ['msg' => $message]);
    }

    /**
     * @route("commandDetails/{commandId}")
     */
    public function commandDetails($IcommandId)
    {
        $Ocommands = (DAO::getAll(Commanddetail::class, 'idOrder= ?', ['product.section'], [$IcommandId]));
        $this->loadView('TestController/index.html', ['commands' => $Ocommands]);
    }

    /**
     * @route("/validateCommandeDetail")
     */
    public function validateCommandDetail() {
        $IproductId = $_POST['product'];
        $IcommandId = $_POST['command'];

        $Ocommanddetail = DAO::getOne(Commanddetail::class, 'idOrder = ? AND idProduct = ?', true, [$IcommandId,$IproductId]);
        $Ocommanddetail->setPrepared(True);
        DAO::toUpdate($Ocommanddetail);
        DAO::flushUpdates();
        $this->commandDetails($IcommandId);
    }
}