<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');

class Words extends REST_Controller {
    
    function __construct() {
        parent::__construct();
        // Autoloaded Config, Helpers, Models
        $this->load->model('language');
        $this->load->model('word');
        $this->load->model('translation');
    }

    // Used to create a new group in the DB
    public function index_post() {
        $data = $this->post();
        
        if ( isset($data['word']) ){
            $word    = $data['word']; 
            
            $availability = $this->word->retrieve( 
                array(
                    'tag' => url_title( $word )
                )
            ); 

            if ( count($availability) == 0 ) {                        
                $new_word = array( 
                    'tag'  => url_title( $word ),
                    'word' => $word
                );
            
                $word_id = $this->word->create( $new_word );
                echo $word_id;

            } else {                    
                echo 'Tag already exists.';
            }

        } else {
            echo 'Missing word parameter.';
        }

        return;
    }

    // Used to create a new group in the DB
    public function index_put() {
        $data = $this->put( );
        
        if ( isset($data['word_id']) && isset($data['word']) ){
            $word_id = $data['word_id'];
            $word    = $data['word'];

            $availability = $this->word->retrieve( 
                array(
                    'id' => $word_id
                )
            );

            if ( count($availability) > 0 ) {
                $word_id = $this->word->update( 
                    array(
                        'id' => $word_id
                    ),
                    array(

                        'word' => $word
                    ) 
                );
                echo 'OK';   
            
            } else {
                echo 'Nothing to update.';
            }

        } else {
            echo 'Missing word_id or word parameters.';
        }

        return;
    }
}