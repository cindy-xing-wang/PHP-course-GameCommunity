<?php
declare(strict_types = 1);
//Load the model and the view
class Controller {
  private ISession $_session;
  public function __construct(ISession $session) {
      $this->_session = $session;
  }
  public function model($model) {
    //Require model file
    require_once 'models/' . $model . '.php';
    return new $model();
  }

  //Loda the view (checks for the file)
  public function view($view, $data = []){
    if (file_exists( $view . '.php')) {
      require_once  $view . '.php';
    } else {
      die("View does not exists.");
    }
  }
}
