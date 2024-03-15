<?php

namespace App\Models\Operational;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use model class that have relation with this model
use App\Models\MasterData\Poli;
use App\Models\Operational\Appointment;

class Doctor extends Model
{
    // use HasFactory;
    use SoftDeletes;

    // declare table
    public $table = 'doctor';

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $date = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    //declare fillable
    protected $fillable = [
        'poli_id',
        'name',
        'fee',
        'photo',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    // one to many
    public function poli()
    {
        // 3 parameter (path model, field foreign key, field primary key from table/model hasMany/hasOne)
        return $this->belongsTo(Poli::class, 'poli_id', 'id');
    }

    // one to many
    public function appointment()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
}
