<?

/** minimal functionality pdo wrapper class
depends on PDO to throw exceptions on errors
*/
class SimpleDb{

	protected $_dsn = '';
	protected $_username = '';
	protected $_password = '';
	protected $_connection = NULL;

	/** constructor, receives variables required for connecting to database
	@param string $dsn       database connection string
	@param string $username  database username
	@param string $password  database password
	*/
	public function __construct( $dsn, $username, $password) {
		$this->_dsn = $dsn;
		$this->_username = $username;
		$this->_password = $password;
	}

	/** performs SELECT queries and returns result set as array
	@param text  $sql    sql to query
	@param array $params parameters to bind
	@return result set handler
	*/
	public function select( $sql, $params = array() ) {
		$statement = $this->_prepareStatement( $sql, $params );
		return $statement->fetchAll();

	}

	/** performs INSERT/UPDATE/REPLACE/DELETE queries and returns number of modified rows
	@param text  $sql    sql to query
	@param array $params parameters to bind
	@return int
	*/
	public function modify( $sql, $params = array() ) {
		$statement = $this->_prepareStatement( $sql, $params );
		return $statement->rowCount();
	}

	/** creates and executes an INSERT statement based on supplied values
	@param text  $table  name of table to insert into
	@param array $values list of fields and values to insert. Assumes keys are text
	@return int number of records changed
	*/
	public function insert( $table, $params ) {

		$new_params = array();
		$set = array();
		foreach( $params as $key => $value ) {
			// add : to each key so it matches the naming convetion required by pdo
			$new_key = ':'.$key;
			$set[] = ' '.$key.' = '.$new_key;
			$new_params[$new_key] = $value;
		}
		$sql = 'INSERT INTO '.$table.' SET '.implode( ',', $set );
		return $this->modify( $sql, $new_params );
	}

	/** attributes to apply to all pdo connections
	@return array
	*/
	protected function _defaultPdoAttributes() {
		return array(PDO::ATTR_PERSISTENT => TRUE,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_CASE => PDO::CASE_NATURAL,
					PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => TRUE,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				);
	}

	/** create a new connection if necessary and return the connection
	@return PDO
	*/
	protected function _connection() {
		if( $this->_connection !== NULL ) return $this->_connection;

		$this->_connection = new PDO( $this->_dsn, $this->_username, $this->_password, $this->_defaultPdoAttributes() );

		return $this->_connection;
	}

	/** creates a prepared statement, executes and returns it
	all statements are prepared to prevent sql injection
	@param text  $sql    sql to query, assumes params are named like :foo
	@param array $params parameters to bind, assumes are in array( :foo => foo ) format
	@return PdoStatement
	*/
	protected function _prepareStatement( $sql, $params ) {
		$connection = $this->_connection();
		$statement = $connection->prepare( $sql );
		foreach( $params as $key => $value ) {
			$statement->bindValue( $key, $value );
		}
		$statement->execute();
		return $statement;
	}

	/** format supplied date in sql format, return current date if no date passed
	@param string $date strtotime value to make date from
	@return string
	**/
	static public function sqlDateTime( $date = NULL ) {
		if( is_scalar( $date ) )
			$datetime = new DateTime( $date );
		if( empty( $datetime ) )
			$datetime = new DateTime();
		return $datetime->format( 'Y-m-d H:i:s');
	}

}