<?php
namespace models;

use Ubiquity\attributes\items\Id;
use Ubiquity\attributes\items\Column;
use Ubiquity\attributes\items\Validator;
use Ubiquity\attributes\items\Transformer;
use Ubiquity\attributes\items\Table;
use Ubiquity\attributes\items\OneToMany;

#[Table(name: "timeslot")]
class Timeslot{
	
	#[Id()]
	#[Column(name: "id",dbType: "int(11)")]
	#[Validator(type: "id",constraints: ["autoinc"=>true])]
	private $id;

	
	#[Column(name: "slotDate",dbType: "datetime")]
	#[Validator(type: "type",constraints: ["ref"=>"dateTime","notNull"=>true])]
	#[Transformer(name: "datetime")]
	private $slotDate;

	
	#[Column(name: "full",dbType: "tinyint(1)")]
	#[Validator(type: "isBool",constraints: ["notNull"=>true])]
	private $full;

	
	#[Column(name: "expired",dbType: "tinyint(1)")]
	#[Validator(type: "isBool",constraints: ["notNull"=>true])]
	private $expired;

	
	#[OneToMany(mappedBy: "timeslot",className: "models\\Command")]
	private $commands;

	 public function __construct(){
		$this->commands = [];
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id=$id;
	}

	public function getSlotDate(){
		return $this->slotDate;
	}

	public function setSlotDate($slotDate){
		$this->slotDate=$slotDate;
	}

	public function getFull(){
		return $this->full;
	}

	public function setFull($full){
		$this->full=$full;
	}

	public function getExpired(){
		return $this->expired;
	}

	public function setExpired($expired){
		$this->expired=$expired;
	}

	public function getCommands(){
		return $this->commands;
	}

	public function setCommands($commands){
		$this->commands=$commands;
	}

	 public function addToCommands($command){
		$this->commands[]=$command;
		$command->setTimeslot($this);
	}

	 public function __toString(){
		return ($this->expired??'no value').'';
	}


}