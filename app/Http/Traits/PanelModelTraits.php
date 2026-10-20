<?php
/**
 * Created by PhpStorm.
 * User: XENAN
 * Date: 21.10.2021
 * Time: 17:23
 */

namespace App\Http\Traits;


use Illuminate\Database\Eloquent\Model;

trait PanelModelTraits
{
    /**
     * @var Model
     */
    protected $model            = null;

    /**
     * @var string
     */
    protected $primary_key      = "";

    /**
     * @var int
     */
    protected $table_name       = "";


    /**
     * @var bool
     */
    protected $created_by       = true;


    /**
     * @var int
     */
    protected $limit            = 20;

    protected $limits           = array(
        20 => 20,
        50 => 50,
        100 => 10,
        250 => 250,
        500 => 500,
        -1 => -1
    );

    /**
     * @var string
     */
    protected $sort             = 'id';

    /**
     * @var string
     */
    protected $order            = 'asc';

    /**
     * @return Model|Model[]
     */
    public function getModel(){
        return $this->model;
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primary_key;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table_name;
    }

    /**
     * @return array
     */
    public function getLimits()
    {
        return $this->limits;
    }


    public function getData(){
        if (is_null($this->model)) return [];
        if($this->limit == -1){
            $results = $this->model->orderBy($this->table_name . '.' . $this->sort, $this->order)->get();
            $this->model = new LengthAwarePaginator($results, $results->count(), -1);
        }else{
            $this->model = $this->model->orderBy($this->table_name . '.' . $this->sort, $this->order)->paginate($this->limit);
        }
        return $this->model;
    }


    /**
     * @return bool
     */
    public function isTimestamps()
    {
        return $this->timestamps;
    }

    /**
     * @return bool
     */
    public function isCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @return bool
     */
    public function isShowCreatedBy()
    {
        return true;
    }


    public function isModel(){
        return !is_null($this->model);
    }



}
