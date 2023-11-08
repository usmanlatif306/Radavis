<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Commoditie;
use App\Models\Supplier;
use App\Models\Exits;
use App\Models\Via;
use App\Models\rate;
use App\Models\Destination;
use App\Models\User;
use App\Models\DispatchLog;

class dispatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'commodity_id',
        'supplier_id',
        'purchase_code',
        'exit_id',
        'release_code',
        'driver_instructions',
        'via_id',
        'destination_id',
        'rate_id',
        'salesman',
        'sales_num',
        'sales_notes',
        'accounting_notes',
        'noship',
        'void',
        'delivered'
    ];

    public function commodity()
    {
        return $this->belongsTo(Commoditie::class, 'commodity_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function exit()
    {
        return $this->belongsTo(Exits::class, 'exit_id', 'id');
    }

    public function via()
    {
        return $this->belongsTo(Via::class, 'via_id', 'id');
    }

    public function rate()
    {
        return $this->belongsTo(rate::class, 'rate_id', 'id');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'id');
    }
    public function salesman1()
    {
        return $this->belongsTo(User::class, 'salesman', 'id');
    }

    public static function get_dispatches_search($from, $to, $variables = array(), $select = '*')
    {
        $query = dispatch::query()->with(['commodity', 'destination', 'rate'])->select($select);

        if (!isset($variables['datepicker_all'])) {
            if (!$from instanceof Carbon) {
                $from = Carbon::createFromFormat('Y-m-d', $from)->startOfDay();
            }
            if (!$to instanceof Carbon) {
                $to = Carbon::createFromFormat('Y-m-d', $to)->endOfDay();
            }

            $query->when($from, function ($q, $from) {
                return $q->where('date', '>=', $from->timestamp);
            });

            $query->when($to, function ($q, $to) {
                return  $q->where('date', '<=', $to->timestamp);
            });
        }


        //   print_r($variables);

        foreach ($variables as $key => $value) {
            switch ($key) {
                case 'delivered':
                case 'noship':
                case 'void':
                case 'release_code':
                case 'purchase_code':
                case 'id':
                case 'sales_num':
                case 'salesman':
                    $query->where($key, $value);
                    break;
                case 'notes':
                    $query->where("(`driver_instructions` LIKE '%$value%' OR `sales_notes` LIKE '%$value%' OR `accounting_notes` LIKE '%$value%')", NULL, FALSE);
                    break;
                case 'commodity':
                case 'supplier':
                case 'exit':
                case 'via':
                case 'destination':
                case 'rate':
                    $query->where($key . '_id', $value);
                    break;
            }
        }



        if (\Auth::user()->hasRole('salesman')) {
            return $query->where('salesman', \Auth::user()->id)->paginate(10);
        } elseif (\Auth::user()->hasRole('truck')) {
            return $query->whereIn('via_id', auth()->user()->trucks->pluck('id'))->paginate(10);
        } else {
            /*echo $query->toSql();
            $bindings = $query->getBindings();
            print_r($bindings);
            //exit;*/
            return $query->paginate(10);
        }
    }

    public function logs()
    {
        return $this->hasMany(DispatchLog::class);
    }
}
