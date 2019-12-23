<?php
namespace App\Utilities;
/**
 * This class design to return necessary data on 3rdy party DataTable plugin.
 */
class DataTable
{
    private $orderable;
    private $searchable;
    private $draw;
    private $offset;
    private $limit;
    private $search;
    private $orderBy;
    private $orderDir;
    private $columns;
    private $table_columns;
    private $query_builder;
    private $filtered;
    private $data;
    private $recordsFiltered;
    private $recordsTotal;
    public function __construct($data, $query_builder, $columns, $table_columns = [])
    {
        $this->orderable = array_keys(array_column($data['columns'], 'orderable'), "true");
        $this->searchable = array_keys(array_column($data['columns'], 'searchable'), "true");
        $this->draw = isset($data['draw']) ? $data['draw'] : 1;
        $this->offset = isset($data['start']) ? $data['start'] : 0;
        $this->limit = isset($data['length']) ? $data['length'] : 10;
        $this->search = isset($data['search']['value']) ? $data['search']['value'] : "";
        $this->orderBy = isset($data['order'][0]['column']) ? $data['order'][0]['column'] : 0;
        $this->orderDir = isset($data['order'][0]['dir']) ? $data['order'][0]['dir'] : "asc";
        $this->columns = !empty($columns) ? $columns : $table_columns;
        $this->table_columns = !empty($table_columns) ? $table_columns : $columns;
        $this->query_builder = $query_builder;
        $this->initSearching();
        $this->initOrdering();
        $this->setRecordsTotal();
        $this->setFiltered();
        $this->setData();
    }
    private function initSearching()
    {
        if (!empty($this->search))
        {
            $searchable = $this->searchable;
            $table_columns = $this->table_columns;
            $search = $this->search;
            $this->query_builder = $this->query_builder->where(function($query) use($searchable, $table_columns, $search) {
                                foreach ($searchable as $index) {
                                    if (isset($table_columns[$index]))
                                    {
                                        $query = $query->orWhere($table_columns[$index], "like", "%{$search}%");
                                    }
                                }
                                return $query;
                            });
        }
    }
    private function initOrdering()
    {
        if (in_array($this->orderBy, $this->orderable))
        {
            $this->query_builder = $this->query_builder->orderBy($this->table_columns[$this->orderBy], $this->orderDir);
        }
    }
    private function setFiltered()
    {
        $this->filtered = $this->query_builder->get()->count();
    }
    private function setData()
    {
        $this->data = $this->query_builder->offset($this->offset)
                        ->limit($this->limit)
                        ->get();
    }
    public function setRecordsTotal()
    {
        $this->recordsTotal = $this->query_builder->get()->count();
    }
    public function getDataOutput($with_index=false)
    {
        $out = [];
        $data_len = count($this->data);
        $column_len = count($this->columns);
        for ($i=0, $ien=$data_len; $i<$ien; $i++) {
            $row = [];
            for ($j=0, $jen=$column_len; $j<$jen; $j++) {
                $column = $this->columns[$j];
                // Is there a formatter?
                if (isset($column['formatter'])) {
                    $row[$column] = $column['formatter']($this->data[$i][$column], $this->data[$i]);
                }
                elseif (is_object($this->data[$i]))
                {
                    $row[isset($column) ? $column : $column] = $this->data[$i]->{$column};
                }
                else {
                    $row[isset($column) ? $column : $column] = $this->data[$i][$column];
                }
            }
            $out[] = $row;
        }
        if ($with_index)
        {
            $copy_out = $out;
            foreach ($copy_out as $index => $datum)
            {
                $out[$index]['index'] = $index;
            }
        }
        return $out;
    }
    public function getResponse($with_index=false)
    {
        return [
            'draw' => intval($this->draw),
            'recordsTotal' => intval($this->recordsTotal),
            'recordsFiltered' => intval($this->filtered),
            'data' => $this->getDataOutput($with_index)
        ];
    }
}