<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
abstract class Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function getAndFormatData()
    {
        $data = $this->getAndNullifyEmptyStringData();
        return $this->formatData($data);
    }
    public function getAndNullifyEmptyStringData()
    {
        $data = $this->getData();
        return array_map([$this, 'nullifyEmptyString'], $data);
    }
    public function getData()
    {
        if (count($this->fields()) === 0) {
            return $this->all();
        }
        if ($this->method() === 'PUT') {
            return $this->getNonNullInput();
        }
        return $this->only($this->fields());
    }
    protected function getNonNullInput()
    {
        $data = [];
        foreach ($this->fields() as $field) {
            if ($this->exists($field)) {
                $data[$field] = $this->input($field);
            }
        }
        return $data;
    }
    public function nullifyEmptyString($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        $value = trim($value);
        return strlen($value) > 0 ? $value : null;
    }
    public function fields()
    {
        return [];
    }
    public function formatData(array $data)
    {
        return $data;
    }
}
