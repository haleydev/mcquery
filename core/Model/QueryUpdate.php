<?php
namespace Core\Model;
use Core\Model\Query;

class QueryUpdate
{
    private array $query = [];
    private string $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * Esta função pode ser usada varias vezes.
     * @param array $condicion
     * @param string $operator
     * @example - $condicions ['id' => 1] ou ['NOT id' => 1, ...]
     */
    public function where(array $condicions, string $operator = '=')
    {
        $new_where = "";
        $count = count($condicions);
        $for_count = 1;
        foreach ($condicions as $key => $value) {
            if ($count > $for_count) {
                $and = "AND";
            } else {
                $and = "";
            }

            if ($for_count == 1 and !isset($this->query['where'])) {
                $wh = "WHERE";
            } else {
                $wh = "";
            }

            $this->query['bindparams']['where'][] = $value;

            $new_where .= "$wh $key $operator ? $and";
            $for_count++;
        }

        if (isset($this->query['where'])) {
            $this->query['where'] = $this->query['where'] . 'AND' . $new_where;
        } else {
            $this->query['where'] = $new_where;
        }

        return $this;
    }
    
    public function values(array $values)
    {
        $new_update = '';
        foreach ($values as $key => $value) {
            $new_update .= $key . ' = ? ,';               
            $this->query['bindparams']['update'][] = $value;
        }

        if (isset($this->query['update'])) {
            $this->query['update'] = $this->query['update'] . ',' . rtrim( $new_update , ',');
        } else {
            $this->query['update'] = rtrim($new_update , ',');
        }

        return $this;
    }

    /**
     * @param int|string $limit
     */
    public function limit(int|string $limit)
    {
        $this->query['limit'] = "LIMIT " . $limit;
        return $this;
    }

    /**
     * Retorna a query completa
     * @return string|false
     */
    public function get_query()
    {
        if (isset($this->query['update'])) {
            $update = $this->query['update'];
        } else {
            return false;
        }

        if (isset($this->query['where'])) {
            $where = $this->query['where'];
        }else{
            $where = '';
        }

        if (isset($this->query['limit'])) {
            $limit = $this->query['limit'];
        } else {
            $limit = '';
        }       

        $query = preg_replace('/( ){2,}/','$1',
            "UPDATE $this->table SET $update $where $limit"
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
     * Executa a query UPDATE retornando os resultados.
     * @return int|false|error
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

        return (new Query)->table($this->table)->update($query, $bindparams);
    }
}
