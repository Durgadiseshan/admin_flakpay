<?php
namespace App\Repository\Interfaces;

use App\Model\User;
use Illuminate\Support\Collection;

interface SettlementRepositoryInterface
{
   public function all(): Collection;
}