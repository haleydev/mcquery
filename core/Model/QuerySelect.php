<?php
namespace Core\Model;
use Core\Model\Query;

class QuerySelect
{
    public array $query = [];
    private string $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    /**  
     * @param string|array $coluns selecionar colunas
     * 
     * example: ['SUM(colun) as total']
     * 
     * example: ['MAX(id)']
     * 
     * example: ['COUNT(colun) as total']
     */
    public function coluns(array $coluns = ['*'])
    {
        $all_coluns = '';
        foreach ($coluns as $colun) {
            $all_coluns .= $colun . ',';
        }

        $coluns = rtrim($all_coluns, ",");
        $this->query['coluns'] = $coluns;
        return $this;
    }

    /**
     * Esta função pode ser usada varias vezes.
     * 
     * example: (['name' => '%example%', ...],'LIKE','OR')
     * 
     * @param array $values
     * @param string $operator   
     * @param strign $boolean
     */
    public function where(array $values, string $operator = '=', string $boolean = 'AND')
    {
        $new_where = '';
        $count_values = count($values);
        $count_boolean = 1;

        foreach ($values as $key => $value) {
            if ($count_values > $count_boolean) {
                $and = $boolean;
            } else {
                $and = '';
            }

            if ($count_boolean == 1 and !isset($this->query['where'])) {
                $where = 'WHERE';
            } else {
                $where = '';
            }

            $this->query['bindparams']['where'][] = $value;

            $new_where .= "$where $key $operator ? $and";
            $count_boolean++;
        }

        if (isset($this->query['where'])) {
            $this->query['where'] = $this->query['where'] . $boolean . $new_where;
        } else {
            $this->query['where'] = $new_where;
        }

        return $this;
    }    

    /**
     * Exemplo - whereRaw('id IN ( SELECT id FROM table )')
     */
    public function whereRaw(string $raw, array $bindparams = [], string $boolean = 'AND')
    {


        if (isset($this->query['where'])) {
            $this->query['where'] = $this->query['where'] . $boolean . $raw;
        } else {
            $this->query['where'] = 'WHERE ' . $raw;
        }

        return $this;
    }    

    /**
     * Retornar apenas valores distintos (diferentes).
     */
    public function distinct()
    {
        $this->query['distinct'] = 'DISTINCT';          

        return $this;
    }

    /**
     * Esta função pode ser usada varias vezes.
     * 
     * @param array $values
     * @param strign $boolean
     */
    public function whereIsNull(array $coluns, string $boolean = 'AND')
    {
        $new_where = '';
        $count_values = count($coluns);
        $count_boolean = 1;

        foreach ($coluns as $value) {
            if ($count_values > $count_boolean) {
                $and = $boolean;
            } else {
                $and = '';
            }

            if ($count_boolean == 1 and !isset($this->query['where'])) {
                $where = 'WHERE';
            } else {
                $where = '';
            }          

            $new_where .= "$where $value IS NULL $and";
            $count_boolean++;
        }

        if (isset($this->query['where'])) {
            $this->query['where'] = $this->query['where'] . $boolean . $new_where;
        } else {
            $this->query['where'] = $new_where;
        }

        return $this;
    }   

    /**
     * Esta função pode ser usada varias vezes.
     * 
     * @param array $values
     * @param strign $boolean
     */
    public function whereNotNull(array $coluns, string $boolean = 'AND')
    {
        $new_where = '';
        $count_values = count($coluns);
        $count_boolean = 1;

        foreach ($coluns as $value) {
            if ($count_values > $count_boolean) {
                $and = $boolean;
            } else {
                $and = '';
            }

            if ($count_boolean == 1 and !isset($this->query['where'])) {
                $where = 'WHERE';
            } else {
                $where = '';
            }          

            $new_where .= "$where $value IS NOT NULL $and";
            $count_boolean++;
        }

        if (isset($this->query['where'])) {
            $this->query['where'] = $this->query['where'] . $boolean . $new_where;
        } else {
            $this->query['where'] = $new_where;
        }

        return $this;
    }   

    /**
     * Agrupa os arrays onde as colunas possuem valores iguais
     * @param array|string $coluns
     */
    public function groupBy(array|string $coluns)
    {
        if (is_array($coluns)) {
            $all_coluns = 'GROUP BY ';
            foreach ($coluns as $colun) {
                $all_coluns .= $colun . ',';
            }

            $group_by = rtrim($all_coluns, ',');
        }

        if (is_string($coluns)) {
            $group_by = 'GROUP BY ' . $coluns;
        }

        $this->query['group_by'] = $group_by;
        return $this;
    }

    /**
     * @example - $condicion 'max(id) > 10'
     * @param string $condicion
     */
    public function having(string $condicion)
    {
        $this->query['having'] = 'HAVING ' . $condicion;
        return $this;
    }

    /**
     * Limite de resultados
     * @param int $limit
     * @param int|null $page
     */
    public function limit($limit, int $page = null)
    {
        if($page == null) {
            $this->query['limit'] = 'LIMIT '  . $limit;            
        }else{            
            $page = ($page - 1) * $limit;
            $this->query['limit'] = 'LIMIT '  . $page . ' , ' . $limit;           
        }     
        
        return $this;   
    }

    /**
     * @param string $order ASC | DESC | RAND() 
     */
    public function orderBy(string $order)
    {
        $this->query['order'] = 'ORDER BY ' . $order;
        return $this;
    }

