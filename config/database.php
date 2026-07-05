<?php

class Database
{
   
    private $_connection;
    private static $_instance;

    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'bbc';


    public function __construct()
    {
        $this->Connection();
    }


    private function Connection()
    {

        try {
            $this->_connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

    }

    /**
     * @return Database|null
     * Instance
     * Database connection check
     */

    public static function Instance()
    {
        if (!isset(self::$_instance)) {
            return self::$_instance = new Database();
        }

        return self::$_instance;
    }

    /**
     * @param string $tableName
     * @param array $data
     * @return bool
     */

    public function Insert($tableName, $data = array())
    {

        if (empty($tableName) || empty($data)) throw new PDOException("Table name & data field is mandatory");
        $columns = implode(',', array_keys($data));
        $dataValues = array_values($data);
        $setKey = '';
        $increment = 1;
        foreach ($data as $key => $val) {
            $setKey .= '?';
            if ($increment < count($data)) {
                $setKey .= ',';
            }
            $increment++;
        }

        $query = "INSERT INTO `$tableName` ($columns)VALUES ($setKey)";
        /**
         * prepare query
         */

        $prepareStatement = $this->_connection->prepare($query);
        try {
            if ($prepareStatement->execute($dataValues)) {
                return $this->_connection->lastInsertId();
            }

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

        return false;

    }

    /**
     * @param string $tableName
     * @param array $data
     * @param string $criteria
     * @param array $bindValue
     * @return mixed
     */

    public function Update($tableName = '', $data = array(), $criteria = '', $bindValue = array())
    {
        if (empty($tableName) || empty($tableName) || empty($criteria) ||
            empty($bindValue)) throw new PDOException("Criteria not match");
        /**
         * merge array
         */
        $mergeValue = array_merge(array_values($data), $bindValue);
        $setColumns = '';
        $increment = 1;
        foreach ($data as $column => $val) {
            $setColumns .= "{$column}=?";
            if ($increment < count($data)) {
                $setColumns .= ", ";
            }
            $increment++;
        }

        $query = "UPDATE {$tableName} SET {$setColumns} WHERE $criteria=?";

        $prepareStatement = $this->_connection->prepare($query);
        try {
            return $prepareStatement->execute($mergeValue);

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }


    }

    /**
     * @param string $tableName
     * @param string $criteria
     * @param array $bindValue
     * @return mixed
     */

    public function Delete($tableName = '', $criteria = '', $bindValue = array())
    {
        if (empty($tableName) || empty($criteria) || empty($bindValue)) throw new PDOException('Not valid criteria');
        $query = "DELETE FROM {$tableName} WHERE $criteria=?";
        $prepareStatement = $this->_connection->prepare($query);
        try {
            return $prepareStatement->execute($bindValue);

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

    }

    /**
     * @param string $tableName
     * @param array $bindData
     * @return bool
     */

    public function SelectAll($tableName = '', $bindData = array())
    {
        if (empty($tableName)) throw new PDOException('Table name is required');

        $query = "SELECT * FROM {$tableName}";
        $prepareStatement = $this->_connection->prepare($query);
        try {
            if ($prepareStatement->execute($bindData)) {
                return $prepareStatement->fetchAll(PDO::FETCH_CLASS);
            }

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

        return false;

    }

    /**
     * @param string $tableName
     * @param string $column
     * @param string $criteria
     * @param array $bindValue
     * @param string $clause
     * @return bool
     */
    public function SelectByCriteria($tableName = '', $column = '*', $criteria = '', $bindValue = array(), $clause = '')
    {

        if (empty($tableName)) throw new PDOException('table name is required');
        if (empty($column)) {
            $column .= '*';
        }

        $query = "SELECT {$column} FROM {$tableName}";

        if (!empty($criteria)) {
            $query .= " WHERE {$criteria}=?";
        }

        if (!empty($clause)) {
            $query .= " " . $clause;
        }

        $prepareStatement = $this->_connection->prepare($query);
        try {
            if ($prepareStatement->execute($bindValue)) {
                return $prepareStatement->fetchAll(PDO::FETCH_CLASS);
            }

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

        return false;


    }

    /**
     * @param string $query
     * @return bool
     */

    public function CustomQuery($query = '')
    {
        if (empty($query)) throw new PDOException('Query field is required');
        $prepareStatement = $this->_connection->prepare($query);

        try {
            if ($prepareStatement->execute([])) {
                return $prepareStatement->fetchAll(PDO::FETCH_CLASS);
            }

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

        return false;


    }

    /**
     * @param string $tableName
     * @param string $column
     * @param string $criteria
     * @param array $bindValue
     * @return bool
     */

    public function Count($tableName = '', $column = '*', $criteria = '', $bindValue = array())
    {
        if (empty($tableName)) throw new PDOException('Table name is required');
        $query = "SELECT COUNT($column) COUNT FROM {$tableName}";
        if (!empty($criteria) && !empty($bindValue)) {
            $query .= " WHERE {$criteria}=?";
        }
        $prepareStatement = $this->_connection->prepare($query);
        try {
            if ($prepareStatement->execute($bindValue)) {
                $result = $prepareStatement->fetchAll(PDO::FETCH_COLUMN);
                if ($result) {
                    return $result[0];
                }
                return $result;
            }

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

        return false;
    }

}