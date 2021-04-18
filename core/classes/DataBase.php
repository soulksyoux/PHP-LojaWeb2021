<?php

namespace core\classes;

class DataBase
{

    /**
     * @var \PDO
     */
    private $ligacao;
    private $lastId;

    // 3 etapas - ligar, comunicar e fechar

    /**
     * Estabelece ligacao a base de dados
     */
    private function ligar(): void{
        $this->ligacao = new \PDO(
            "mysql:" .
            "host=" . MYSQL_SERVER . ";" .
            "dbname=" . MYSQL_DATABASE . ";" .
            "charset=" . MYSQL_CHARSET,
            MYSQL_USER,
            MYSQL_PASSWORD,
            array(\PDO::ATTR_PERSISTENT => true)
        );

        // debug
        $this->ligacao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);

    }

    /**
     * Desliga a conexao a base de dados
     */
    public function desligar(): void
    {
        unset($this->ligacao);
    }


    //Metodos CRUD


    /**
     * @param string $sql
     * @param array|null $params
     * @return array|false|null
     * @throws \Exception
     */
    public function select(string $sql, array $params = null): ?array
    {
        $sql = trim($sql);

        //verifica se é uma instrução SELECT
        if(!preg_match("/^SELECT/i", $sql)) {
            throw new \Exception("Base de dados - Query não é um Select");
        }

        $this->ligar();

        $resultados = null;

        try {
            //ligacao com a DB
            if(!empty($params)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($params);
                $resultados = $executar->fetchAll(\PDO::FETCH_CLASS);
            }else{
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
                $resultados = $executar->fetchAll(\PDO::FETCH_CLASS);
            }


        } catch (\PDOException $e) {
            return false;
        }

        $this->desligar();

        return $resultados;
    }


    /**
     * @param string $sql
     * @param array|null $params
     * @return bool
     * @throws \Exception
     */
    public function insert(string $sql, array $params = null): ?bool
    {
        //verifica se é uma instrução INSERT
        if(!preg_match("/^INSERT/i", $sql)) {
            throw new \Exception("Base de dados - Query não é um INSERT");
        }

        $this->ligar();

        $resultado = null;

        try {
            //ligacao com a DB
            if(!empty($params)) {
                $executar = $this->ligacao->prepare($sql);
                $resultado = $executar->execute($params);
            }else{
                $executar = $this->ligacao->prepare($sql);
                $resultado = $executar->execute();
            }

        } catch (\PDOException $e) {
            return false;
        }

        $this->lastId = $this->ligacao->lastInsertId();
        $this->desligar();

        return $resultado;

    }


    /**
     * @param string $sql
     * @param array|null $params
     * @return int|null
     * @throws \Exception
     */
    public function update(string $sql, array $params = null): ?int
    {
        //verifica se é uma instrução de UPDADE
        if(!preg_match("/^UPDATE/i", $sql)) {
            throw new \Exception("Base de dados - Query não é um UPDATE");
        }

        $this->ligar();

        try {
            //ligacao com a DB
            if(!empty($params)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($params);
            }else{
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }

        } catch (\PDOException $e) {
            return false;
        }

        $this->desligar();

        return $executar->rowCount();
    }


    /**
     * @param string $sql
     * @param array|null $params
     * @return int|null
     * @throws \Exception
     */
    public function delete(string $sql, array $params = null): ?int
    {
        //verifica se é uma instrução de DELETE
        if(!preg_match("/^DELETE/i", $sql)) {
            throw new \Exception("Base de dados - Query não é um DELETE");
        }

        $this->ligar();

        try {
            //ligacao com a DB
            if(!empty($params)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($params);
            }else{
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }

        } catch (\PDOException $e) {
            return false;
        }

        $this->desligar();

        return $executar->rowCount();
    }


    public function statement(string $sql, array $params = null): ?bool
    {
        $sql = trim($sql);

        //verifica se é uma instrução diferente de SELECT, INSERT, UPDATE e DELETE
        if(preg_match("/^(SELECT|INSERT|UPDATE|DELETE)/i", $sql)) {
            throw new \Exception("Base de dados - Query inválida");
        }

        $this->ligar();

        try {
            //ligacao com a DB
            if(!empty($params)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($params);
            }else{
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }

        } catch (\PDOException $e) {
            return false;
        }

        $this->desligar();

        return $executar->rowCount();
    }

    public function getLastId(){
        return $this->lastId;
    }

}