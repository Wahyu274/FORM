<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use App\Models\FormFieldOption;
use App\Models\FormSection;
use Illuminate\Http\Request;

class FormBuilderController extends Controller
{
    public function index()
    {
        $form = Form::with(['sections.fields.optionItems'])->first();

        if (!$form) {
            $form = Form::create([
                'title' => 'FORM INVENTARIS JARINGAN PARTNER KALIMANTAN',
                'slug' => 'inventaris-kalimantan',
                'code_prefix' => 'INV-KAL',
                'description' => 'Formulir pendataan dan inventarisasi infrastruktur jaringan partner STARKINK Kalimantan.',
                'max_clients_per_antenna' => 25,
            ]);
        }

        $fields = FormField::with(['section', 'optionItems'])
            ->where('form_id', $form->id)
            ->orderBy('sort_order', 'asc')
            ->get();

        $sections = FormSection::where('form_id', $form->id)->orderBy('sort_order', 'asc')->get();

        return view('admin.form-builder.index', compact('form', 'fields', 'sections'));
    }

    public function storeField(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|string|in:text,textarea,number,date,dropdown,radio,checkbox,file,image,gps_location',
            'section_id' => 'required|exists:form_sections,id',
            'is_required' => 'boolean',
            'placeholder' => 'nullable|string|max:255',
            'help_text' => 'nullable|string|max:255',
            'options' => 'nullable|string', // newline or comma separated options
        ]);

        $form = Form::first();
        $name = str_replace('-', '_', \Illuminate\Support\Str::slug($request->label));
        $maxOrder = FormField::where('form_id', $form->id)->max('sort_order') ?? 0;

        $field = FormField::create([
            'form_id' => $form->id,
            'section_id' => $request->section_id,
            'label' => $request->label,
            'name' => $name,
            'type' => $request->type,
            'is_required' => $request->boolean('is_required'),
            'is_active' => true,
            'sort_order' => $maxOrder + 1,
            'placeholder' => $request->placeholder,
            'help_text' => $request->help_text,
        ]);

        // Process options if type is dropdown/radio/checkbox
        if (in_array($request->type, ['dropdown', 'radio', 'checkbox']) && $request->filled('options')) {
            $optionLines = explode("\n", str_replace("\r", "", $request->options));
            foreach ($optionLines as $idx => $line) {
                $line = trim($line);
                if (!empty($line)) {
                    FormFieldOption::create([
                        'field_id' => $field->id,
                        'label' => $line,
                        'value' => $line,
                        'sort_order' => $idx + 1,
                        'is_active' => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.form-builder.index')->with('success', "Field '{$field->label}' berhasil ditambahkan.");
    }

    public function updateField(Request $request, FormField $field)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|string|in:text,textarea,number,date,dropdown,radio,checkbox,file,image,gps_location',
            'section_id' => 'required|exists:form_sections,id',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'placeholder' => 'nullable|string|max:255',
            'help_text' => 'nullable|string|max:255',
            'options' => 'nullable|string',
        ]);

        $field->update([
            'label' => $request->label,
            'type' => $request->type,
            'section_id' => $request->section_id,
            'is_required' => $request->boolean('is_required'),
            'is_active' => $request->boolean('is_active', true),
            'placeholder' => $request->placeholder,
            'help_text' => $request->help_text,
        ]);

        if (in_array($request->type, ['dropdown', 'radio', 'checkbox']) && $request->has('options')) {
            $field->optionItems()->delete();
            $optionLines = explode("\n", str_replace("\r", "", $request->options));
            foreach ($optionLines as $idx => $line) {
                $line = trim($line);
                if (!empty($line)) {
                    FormFieldOption::create([
                        'field_id' => $field->id,
                        'label' => $line,
                        'value' => $line,
                        'sort_order' => $idx + 1,
                        'is_active' => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.form-builder.index')->with('success', "Field '{$field->label}' berhasil diperbarui.");
    }

    public function toggleField(FormField $field)
    {
        $field->is_active = !$field->is_active;
        $field->save();

        $status = $field->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.form-builder.index')->with('success', "Field '{$field->label}' berhasil {$status}.");
    }

    public function destroyField(FormField $field)
    {
        $label = $field->label;
        $field->delete();
        return redirect()->route('admin.form-builder.index')->with('success', "Field '{$label}' berhasil dihapus.");
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'max_clients_per_antenna' => 'required|integer|min:1|max:500',
            'title' => 'required|string|max:255',
            'code_prefix' => 'required|string|max:20',
        ]);

        $form = Form::first();
        $form->update([
            'title' => $request->title,
            'code_prefix' => strtoupper($request->code_prefix),
            'max_clients_per_antenna' => (int) $request->max_clients_per_antenna,
        ]);

        return redirect()->route('admin.form-builder.index')->with('success', 'Pengaturan form berhasil diperbarui.');
    }
}
