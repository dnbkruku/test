<?php
class CatalogController extends Controller {

    /**
     *
     */
    public function __construct(){
        require_once $this->cModel.'/CatalogModel.class.php';
        $this->model = new CatalogModel();
        require_once $this->cView.'/CatalogView.class.php';
    }

    public function index($params = null){
        $data= $this->model->all((isset($params['page'])?$params['page']:null));
        $this->view = new CatalogView('index');
        $this->view->data = $data[0];
        $this->view->navi = $data[1];
        $this->view->display();
    }

    public function view($params = null){
        $data= $this->model->one((isset($params['id'])?$params['id']:null));
        $this->view = new CatalogView('view');
        $this->view->data = $data;
        $this->view->display();
    }

    public function add(){
        require_once $this->cModel.'/ColorsModel.class.php';
        $this->model = new ColorsModel();
        $data= $this->model->all();
        $this->view = new CatalogView('add');
        $this->view->data = $data;
        $this->view->display();
    }

    public function submit(){
        if(isset($_POST)){
            $errors = array();
            $shit = array();
            if(empty($_POST['vendor']))
                $errors[] = 'vendor';
            if(empty($_POST['model']))
                $errors[] = 'model';
            if(empty($_POST['price']))
                $errors[] = 'price';
            if(empty($_POST['type']))
                $errors[] = 'type';
            if(empty($_POST['colors']))
                $errors[] = 'colors';
            if(empty($_POST['description']))
                $errors[] = 'description';
            if(empty($_FILES['img']))
                $errors[] = 'img';
            $shit['vendor'] = filter_var($_POST['vendor'],FILTER_SANITIZE_STRING);
            $shit['model'] = filter_var($_POST['model'],FILTER_SANITIZE_STRING);
            $shit['price'] = filter_var($_POST['price'],FILTER_VALIDATE_INT);
            $shit['type'] = filter_var($_POST['type'],FILTER_SANITIZE_STRING);
            $shit['description'] = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
            $shit['colors'] = ',';
            foreach($_POST['colors'] as $k=>$v){
                if($v == 'on')
                    $shit['colors'].= $k.',';
            }
            if(count($errors)>0)
                exit(header('Location: /test/add/?error'));
            else{
                $id = $this->model->next_id();
                $this->model->save($shit);
                require_once 'classes/simpleimage/SimpleImage.php';
                $img = new SimpleImage($_FILES['img']['tmp_name']);
                $img->best_fit(400, 200)->save('images/'.$id.'_big.jpg');
                $img->best_fit(100, 50)->save('images/'.$id.'_mini.jpg');
                exit(header('Location: /test/add/?success'));
            }
        }
        else{
            exit(header('Location: /test/add/?error'));
        }
    }
}