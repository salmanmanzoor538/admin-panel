<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_form_id',
        'name',
        'label',
        'type',
        'placeholder',
        'required',
        'validation',
        'options',
        'sort_order',
        'settings',
    ];

    protected $casts = [
        'required' => 'boolean',
        'options' => 'array',
        'settings' => 'array',
        'sort_order' => 'integer',
    ];

    public function form()
    {
        return $this->belongsTo(CustomForm::class, 'custom_form_id');
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmissionData::class);
    }

    public function getFieldHtmlAttribute(): string
    {
        $html = '';
        
        switch ($this->type) {
            case 'text':
            case 'email':
            case 'number':
            case 'date':
                $html = $this->generateInputField();
                break;
            case 'textarea':
                $html = $this->generateTextareaField();
                break;
            case 'select':
                $html = $this->generateSelectField();
                break;
            case 'checkbox':
                $html = $this->generateCheckboxField();
                break;
            case 'radio':
                $html = $this->generateRadioField();
                break;
            case 'file':
                $html = $this->generateFileField();
                break;
        }

        return $html;
    }

    protected function generateInputField(): string
    {
        $required = $this->required ? 'required' : '';
        $placeholder = $this->placeholder ? "placeholder=\"{$this->placeholder}\"" : '';
        
        return "<input type=\"{$this->type}\" name=\"{$this->name}\" id=\"{$this->name}\" {$placeholder} {$required} class=\"form-input\">";
    }

    protected function generateTextareaField(): string
    {
        $required = $this->required ? 'required' : '';
        $placeholder = $this->placeholder ? "placeholder=\"{$this->placeholder}\"" : '';
        $rows = $this->settings['rows'] ?? 4;
        
        return "<textarea name=\"{$this->name}\" id=\"{$this->name}\" rows=\"{$rows}\" {$placeholder} {$required} class=\"form-input\"></textarea>";
    }

    protected function generateSelectField(): string
    {
        $required = $this->required ? 'required' : '';
        $html = "<select name=\"{$this->name}\" id=\"{$this->name}\" {$required} class=\"form-input\">";
        
        if (!$this->required) {
            $html .= '<option value="">Select an option...</option>';
        }
        
        foreach ($this->options ?? [] as $option) {
            $value = $option['value'] ?? '';
            $label = $option['label'] ?? $value;
            $html .= "<option value=\"{$value}\">{$label}</option>";
        }
        
        $html .= '</select>';
        return $html;
    }

    protected function generateCheckboxField(): string
    {
        $html = '';
        $required = $this->required ? 'required' : '';
        
        foreach ($this->options ?? [] as $option) {
            $value = $option['value'] ?? '';
            $label = $option['label'] ?? $value;
            $html .= "<label class=\"flex items-center\">
                        <input type=\"checkbox\" name=\"{$this->name}[]\" value=\"{$value}\" {$required} class=\"form-checkbox\">
                        <span class=\"ml-2\">{$label}</span>
                      </label>";
        }
        
        return $html;
    }

    protected function generateRadioField(): string
    {
        $html = '';
        $required = $this->required ? 'required' : '';
        
        foreach ($this->options ?? [] as $option) {
            $value = $option['value'] ?? '';
            $label = $option['label'] ?? $value;
            $html .= "<label class=\"flex items-center\">
                        <input type=\"radio\" name=\"{$this->name}\" value=\"{$value}\" {$required} class=\"form-radio\">
                        <span class=\"ml-2\">{$label}</span>
                      </label>";
        }
        
        return $html;
    }

    protected function generateFileField(): string
    {
        $required = $this->required ? 'required' : '';
        $accept = $this->settings['accept'] ?? '';
        
        return "<input type=\"file\" name=\"{$this->name}\" id=\"{$this->name}\" accept=\"{$accept}\" {$required} class=\"form-input\">";
    }
}