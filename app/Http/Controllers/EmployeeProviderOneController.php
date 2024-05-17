<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\Services\TrackTikService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeProviderOneController extends Controller
{
    protected $employeeService;
    protected $tracktikService;

    public function __construct(EmployeeService $employeeService, TrackTikService $tracktikService)
    {
        $this->employeeService = $employeeService;
        $this->tracktikService = $tracktikService;
    }

    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email_address' => 'sometimes|required|email',
            'occupation' => 'sometimes|required|string'
        ]);
        // Check for validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();

			$formattedErrors = [];
			foreach ($errors as $field => $errorMessages) {
				$formattedErrors[$field] = implode(', ', $errorMessages); // Combine error messages for a field
			}

			return response()->json([
				'message' => 'Validation failed',
				'errors' => $formattedErrors,
			], 422);
        }
		
        // Map Data
        $employeeData = $this->employeeService->mapData('provider_one', $request->all());
        
		
		// Create Employee
        $response = $this->tracktikService->createEmployee($employeeData);
		return $response;
    }

    public function update(Request $request, $id)
    {
		$validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email_address' => 'sometimes|required|email',
            'occupation' => 'sometimes|required|string'
        ]);
		
        // Check for validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();

			$formattedErrors = [];
			foreach ($errors as $field => $errorMessages) {
				$formattedErrors[$field] = implode(', ', $errorMessages); // Combine error messages for a field
			}

			return response()->json([
				'message' => 'Validation failed',
				'errors' => $formattedErrors,
			], 422);
        }
		
        // Map Data
        $employeeData = $this->employeeService->mapData('provider_one', $request->all());
		
		// Update Employee
        $response = $this->tracktikService->updateEmployee($id, $employeeData);
		return $response;
    }
}
