<?php

class CatalogView extends View {

    public function display(){
        extract($this->vars);
        require_once($this->view);
    }
}