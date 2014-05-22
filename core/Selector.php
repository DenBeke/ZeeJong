<?php

class Selector {
    private $count = false;
    private $orderByColumns = [];
    private $sortType = '';
    private $limit = [];
    private $table = '';
    private $select = ['*'];
    private $values = [];
    private $group = [];
    private $rawFilters = [];

    private $joins = [];

    private $filters = [];

    public function __construct($table) {
        $this->table = $table;
    }

    public function filter($f) {
        foreach($f as &$column) {
            if(!is_array($column[2])) {
                $column[2] = [$column[2]];
            }

            foreach($column[2] as &$value) {
                if (($column[1] == 'IS NOT NULL') || ($column[1] == 'IS NULL')) {
                    continue;
                }

                array_push($this->values, $value);
            }
        }



        array_push($this->filters, $f);

        return $this;
    }

    public function rawFilter($f) {
        $this->rawFilters = array_merge($this->rawFilters, $f);

        return $this;
    }

    public function count() {
        $this->count = true;

        return $this;
    }

    public function order($columns, $sortType = '') {
        if(!is_array($columns)) {
            $columns = [$columns];
        }

        $this->orderByColumns = $columns;
        $this->sortType = $sortType;

        return $this;
    }

    public function group($columns) {
        if(!is_array($columns)) {
            $columns = [$columns];
        }

        foreach($columns as &$column) {
            $exploded = explode('.', $column);

            $column = '`' . $exploded[0] . '`';

            if(count($exploded) == 2) {
                $column .= '.`' . $exploded[1] . '`';
            }
        }

        $this->group = $columns;
        return $this;
    }

    public function limit($start, $end) {
        $this->limit = [$start, $end];

        return $this;
    }

    public function join($table, $from, $to) {
        array_push($this->joins, [$table, $from, $to]);

        return $this;
    }

    public function select($columns) {
        if(!is_array($columns)) {
            $columns = [$columns];
        }

        $this->select = $columns;

        return $this;
    }

    public function sql() {
        $sql = 'SELECT ';

        if($this->count) {
            $sql .= 'COUNT(';
            foreach($this->select as $column) {
                $sql .=  $column;

                if(end($this->select) !== $column) {
                    $sql .= ',';
                }
            }
            $sql .= ')';
        } else {
            foreach($this->select as $column) {
                $sql .=  $column;

                if(end($this->select) !== $column) {
                    $sql .= ',';
                }
            }
        }

        $sql .= ' FROM `' . $this->table . '`';

        if(count($this->joins) > 0) {
            $sql .= ' INNER JOIN `' . $this->joins[0][0] . '` ON ';
            $sql .= '`' . $this->table . '`' . '.' . $this->joins[0][1] . '=';
            $sql .= '`' . $this->joins[0][0] . '`' . '.' . $this->joins[0][2];
        }

        if(count($this->filters) > 0 || count($this->rawFilters) > 0) {
            $sql .= ' WHERE';
        }

        foreach($this->filters as &$filter) {

            $sql .= ' (';

            foreach($filter as &$column) {
                foreach($column[2] as &$orValue) {
                    $sql .= ' ' . $column[0] . ' ' . $column[1];

                    if (($column[1] != 'IS NOT NULL') && ($column[1] != 'IS NULL')) {
                        $sql .= '?';
                    }

                    if(end($column[2]) !== $orValue) {
                        $sql .= ' OR';
                    }
                }

                if(end($filter) !== $column) {
                    $sql .= ' OR';
                }
            }

            $sql .= ')';

            if(end($this->filters) !== $filter) {
                $sql .= ' AND';
            }
        }

        if(count($this->filters) > 0 && count($this->rawFilters) > 0) {
            $sql .= ' AND ';
        }

        foreach($this->rawFilters as &$filter) {
            $sql .= ' (';

            $sql .= $filter;

            $sql .= ')';

            if(end($this->rawFilters) !== $filter) {
                $sql .= ' AND';
            }
        }

        if(count($this->group) > 0) {
            $sql .= ' GROUP BY ';
            foreach($this->group as &$group) {
                $sql .= $group;

                if(end($this->group) !== $group) {
                    $sql .= ',';
                }
            }
        }

        if(count($this->orderByColumns) > 0) {
            $sql .= ' ORDER BY ';
            foreach($this->orderByColumns as &$column) {
                $sql .= '`' . $column . '`';

                if(end($this->orderByColumns) !== $column) {
                    $sql .= ',';
                }
            }

            $sql .= ' ' . $this->sortType;
        }

        if(count($this->limit) == 2) {
            $sql .= ' LIMIT ' . $this->limit[0] . ',' . $this->limit[1];
        }

        return $sql;
    }

    public function values() {
        return $this->values;
    }
}

?>
