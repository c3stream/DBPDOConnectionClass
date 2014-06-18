<?php
/**
 * User: c3stream
 * Date: 13/06/06
 * Time: 16:31
 */

namespace libs\db\DBConnection;

class DBPDOConnectionClass extends \PDO {

    private $_data_base;
    private $_data_base_name;
    private $_data_base_user;
    private $_data_base_pass;
    private $_data_base_host;
    private $_data_base_port;
    private $_data_base_net_string;
    private $_data_base_connection_string;
    private $_data_base_connection = null;
    private $_data_base_connection_pooling = false;

    function __construct($data_base, $data_base_user, $data_base_name = "" , $data_base_pass = "", $_data_base_connection_pooling = false,$data_base_host = false, $data_base_port = false){
        if(empty($data_base)){
            throw new \Exception("WARNING! SET DB NAME!");
        }
        if(empty($data_base_user)){
            throw new \Exception("WARNING! SET DB USER NAME!");
        }
        if(!is_bool($_data_base_connection_pooling)){
            throw new \Exception("WARNING! SET DB CONNECTION POOLING BOOLEAN!");
        }
        $this->_data_base = $data_base;
        $this->_data_base_user = $data_base_user;
        $this->_data_base_connection_pooling = $_data_base_connection_pooling;
        $this->_data_base_pass = empty($data_base_pass) ? '': $data_base_pass;
        $this->_data_base_name = empty($data_base_name) ? '': $data_base_name;
        $this->_data_base_host = empty($data_base_host)? "localhost": $data_base_host;
        if($data_base_host[0] === "/"){
            $this->_data_base_net_string = sprintf("unix_socket=%s",$this->_data_base_host);
        } else {
            $this->_data_base_port = empty($data_base_port)? 3306: $data_base_port;
            $this->_data_base_net_string = sprintf("host=%s;port=%s",$this->_data_base_host,$this->_data_base_port);
        }

        $this->_data_base_connection_string = sprintf("%s:%s;dbname=%s", $this->_data_base, $this->_data_base_net_string, $this->_data_base_name);
        $this->_Connection();
    }

    function __destruct(){
        if(!$this->_data_base_connection_pooling){
            $this->_data_base_connection = null;
            unset($this->_data_base_connection);
        }
    }
    private function _Connection(){
        try {
            if($this->_data_base_connection_pooling){
                $this->_data_base_connection = parent::__construct($this->_data_base_connection_string , $this->_data_base_user, $this->_data_base_pass, array(\PDO::ATTR_PERSISTENT => true));
            } else {
                $this->_data_base_connection = parent::__construct($this->_data_base_connection_string , $this->_data_base_user, $this->_data_base_pass, array(\PDO::ATTR_PERSISTENT => false));
            }
        } catch (\PDOException $e) {
            throw new \Exception("DB CONNECTION ERROR! : ". $e->getMessage());
        } catch (\Exception $e){
            throw new \Exception("DB CONNECTION EXCEPTION! : ". $e->getMessage());
        }
        $this->exec("SET NAME utf8");
        return true;
    }
}
