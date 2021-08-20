<?php
declare(strict_types = 1);
include_once 'DBInterface.php';
include_once 'AbstractDB.php';
include_once 'AbstractQueryResult.php';
include_once 'QueryResultInterface.php';

class Database extends AbstractDB implements DBInterface {
  private  $host = HOST;
	private  $dbUser = USERNAME;
	private  $dbPass = PASSWORD;
	private  $dbName = DBNAME;
	private  $dbConn;
  private $dbconnectError;

  function __construct()	{
	   $this->connectToServer();
	}

	function connectToServer():void {
	   $this->dbConn = mysqli_connect($this->host, $this->dbUser, $this->dbPass );
	   if (! $this->dbConn) {
		     throw new Exception("the $this->dbName database was not dropped");
	   }
	}

  function dropDatabase():void {
    $sql = "drop database if exists $this->dbName";
    $this->query($sql);
  }

  function createDatabase(): void {
    $sql = "create database if not exists $this->dbName";
    $this->query($sql);
  }

  function selectDatabase(): void {
        $sql = "use $this->dbName";
        $this->query($sql);
      }

    public function createTable(string $tableName, array $columns, string $primaryKeyColumn, string $extraModifiers = null) : QueryResultInterface {
      $sql = "create table if not exists $tableName (";
      foreach ($columns as $columnName => $columnDetails) {
          $sql .= "$columnName $columnDetails, ";
      }
      $sql .= "primary key ($primaryKeyColumn)";
      if (!empty($extraModifiers)) {
          $sql .= ", $extraModifiers";
      }
      $sql .= ") engine = InnoDB;";
      return $this->query($sql);
    }

    function isError(): bool {
      if  ( $this->dbconnectError )	{
		       return true;
	     }
  		$error = mysqli_error ( $this->dbConn );
  		if ( empty ($error) ) {
  			return false;
      }  else {
  			return true;
      }
    }

    function query( string $sql ): QueryResultInterface {
  		if ( ! $queryResource = mysqli_query( $this->dbConn, $sql ) )	{
  			trigger_error( 'Query Failed: ' . mysqli_error($this->dbConn ) . ' SQL: ' . $sql );
  			return false;
  		}
  		return new SQLQueryResult( $this, $queryResource );
     }

}

class SQLQueryResult extends AbstractQueryResult implements QueryResultInterface
{
   var $db;
   var $queryResource;

   function __construct( $theDB, $theQueryResource )
   {
		$this->db = $theDB;
		$this->queryResource = $theQueryResource;
   }

    function size():int
    {
		return mysqli_num_rows( $this->queryResource );
    }

    function fetch(): array
  {
    if ( $row = mysqli_fetch_array( $this->queryResource , MYSQLI_ASSOC ))
    {
      return $row;
    }
    else if ( $this->size() > 0 )
    {
      mysqli_data_seek( $this->queryResource , 0 );
      return [];
    }
    else
    {
      return [];
    }
  }

   function isError():bool
    {
      return $this->db->isError();
    }
}
