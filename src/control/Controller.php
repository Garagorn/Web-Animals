<?php
class Controller{
    private $view;

    private array $animalsTab = array(
        'medor' => array('Médor', 'chien'),
        'felix' => array('Félix', 'chat'),
        'denver' => array('Denver', 'dinosaure'),
    );

    public function __construct(View $vue){
        $this->view = $vue;
    }

    public function showInformation(String $id):void{
        if(array_key_exists($id,$this->animalsTab)){
            [$name,$species]= $this->animalsTab[$id];
            $this->view->prepareAnimalPage($name,$species);
        }
        else{
            $this->view->prepareUnknownAnimalPage();
        }
    }

}
?>
