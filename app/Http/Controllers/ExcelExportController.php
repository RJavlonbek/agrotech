<?php 


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Exports\ExportLicence;
use App\Exports\ExportVehicle;
use App\Exports\ExportNumbers;
use App\Exports\ExportPassport;
use App\Exports\ExportCertificate;
use App\Exports\ExportMed;
use App\Exports\ExportExam;
use App\Exports\ExportTm;
use App\Exports\ExportCustomer;
use App\Exports\ExportMedout;
use App\Exports\ExportRegout;
use App\Http\Requests;
use DateTime;
use PDO;
use DB;
use URL;
use auth;
use Illuminate\Support\Facades\Input;

use Maatwebsite\Excel\Facades\Excel;


class ExcelExportController extends Controller
{
    public function vehicle_list()
    {
        return Excel::download(new ExportVehicle, 'Texnikalar.xlsx');
    }
    public function driver_licence()
    {
    	return Excel::download(new ExportLicence, 'Guvohnomalar.xlsx');
    }
    public function transport_numbers()
    {
    	return Excel::download(new ExportNumbers, 'Davlat raqamlari.xlsx');
    }
    public function technical_passports()
    {
        return Excel::download(new ExportPassport, 'Texnik pasportlar.xlsx');
    }
    public function certificate()
    {
        return Excel::download(new ExportCertificate, 'Texnik Guvohnomalar.xlsx');
    }
    public function med()
    {
        return Excel::download(new ExportMed, 'Texnik Ko\'rik.xlsx');
    }
    public function exam()
    {
        return Excel::download(new ExportExam, 'Haydovchi imtixonlari.xlsx');
    }
    public function tm()
    {
        return Excel::download(new ExportTm, 'TM-1 Ma\'lumotnomalar.xlsx');
    }
    public function customer()
    {
        return Excel::download(new ExportCustomer, 'Mulk egalari.xlsx');
    }
    public function medout()
    {
        return Excel::download(new ExportMedout, 'Texnik ko\'rik muddati tugagan texnikalar.xlsx');
    }
    public function regout()
    {
        return Excel::download(new ExportRegout, 'Ro\'yxatdan o\'tish muddati tugagan texnikalar.xlsx');
    }
}