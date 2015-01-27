<?php

class CatalogModel extends Model {
    public function save($v=null){
        $fields = array_keys($v);
        $values = array_values($v);
        $s = $this->db->prepare("INSERT INTO `models` SET ".$this->pdoSet($fields,$values,$v));
        $s->execute($values);
    }
    public function all($p=0){
        $n=new Navigator('',5,'',$p);
        $s = $this->db->prepare("SELECT SQL_CALC_FOUND_ROWS *,(SELECT GROUP_CONCAT(' ',`name`) FROM `colors` WHERE FIND_IN_SET(`id`,`models`.`colors`)) AS `colors_names` FROM `models` LIMIT {$n->start()}, $n->pnumber ");
        $s->execute();
        $all = $this->db->query("SELECT FOUND_ROWS()")->fetchColumn();
        return array($s->fetchAll(),$n->navi($all));
    }

    public function one($id=null){
        $s = $this->db->prepare("SELECT *,(SELECT GROUP_CONCAT(' ',`name`) FROM `colors` WHERE FIND_IN_SET(`id`,`models`.`colors`)) AS `colors_names` FROM `models` WHERE `id` = ?");
        $s->execute(array($id));
        return $s->fetch();
    }

    public function next_id(){
        $s = $this->db->prepare('SELECT * FROM `models` ORDER BY `id` DESC LIMIT 1');
        $s->execute();
        return $s->fetchColumn()+1;
    }
}