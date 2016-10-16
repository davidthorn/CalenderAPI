<?php

namespace App\Transformers\Management;

use League\Fractal\TransformerAbstract;
use App\Models\CalenderEntry;

class CalenderEntryTransformer extends TransformerAbstract
{
    public function transform(CalenderEntry $model)
    {
        return [
            'id' => (int) $model->id,
            'subject' => (string) $model->subject,
            'start' => $model->start->toIso8601String(),
            'finish' => $model->finish->toIso8601String(),
            'created_at' => $model->created_at->toIso8601String(),
            'updated_at' => $model->updated_at->toIso8601String(),
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => api_url('v1')->route('mgmt.calendar.entries.show', [
                        'id' => $model->id,
                    ]),
                ],
            ],
        ];
    }
}
