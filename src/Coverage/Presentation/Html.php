<?php
/**
 * PHPUnit Coverage Styles - [file description]
 * @author adrian7
 * @version 1.0
 */

namespace DevLib\Candybar\Coverage\Presentation;

use DevLib\Candybar\Util;
use DevLib\Candybar\Exceptions\UnsupportedFeatureException;

class Html implements PresentationInterface {

    /**
     * Default styles dir
     */
    const STYLES_DIR = 'styles';

    /**
     * PHPUnit's default style file
     */
    const MAIN_CSS_FILE = 'style.css';

    /**
     * Base dir of the html presentation
     * @var null|string
     */
    protected $base = NULL;

    /**
     * Base dir of css files, usually {base}/.css
     * @var null|string
     */
    protected $cssBase = NULL;

    /**
     * Base dir of javascript files; usually {base}/.js
     * @var null|string
     */
    protected $jsBase = NULL;

    /**
     * Presentation index file - index.html
     * @var null|string
     */
    protected $index = NULL;

    /**
     * Html constructor.
     *
     * @param $path
     */
    public function __construct($path) {

        if( is_file($path) and ( 'index.html' == basename($path) ) )
            $this->base = dirname($path);
        else
            $this->base = rtrim($path, DIRECTORY_SEPARATOR);

        if( $this->base = realpath($this->base) );
        else
            throw new \InvalidArgumentException(
                "Cannot resolve base path as {$path} ... ."
            );

        $this->index    = ( $this->base . DIRECTORY_SEPARATOR . 'index.html' );
        $this->cssBase  = ( $this->base . DIRECTORY_SEPARATOR .'.css' );
        $this->jsBase   = ( $this->base . DIRECTORY_SEPARATOR .'.js' );

        if( ! is_file($this->index) )
            throw new \InvalidArgumentException(
                "Can't find presentation index.html at {$path}... ."
            );

        if( $css = $this->getCssPath(self::MAIN_CSS_FILE) );
        else
            throw new \InvalidArgumentException(
                sprintf(
                    "Can't find presentation style path at %s... .",
                    ($this->cssBase . DIRECTORY_SEPARATOR . self::MAIN_CSS_FILE)
                )
            );

    }

    /**
     * Retrieve path of the index file
     * @return null|string
     */
    public function getIndexPath(){
        return $this->index;
    }

    /**
     * Retrieve path of a css file or css base dir if no file is specified
     * @param string $file
     *
     * @return null|string
     */
    public function getCssPath($file='style.css'){

        return $file ?
            (
                $this->cssBase .
                DIRECTORY_SEPARATOR .
                trim($file, DIRECTORY_SEPARATOR)
            ) :
            $this->cssBase;

    }

    /**
     * Retrieve javascript file path, or javascript base path if no file is specified
     *
     * @param $file
     *
     * @return null|string
     */
    public function getJsPath($file=DIRECTORY_SEPARATOR){

        return $file ?
            (
                $this->jsBase .
                DIRECTORY_SEPARATOR .
                trim($file, DIRECTORY_SEPARATOR)
            ) :
            $this->jsBase;

    }

    /**
     * Set desired style
     *
     * @param $name
     *
     * @return bool
     */
    public function setStyle($name){

        if( $name = Util::lookupFile($name, 'css', self::STYLES_DIR) )
            //Style found, replace default styling
            return
                copy($name, $this->getCssPath( self::MAIN_CSS_FILE ) );

        //Can't find or can't copy the file
        throw new \InvalidArgumentException("Can't read style file for {$name}... .");

    }

    /**
     * @param string $source
     *
     * @throws UnsupportedFeatureException
     */
    public function createStyle($source='default'){
        throw new UnsupportedFeatureException("Feature not supported... .");
    }

    /**
     * @param $contents
     *
     * @throws UnsupportedFeatureException
     */
    public function addJsScript($contents){
        throw new UnsupportedFeatureException("Feature not supported... .");
    }

    /**
     * @param $name
     *
     * @throws UnsupportedFeatureException
     */
    public function setTheme($name){
        throw new UnsupportedFeatureException("Feature not supported... .");
    }

    /**
     * @param string $source
     *
     * @throws UnsupportedFeatureException
     */
    public function createTheme($source='default'){
        throw new UnsupportedFeatureException("Feature not supported... .");
    }

}