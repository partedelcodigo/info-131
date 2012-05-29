<?php
/**
 * Class for create combo related to a table
 *
 * @author juan
 */
class comboTabla extends combo {
    /**
     * Stores table where we get the values
     *
     * @var string $tableName
     * 
     * @access private
     */
    private $tableName;
    
    /**
     * Contains the sql query to get elements from the table
     *
     * @var string $customQuery
     * 
     * @access private
     */
    private $customQuery;
    
    /**
     * Array that contains fields to be returned in the SQL query
     *
     * @var array|mixed $tableFields
     * 
     * @access private
     */
    private $tableFields;
    
    
    /**
     * Class construct 
     */
    public function __construct() {
        # initialized variables
        $this -> tableName = '';
        $this -> customQuery = '';
        $this -> tableFields = array( );
    }
    
    /**
     * FUnction to set the fields for the SQL query
     *
     * @param array|mixed $fields, table fields
     * 
     * @access public
     */
    public function setTableFields($fields) {
        $this -> tableFields = $fields;
    }
    
    
    /**
     * Function to set table name
     *
     * @param string $tableName, table name
     *
     * @access public
     */
    public function setTableName($tableName) {
        $this -> tableName = $tableName;
    }
    
    /**
     * Set custom query to get table elements
     *
     * @param string $query, SQL query
     *
     * @access public
     */
    public function setCustomQuery($query) {
        $this -> customQuery = $query;
    }
    
    /**
     * Function to return the table's elements
     *
     * @return array|mixed, table elements
     * 
     * @access public
     */
    public function getElements() {
        $elements = array();
        
        $query = new QUERY();
        
        $sql = new SQL();
        
        $sql -> setS($this -> tableFields);
        $sql -> setF($this -> tableName);
        
        $query -> consulta($sql -> crearSQL());
        
        while($reg = $query -> valores_row()) {
            $elements[] = $reg;
        }
        
        return $elements;
    }
}
?>