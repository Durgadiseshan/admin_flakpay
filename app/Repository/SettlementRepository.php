<?php

namespace App\Repository;

use App\Settlement;
use App\Repository\BaseRepository;
use App\Interfaces\SettlementRepositoryInterface;
use Illuminate\Support\Collection;
use Auth;
class SettlementRepository extends BaseRepository implements SettlementRepositoryInterface
{
    public function __construct(Settlement $model)
    {
        parent::__construct($model);
    }
 
    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();    
    }

    public function generateSettlementreport(){
        dd('here');
    }
}