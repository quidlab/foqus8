<?php
namespace App\Models;


class Language extends Model {

    static $table = 'languages';
    protected static $primaryKey = 'ID';
    protected static $readable = [
        'Language_Name',
        'Language_ID',
        'Flag_ID',
        'Active',
        'Approve',
        'DisApprove',
        'Abstain',
        'NoVote',
        'Void',
    ];


     
}