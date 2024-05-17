<?php

namespace App\Services;

class EmployeeService
{
    protected $providerMappings = [
        'provider_one' => [
            'firstName' => 'first_name',
            'lastName' => 'last_name',
            'email' => 'email_address',
            'jobTitle' => 'occupation',
        ],
        'provider_two' => [
            'firstName' => 'givenName',
            'lastName' => 'surname',
            'email' => 'contactEmail',
            'jobTitle' => 'position',
        ],
        // Add more providers as needed
    ];

    public function mapData($provider, $data)
    {
        if (!isset($this->providerMappings[$provider])) {
            throw new \InvalidArgumentException("Mapping configuration for provider '{$provider}' not found.");
        }

        $mappedData = [];
        foreach ($this->providerMappings[$provider] as $targetField => $sourceField) {
            if (is_array($sourceField)) {
                $concatenatedValue = $this->concatenateFields($data, $sourceField);
                if (!empty($concatenatedValue)) {
                    $mappedData[$targetField] = $concatenatedValue;
                }
            } else {
                $value = $data[$sourceField] ?? null;
                if (!empty($value)) {
                    $mappedData[$targetField] = $value;
                }
            }
        }

        return $mappedData;
    }

    protected function concatenateFields($data, $fields)
    {
        $result = '';
        foreach ($fields as $field) {
            $result .= ($data[$field] ?? '') . ' ';
        }

        return trim($result);
    }
}
