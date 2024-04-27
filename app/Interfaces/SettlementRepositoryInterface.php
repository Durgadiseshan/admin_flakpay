<?php
namespace App\Interfaces;

use Illuminate\Support\Collection;

interface SettlementRepositoryInterface
{
   public function all(): Collection;
}