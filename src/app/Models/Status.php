<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_name',
    ];

    static $SeafarerStatuses = array( 1 => 'Submitted', 'Reviewed', 'Accepted', 'Verified' );

    public static function getKeyOfStatus($statusToUse){
        return array_search( $statusToUse, Status::$SeafarerStatuses );
    }

    /*public function submissions() {
        return $this->belongsToMany(Submission::class, 'submissions_statuses');
    }*/
}
