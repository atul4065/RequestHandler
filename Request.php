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
        $data = $this->data();

        return $this->formatData($data);
    }

    abstract public function fields(): array;

    public function data()
    {
        $data = $this->getAllFields();

        return $data;
    }


    public function getAllFields()
    {
        $data = [];

        $fields = $this->fields();
        foreach($fields as $field)
        {
            if($this->exists($field))
            {
                $data[$field] = $this->input($field);
            }
        }


        return $data;
    }

    public function formatData(array $data)
    {
        return $data;
    }
}
