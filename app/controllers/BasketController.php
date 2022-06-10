<?php
namespace controllers;

use models\Basketdetail;
use models\Command;
use models\Commanddetail;
use models\Timeslot;
use Ubiquity\orm\DAO;
use models\Basket;
 /**
  * Controller BasketController
  */
class BasketController extends \controllers\ControllerBase{

	public function index(){
		$this->loadDefaultView();
	}

    /**
     * @route("Baskets/{userId}")
     */
    public function Baskets($IuserId)
    {
        $OBaskets = (DAO::getAll(Basket::class,'idUser = ?', false, [$IuserId]));
        $this->loadView('BasketController/index.html', ['baskets' => $OBaskets]);
    }

    /**
     * @route("/BasketDetails/{basketId}")
     */
    public function BasketDetails($IbasketId) {
        $OBasketsDetails = (DAO::getAll(Basketdetail::class,'idBasket = ?', ['product'], [$IbasketId]));
        $this->loadView('BasketController/index.html', ['basketsDetails' => $OBasketsDetails]);
    }

    /**
     * @route("/Timeslots/{basketId}")
     */
    public function Timeslots($IbasketId) {
        $Otimeslots = (DAO::getAll(Timeslot::class,'full = 0 AND expired = 0'));
        $this->loadView('BasketController/index.html', ['timeslots' => $Otimeslots, 'basketId' => $IbasketId]);
    }

    /**
     * @route("/ValidateBasket/{basketId}/{timeslotId}")
     */
    public function ValidateBasket($IbasketId, $ItimeslotId) {
        $ObasketDetails = (DAO::getAll(Basketdetail::class,'idBasket = ?',['basket.user'], [$IbasketId]));
        $Otimeslot = (DAO::getOne(Timeslot::class,'id = ?', false, [$ItimeslotId]));

        $Ocommand = new Command();
        $Obasket = NULL;
        foreach ($ObasketDetails as $ObasketDetail) {
            $Obasket = $ObasketDetail->getBasket();
            break;
        }

        $Ocommand->setUser($Obasket->getUser());
        $Ocommand->setDatecreation(date('Y-m-d'));
        $Ocommand->setStatus('preparation');
        $Ocommand->setAmount(0);
        $Ocommand->setTopay(0);
        $Ocommand->setItemsnumber(0);
        $Ocommand->setMissingnumber(0);
        $Ocommand->setTimeslot($Otimeslot);

        DAO::toInsert($Ocommand);
        DAO::flushInserts();

        foreach ($ObasketDetails as $ObasketDetail) {
            $product = $ObasketDetail->getProduct();
            $quantity = $ObasketDetail->getQuantity();

            $OcommandDetail = new Commanddetail();
            $OcommandDetail->setQuantity($quantity);
            $OcommandDetail->setPrepared(false);
            $OcommandDetail->setProduct($product);
            $OcommandDetail->setCommand($Ocommand);

            DAO::toInsert($OcommandDetail);
            DAO::flushInserts();
        }

        $IuserId = $Obasket->getUser()->getId();
        DAO::toDelete($Obasket);
        DAO::flushDeletes();

        $this->Baskets($IuserId);
    }
}
