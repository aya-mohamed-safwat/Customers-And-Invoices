<?php
namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter{

    protected $safeParms=[];

    protected $columnMap = [];

    protected $operatorMap =[];

    public function transform(Request $request){
        $eloQuery=[];

        foreach($this->safeParms as $parm => $operators){
            $query = $request->query($parm);

            if(!isset($query)){
                continue;
            }
            $column =$this->columnMap[$parm] ?? $parm;

            foreach($operators as $operator){
                if(isset($query[$operator])){
                    $eloQuery[]=[$column, $this->operatorMap[$operator],$query[$operator]];
                }
            }
        }
        return $eloQuery;

    }    

    /*
      public function transform(Request $request)
    {
  $eloQuery = array_merge($eloQuery, array_map(function ($operator) use ($column, $query) {
              
                return isset($query[$operator]) ? [$column, $this->operatorMap[$operator], $query[$operator]] : null;
            }, $operators));
        }

        return array_filter($eloQuery);
    }
    */
            
            
}