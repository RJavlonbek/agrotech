<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



use App\tbl_payment_types;

use App\Http\Requests;

use DB;

use Illuminate\Support\Facades\Input;



class BackupController extends Controller

{

    public function __construct()

    {

        $this->middleware('auth');

    }

    

    //  get tables and compact

    public function index(){   

        $queryTables    = DB::select('SHOW TABLES'); 
        foreach($queryTables as $table){
            $tableName=$table->Tables_in_agroin;
            $result         =   DB::table($tableName)->get();  
            $fields_amount  =   count($result);  

            $createTableStatement=DB::select('SHOW CREATE TABLE '.$tableName)[0]->{'Create Table'};

            // $rows_num=$mysqli->affected_rows;     
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$createTableStatement.";\n\n";

            for ($i = 0, $st_counter = 0; $i < 1;   $i++, $st_counter=0) 
            {
                foreach($result as $key=>$row){ //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\n\nINSERT INTO ".$tableName." VALUES";
                    }
                    $content .= "\n(";
                    $j=0;
                    foreach($row as $field=>$value) { 
                        $value = str_replace("\n","\\n", addslashes($value) ); 
                        if (isset($value))
                        {
                            $content .= '"'.$value.'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<(count((array)$row)-1))
                        {
                                $content.= ',';
                        }
                        $j++;   
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$fields_amount) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        $backup_name = "agrotech_db_(".date('d.m.Y')."_".date('H:i').").sql";
        $backup_name = $backup_name ? $backup_name : $name.".sql";
        // header('Content-Type: application/octet-stream');   
        // header("Content-Transfer-Encoding: Binary"); 
        // header("Content-disposition: attachment; filename=\"".$backup_name."\"");
        file_put_contents(public_path().'/uploads/backup/'.$backup_name,$content);
        exit;
    }

    public function list(){
        $title="Ma'lumotlar bazasi arxiv fayllari";
        $dirn=public_path().'/uploads/backup';
        $sqlFiles=glob(public_path().'/uploads/backup/*.sql');

        if(!is_dir($dirn)){
            mkdir($dirn);
        }
        $files=scandir($dirn);

        foreach($files as $key=>$f){
            $pathinfo=pathinfo($f);
            $f=app()->make('stdClass');
            $f->name=$pathinfo['basename'];
            $f->extension=$pathinfo['extension'];
            $f->size=round(filesize($dirn.'/'.$f->name)/1000).' KB';
            $f->date=date('d.m.Y H:i',filectime($dirn.'/'.$f->name));
            $files[$key]=$f;

            if($pathinfo['extension'] != 'sql'){
                unset($files[$key]);
            }
        }
        return view('backup.list',compact('title','sqlFiles','files'));
    }

    public function get_file(){
        $filename=Input::get('filename');

        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$filename."\"");
        echo file_get_contents(public_path().'/uploads/backup/'.$filename);
        exit;
    }

}