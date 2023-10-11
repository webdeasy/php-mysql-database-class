<?php

/**
 * Simple PHP MySQLi Database class for PHP7.* & PHP8.*
 * ----------------------------------------
 * This class provides a simple way to connect to your database and execute your queries.
 * It uses prepared statements to prevent SQL injections.
 * 
 * @author LH
 * @link https://webdeasy.de/en/php-mysql-database-class
 */
class Database {

  private $host, $database, $username, $password, $connection;  // connection credentials
  private $port = 3306; // default port

  private $affected_rows;  // properties to save before executing next query

  /**
   * Sets the connection credentials to connect to your database.
   *
   * @param string $host - the host of your database
   * @param string $username - the username of your database
   * @param string $password - the password of your database
   * @param string $database - your database name
   * @param integer $port - the port of your database
   * @param boolean $autoconnect - to auto connect to the database after settings connection credentials
   */
  function __construct($host, $username, $password, $database, $port = 3306, $autoconnect = true) {
    $this->host = $host;
    $this->database = $database;
    $this->username = $username;
    $this->password = $password;
    $this->port = $port;

    if ($autoconnect) $this->open();
  }

  /**
   * Open the connection to your database.
   */
  function open() {
    $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
  }

  /**
   * Close the connection to your database.
   */
  function close() {
    $this->connection->close();
  }

  /**
   *
   * Execute your query
   *
   * @param string $query - your sql query
   * @param array $parameters - your parameters to bind to your query
   * @return mysqli_result result of the executed query 
   */
  function query($query, $parameters = array()) {
    // reset data of last query
    $this->affected_rows = 0;

    // prepare the query
    $stmt = $this->connection->prepare($query);

    // check if prepare statement failed
    if ($stmt === false) {
      die("Error in prepare statement: " . $this->connection->error);
    }

    // check if parameters are given
    if (!empty($parameters)) {
      $types = "";
      $bindParams = [];

      // get the types of the parameters
      foreach ($parameters as $param) {
        if (is_int($param)) {
          $types .= "i";
        } elseif (is_double($param)) {
          $types .= "d";
        } else {
          $types .= "s";
        }
        $bindParams[] = $param;
      }

      // bind the parameters to the query
      $stmt->bind_param($types, ...$bindParams);
    }

    // execute the query
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      $this->affected_rows = $stmt->affected_rows;
      $stmt->close();
      return $result;
    } else {
      die("Error executing query: " . $stmt->error);
    }
  }

  /**
   * Get the amount of affected rows of the last executed query.
   * @return integer
   */
  function get_affected_rows() {
    return $this->affected_rows;
  }

  /**
   * Get the last inserted id of the last executed query.
   * @return integer
   */
  function get_last_inserted_id() {
    return $this->connection->insert_id;
  }
}
