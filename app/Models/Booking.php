<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    use HasFactory;

    protected $casts = [
        'date_time' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'business_id',
        'date_time',
        'client_name',
        'personal_id',
        'description',
        'notification_method',
        'doctor_id',
        'hairstylist_id',
        'table_id',
    ];


    public static function createBooking($request)
    {
        $data = [
            'user_id' => auth()->id(),
            'business_id' => $request->business_id,
            'date_time' => $request->date_time,
            'client_name' => $request->client_name,
            'personal_id' => $request->personal_id,
            'description' => $request->description,
            'notification_method' => $request->notification_method,
            'doctor_id' => null,
            'hairstylist_id' => null,
            'table_id' => null,
        ];

        switch ($request->provider_type) {
            case 'doctor':
                $data['doctor_id'] = $request->service_provider_id;
                break;

            case 'hair_salon':
            case 'hairstylist':
                $data['hairstylist_id'] = $request->service_provider_id;
                break;

            case 'restaurant':
            case 'table':
                $data['table_id'] = $request->service_provider_id;
                break;
        }

        return self::create($data);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when(!empty($filters['business_type_id']), function ($q) use ($filters) {
            $q->whereHas('business.businessType', function ($q2) use ($filters) {
                $q2->where('id', $filters['business_type_id']);
            });
        });

        $query->when(!empty($filters['business_id']), function ($q) use ($filters) {
            $q->where('business_id', $filters['business_id']);
        });

        $query->when(!empty($filters['personal_id']), function ($q) use ($filters) {
            $q->where('personal_id', $filters['personal_id']);
        });

        $query->when(!empty($filters['from_date']), function ($q) use ($filters) {
            $q->whereDate('date_time', '>=', $filters['from_date']);
        });

        $query->when(!empty($filters['to_date']), function ($q) use ($filters) {
            $q->whereDate('date_time', '<=', $filters['to_date']);
        });

        return $query;
    }

    public static function getUpcomingBookings(string $personalId, int $excludeId)
    {
        return self::where('personal_id', $personalId)
            ->where('date_time', '>', now())
            ->where('id', '!=', $excludeId)
            ->get();
    }

    public function updateBooking(array $data)
    {
        $data['description'] = trim($data['description'] ?? '');

        return $this->update($data);
    }

    public function business() {
        return $this->belongsTo(Business::class);
    }
    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }
    public function hairstylist() {
        return $this->belongsTo(Hairstylist::class);
    }
    public function table() {
        return $this->belongsTo(Table::class);
    }

}
