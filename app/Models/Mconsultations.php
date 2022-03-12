<?php

namespace App\Models;

use CodeIgniter\Model;

class Mconsultations extends Model
{
    protected $table            = 'consultations';
    protected $primaryKey       = 'id_consultations';
    protected $allowedFields    = ["society_id", "doctor_id", "status", "disease_history", "current_symptomps", "doctor_notes"];
}
