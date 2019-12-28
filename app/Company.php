<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    protected $sortable_dt = [
        'name',
    ];

    protected $searchable_dt = [
        'website',
        'name',
        'email'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function getSortableDT()
    {
        return $this->sortable_dt;
    }

    public function scopeFilter($query, $data)
    {
        $sort_col = isset($data['column']) ? $data['column'] : 'name';
        $sort_order = isset($data['order']) ? $data['order'] : 'asc';
        $keyword = isset($data['keyword']) ? $data['keyword'] : '';
        $columns = $this->searchable_dt;

        return $query->where(function ($q) use ($columns, $keyword)  {
            foreach($columns as $col) {
                $q = $q->orWhere($col, 'LIKE', '%'. $keyword .'%' );
            }
        })
        ->orderBy($sort_col, $sort_order);
    }
}
