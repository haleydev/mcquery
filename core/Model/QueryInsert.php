<?php
namespace Core\Model;
use Core\Model\Query;

class QueryInsert
{
    private array $query = [];
    private string $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * @param array $insert Valores a serem inseridos na tabela.
     */       
    public function insert(array $insert)
    {
        $coluns = '';
        $bind = '';
        foreach ($insert as $key => $value) {
            $coluns .= $key . ',';
            $bind .= '?,';               
            $this->query['bindparams']['insert'][] = $value;
        }

        if (isset($this->query['insert']['coluns'])) {
            $this->query['insert']['coluns'] = $this->query['insert']['coluns'] . ',' . rtrim( $coluns , ',');
            $this->query['insert']['bind'] = $this->query['insert']['bind'] . ',' . rtrim( $bind  , ',');
        } else {
            $this->query['insert']['coluns'] = rtrim($coluns , ',');
            $this->query['insert']['bind'] = rtrim($bind , ',');
        }

        return $this;
    }

    /**
     * Retorna a query completa
     * @return string|false
     */
    public function get_query()
    {
        if (isset($this->query['insert'])) {
            $coluns = $this->query['insert']['coluns'];
            $bind = $this->query['insert']['bind'];
        } else {
            return false;
        }     

        $query = preg_replace('/( ){2,}/','$1',
            "INSERT INTO $this->table ($coluns) VALUES ($bind)"
        );

        return $query;
    }

    /**
     * @return array|false 
     */
    public function get_bindparams()
    {
        if (isset($this->query['bindparams'])) {
            return $this->query['bindparams'];
        }

        return false;
    }

    /**
     * Executa a query INSERT retornando os resultados.
     * @return true|false
     */
    public function execute()
    {
        $query = $this->get_query();

        if( $query == false ) {
            return false;
        }

        if (isset($this->query['bindparams'])) {
            $bindparams = $this->query['bindparams'];
        } else {
            $bindparams = [];
        }

        return (new Query)->table($this->table)->insert($query, $bindparams);
    }
}
