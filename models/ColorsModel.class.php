<?php
class ColorsModel extends Model {
    public function save(){
    }
    public function all(){
        $s = $this->db->prepare("SELECT * FROM `colors`");
        $s->execute();
        return $s->fetchAll();
    }

    public function one($id=null){
        $s = $this->db->prepare('SELECT * FROM `colors` WHERE `id` = ?');
        $s->execute(array($id));
        return $s->fetch();
    }
}