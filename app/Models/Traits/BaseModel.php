<?php
namespace App\Models\Traits;

trait BaseModel
{
    public function getId(): int
    {
        return $this->id;
    }
}
