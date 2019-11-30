<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Folio;
use App\User;

class FoliosExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $id;

    public function __construct($id) {
        $this->id = $id;
    }

    public function query()
    {
        $user = User::find($this->id);

        $query = [];

        if ($user->organization_id) {
            $query[] = ['organization_id', '=', $user->organization_id];
        }

        if ($user->location_id) {
            $query[] = ['location_id', '=', $user->location_id];
        }

        return Folio::where($query);
    }
    
    public function headings(): array
    {
        return [
            'id',
            'user_id',
            'organization_id',
            'location_id',
            'folio_name',
            'email',
            'cell_phone',
            'home_phone',
            'address1',
            'address2',
            'zip',
            'city',
            'state',
            'country',
            'last_reservation' ,
            'total_reservation' ,
            'total_nights',
            'created_at',
            'updated_at'
        ];
    }

    private function getDateFilter(String $filter_by): Array {
        if ($filter_by === 'last7Days') {
            return ['created_at', '>=', Carbon::now()->subDays(7)->toDateTimeString()];
        } elseif ($filter_by === 'last30Days') {
            return ['created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString()];
        } elseif ($filter_by === 'today') {
            return ['created_at', '>=', Carbon::now()->subDays(1)->toDateTimeString()];
        } elseif ($filter_by === 'owned') {
            return ['user_id', '=', $this->user->id];
        }
    }
    private function buildQuery(Array $queries = [], String $filter_by = '', $conditions = null): Array {
        $collection = [];

        if ($this->user->organization_id) {
            $collection[] = ['organization_id', '=', $this->user->organization_id];
        }

        if ($this->user->location_id) {
            $collection[] = ['location_id', '=', $this->user->location_id];
        }

        if (!empty($queries)) {
            foreach ($queries as $key => $value) {
                if ($key !== 'general') {
                    $collection[] = [$key, 'like', "%{$value}%"];
                }
            }
        }

        if (!empty($filter_by) && $filter_by !== 'all') {
            $collection[] = $this->getDateFilter($filter_by);
        }

        $conditions = json_decode($conditions, true);

        if ($conditions && count($conditions) > 0) {
            foreach ($conditions as $condition) {
                $field    = $condition['value'];
                $operator = $condition['condition'] === 'equal' ? '=' : ($condition['condition'] === 'not_equal' ? '!=' : 'like');
                $value = $operator === 'like' ? "%{$condition['conditionValue']}%" : $condition['conditionValue'];
                $collection[] = [$field, $operator, $value];
            }
        }

        return $collection;
    }
}
