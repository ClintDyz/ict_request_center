<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rstbl extends Model
{
    use HasFactory;

    protected $table = 'rstbl';

    protected $fillable = [
        'last_name', 'given_name', 'middle_name', 'ext_name', 'date_of_birth',
        'place_of_birth', 'age', 'email', 'expertise', 'building_no', 'home_address',
        'home_building_no', 'home_barangay', 'home_municipality', 'home_province',
        'home_zip_code', 'home_tel_no', 'home_cell_no', 'home_fax_no'
    ];

    public function referencesTrainings()
    {
        return $this->hasMany(RsReferencesTraining::class, 'rs_id');
    }

    public function educationalBackground()
    {
        return $this->hasMany(RsEducational::class, 'rs_id');
    }

    public function workExperiences()
    {
        return $this->hasMany(RsWorkExperience::class, 'rs_id');
    }

        // Relationship with Office
        public function office()
        {
            return $this->hasOne(Office::class, 'rs_id');
        }

        // Relationship with RsTraining
        public function trainings()
        {
            return $this->hasMany(RsTraining::class, 'rs_id');
        }

        // Relationship with RsExperienceTrainer
        public function experienceTrainer()
        {
            return $this->hasMany(RsExperienceTrainer::class, 'rs_id');
        }

        // Relationship with RsPublication
        public function publications()
        {
            return $this->hasMany(RsPublication::class, 'rs_id');
        }

        protected static function boot()
{
    parent::boot();

    static::deleting(function ($rstbl) {
        $rstbl->educationalBackground()->delete();
        $rstbl->workExperiences()->delete();
        $rstbl->referencesTrainings()->delete();
        $rstbl->experienceTrainer()->delete();
        $rstbl->publications()->delete();
        $rstbl->office()->delete();
    });
}

}
