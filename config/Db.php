<?php

Class Db
{
	private $pdo;
	private $sql;
	private $params;

	public function __construct()
	{
		$host = '127.0.0.1';
		$db   = 'db_spk_dosen';
		$user = 'root';
		$pass = '';
		$charset = 'utf8mb4';

		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];

		try {
			$this->pdo = new PDO($dsn, $user, $pass, $options);
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
	}

	private function prepareStatement()
	{
		var_dump($this->sql, $this->params);
		$stmt = $this->pdo->prepare($this->sql);
		$stmt->execute($this->params);
		
		$this->removeAttributes();
		return $stmt;
	}

	private function removeAttributes()
	{
		$this->sql = $this->params = null;
	}

	public function escape_query($q, $like = false){
		$q = str_replace("'", "''", $q);
		$q = str_replace("\\", "\\\\", $q);
		if($like){
			$q = str_replace("%", "\\%", $q);
			$q = str_replace("_", "\\_", $q);
		}
		return $q;
	}

	public function selectQuery($tbl, $column = false)
	{
		$fields = "*";
		
		if ($column) {
			$fields = implode(", ", $column);
		}

		$this->sql = "SELECT {$fields} FROM {$tbl}";

		return $this;
	}

	public function where($where)
	{
		$this->sql .= " WHERE ";
		$this->params = [];

		$count = 1;
		foreach ($where as $field => $record) {
			$this->sql .= " {$field} = :param{$count}";
			$this->params[":param{$count}"] = $record;
			if ($record !== end($where)) {
				$this->sql .= " AND ";
			}
			$count++;
		}

		return $this;
	}

	public function whereIn($column, $in, $not = "IN")
	{
		if ($in) {
			$this->params = [];
			$count = 1;
			foreach ($in as $n) {
				$this->params[":param{$count}"] = $n;
				$count++;
			}

			$list = implode(', ', array_keys($this->params));
			$this->sql .= " WHERE {$column} {$not} ({$list})";	
		}

		return $this;
	}

	public function join($tbl)
	{
		$this->sql .= " JOIN {$tbl} ";
		return $this;
	}

	public function on($on)
	{
		$this->sql .= " ON {$on} ";
		return $this;
	}

	public function column()
	{
		$stmt = $this->prepareStatement();
		return $stmt->fetchAll(PDO::FETCH_COLUMN);
	}

	public function all()
	{
		$stmt = $this->prepareStatement();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function one()
	{
		$stmt = $this->prepareStatement();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function insertQuery($tbl, $data)
	{
		$fields = implode(', ', array_keys($data));
		$params = [];

		foreach ($data as $field => $record) {
			$params[":{$field}"] = $record;
		}

		$params_field = implode(', ', array_keys($params));

		$sql = "INSERT INTO {$tbl} ({$fields}) VALUES ({$params_field})";

		return $this->pdo->prepare($sql)->execute($params);
	}

	public function updateQuery($tbl, $data)
	{
		$id = $data['id'];
		unset($data['id']);
		$set_value = "";
		$params = [];
		
		foreach ($data as $field => $record) {
			$set_value .= "{$field} = :{$field}";
			if ($record !== end($data)) {
				$set_value .= ", ";
			}

			$params[":{$field}"] = $record;
		}
		$sql = "UPDATE {$tbl} SET {$set_value} WHERE id = {$id}";

		return $this->pdo->prepare($sql)->execute($params);
	}

	public function deleteQuery($tbl, $id)
	{
		$sql = "DELETE FROM {$tbl} WHERE id = :id";
		return $this->pdo->prepare($sql)->execute([':id' => $id]);
	}
}