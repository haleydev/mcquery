<?php
namespace Core\Model;
use Core\Model\Query;

class QuerySelectOne
{
    private array $query = [];
    private string $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * @param string|array $coluns
     * @example - $coluns ['colun1', 'colun2'] 'recomendado' ou 'colun1, colun2'
     * @example - $coluns ['SUM(colun) as total']
     * @example - $coluns ['MAX(colun)'] ou ['max(colun)']
     * @example - $coluns ['COUNT(colun) as total']
     */
    public function coluns(string|array $coluns = '*')
    {
        if (is_array($coluns)) {
            $all_coluns = '';
            foreach ($coluns as $colun) {
                $all_coluns .= $colun . ',';
            }

            $coluns = rtrim($all_coluns, ",");
        }

        $this->query['coluns'] = $coluns;
        return $this;
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
     * Esta função pode ser usada varias vezes.
     * @param array $like ['name' => '%example%', ...]
     */
    public function like(array $like)
    {
        $new_like = "";
        $count = count($like);
        $for_count = 1;
        foreach ($like as $key => $value) {
            if ($count > $for_count) {
                $and = " OR";
            } else {
                $and = "";
            }

            if ($for_count == 1 and !isset($this->query['like'])) {
                $wh = "WHERE";
            } else {
                $wh = "";
            }

            $this->query['bindparams']['like'][] = $value;

            $new_like .= " $wh $key LIKE ? $and";
            $for_count++;
        }

        if (isset($this->query['like'])) {
            $this->query['like'] = $this->query['like'] . 'OR' . $new_like;
        } else {
            $this->query['like'] = $new_like;
        }

        return $this;
    }

    /**
     * @param string $order ASC | DESC | RAND() 
     */
    public function order(string $order)
    {
        $this->query['order'] = "ORDER BY " . $order;
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
    public function left_join(string $table, array $join, string $operator = '=')
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
    public function right_join(string $table, array $join, string $operator = '=')
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
    public function cross_join(array $cross_join)
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
     * Remove coluns da query atual.
     */
    public function remove_coluns()
    {
        if(isset($this->query['coluns'])){
            unset($this->query['coluns']);
        }
      
        return $this;
    }
    
    /**
     * Remove having da query atual.
     */
    public function remove_having()
    {
        if(isset($this->query['having'])){
            unset($this->query['having']);
        }
      
        return $this;
    }    

    /**
     * Remove order da query atual.
     */
    public function remove_order()
    {
        if(isset($this->query['order'])){
            unset($this->query['order']);
        }
      
        return $this;
    }    

    /**
     * Remove where da query atual.
     */
    public function remove_where()
    {
        if(isset($this->query['where'])){
            unset($this->query['where']);
        }

        if(isset($this->query['bindparams']['where'])){
            unset($this->query['bindparams']['where']);
        }

        return $this;
    }

    /**
     * Remove like da query atual.
     */
    public function remove_like()
    {
        if(isset($this->query['like'])){
            unset($this->query['like']);
        }

        if(isset($this->query['bindparams']['like'])){
            unset($this->query['bindparams']['like']);
        }

        return $this;
    }

    /**
     * Remove join da query atual.
     */
    public function remove_join()
    {
        if(isset($this->query['join'])){
            unset($this->query['join']);
        }       

        return $this;
    }

    /**
     * Remove left join da query atual.
     */
    public function remove_leftjoin()
    {
        if(isset($this->query['left_join'])){
            unset($this->query['left_join']);
        }
      
        return $this;
    }

    /**
     * Remove right join da query atual.
     */
    public function remove_rightjoin()
    {
        if(isset($this->query['right_join'])){
            unset($this->query['right_join']);
        }
      
        return $this;
    }

    /**
     * Remove cross join da query atual.
     */
    public function remove_crossjoin()
    {
        if(isset($this->query['cross_join'])){
            unset($this->query['cross_join']);
        }
      
        return $this;
    }

    /**
     * Retorna a query completa
     * @return string
     */
    public function get_query()
    {
        if (isset($this->query['where'])) {
            $where = $this->query['where'];
        }

        if (isset($this->query['like']) and !isset($this->query['where'])) {
            $where = $this->query['like'];
        }

        if (!isset($where)) {
            $where = '';
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

        if (isset($this->query['order'])) {
            $order = $this->query['order'];
        } else {
            $order = '';
        }

        $query = preg_replace('/( ){2,}/','$1',
            "SELECT $coluns FROM $this->table $join $left_join $right_join $cross_join $where $having $order LIMIT 1"
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
     * Executa a query SELECT retornando os resultados.
     * @return array|null|error
     */
    public function execute()
    {
        $query = $this->get_query();

        if (isset($this->query['bindparams'])) {
            $bindparams = $this->query['bindparams'];
        } else {
            $bindparams = [];
        }

        return (new Query)->table($this->table)->selectOne($query, $bindparams);
    }
}
