<?php
namespace models;

use Ubiquity\attributes\items\Id;
use Ubiquity\attributes\items\Column;
use Ubiquity\attributes\items\Validator;
use Ubiquity\attributes\items\Table;
use Ubiquity\attributes\items\OneToMany;
use Ubiquity\attributes\items\ManyToOne;
use Ubiquity\attributes\items\JoinColumn;

#[Table(name: "command")]
class Command{
	
	#[Id()]
	#[Column(name: "id",dbType: "int(11)")]
	#[Validator(type: "id",constraints: ["autoinc"=>true])]
	private $id;

	
	#[Column(name: "dateCreation",dbType: "timestamp")]
	#[Validator(type: "notNull",constraints: [])]
	private $dateCreation;

	
	#[Column(name: "status",dbType: "varchar(100)")]
	#[Validator(type: "length",constraints: ["max"=>100,"notNull"=>true])]
	private $status;

	
	#[Column(name: "amount",dbType: "decimal(6,2)")]
	#[Validator(type: "notNull",constraints: [])]
	private $amount;

	
	#[Column(name: "toPay",dbType: "decimal(6,2)")]
	#[Validator(type: "notNull",constraints: [])]
	private $toPay;

	
	#[Column(name: "itemsNumber",dbType: "int(11)")]
	#[Validator(type: "notNull",constraints: [])]
	private $itemsNumber;

	
	#[Column(name: "missingNumber",dbType: "int(11)")]
	#[Validator(type: "notNull",constraints: [])]
	private $missingNumber;

	
	#[OneToMany(mappedBy: "command",className: "models\\Commanddetail")]
	private $commanddetails;

	
	#[ManyToOne()]
	#[JoinColumn(className: "models\\Employee",name: "idEmployee",nullable: true)]
	private $employee;

	
	#[ManyToOne()]
	#[JoinColumn(className: "models\\Timeslot",name: "idTimeslot",nullable: true)]
	private $timeslot;

	
	#[ManyToOne()]
	#[JoinColumn(className: "models\\User",name: "idUser")]
	private $user;

	 public function __construct(){
		$this->commanddetails = [];
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id=$id;
	}

	public function getDateCreation(){
		return $this->dateCreation;
	}

	public function setDateCreation($dateCreation){
		$this->dateCreation=$dateCreation;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setStatus($status){
		$this->status=$status;
	}

	public function getAmount(){
		return $this->amount;
	}

	public function setAmount($amount){
		$this->amount=$amount;
	}

	public function getToPay(){
		return $this->toPay;
	}

	public function setToPay($toPay){
		$this->toPay=$toPay;
	}

	public function getItemsNumber(){
		return $this->itemsNumber;
	}

	public function setItemsNumber($itemsNumber){
		$this->itemsNumber=$itemsNumber;
	}

	public function getMissingNumber(){
		return $this->missingNumber;
	}

	public function setMissingNumber($missingNumber){
		$this->missingNumber=$missingNumber;
	}

	public function getCommanddetails(){
		return $this->commanddetails;
	}

	public function setCommanddetails($commanddetails){
		$this->commanddetails=$commanddetails;
	}

	 public function addToCommanddetails($commanddetail){
		$this->commanddetails[]=$commanddetail;
		$commanddetail->setCommand($this);
	}

	public function getEmployee(){
		return $this->employee;
	}

	public function setEmployee($employee){
		$this->employee=$employee;
	}

	public function getTimeslot(){
		return $this->timeslot;
	}

	public function setTimeslot($timeslot){
		$this->timeslot=$timeslot;
	}

	public function getUser(){
		return $this->user;
	}

	public function setUser($user){
		$this->user=$user;
	}

	 public function __toString(){
		return ($this->missingNumber??'no value').'';
	}


}