<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_form_id',
        'ip_address',
        'user_agent',
        'submitted_data',
        'status',
    ];

    protected $casts = [
        'submitted_data' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(CustomForm::class, 'custom_form_id');
    }

    public function data()
    {
        return $this->hasMany(FormSubmissionData::class);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getFormattedDataAttribute(): array
    {
        $formatted = [];
        
        foreach ($this->submitted_data as $field => $value) {
            $fieldModel = $this->form->fields()->where('name', $field)->first();
            $label = $fieldModel ? $fieldModel->label : $field;
            
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            
            $formatted[] = [
                'label' => $label,
                'value' => $value,
                'field_type' => $fieldModel ? $fieldModel->type : 'text',
            ];
        }
        
        return $formatted;
    }
}