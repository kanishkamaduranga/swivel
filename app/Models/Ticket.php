<?php

namespace App\Models;


class Ticket extends JsonModel
{
    protected $file_name = "tickets.json";

    /*public $fillable = [
        '_id',
        'url',
        'external_id',
        'created_at',
        'type',
        'subject',
        'description',
        'priority',
        'status',
        'submitter_id',
        'assignee_id',
        'organization_id',
        'tags',
        'has_incidents',
        'due_at',
        'via'
    ];*/
}
