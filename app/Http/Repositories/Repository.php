<?php
namespace App\Http\Repositories;

class Repository 
{
    private $model;
    
    public function __construct($model) 
    {
        $this->model = $model;
    }

    public function find($id,  $with = []) 
    {
        return $this->model->with($with)->find($id);
    }

    public function findOne($attributes, $with = []) 
    {
        return $this->model->where($attributes)->with($with)->get()->first();
    }

    public function findWhere($attributes)
    {
        return $this->model->where($attributes)->get();
    }

    public function findWherePaginate($attributes, $with = [], $limit = 15)
    {
        return $this->model->where($attributes)->with($with)->paginate($limit);
    }

    public function findWherePaginateWithDistinct($attributes, $with = [], $limit = 15)
    {
        return $this->model->distinct()->where($attributes)->with($with)->paginate($limit);
    }


    public function all()
    {
        return $this->model->all();
    }

    public function insert($attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($attributes, $condition)
    {
        return $this->model
            ->where($condition)
            ->update($attributes);
    }

    public function delete($id) 
    {
        $record = $this->model->find($id);
        if($record) {
            $destroy = $this->model->destroy($id);
            return $destroy;
        }
        return 0;
    }

    public function deleteOne($attributes) 
    {
        $record = $this->model->where($attributes)->get()->first();
        if($record) {
            $destroy = $this->model->destroy($record->id);
            return $destroy;
        }
        return 0;
    }

    public function deleteMany($attributes) 
    {
        $count = 0;
        $records = $this->model->where($attributes)->get();
        if(sizeof($records) > 0) {
            foreach ($records as $rec ) {
                if($rec) {
                    $destroy = $this->model->destroy($rec->id);
                    ++$count;
                }
            }
        }
        return $count;
    }
}
