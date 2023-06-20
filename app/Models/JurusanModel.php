<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurusanModel extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $fillable = [
        'id', '_jurusan', 'created_at', 'updated_at'
    ];

    public function scopesortered($query, $params)
    {
        if ($params['orderBy'] === 'created_at') {
            return $query->orderBy('created_at', $params['sort']);
        } else {
            $orderBy = $params['orderBy'];
            $sort = $params['sort'];
            return $query->orderByRaw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX($orderBy, ' ', -1), ' ', 1) AS UNSIGNED) $sort")
                         ->orderByRaw("SUBSTRING_INDEX($orderBy, ' ', -1) $sort");
        }
    }

    public function scopepagginateList($query, $params)
    {
        $page = ($params['page'] - 1) * $params['limit'];
        if (strlen($params['search']) >= 1) {
            return $query
                ->where('_jurusan', 'LIKE', '%' . $params['search'] . '%');
        } else {
            return $query
                ->offset($page)
                ->limit($params['limit']);
        }
    }
}
