<?php

namespace Laracademy\ModelGenerator\Commands;

use Schema;
use Illuminate\Console\Command;

class ModelGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:model {tables : a single table or a list of tables separated by a comma (,)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate models for the given tables based on their columns';

    var $fieldsFillable;
    var $fieldsHidden;
    var $fieldsCast;
    var $fieldsDate;
    var $columns;

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
     * returns the stub to use to generate the class
     */
    public function getStub()
    {
        return __DIR__.'/../stubs/model.stub';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('');

        $tablesToGenerate = explode(',', $this->argument('tables'));
        $tablesInDatabase = array();
        $module = array();
        $path = app_path();

        $this->comment('Starting generation');
        $this->comment('Gathering Tables');

        foreach($tablesToGenerate as $tableName)
        {
            // grab the stub
            $stub = file_get_contents($this->getStub());

            $this->comment('Gathering information for table: '. $tableName);

            // file name for the model
            $filename = str_singular(ucfirst($tableName));
            $fullFileName = "$path/$filename.php";

            // gather information on it
            $module = array(
                'table'     => $tableName,
                'fillable'  => Schema::getColumnListing($tableName),
                'guardable' => array(),
                'hidden'    => array(),
                'casts'     => array(),
            );

            // fix these up
            $columns = \DB::select(\DB::raw('describe '. $tableName));

            // use a collection
            $this->columns = collect();

            foreach($columns as $col) {
                $this->columns->push([
                    'field' => $col->Field,
                    'type' => $col->Type,
                ]);
            }

            // replace the class name
            $stub = $this->replaceClassName($stub, $tableName);

            // replace the fillable
            $stub = $this->replaceModuleInformation($stub, $module);

            // writing stub out
            $this->comment('Writing Model at '. $fullFileName);
            file_put_contents($fullFileName, $stub);
        }

        $this->comment('Done');
    }

    /**
     * replaces the class name in the stub
     * @param  string $stub      stub content
     * @param  string $tableName the name of the table to make as the class
     * @return string            stub content
     */
    public function replaceClassName($stub, $tableName)
    {
        return str_replace('{{class}}', str_singular(ucfirst($tableName)), $stub);
    }

    /**
     * replaces the module information
     * @param  string $stub             stub content
     * @param  array $modelInformation  array (key => value)
     * @return string                   stub content
     */
    public function replaceModuleInformation($stub, $modelInformation)
    {
        // replace table
        $stub = str_replace('{{table}}', $modelInformation['table'], $stub);

        // replace fillable
        $this->fieldsHidden = '';
        $this->fieldsFillable = '';
        $this->fieldsCast = '';
        foreach($modelInformation['fillable'] as $field)
        {
            // fillable and hidden
            if($field != 'id' && $field != 'created_at' && $field != 'updated_at') {
                $this->fieldsFillable .= (strlen($this->fieldsFillable) > 0 ? ', ' : '') ."'$field'";

                $fieldsFiltered = $this->columns->where('field', $field);
                if($fieldsFiltered) {
                    // check type
                    switch(strtolower($fieldsFiltered->first()['type'])) {
                        case 'timestamp':
                            $this->fieldsDate .= (strlen($this->fieldsDate) > 0 ? ', ' : '') ."'$field'";
                            break;
                        case 'datetime':
                            $this->fieldsDate .= (strlen($this->fieldsDate) > 0 ? ', ' : '') ."'$field'";
                            break;
                        case 'date':
                            $this->fieldsDate .= (strlen($this->fieldsDate) > 0 ? ', ' : '') ."'$field'";
                            break;
                        case 'tinyint(1)':
                            $this->fieldsCast .= (strlen($this->fieldsCast) > 0 ? ', ' : '') ."'$field' => 'boolean'";
                            break;
                    }
                }
            } else {
                if($field != 'id' && $field != 'created_at' && $field != 'updated_at') {
                    $this->fieldsHidden .= (strlen($this->fieldsHidden) > 0 ? ', ' : '') ."'$field'";
                }
            }
        }

        // replace in stub
        $stub = str_replace('{{fillable}}', $this->fieldsFillable, $stub);
        $stub = str_replace('{{hidden}}', $this->fieldsHidden, $stub);
        $stub = str_replace('{{casts}}', $this->fieldsCast, $stub);
        $stub = str_replace('{{dates}}', $this->fieldsDate, $stub);

        return $stub;
    }
}