<?php
namespace App\Traits;
use Carbon\Carbon;
trait HasModelTrait
{
    public function showStatusOf($record)
    {
        switch ($record) {
            case $record->status_id == 1:
                return 'Active';
                break;
            case $record->status_id == 10:
                return 'Inactive';
                break;
            default:
                return 'Inactive';
        }
    }
}