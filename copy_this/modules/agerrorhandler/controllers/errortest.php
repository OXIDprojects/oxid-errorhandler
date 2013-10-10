<?php

class errortest extends oxUBase{
    
    public function render(){
        
        throw new Exception('An error happened!', '100');
        
    }
    
}