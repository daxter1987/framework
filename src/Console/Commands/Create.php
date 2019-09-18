<?php

namespace daxter1987\Framework\Commands;

use Illuminate\Console\Command;

class Create extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dax:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates composer file in project to be able to use classes and components in vendor folder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Started create command\n";

        $table_name = $this->ask('What is the table name?');

        $table_name = ucfirst(strtolower($table_name));

        if(file_exists('app/' . $table_name . '.php')){
            echo "Class " . $table_name . " already exists\n";
            return 'Done';
        }

        $sql = "select column_name,data_type,is_nullable from information_schema.columns where table_name = '$table_name'";

        $results = app('db')->select($sql);

        $class_file = file_get_contents('vendor/daxter1987/framework/resources/templates/class_template.php');
        $remove_array = ['id', 'created_at', 'updated_at', 'deleted_at'];
        $fillable_attributes = '';

        foreach ($results as $index => $column){
            if(in_array($column->column_name, $remove_array)){
                unset($results[$index]);
                if($column->column_name === 'deleted_at'){
                    $has_deleted = true;
                }
            }else{
                $fillable_attributes .= "'" . $column->column_name . "',";

            }
        }

        if(!empty($has_deleted)){
            $class_file = str_replace("//use Illuminate\Database\Eloquent\SoftDeletes;", "use Illuminate\Database\Eloquent\SoftDeletes;", $class_file);
            $class_file = str_replace("//    use SoftDeletes;", "    use SoftDeletes;", $class_file);
            $class_file = str_replace("//    protected \$dates = ['deleted_at'];", "    protected \$dates = ['deleted_at'];", $class_file);
        }else{
            $class_file = str_replace("//    protected \$dates = ['deleted_at'];", "", $class_file);
            $class_file = str_replace("//    use SoftDeletes;", "", $class_file);
            $class_file = str_replace("//use Illuminate\Database\Eloquent\SoftDeletes;", "", $class_file);
        }

        $class_file = str_replace("'\$fillable_attributes'", $fillable_attributes, $class_file);
        $class_file = str_replace("ClassName", $table_name, $class_file);

        $handle = fopen("app/" . $table_name . ".php", 'w') or die('Cannot open file:  '.$table_name); //implicitly creates file

        fwrite($handle, $class_file);

        echo "End create command\n";
    }
}