    /**
     * Esta função pode ser usada varias vezes.
     * @param string $table
     * @param array $join
     * @param string $operator
     * @example - ('table2' ['table2' => '1'],'=')
     */
    public function join(string $table, array $join, string $operator = '=')
    {
        $new_join = "";
        $count = count($join);
        $for_count = 1;
        foreach ($join as $table1 => $table2) {
            if ($count > $for_count) {
                $and = "AND";
            } else {
                $and = "";
            }

            if ($for_count == 1) {
                $in = "INNER JOIN $table ON";
            } else {
                $in = "";
            }

            $new_join .= " $in $table1 $operator $table2 $and";
            $for_count++;
        }

        if (isset($this->query['join'])) {
            $this->query['join'] = $this->query['join'] . $new_join;
        } else {
            $this->query['join'] = $new_join;
        }

        return $this;
    }

    /**
     * Esta função pode ser usada varias vezes.
     * @param string $table
     * @param array $join
     * @param string $operator
     * @example - ('table2' ['table2' => '1'],'=')
     */
    public function leftJoin(string $table, array $join, string $operator = '=')
    {
        $new_join = "";
        $count = count($join);
        $for_count = 1;
        foreach ($join as $table1 => $table2) {
            if ($count > $for_count) {
                $and = "AND";
            } else {
                $and = "";
            }

            if ($for_count == 1) {
                $in = "LEFT JOIN $table ON";
            } else {
                $in = "";
            }

            $new_join .= " $in $table1 $operator $table2 $and";
            $for_count++;
        }

        if (isset($this->query['left_join'])) {
            $this->query['left_join'] = $this->query['left_join'] . $new_join;
        } else {
            $this->query['left_join'] = $new_join;
        }

        return $this;
    }

    /**
     * Esta função pode ser usada varias vezes.
     * @param string $table
     * @param array $join
     * @param string $operator
     * @example - ('table2' ['table2' => '1'],'=')
     */
    public function rightJoin(string $table, array $join, string $operator = '=')
    {
        $new_join = "";
        $count = count($join);
        $for_count = 1;
        foreach ($join as $table1 => $table2) {
            if ($count > $for_count) {
                $and = "AND";
            } else {
                $and = "";
            }

            if ($for_count == 1) {
                $in = "RIGHT JOIN $table ON";
            } else {
                $in = "";
            }

            $new_join .= " $in $table1 $operator $table2 $and";
            $for_count++;
        }

        if (isset($this->query['right_join'])) {
            $this->query['right_join'] = $this->query['right_join'] . $new_join;
        } else {
            $this->query['right_join'] = $new_join;
        }

        return $this;
    }

    /**
     * Esta função pode ser usada varias vezes.
     * @param array $cross_join ['table1', 'table2']
     */
    public function crossJoin(array $cross_join)
    {
        $new_join = "";
        $count = count($cross_join);
        $for_count = 1;
        foreach ($cross_join as $table) {
            if ($count > $for_count) {
                $and = "AND";
            } else {
                $and = "";
            }

            if ($for_count == 1) {
                $in = "CROSS JOIN $table";
            } else {
                $in = "";
            }

            $new_join .= " $in $table $and";
            $for_count++;
        }

        if (isset($this->query['cross_join'])) {
            $this->query['cross_join'] = $this->query['cross_join'] . $new_join;
        } else {
            $this->query['cross_join'] = $new_join;
        }

        return $this;
    }

    /**
     * Retorna a query completa
     * @return string
     */
    public function getQuery()
    {
        if (isset($this->query['where'])) {
            $where = $this->query['where'];
        }else{
            $where = '';
        }

        if(isset($this->query['distinct'])){
            $distinct = $this->query['distinct'];
        }else{
            $distinct = '';
        }

        if (isset($this->query['coluns'])) {
            $coluns = $this->query['coluns'];
        } else {
            $coluns = '*';
        }

        if (isset($this->query['having'])) {
            $having = $this->query['having'];
        } else {
            $having = '';
        }

        if (isset($this->query['group_by'])) {
            $group_by = $this->query['group_by'];
        } else {
            $group_by = '';
        }

        if (isset($this->query['join'])) {
            $join = $this->query['join'];
        } else {
            $join = '';
        }

        if (isset($this->query['left_join'])) {
            $left_join = $this->query['left_join'];
        } else {
            $left_join = '';
        }

        if (isset($this->query['right_join'])) {
            $right_join = $this->query['right_join'];
        } else {
            $right_join = '';
        }

        if (isset($this->query['cross_join'])) {
            $cross_join = $this->query['cross_join'];
        } else {
            $cross_join = '';
        }

        if (isset($this->query['limit'])) {
            $limit = $this->query['limit'];
        } else {
            $limit = '';
        }

        if (isset($this->query['order'])) {
            $order = $this->query['order'];
        } else {
            $order = '';
        }

        $query = trim(preg_replace('/( ){2,}/','$1',
        "SELECT $distinct $coluns FROM $this->table $join $left_join $right_join $cross_join $where $group_by $having $order $limit"));

        return $query;
    }

    /**
     * @return array|false 
     */
    public function getBindparams()
    {
        if (isset($this->query['bindparams'])) {
            return $this->query['bindparams'];
        }

        return false;
    }

    /**
     * Executa a query SELECT retornando os resultados.
     * @return array|null|error
     */
    public function execute()
    {
        $query = $this->getQuery();

        if (isset($this->query['bindparams'])) {
            $bindparams = $this->query['bindparams'];
        } else {
            $bindparams = [];
        }

        return (new Query)->table($this->table)->select($query, $bindparams);
    }
}
