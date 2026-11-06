<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CustomForm;
use App\Models\FormField;
use Illuminate\Support\Str;

class FormBuilder extends Component
{
    public $formId;
    public $form;
    public $fields = [];
    public $availableFields = [
        'text' => [
            'label' => 'Text Input',
            'icon' => 'heroicon-o-pencil-square',
            'defaults' => [
                'name' => 'text_field',
                'label' => 'Text Field',
                'placeholder' => 'Enter text...',
                'required' => false,
                'validation' => 'string|max:255',
            ]
        ],
        'email' => [
            'label' => 'Email Input',
            'icon' => 'heroicon-o-envelope',
            'defaults' => [
                'name' => 'email_field',
                'label' => 'Email Field',
                'placeholder' => 'Enter email...',
                'required' => true,
                'validation' => 'email|max:255',
            ]
        ],
        'textarea' => [
            'label' => 'Textarea',
            'icon' => 'heroicon-o-document-text',
            'defaults' => [
                'name' => 'textarea_field',
                'label' => 'Textarea Field',
                'placeholder' => 'Enter your message...',
                'required' => false,
                'validation' => 'string|max:1000',
                'rows' => 4,
            ]
        ],
        'select' => [
            'label' => 'Select Dropdown',
            'icon' => 'heroicon-o-chevron-down',
            'defaults' => [
                'name' => 'select_field',
                'label' => 'Select Field',
                'required' => false,
                'validation' => 'string',
                'options' => [
                    ['value' => 'option1', 'label' => 'Option 1'],
                    ['value' => 'option2', 'label' => 'Option 2'],
                ]
            ]
        ],
        'checkbox' => [
            'label' => 'Checkbox',
            'icon' => 'heroicon-o-check-square',
            'defaults' => [
                'name' => 'checkbox_field',
                'label' => 'Checkbox Field',
                'required' => false,
                'validation' => 'boolean',
                'options' => [
                    ['value' => 'agree', 'label' => 'I agree to the terms']
                ]
            ]
        ],
        'radio' => [
            'label' => 'Radio Button',
            'icon' => 'heroicon-o-radio',
            'defaults' => [
                'name' => 'radio_field',
                'label' => 'Radio Field',
                'required' => false,
                'validation' => 'string',
                'options' => [
                    ['value' => 'yes', 'label' => 'Yes'],
                    ['value' => 'no', 'label' => 'No'],
                ]
            ]
        ],
        'file' => [
            'label' => 'File Upload',
            'icon' => 'heroicon-o-paper-clip',
            'defaults' => [
                'name' => 'file_field',
                'label' => 'File Upload',
                'required' => false,
                'validation' => 'file|max:2048',
                'accept' => '.pdf,.doc,.docx,.jpg,.png',
            ]
        ],
        'number' => [
            'label' => 'Number Input',
            'icon' => 'heroicon-o-calculator',
            'defaults' => [
                'name' => 'number_field',
                'label' => 'Number Field',
                'placeholder' => 'Enter number...',
                'required' => false,
                'validation' => 'numeric',
                'min' => 0,
                'max' => 999999,
            ]
        ],
        'date' => [
            'label' => 'Date Input',
            'icon' => 'heroicon-o-calendar',
            'defaults' => [
                'name' => 'date_field',
                'label' => 'Date Field',
                'required' => false,
                'validation' => 'date',
            ]
        ],
    ];

    public $editingField = null;
    public $fieldSettings = [];
    public $formSettings = [
        'title' => 'New Form',
        'description' => '',
        'submit_text' => 'Submit',
        'success_message' => 'Thank you for your submission!',
        'email_notifications' => false,
        'notification_email' => '',
    ];

    protected $listeners = ['fieldUpdated' => 'updateField', 'deleteField' => 'deleteField'];

