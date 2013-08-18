<?php

class City
{

    const NORMAL_FOOT_RATE  = 1000;
    const CAPITAL_FOOT_RATE = 10000;
    const PLAYER_ID         = 1;
    const INIT_TAX          = 0.2;
    const SOME_FACTOR       = 1000;

    private $_db         = null;
    private $_attributes = null;

    public function __construct($city_id = NULL) {
        $this->_db = require('pdo.php');

        if(is_null($city_id)){
            //check if player have cities, return first
            $cities = $this->_db->query("SELECT * FROM CITIES WHERE PLAYER_ID = ".self::PLAYER_ID);
            if($cities->rowCount() > 0){
                $this->_attributes = $cities->fetch();
                return;
            }
            $this->_attributes = $this->_new_city(self::PLAYER_ID);

        }else{ //初始化一个已经存在的city
            $city_id = intval($city_id);
            $q = $this->_db->prepare("SELECT * FROM CITIES WHERE ID = ?");
            $q->execute(array($city_id));
            $r = $q->fetch();
            $this->_attributes = $r === FALSE ? NULL : $r;
        }
    }
    public function attributes(){
        return $this->_attributes;
    }


    //create a new city in current city
    public function create_city($x, $y){

        $attr = $this->_attributes;
        //check if this area has city
        $q = $this->_db->prepare("SELECT * FROM AREAS WHERE parent_city_id = ? and x = ? and y = ?");
        $q->execute(array($attr['id'], $x, $y));
        if($q->rowCount() > 0){
            return "this area is occupied";
        }

        $new_city_attr = $this->_new_city($attr['player_id']);
        $sql = "INSERT INTO AREAS (parent_city_id, x, y, city_id) VALUES (?, ?, ?, ?)";
        $this->_db->prepare($sql)->execute(
            array(
                $attr['id'],
                $x,
                $y,
                $new_city_attr['id'],
            )
        );
        return new City($new_city_attr['id']);
    }

    public function status(){
        //取出状态前先更新数据
        $sql = $this->_db->query("SELECT * FROM CITIES WHERE id = ". $this->_attributes['id']);
        $attr =  $sql->fetch();
        $food_rate = $attr['is_capital'] == 0 ? self::NORMAL_FOOT_RATE : self::CAPITAL_FOOT_RATE;
        $food_time = time() - $attr['last_food_checked_out_at'];
        $food_inscrease = $food_time / 3600 * $food_rate;
        if($attr['population'] < self::SOME_FACTOR * $attr['tax']){
            $population_increase = 1.05;
        }else{
            $population_increase = 0.95;
        }
        $this->_db->prepare("UPDATE CITIES SET population = population * ?, food = food + ?")->execute(array($population_increase, $food_inscrease));
        $this->_attributes['population'] *= $population_increase;
        $this->_attributes['food'] += $food_inscrease;
        return $this->_attributes;
    }

    private function _new_city($player_id, $tax = self::INIT_TAX){
        //player not have a city, create one
        $q = $this->_db->prepare("INSERT INTO CITIES (player_id, tax, created_at, last_food_checked_out_at, last_gold_checked_out_at) VALUES (?, ?, ?, ?, ?)");
        $current_time = time();
        $r = $q->execute(
            array(
                $player_id,
                $tax,
                $current_time,
                $current_time,
                $current_time,
            )
        );
        return $this->_db->query("SELECT * FROM CITIES WHERE ID = ". $this->_db->lastInsertId())->fetch();
    }

    public function change_tax($tax){
        $this->_db->prepare("UPDATE cities SET tax = ? WHERE ID = ?")->execute(array($tax, $this->_attributes['id']));
        $this->_attributes['tax'] = $tax;
    }

    public function set_capital(){
        //if current city is capital, return;
        if($this->_attributes['is_capital'] == 1){
            return;
        }
        //set current capital to normal city
        $this->_db->prepare("UPDAE CITIES SET is_capital = 0 WHERE player_id = ? and is_capital = 1")->execute(array(self::PLAYER_ID));

        //set current city to capital
        $this->_db->prepare("UPDATE CITIES SET is_capital = 1 WHERE id = ?")->execute(array($this->_attributes['id']));
        $this->_attributes['is_capital'] = 1;
    }
}

