<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, LogsActivity, HasRoles;
    
    /**
     * The table associated with created data.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * The table associated with updated data.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'concert_id',
        'user_id',
        'transaction_code',
        'quantity',
        'total_payment',
        'payment_date'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];
    
    /**
     * The attributes that aren't mass assignable to determine if this is a date.
     *
     * @var array
     */
    protected $dates = [
        'payment_date'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'concert_id' => 'integer',
        'user_id' => 'integer',
        'transaction_code' => 'string',
        'quantity' => 'integer',
        'total_payment' => 'string',
        'payment_date' => 'date:Y-m-d'
    ];

    /**
     * The spatie log that setting log option.
     *
     * @var bool
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                            ->logOnly($this->fillable)
                            ->logOnlyDirty()
                            ->useLogName('model')
                            ->setDescriptionForEvent(fn(string $eventName) => trans('model.activity.description', ['model' => $this->table, 'event' => $eventName]))
                            ->dontSubmitEmptyLogs();
    }
    
    /**
     * Get the concert that owns the transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function concert(): BelongsTo
    {
        return $this->belongsTo(Concert::class,'concert_id','id');
    }
    
    /**
     * Get the user that owns the transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
