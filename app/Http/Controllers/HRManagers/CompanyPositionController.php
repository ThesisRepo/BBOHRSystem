<?php

namespace App\Http\Controllers\HRManagers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\CompanyPositionEloquent;

class CompanyPositionController extends Controller
{
    protected $company_position;

    public function __construct(
        CompanyPositionEloquent $company_position
        ) {
        $this->middleware(['auth', 'verify.manager.hr']);
        $this->company_position = $company_position;
    }

    public function index() {
        $res = $this->company_position->all();
        return $res;
    }

    public function create(Request $request) {

        $data = [
            'position_name' => $request->position_name
        ];
        $res = $this->company_position->create($data);

        return $res;

    }

    public function update(Request $request) {

        $id = $request->id;
        $data = [
            'position_name' => $request->position_name
        ];
        $res = $this->company_position->update($data, $id);
        
        return $res;

    }

    public function delete($id) {     
        $id = $request->id;
        $res = $this->company_position->delete($id);  
        return $res;

    }

}
