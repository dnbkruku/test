<?php

define('M_HOST','localhost');
define('M_USER','root');
define('M_DB','test');
define('M_PS','');

class Database {
    private $pdo;


    /**
     * @param $db
     * @param $user
     * @param $ps
     * @param $host
     */
    public function __construct($db,$user,$ps,$host){
        $dsn = "mysql:host=".$host.";dbname=".$db.";charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        try {
            $this->pdo = new PDO($dsn, $user, $ps, $opt);
        } catch (PDOException $e) {
            die('DBConnection error: ' . $e->getMessage());
        }
    }

    public function obj(){
        return $this->pdo;
    }
}

abstract class Controller {

    protected $model;
    protected $view;
    protected $cModel = 'models';
    protected $cView = 'views';
    /**
     * @return mixed
     */
    abstract function index();
}

abstract class Model {

    protected $db;

    /**
     *
     */
    public function __construct(){
        $n = new Database(M_DB,M_USER,M_PS,M_HOST);
        $this->db = $n->obj();
    }

    /**
     * @return mixed
     */
    abstract function save();

    /**
     * @return mixed
     */
    abstract function all();

    /**
     * @return mixed
     */
    abstract function one();

    public function pdoSet($fields, &$values, $source = array()) {
        $set = '';
        $values = array();
        if (!$source) $source = &$_POST;
        foreach ($fields as $field) {
            if (isset($source[$field])) {
                $set.="`".str_replace("`","``",$field)."`". "=:$field, ";
                $values[$field] = $source[$field];
            }
        }
        return substr($set, 0, -2);
    }
}

abstract class View {

    private $dir = 'templates';
    private $default = 'index';
    protected $view = '';
    protected $vars = array();

    /**
     * @param string $view
     */
    public function __construct($view = ''){
        if($view !== ''){
            $view = $this->dir.'/'.$view.'.php';
            if(file_exists($view)){
                $this->view = $view;
            }
        }
        else $this->view = $this->dir.'/'.$this->default.'.php';
    }

    /**
     * @param $p
     * @param $v
     */
    public function __set($p,$v){
        $this->vars[$p] = $v;
    }

    /**
     * @param $p
     * @return bool
     */
    public function __get($p){
        return (isset($this->vars[$p])?$this->vars[$p]:false);
    }

    abstract public function display();
}

class Router {
    private $cPath = 'controllers';

    /**
     * @param $route
     */
    public function __construct($route){
        $action = 'index';
        require_once $this->cPath.'/CatalogController.class.php';
        $controller = new CatalogController();

        if(!empty($route)){
            $p = explode('/', trim($route, '/\\'));
            if(is_numeric($p[0]))
                $param = array('page' => intval($p[0]));
            else{
                $action = $p[0];
                if(!empty($p[1]))
                    $param = array('id' => intval($p[1]));
            }
        }

        if(is_callable(array($controller,$action)) === false)
            die('404');
        $controller->$action((isset($param))?$param:null);
    }
}

class Navigator {

    function __construct($script,$pnumber,$query='',$page) {
        $this->script=$script;

        if (empty($script)) {
            $this->script='/test';
        }

        $this->pnumber=$pnumber;

        $this->query='';
        $this->or_query=$query;

        if (is_array($query)) {
            foreach ($query as $k=>$v) {
                $this->query.='&'.$k.'='.urlencode($v);
            }
        }

        $this->page=isset($page) ? (int)$page : 1;
    }

    function start() {

        $this->start = $this->page * $this->pnumber - $this->pnumber;

        if ($this->page < 1) {
            $this->page=1;
            $this->start=0;
        }

        return $this->start;
    }

    function navi($all,$input=0) {

        $this->all=$all;

        $this->num_pages=ceil($this->all/$this->pnumber);

        if ($this->num_pages > 25) $input=1;

        if ($this->page > $this->num_pages || $this->page < 1) {
            $this->page=1;
            $this->start=0;
        }

        if ($this->num_pages<2)
            return '';

        $buff='<div class="navi">';

        if ($this->page>1)
            $buff.='<a href="'.$this->script.'/'.($this->page-1).$this->query.'"><</a>';
        else
            $buff.='<';

        for($pr = '', $i =1; $i <= $this->num_pages; $i++) {
            $buff.=
            $pr=(($i == 1 || $i == $this->num_pages || abs($i-$this->page) < 2) ? ($i == $this->page ? " [$i] " : ' <a href="'.$this->script.'/'.$i.$this->query.'">'.$i.'</a> ') : (($pr == ' ... ' || $pr == '')? '' : ' ... '));
        }

        if ($this->page<$this->num_pages)
            $buff.='<a href="'.$this->script.'/'.($this->page+1).$this->query.'">></a>';
        else
            $buff.='>';

        $buff.='</div>';

        return $buff;
    }
}