    public function mount($formId = null)
    {
        if ($formId) {
            $this->form = CustomForm::findOrFail($formId);
            $this->fields = $this->form->fields()->orderBy('sort_order')->get()->toArray();
            $this->formSettings = array_merge($this->formSettings, $this->form->settings ?? []);
        } else {
            $this->form = new CustomForm();
            $this->fields = [];
        }
    }

    public function addField($type)
    {
        if (!isset($this->availableFields[$type])) {
            return;
        }

        $defaults = $this->availableFields[$type]['defaults'];
        $defaults['name'] = $defaults['name'] . '_' . (count($this->fields) + 1);
        $defaults['type'] = $type;
        $defaults['sort_order'] = count($this->fields);

        $this->fields[] = $defaults;
    }

    public function updateField($fieldIndex, $fieldData)
    {
        if (isset($this->fields[$fieldIndex])) {
            $this->fields[$fieldIndex] = array_merge($this->fields[$fieldIndex], $fieldData);
        }
    }

    public function deleteField($fieldIndex)
    {
        if (isset($this->fields[$fieldIndex])) {
            unset($this->fields[$fieldIndex]);
            $this->fields = array_values($this->fields);
            $this->reorderFields();
        }
    }

    public function moveField($fromIndex, $toIndex)
    {
        if (isset($this->fields[$fromIndex]) && isset($this->fields[$toIndex])) {
            $field = $this->fields[$fromIndex];
            unset($this->fields[$fromIndex]);
            array_splice($this->fields, $toIndex, 0, [$field]);
            $this->reorderFields();
        }
    }

    public function reorderFields()
    {
        foreach ($this->fields as $index => $field) {
            $this->fields[$index]['sort_order'] = $index;
        }
    }

    public function editField($fieldIndex)
    {
        $this->editingField = $fieldIndex;
        $this->fieldSettings = $this->fields[$fieldIndex] ?? [];
    }

    public function saveField()
    {
        if ($this->editingField !== null && isset($this->fields[$this->editingField])) {
            $this->fields[$this->editingField] = array_merge(
                $this->fields[$this->editingField],
                $this->fieldSettings
            );
            $this->editingField = null;
            $this->fieldSettings = [];
        }
    }

    public function cancelEdit()
    {
        $this->editingField = null;
        $this->fieldSettings = [];
    }

    public function saveForm()
    {
        $this->validate([
            'formSettings.title' => 'required|string|max:255',
            'formSettings.description' => 'nullable|string',
            'formSettings.submit_text' => 'required|string|max:255',
            'formSettings.success_message' => 'required|string',
            'formSettings.notification_email' => 'nullable|email',
        ]);

        $formData = [
            'title' => $this->formSettings['title'],
            'description' => $this->formSettings['description'],
            'settings' => $this->formSettings,
            'fields_schema' => $this->fields,
            'is_active' => true,
        ];

        if ($this->form->id) {
            $this->form->update($formData);
        } else {
            $formData['slug'] = Str::slug($this->formSettings['title']);
            $this->form = CustomForm::create($formData);
        }

        // Save individual fields
        $this->form->fields()->delete();
        foreach ($this->fields as $fieldData) {
            $this->form->fields()->create($fieldData);
        }

        session()->flash('message', 'Form saved successfully!');
        $this->emit('formSaved', $this->form->id);
    }

    public function previewForm()
    {
        // This would open a modal or redirect to preview
        $this->emit('showPreview', $this->fields);
    }

    public function exportForm()
    {
        $exportData = [
            'form' => $this->formSettings,
            'fields' => $this->fields,
            'exported_at' => now()->toISOString(),
        ];

        return response()->json($exportData);
    }

    public function importForm($data)
    {
        if (isset($data['form']) && isset($data['fields'])) {
            $this->formSettings = array_merge($this->formSettings, $data['form']);
            $this->fields = $data['fields'];
            $this->reorderFields();
        }
    }

    public function render()
    {
        return view('livewire.form-builder', [
            'availableFields' => $this->availableFields,
            'fields' => $this->fields,
        ]);
    }
}