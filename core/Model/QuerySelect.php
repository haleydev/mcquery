<?php
namespace Core\Model;
use Core\Model\Query;

class QuerySelect
{
    public array $query = []; 
    public string $table;

    public function coluns(string|array $coluns = '*') 
    {
        if(is_array($coluns)){
            $all_coluns = '';
            foreach($coluns as $colun){
                $all_coluns .= $colun . ',';
            }   
            
            $coluns = rtrim($all_coluns,",");
        }

        $this->query['coluns'] = $coluns;
        return $this;
    }
   
    public function where(array $where, string $operator = '=')
    {        
        $new_where = "";
        $count = count($where);
        $for_count = 1;
        foreach ($where as $key => $value) {
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
        }else{
            $this->query['where'] = $new_where;
        }        
       
        return $this;        
    }

    public function group_by(array|string $coluns)
    {
        if(is_array($coluns)){
            $all_coluns = 'GROUP BY ';
            foreach($coluns as $colun){
                $all_coluns .= $colun . ',';
            }   
            
            $group_by = rtrim($all_coluns,",");
        }

        if(is_string($coluns)) {
            $group_by = 'GROUP BY ' . $coluns;
        }

        $this->query['group_by'] = $group_by;
        return $this;
    }

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
            $this->query['like'] = trim($this->query['like'] . 'OR' . $new_like);
        }else{
            $this->query['like'] = trim($new_like);
        }            

        return $this;
    }
    
    public function limit(int|string $limit)
    {
        $this->query['limit'] = "LIMIT " . $limit;
        return $this;
    }
    
    /**
     * @param string $order ASC | DESC | RAND() 
     */
    public function order(string $order)
    {
        $this->query['order'] = "ORDER BY " . trim($order);
        return $this;
    }

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
            $this->query['join'] = trim($this->query['join'] . $new_join);
        }else{
            $this->query['join'] = trim($new_join);
        }        
       
        return $this;
    }

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

        if (isset($this->query['join'])) {
            $this->query['join'] = trim($this->query['join'] . $new_join);
        }else{
            $this->query['join'] = trim($new_join);
        }        
       
        return $this;
    }

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

        if (isset($this->query['join'])) {
            $this->query['join'] = trim($this->query['join'] . $new_join);
        }else{
            $this->query['join'] = trim($new_join);
        }        
       
        return $this;
    }

    public function full_join(string $table, array $join, string $operator = '=')
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
                $in = "FULL JOIN $table ON";
            } else {
                $in = "";
            }           

            $new_join .= " $in $table1 $operator $table2 $and";
            $for_count++;
        }       

        if (isset($this->query['join'])) {
            $this->query['join'] = trim($this->query['join'] . $new_join);
        }else{
            $this->query['join'] = trim($new_join);
        }        
       
        return $this;
    }

    /**
     * CROSS JOIN
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
            $this->query['cross_join'] = trim($this->query['cross_join'] . $new_join);
        }else{
            $this->query['cross_join'] = trim($new_join);
        }        
       
        return $this;
    }

    /**
     * Executa a query, retornando os resultados.
     * @return mixed
     */
    public function execute()
    {
        return (new Query)->table($this->table)->select($this->query);
    }
}