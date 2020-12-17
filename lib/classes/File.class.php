<?php

/**
 * File wrapper class
 * 
 */

class File
{
    /**
     * @var string the temporary file name
     * @access protected
     */
    var $_name = null;

    /**
     * @var string the content
     * @access protected
     */
    var $_content = null;

    /**
     * @var string the error message
     * @access protected
     */
    var $_error_message = '';

    /**
     * @var bool whether the file is temporary or not
     * @access protected
     */
    var $_is_temp = false;

    /**
     * @var string charset of file
     */
    var $_charset = null;
    
    /**
     * @var string extension of file
     */
    var $_extension = null;
    
    /**
     * @var string directory of the file
     */
    var $_dirname = null;
    
    /**
     * @var string basename of file
     */
    var $_basename = null;
    
    /**
     * @var string name of the file whitout extension
     */
    var $_filename = null;
    
    /**
     * @var string type of the file
     */
    var $_filetype = null;
    
    /**
     * @var string 
     */
    var $modified_date = null;
    
    
    const MODE_APPEND = 'a+';
    const MODE_READ = 'r';
    const MODE_WRITE = 'w+';

    /**
     * constructor
     *
     * @param boolean|string $name file name or false
     *
     * @access public
     */
    public function __construct($name = false)
    {
        if ($name) {
            $this->setName($name);
        }
    }

    /**
     * destructor
     *
     * @see     File::cleanUp()
     * @access  public
     */
    public function __destruct()
    {
        $this->cleanUp();
    }

    /**
     * deletes file if it is temporary, usually from a moved upload file
     *
     * @access  public
     * @return boolean success
     */
    public function cleanUp()
    {
        if ($this->isTemp()) {
            return $this->delete();
        }

        return true;
    }

    /**
     * deletes the file
     *
     * @access  public
     * @return boolean success
     */
    public function delete()
    {
        return unlink($this->getName());
    }

    /**
     * checks or sets the temp flag for this file
     * file objects with temp flags are deleted with object destruction
     *
     * @param boolean $is_temp sets the temp flag
     *
     * @return boolean File::$_is_temp
     * @access  public
     */
    public function isTemp($is_temp = null)
    {
        if (null !== $is_temp) {
            $this->_is_temp = (bool) $is_temp;
        }

        return $this->_is_temp;
    }

    /**
     * accessor
     *
     * @param string $name file name
     *
     * @return void
     * @access  public
     */
    public function setName($name)
    {
        $this->_name = trim($name);
    }

    /**
     * Gets file content
     *
     * @param boolean $as_binary whether to return content as binary
     * @param integer $offset    starting offset
     * @param integer $length    length
     *
     * @return mixed   the binary file content as a string,
     *                 or false if no content
     *
     * @access  public
     */
    public function getContent($as_binary = true, $offset = 0, $length = null)
    {
        if (null === $this->_content) {

            if (! $this->isReadable()) {
                return false;
            }

            if (function_exists('file_get_contents')) {
                $this->_content = file_get_contents($this->getName());
            } elseif ($size = filesize($this->getName())) {
                $this->_content = fread(fopen($this->getName(), 'rb'), $size);
            }
        }

        if (! empty($this->_content) && $as_binary) {
            return '0x' . bin2hex($this->_content);
        }

        if (null !== $length) {
            return substr($this->_content, $offset, $length);
        } elseif ($offset > 0) {
            return substr($this->_content, $offset);
        }

        return $this->_content;
    }

    /**
     * Whether file is uploaded.
     *
     * @access  public
     *
     * @return bool
     */
    public function isUploaded()
    {
        return is_uploaded_file($this->getName());
    }

    /**
     * accessor
     *
     * @access  public
     * @return string  File::$_name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Returns possible error message.
     *
     * @access  public
     * @return string  error message
     */
    public function getError()
    {
        return $this->_error_message;
    }

    /**
     * Checks whether there was any error.
     *
     * @access  public
     * @return boolean whether an error occurred or not
     */
    public function isError()
    {
        return ! empty($this->_error_message);
    }

    /**
     * Checks whether file can be read.
     *
     * @access  public
     * @return boolean whether the file is readable or not
     */
    public function isReadable()
    {
        // suppress warnings from being displayed, but not from being logged
        // any file access outside of open_basedir will issue a warning
        ob_start();
        $is_readable = is_readable($this->getName());
        ob_end_clean();
        return $is_readable;
    }
    
    /**
     * Returns the file handle
     *
     * @return resource file handle
     */
    private function getHandle()
    {
        if (null === $this->_handle) {
            $this->open();
        }
        return $this->_handle;
    }

    /**
     * Sets the file handle
     *
     * @param object $handle file handle
     *
     * @return void
     */
    private function setHandle($handle)
    {
        $this->_handle = $handle;
    }
  
    /**
     * Attempts to open the file.
     *
     * @return bool
     */
    public function open($mode = self::MODE_APPEND) {


        if ($this->_handle = @fopen($this->getName(), $mode)) {
            return true;
        } else {
            $this->_error_message = 'Can\'t open file';
        }
    }
    
    
    private function getFileInfo() {
        $retorno = true;
        
        if( !file_exists( $this->getName())) {
            $retorno = false;
        } else {
            $fileinfo = $this->getFileInfo();
            
            $this->_basename = $fileinfo['basename'];
            $this->_dirname = $fileinfo['dirname'];
            $this->_extension = (!empty( $fileinfo['extension'])) ? $fileinfo['extension'] : '';
            $this->_filename = $fileinfo['filename'];
            
            $this->_filetype = filetype( $this->getName());
            $this->modified_date = filemtime( $this->getName());
            
        }
        
        return $retorno;
    }
    
    /**
     * Returns the typoe of the file.
     *
     * @return string filetype of the file
     */
    public function getFileType() {
        return $this->_filetype;
    }
    
    /**
     * Returns the extension of the file.
     *
     * @return string extension of the file
     */
    public function getFileExtension() {
        return $this->_extension;
    }
    
    /**
     * Returns the basename of the file
     *
     * @return string basename of the file
     */
    public function getFileBaseName() {
        return $this->_basename;
    }

    /**
     * Returns the character set of the file
     *
     * @return string character set of the file
     */
    public function getCharset()
    {
        return $this->_charset;
    }

    /**
     * Sets the character set of the file
     *
     * @param string $charset character set of the file
     *
     * @return void
     */
    public function setCharset($charset)
    {
        $this->_charset = $charset;
    }

    /**
     * Returns the length of the content in the file
     *
     * @return integer the length of the file content
     */
    public function getContentLength()
    {
        return strlen($this->_content);
    }

    /**
     * Returns whether the end of the file has been reached
     *
     * @return boolean whether the end of the file has been reached
     */
    public function eof()
    {
        if ($this->getHandle()) {
            return feof($this->getHandle());
        } else {
            return ($this->getOffset() >= $this->getContentLength());
        }

    }
}
?>
