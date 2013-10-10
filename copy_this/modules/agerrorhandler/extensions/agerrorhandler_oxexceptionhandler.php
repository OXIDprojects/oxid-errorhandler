<?php

class agerrorhandler_oxexceptionhandler extends agerrorhandler_oxexceptionhandler_parent {

    protected $charset = 'UTF-8';

    //Overriden for our custom rendering of uncaught errors
    protected function _uncaughtException( oxException $oEx )
    {
        // exception occured in function processing
        $oEx->setNotCaught();
        // general log entry for all exceptions here
        $oEx->debugOut();

        if ( defined( 'OXID_PHP_UNIT' ) ) {
            return $oEx->getString();
        } elseif ( 0 != $this->_iDebug ) {
            return $this->_renderException($oEx);
        }

        //simple safe redirect in productive mode
        $sShopUrl = oxConfig::getInstance()->getShopMainUrl();
        $this->_safeShopRedirectAndExit( $sShopUrl . "offline.html" );

        //should not be reached
        return ;
    }
    
    protected function _dealWithNoOxException( Exception $oEx )
    {
        if ( 0 != $this->_iDebug ) {
            $sLogMsg = date( 'Y-m-d H:i:s' ) . $oEx . "\n---------------------------------------------\n";
            oxUtils::getInstance()->writeToLog( $sLogMsg, $this->getLogFileName() );
            if ( defined( 'OXID_PHP_UNIT' ) ) {
                return;
            } elseif ( 0 != $this->_iDebug ) {
               return $this->_renderException($oEx);
            }
        }

        $sShopUrl = oxConfig::getInstance()->getShopMainUrl();
        $this->_safeShopRedirectAndExit( $sShopUrl . "offline.html" );
    }
    
    protected function _renderException( Exception $oEx ){
        
        $oSmarty = oxUtilsView::getInstance()->getSmarty();
        $oSmarty->assign('oViewConf',oxNew('oxViewConfig'));
        $oSmarty->assign('exception',$this->_buildException($oEx));
        echo $oSmarty->fetch('error.tpl');
        exit();
        
    }

    protected function _buildException( Exception $oEx ){

        $e = new stdClass();

        $e->message = $oEx->getMessage();
        $e->class = $this->abbrClass(get_class($oEx));
        $e->code = $oEx->getCode();
        $e->file = $oEx->getFile();
        $e->line = $oEx->getLine();
        $e->trace = $oEx->getTrace();
        $e->text = $oEx->getTraceAsString();

        $trace = $oEx->getTrace();
        $traces = array();

        
        $outLines = array();

        if($e->file){
            $lines = file($e->file);
            $l = $e->line;
            for ($i=$l-4; $i <= $l+2; $i++) { 
                $outLines[$i+1] = str_replace("\t", "    ", $lines[$i]);
            }
        }

        $geshi = oxNew('geshi');

        $geshi->set_language('php');
        $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS );
        $geshi->set_source(implode("",$outLines));
        $geshi->start_line_numbers_at($e->line-3);

        $traces[] = array("lines" => $geshi->parse_code(), "line" => $e->line,  "file" => $this->abbrPath($e->file), "function" => $e->function, "args" => $this->formatArgs($e->args), "class" => $this->abbrType($e->class), "type" => $e->type);
    
        foreach ($trace as $aTrace) {
            
            $outLines = array();

            if($aTrace["file"]){
                $lines = file($aTrace["file"]);
                $l = $aTrace["line"];
                for ($i=$l-4; $i <= $l+2; $i++) { 
                    $outLines[$i+1] = str_replace("\t", "    ", $lines[$i]);
                }
            }

            $geshi->set_source(implode("",$outLines));
            $geshi->start_line_numbers_at($aTrace["line"]-3);

            $traces[] = array("lines" => $geshi->parse_code(), "line" => $aTrace["line"],  "file" => $this->abbrPath($aTrace["file"]), "function" => $aTrace["function"], "args" => $this->formatArgs($aTrace["args"]), "class" => $this->abbrType($aTrace["class"]), "type" => $aTrace["type"]);
        }

        $e->traces = $traces;
        return $e;
    }

    protected function removeBasePath($file){
        return str_replace(getShopBasePath(), '', $file);
    }

    protected function abbrPath($file){
        return sprintf("<abbr title=\"%s\">%s</abbr>", $file, $this->removeBasePath($file));
    }

    protected function abbrClass($class)
    {
        $parts = explode('\\', $class);
        if(count($parts) < 2){
            return $class;
        }else{
            return sprintf("<abbr title=\"%s\">%s</abbr>", $class, array_pop($parts));
        }
        
    }

    protected function abbrType($object){
        $cname = is_object($object) ? get_class($object) : $object;
        $class = new ReflectionClass($cname); 
        return sprintf("<abbr title=\"defined in %s\">%s</abbr>", $this->removeBasePath($class->getFilename()), $class->getName());
    }

    /**
     * Formats an array as a string.
     *
     * @param array $args The argument array
     *
     * @return string
     */
    protected function formatArgs($args)
    {
        if(!$args) return '';
        $result = array();
        foreach ($args as $key => $item) {
            
            $type = gettype($item);
            $class = get_class($item);

            if ('object' === $type) {
                $formattedValue = sprintf("<em>object</em>(%s)", $this->abbrType($item));
            } elseif ('array' === $type) {
                $formattedValue = sprintf("<em>array</em>(%s)", $this->formatArgs($item));
            } elseif ('string'  === $type) {
                $formattedValue = sprintf("'%s'", htmlspecialchars($item, ENT_QUOTES | ENT_SUBSTITUTE, $this->charset));
            } elseif ('null' === $type) {
                $formattedValue = '<em>null</em>';
            } elseif ('boolean' === $type) {
                $formattedValue = '<em>'.strtolower(var_export($item, true)).'</em>';
            } elseif ('resource' === $type) {
                $formattedValue = '<em>resource</em>';
            } else {
                $formattedValue = str_replace("\n", '', var_export(htmlspecialchars((string) $item, ENT_QUOTES | ENT_SUBSTITUTE, $this->charset), true));
            }

            $result[] = is_int($key) ? $formattedValue : sprintf("'%s' => %s", $key, $formattedValue);
        }

        return implode(', ', $result);
    }
    
}