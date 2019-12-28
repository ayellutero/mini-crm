<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    // protected $guard = 'employee';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'company_id',
        'email',
        'phone'
    ];

    protected $sortable_dt = [
        'last_name',
        'first_name',
        'email',
        'phone'
    ];

    protected $searchable_dt = [
        'last_name',
        'first_name',
        'email',
        'phone'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute()
    {
        return $this->last_name . ', ' . $this->first_name;
    }

    public function getCompanyNameAttribute()
    {
        return isset($this->company) ? $this->company->name : null;
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function updatePassword($password)
    {
        $this->password = \Hash::make($password);
        return $this->save();
    }

    public function getSortableDT()
    {
        return $this->sortable_dt;
    }

    public function scopeFilter($query, $data)
    {
        $sort_col = isset($data['column']) ? $data['column'] : 'last_name';
        $sort_order = isset($data['order']) ? $data['order'] : 'asc';
        $keyword = isset($data['keyword']) ? $data['keyword'] : '';
        $columns = $this->searchable_dt;

        return $query->where(function ($q) use ($columns, $keyword)  {
            foreach($columns as $col) {
                $q = $q->orWhere($col, 'LIKE', '%'. $keyword .'%' );
            }
        })
        ->orWhereHas('company', function ($q) use ($keyword) {
            $q->where('name', $keyword);
        })->orderBy($sort_col, $sort_order);
    }

}
